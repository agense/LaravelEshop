@component('components.admin.table-display')
    @slot('tHead')
      <th class="w-25">Title</th>
      <th class="w-25">Type</th>
      <th></th>
    @endslot

    @slot('tBody')
      @foreach($pages as $page)
      <tr>
        <td class="w-25">{{ ucfirst($page->title) }}</td>
        <td class="w-25">{{ ucfirst($page->type) }}</td>
        <td class="text-right table-col-w-md">
            @can('isAdmin')
            @include('partials.admin_partials.table_actions.edit-delete', 
            ['editLink' => 'admin.pages.edit',
            'dataId' => $page->id, 
            'deleteUrl' => 'admin.pages.destroy',
            'confirmationText' => [
                'item' => 'page',
                'text' => 'This action is irreversible.'
                ]
            ])
            @endcan
        </td>
      </tr>
      @endforeach
    @endslot
  @endcomponent