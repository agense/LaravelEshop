@component('components.admin.table-display')
    @slot('tHead')
      <th>Id</td>
      <th>Order Nr. </th>
      <th>
        @include('partials.admin_partials.table_actions.sorter-header', ['sortKey'=>'order_date', 'colname'=>'Order Date', ])
      </th>
      <th>Billing Name</th>
      <th>
        @include('partials.admin_partials.table_actions.sorter-header', ['sortKey'=>'billing_total', 'colname'=>'Billing Total', 'type' => 'numeric'])
      </th>
      <th>
        @include('partials.admin_partials.table_actions.sorter-header', ['sortKey'=>'order_status', 'colname'=>'Order Status', ])
      </th>
      @if(isset($completeView) && $completeView == true)
        <th>Date Completed</th>
      @else 
        <th>Payment Status</th>
        <th>Delivery Status</th>   
      @endif
      <th style="width:120px"></th>
    @endslot

    @slot('tBody')
      @foreach($orders as $order)
      <tr>
        <td>{{$order->id}}</td>  
        <td>{{$order->order_nr}}</td>
        <td>{{$order->created_at}}</td>
        <td>{{$order->billing_details['name']}}</td>
        <td>{{formatMoney($order->billing_total)}}</td>
        <td>@include('partials.order_partials.order-status-badge')</td>
        @if(isset($completeView) && $completeView == true)
        <td>{{$order->completed_at}}</td>
        @else
          <td>
            @if($order->orderPaid())
              <span class="badge badge-success w-100">{{$order->payment_status}}</span>
            @else
              <span class="badge badge-light w-100">{{$order->payment_status}}</span>
            @endif
          </td>
          <td>{{$order->delivery->delivery_status}}</td>
        @endif
        <td class="text-right table-col-w-md">
          @include('partials.admin_partials.table_actions.show-btn-link', [
            'showUrl' => 'admin.orders.show', 
            'dataId' => $order->id 
          ])
            @include('partials.admin_partials.table_actions.edit-btn', [
              'editLink' => 'admin.orders.process.show', 
              'dataId' => $order->id 
            ])
        </td>
      </tr>
      @endforeach
    @endslot
@endcomponent