<?php
namespace App\Services;
use App\Exceptions\FilteringException;
use App\Services\Filters\FilterService;
use App\Services\Filters\SortService;
use App\Models\Order;

class OrderService
{
    private $pagination;
    private $filter;
    private $sorter;

    public function __construct(Int $pagination = 10){
        $this->pagination = $pagination;
        $this->filter = new FilterService('order');
        $this->sorter = new SortService('order');
    }

    /**
     * Return a paginated listing of all orders
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAll()
    {
        return Order::defaultSort()->paginate($this->pagination);
    }

    /**
     * Return a paginated listing of all active orders
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getActive()
    {
        return Order::ActiveOrders()->defaultSort()->paginate($this->pagination);
    }


    /**
     * Return a paginated listing of all complete orders
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getComplete()
    {
       return Order::CompleteOrders()->defaultSort()->paginate($this->pagination);
    }

    /**
     * Return a paginated listing of orders based on request query and calling params along with applied filter and sorting names 
     * @param String $specific (optional) - defines additional filter types except request query
     * @return Array
     */
    public function getFiltered($specific = false)
    {
        $filters = [];
        $sort = [];
        $orders = [];

        try{
            if(!request()->isFilterable()){
                $orders = $this->getUnfiltered($specific);
            }else{
                //Apply query filters
                $orders = $this->filter->apply();
    
                //Apply additional filters if exist
                $this->applySpecific($orders, $specific);
    
                //Apply Sorting
                if(request()->isSortable()){
                    $orders = $this->sorter->apply($orders);
                    $sort = $this->sorter->getApplied();
                }
                $filters = $this->filter->getApplied();
                $orders = $orders->paginate($this->pagination);
            }
            return [
                'orders' => $orders,
                'filters' => $filters,
                'sort' => $sort
            ];
        }catch(\Exception $e){
            throw new FilteringException($e->getMessage());
        }
    }

    /**
     * Return a paginated listing of orders before filters according to specified type
     * @param String $specific (optional) - defines query filters to be applied
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    private function getUnfiltered(String $specific = null){
        if($specific == 'active'){
            return $this->getActive();
        }elseif($specific == 'complete'){
            return $this->getComplete();
        }else{
            return $this->getAll();
        }
    }
    /**
     * Applies additional query filters to be applied to query
     * @param String $specific (optional) - defines query filters to be applied
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function applySpecific($orders, $specific){
        if($specific == 'active'){
            $orders = $orders->ActiveOrders();
        }elseif($specific == 'complete'){
            $orders = $orders->CompleteOrders();
        }
        return $orders;
    }

    /**
     * Prepares single order for display: loads products and calculates subtotal before discount
     * @param App\Models\Order $order
     * @return App\Models\Order
     */
    public function formatOne(Order $order){
        $order->loadProducts();
        if($order->card_discount != null){
            $order->subtotal_before_discount = $order->billing_subtotal + $order->card_discount;
        }
        return $order;
    }

    // AUTHENTICATED USERS ORDERS HANDLING
    /**
     * Return a paginated listing of authenticated users orders
     * @param String $specific (optional) - defines what additional query filters must be applied
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getUsersOrders(String $specific = null){
        $orders = auth()->user()->orders();
        if($specific){
            $orders = $this->applySpecific($orders, $specific);
        }
        $orders = $orders->withOrderedProducts()->defaultSort()->paginate($this->pagination);
        return $orders;
    }

    /**
     * Counts users orders of various stages: all, complete, active
     * @return Array
     */
    public function getUserOrderCounts(){
        $orders = [];
        $orders['total'] = $this->getUsersOrders()->count();
        $orders['complete'] = $this->getUsersOrders('complete')->count();
        $orders['active'] = $this->getUsersOrders('active')->count();
        return $orders;
    }

}
