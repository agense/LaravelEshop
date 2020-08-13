@component('components.admin.table-display')
@slot('tHead')
  <th></th>
  <th class="w-20">
    @include('partials.admin_partials.table_actions.sorter-header', ['sortKey'=>'name', 'type' => 'alpha'])
  </th>
  <th>Brand</th>
  <th class="col-w-md">
    @include('partials.admin_partials.table_actions.sorter-header', ['sortKey'=>'price','type' => 'numeric'])
  </th>
  @if(isset($deletedView) && $deletedView == true)
    <th class="text-center">Items Sold</th>
  @else
    <th class="text-center col-w-md">
      @include('partials.admin_partials.table_actions.sorter-header', ['sortKey'=>'quantity', 'type' => 'numeric'])
    </th>
    <th class="text-center">
      @include('partials.admin_partials.table_actions.sorter-header', ['sortKey'=>'featured'])
    </th>
  @endif
  <th></th>
@endslot

@slot('tBody')
  @foreach($products as $product)
  <tr>
    <td>
      <div class="table-img">
        <img src="{{ asset($product->featured_image_link)}}" alt="{{$product->name}}">
      </div>
    </td>  
    <td>{{$product->name}}</td>
    <td>{{strtoupper($product->brand->name)}}</td>
    <td>{{$product->displayPrice()}}</td>

    @if(isset($deletedView) && $deletedView == true)
    <td class="text-center">{{$product->orders_count}}</td>
    <td class="text-right table-col-wide">
      @include('partials.admin_partials.table_actions.edit-delete', [
          'editLink' => 'admin.products.restore',
          'editTxt' => 'Restore',
          'deleteUrl' => 'admin.products.delete.final',
          'dataId' => $product->id,
          'deleteTxt' => 'Delete',
          'confirmationText' => [
            'item' => 'product',
            'text' => 'This action is irreversible.'
          ],
          'protectedDelete' => true
        ])
    </td>

    @else
    <td class="d-flex justify-content-around align-items-center col-w-md" data-url="{{route("admin.products.quantity", $product->id)}}" data-toggle="modal" data-target="#editQtyModal">
      <span class="product-quantity product-quantity-boxed">{{$product->availability}} </span>
      <a href="#" class="btn btn-success btn-sm"><i class=" fi fi-pencil"></i></a>
    </td>
    <td class="text-center">
        @include('partials.forms.featured-item-check', 
        ['route' =>"admin.products.featured", 'item' => $product, 'property' => 'featured'])
    </td>
    <td class="text-right table-col-w-md">
      @include('partials.admin_partials.table_actions.edit-delete', 
      ['editLink' => 'admin.products.edit',
      'dataId' => $product->id, 
      'deleteUrl' => 'admin.products.destroy',
      'confirmationText' => [
          'item' => 'product',
          'text' => 'The product will be deactivated and can be found in deleted products list.'
          ]
      ])
    </td>
    @endif
  </tr>
  @endforeach
@endslot
@endcomponent