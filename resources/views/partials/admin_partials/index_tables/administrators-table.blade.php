@component('components.admin.table-display')
    @slot('tHead')
      <th>Name</th>
      <th>Email</th>
      <th>Role</th>
      <th></th>
    @endslot

    @slot('tBody')
      @foreach($admins as $admin)
      <tr>
        <td>{{$admin->name}}</td>
        <td>{{$admin->email}}</td>
        <td>{{$admin->role}}</td>
        <td class="text-right">
          @include('partials.admin_partials.table_actions.edit-delete', 
          ['dataId' => $admin->id, 
          'deleteUrl' => 'admin.administrators.destroy',
          'confirmationText' => [
              'item' => 'administrator',
              'text' => 'This action is irreversible.'
              ]
          ])
        </td>
      </tr>
      @endforeach
    @endslot
  @endcomponent