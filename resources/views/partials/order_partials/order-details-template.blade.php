<div class="card border-secondary mb-3 order-details-template">
        <div class="card-header side-split">
                <div>
                    <div><span class="mr-1">Order&nbsp;Nr.&nbsp;</span>{{$order->order_nr}}</div>
                    <small><span class="text-uppercase mr-1">Order Date </span>{{$order->created_at}}</small>
                </div>
                @include('partials.order_partials.order-status-badge')
        </div>
        <div class="card-body">
            <div class="order-holder">
                    <div class="grid-split">
                            <div class="mb-3">
                            <h3>Billing Details</h3>
                            <div class="mini-separator-left"></div>
                            @include('partials.order_partials.order-billing-info')
                            </div>
                            <div class="mb-3">
                            <h3>Delivery Details</h3>
                            <div class="mini-separator-left"></div>
                            @include('partials.order_partials.delivery-details')
                            </div>
                    </div>
                    <div class="my-4">
                        <hr/>
                        <h3>Order Products</h3>
                        <hr />
                        @include('partials.order_partials.ordered-products')
                    </div>
                    <hr/>
                    <div class="grid-split">
                        <div class="mb-3">
                            <h3>Payment Details</h3>
                            <div class="mini-separator-left"></div>
                            @include('partials.order_partials.payment-details')
                        </div>
                        <div class="mb-3">
                            <h3>Order Totals</h3>
                            <div class="mini-separator-left"></div>
                            @include('partials.order_partials.order-totals')
                        </div>
                    </div>
                </div>
        </div>
    </div>