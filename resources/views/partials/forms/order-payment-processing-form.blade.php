<form action="" method="POST" id="order-payment-processing-form" class="w-100">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="mini-header">Process Payment</div>
    <div class="separator-narrow"></div>
    <!-- Payment Processing Admin Name-->
    <div class="form-group">
        <label for="payment_processor">PAYMENT PROCESSING BY</label>
        <input type="text" name="payment_processor" id="payment_processor" class="form-control" disabled 
            value="{{auth()->user()->name}}" >
    </div>
    <!-- Payment Type-->
    <div class="form-group">
        <label for="payment_type">PAYMENT TYPE</label>
        <input type="text" name="payment_type" id="payment_type" class="form-control" disabled 
         value="{{$order->payment_type}}" >
    </div>
    <!-- Payment Amount-->
    <div class="form-group">
        <label for="payment_amount">PAYMENT AMOUNT</label>
        <input type="text" name="payment_amount" id="payment_amount" class="form-control" disabled 
         value="{{formatMoney($order->billing_total)}}" >
    </div>
    <!-- Payment Method-->
    @include('partials.forms.fields.dynamic-select-field', [    
            'name' => 'payment_method',
            'loop' => $paymentMethods,
            'selected' => "",
     ])
    <button type="submit" class="btn btn-success btn-md d-block mt-4 mb-3">Confirm Payment</button>
</form>