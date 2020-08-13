@component('components.admin.table-display')
@slot('tHead')
  <th>Brand Name</th>
  <th class="text-center">Brand Products</th>
  <th></th>
@endslot

@slot('tBody')
    @foreach($brands as $brand)
    <tr>
      <td>{{$brand->name}}</td>
      <td class="text-center">{{$brand->products_count}}</td>
      <td class="text-right col-w-md">
          @can('isAdmin')
          @include('partials.admin_partials.table_actions.edit-delete', 
          ['dataId' => $brand->id, 
          'deleteUrl' => 'admin.brands.destroy',
          'confirmationText' => [
            'item' => 'brand',
            'text' => 'This action is irreversible. All products belonging to the brand will also be deleted.'
            ]
          ])
          @endcan
      </td>
    </tr>
    @endforeach
@endslot
@endcomponent