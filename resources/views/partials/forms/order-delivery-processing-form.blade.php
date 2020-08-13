<form action="" method="POST" id="order-delivery-processing-form" class="w-100">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="mini-header mb-4">Update order delivery status</div>
    @include('partials.forms.fields.dynamic-select-field', [
            'name' => 'delivery_status',
            'label' => '',
            'loop' => $deliveryStatusOptions,
            'selected' => $order->delivery->delivery_status,
            ])
            <button type="submit" class="btn btn-success btn-md mt-2">Update</button>    
</form> 