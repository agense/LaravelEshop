<form action=""  method="POST" id="order-status-processing-form" class="w-100">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="mini-header mb-4">Update order status</div>
    @include('partials.forms.fields.dynamic-select-field', [
            'name' => 'order_status',
            'label' => '',
            'loop' => $orderStatusOptions,
            'selected' => $order->status,
            ])
    <button type="submit" class="btn btn-success btn-md mt-2">Update Status</button>

</form> 