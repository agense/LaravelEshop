<?php
namespace App\Services;
use App\Exceptions\OrderFailedException;
use App\Exceptions\ProductAvailabilityException;
use App\Exceptions\UnrecoverableOrderFailureException;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Services\CartTotalsService;
use App\Services\CartService;
use App\Models\Order;
use App\Models\Product;
use DB;

class CheckoutService
{
    private $cart;
    private $cartTotals;
    private $stockControl;
    private $order;
    private $orderProducts;
    private $userId;
    private $cartService;

    public function __construct(CartTotalsService $totals, CartService $cartService){
        $this->cartService = $cartService;
        $this->cart = Cart::instance('default');
        $this->totals = $totals;
        $this->cartTotals = $totals->getTotals();
        $this->userId = auth()->user() ? auth()->user()->id : null;
        $this->order = new Order();
    }

    /**
     * Create a new order in DB
     * @return Mix 
     */
    public function createNewOrder()
    {
        //insert order into db;
        try{
            $this->formatOrder();

            //Check if all products are available in quantities requested before sale
            $this->cartService->confirmQuantities();

            DB::transaction(function (){
            //Save order
            $this->order->save();
            
            //Create a delivery 
            $this->order->delivery()->create($this->formatDelivery());

            //Insert into order_products table
            $this->order->products()->attach($this->orderProducts);

            //adjust sold products availability in DB
            $this->updateAvailabilityOnSale();
            }, 1);

            //Set Billing email on order object
            $this->order->billing_email = request()->email;

            //Set Subtotal before discount
            $this->order->subtotal_before_discount = $this->cartTotals['initialSubtotal'];
            
            return $this->order; 
            
        }catch(\Exception $exception){
            if($exception instanceof ProductAvailabilityException && $this->cartService->isEmpty()){
                throw new UnrecoverableOrderFailureException($exception->getMessage().' Your cart is empty.'); 
            }else{
                throw new OrderFailedException($exception->getMessage());
            }
        } 
    }

    /**
     * Set order properties on order object
     * @return void
     */
    private function formatOrder()
    {
        $this->order->user_id = $this->userId;
        $this->order->order_nr = uniqid();
        $this->order->billing_name = request()->name;
        $this->setOrderTotals();
        $this->setBillingDetails();
        $this->setOrderProducts();
    }

     /**
     * Sets billing properties on order object
     * @return void
     */
    private function setOrderTotals()
    {
        $this->order->billing_subtotal = $this->cartTotals['subtotal'];
        $this->order->billing_tax = $this->cartTotals['tax'];
        $this->order->billing_total = $this->cartTotals['total'];
        $this->order->card_discount = $this->cartTotals['discount'];
        if($this->cartTotals['discount'] !== null){
            $this->order->card_discount_code = $this->totals->discountDetails()['code'];
        }
    }

    /**
     * Creates billing details array from request and sets in on order object as property
     * @return void
     */
    private function setBillingDetails()
    {
        $details = [];
        $details['name'] = request()->name;
        $details['email'] = request()->email;
        $details['address'] = request()->address;
        $details['city'] = request()->city;
        $details['region'] = request()->region;
        $details['postalcode'] = request()->postalcode;
        $details['phone'] = request()->phone;

        $this->order->billing_details = $details;
    }

    /**
     * Creates an array of order products and sets in on order object as property
     * @return void
     */
    private function setOrderProducts()
    {
        $orderProducts = [];
        foreach($this->cart->content() as $item){
            $product = Product::find($item->model->id);
            $orderProducts[$product->id] =  [
                'item_price' => $item->model->price,
                'quantity' => $item->qty,
                'user_id' => $this->userId,
            ];
        }
        $this->orderProducts = $orderProducts;
    }

    /**
     * Creates an array of delivery model properties to be attached to order
     * @return Array
     */
    private function formatDelivery(){
        return [
            'user_id' => $this->userId,
            'delivery_type' => request()->delivery_type, 
        ];
    }

    /**
     * Update product availability in database on sale
     * @return Void
     */
    private function updateAvailabilityOnSale()
    {
        foreach($this->cart->content() as $item){
            $newAvailability = intval($item->model->availability - $item->qty);
            Product::where('id', $item->model->id)->update(['availability' => $newAvailability]);
        }
    }    
}