@component('components.admin.table-display')
    @slot('tHead')
      <th>Feature</th>
      <th></th>
    @endslot

    @slot('tBody')
      @foreach($features as $feature)
      <tr>
        <td>{{$feature->name}}</td>
        <td class="text-right">
              <button class="btn btn-sm btn-dark-border feature-options-modal-btn" data-url="{{route("admin.features.edit", $feature->id)}}">Options</button>
              <div class="d-inline-block table-col-w-md">
                  @include('partials.admin_partials.table_actions.edit-delete', 
                  ['dataId' => $feature->id, 
                  'deleteUrl' => 'admin.features.destroy',
                  'confirmationText' => [
                      'item' => 'product feature',
                      'text' => 'This action is irreversible.'
                      ]
                  ])
              </div>
        </td>
      </tr>
      @endforeach
    @endslot
@endcomponent