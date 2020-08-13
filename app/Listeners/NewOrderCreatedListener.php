<?php

namespace App\Listeners;

use App\Events\NewOrderCreatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\CartService;
use App\Services\DiscountCodesService;
use App\Mail\OrderReceived;
use Illuminate\Support\Facades\Mail;

class NewOrderCreatedListener
{
    private $cart;
    private $codeService;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(CartService $cart, DiscountCodesService $codeService)
    {
        $this->cart = $cart;
        $this->codeService = $codeService;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(NewOrderCreatedEvent $event)
    {
        //Empty the shopping cart
        $this->cart->emptyCart();

        //Remove discount code if exists
        $this->codeService->removeCode();

        //send customer an email with order confirmation
        Mail::send(new OrderReceived($event->order));
    }
}
