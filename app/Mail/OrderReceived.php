<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Order;
use App\Models\Setting;

class OrderReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    private $sender_email;
    private $sender_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->sender_email = Setting::appEmail();
        $this->sender_name = Setting::appName();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->from($address = $this->sender_email, $name = $this->sender_name )
        ->to($this->order->billing_email, $this->order->billing_name)
        ->subject('New Order Received '.$this->order->order_nr)
        ->view('emails.orders.received');
    }
}
