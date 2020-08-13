<?php
namespace App\Services;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;

class PaymentProcessingService
{
    private $order;
    
    /**
     * Create payment 
     * @param \App\Models\Order $order
     * @return Void
     */
    public function createPayment(Order $order)
    {   
        $this->order = $order;
        if($this->order->orderPaid()){
            abort(400, 'This order has already been paid for.');
        }
        $this->formatPayment();  
        $this->payment->save();
        return $this->payment;
    }

    /**
     * Create payment object
     * @return Void
     */
    private function formatPayment(){
        $this->payment = new Payment();
        $this->payment->order_id = $this->order->id;
        $this->payment->amount = $this->order->billing_total;
        $this->payment->payment_type = Payment::getPaymentTypeForUnpaidOrders();
        $this->payment->payment_method = request()->payment_method;
        $this->payment->paid_at = now();
        $this->payment->assignHandler();
    }

}