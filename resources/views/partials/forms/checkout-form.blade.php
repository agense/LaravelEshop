<form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
    <div class="shadow-box p-4">
        <div class="ckeckout-section  mt-2">
            <div>
                <!--Customer Details-->
                {{ csrf_field() }}
                <h2>Billing Details</h2>
                @include('partials.forms.fields.user-data-fields')
                <!--End Customer Details-->
            </div>
            <div>
                <!--Delivery-->
                <div>
                <h2>Delivery</h2>
                @include('partials.forms.fields.radio-box-group',
                 ['name'=> 'delivery_type',
                   'options' => $deliveryOptions,
                   'addClasses' => "bordered-radio"
                 ])
                </div>
                <!-- Delivery-->
                <!--Payment-->
                <div>
                    <h2>Payment</h2>
                    @include('partials.forms.fields.radio-box-group',
                    ['name'=> 'payment_type',
                      'options' => $paymentOptions,
                      'addClasses' => "bordered-radio"
                    ])
                </div>
                <!-- Payment -->
            </div>
        </div>   
    </div>
    <div class="text-right mt-4">
        <button type="submit" class="button button-primary" id="complete-order">Confirm Order</button>
    </div>
</form>