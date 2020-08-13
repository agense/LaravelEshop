@component('components.admin.table-display')
  @slot('tHead')
    <th class="w-25">Code</th>
    <th>Discount Type</th>
    <th class="text-center">Discount Value</th>
    <th class="text-center">Shown As Offer</th>
    <th>Activation Date</th>
    <th>Expiry Date</th>
    <th></td>
  @endslot

  @slot('tBody')
    @foreach($discountCodes as $code)
    <tr>
      <td class="w-25">
        <span>{{$code->code}}</span>
        @if($code->active)
        <span class="small-note">Active</span>
        @endif
      </td>
      <td>{{ucfirst($code->type)}}</td>
      <td class="text-center">{{$code->formatDiscount()}}</td>
      <td class="text-center">
        @if(isset($manageOffers) && $manageOffers == true)
        @include('partials.forms.featured-item-check', 
        ['route' =>"admin.codes.access", 'item' => $code, 'property' => 'public'])
        @else 
        <span>{{$code->public == 1 ? "Yes" : "No"}}</span>
        @endif
      </td>

      <td>{{$code->activation_date}}</td>
      <td>{{$code->expiration_date}}</td>
      @if(!isset($deactivatedView))
      <td class="text-right table-col-w-lg">
          @can('isAdmin')
          @include('partials.admin_partials.table_actions.edit-delete', [
            'deleteUrl' => 'admin.codes.destroy',
            'dataId' => $code->id,
            'confirmationText' => [
              'item' => 'discount code',
              'text' => 'Discount code will be deactivated and can be found in deactivated discount codes.'
            ]
          ])
          @endcan
      </td>
      @else 
      <td class="text-right table-col-wide">
        @can('isAdmin')
          @include('partials.admin_partials.table_actions.edit-delete', [
            'editLink' => 'admin.codes.restore',
            'editTxt' => 'Restore',
            'deleteUrl' => 'admin.codes.delete.final',
            'dataId' => $code->id,
            'deleteTxt' => 'Delete',
            'confirmationText' => [
              'item' => 'discount code',
              'text' => 'This action is irreversible.'
            ]
          ])
        @endcan
      </td>
      @endif
    </tr>
    @endforeach
  @endslot
@endcomponent