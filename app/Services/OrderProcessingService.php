<?php
namespace App\Services;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\PaymentProcessingService;

class OrderProcessingService
{
    private $errors;
    private $order;

    /**
     * Process order status
     * @param \App\Models\Order $order
     * @return Void
     */
    public function handleStatus(Order $order){
        $this->order = $order;
        if(request()->order_status == "complete"){
            $this->setOrderAsComplete();
        }else{
            $this->order->status = request()->order_status;
            if(request()->order_status == "ready"){
                $this->order->ready_at = now();
            }
        }
        $this->order->save();
    }

    /**
     * Process order delivery status
     * @param \App\Models\Order $order
     * @return Void
     */
    public function handleDelivery(Order $order){
        $this->order = $order;
        $this->order->delivery->delivery_status = request()->delivery_status;
        $this->order->delivery->assignHandler();
        if(request()->delivery_status == "delivered"){
            $this->order->delivery->delivered_at = now();
            if($this->order->orderPaid()){
                $this->setOrderAsComplete();
            }
        }
        $this->order->push();
    }


    /**
     * Create payment processed by admin on delivery
     * @param \App\Models\Order $order
     * @return Void
     */
    public function handlePayment(Order $order)
    {   
        return (new PaymentProcessingService())->createPayment($order);
    }

    /**
     * Sets order status as complete and completion date
     * @return Void
     */
    private function setOrderAsComplete(){
        $this->order->status = 'complete';
        $this->order->completed_at = now();
    }

}