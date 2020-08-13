@component('components.admin.table-display')
      @slot('tHead')
        <th>Category Name</th>
        <th class="text-center">Products In</th>
        <th></th>
      @endslot

      @slot('tBody')
        @foreach($categories as $category)
        <tr>
          <td>{{$category->name}}</td>
          <td class="text-center">{{$category->products_count}}</td>
          <td class="text-right col-w-md">
              @can('isAdmin')
              @include('partials.admin_partials.table_actions.edit-delete', 
              ['dataId' => $category->id, 
              'deleteUrl' => 'admin.categories.destroy',
              'confirmationText' => [
                    'item' => 'category',
                    'text' => 'This action is irreversible.'
              ]
              ])
              @endcan
          </td>
        </tr>
        @endforeach
      @endslot
  @endcomponent