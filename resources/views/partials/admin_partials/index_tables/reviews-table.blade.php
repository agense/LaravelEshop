@component('components.admin.table-display')
    @slot('tHead')
      <th class="w-20">Product</th>
      <th class="text-center table-col-sm">
        @include('partials.admin_partials.table_actions.sorter-header', 
        ['sortKey'=>'rating', 'colname' => 'Rating','type' => 'numeric'])
      </th>
      <th class="text-center">Customer</th>
      <th class="text-center">
        @include('partials.admin_partials.table_actions.sorter-header', 
        ['sortKey'=>'review_date', 'colname' => 'Review Date'])
      </th>
       @if(isset($deletedView) && $deletedView == true)
       <th>
        @include('partials.admin_partials.table_actions.sorter-header', 
        ['sortKey'=>'delete_date', 'colname' => 'Delete Date'])
       </th>
       <th>Deleted By</th>
       @endif
      <th></th>
    @endslot

    @slot('tBody')
      @foreach($reviews as $review)
      <tr>
        <td>
          <span class="d-block">{{$review->product->name}}</span>
          <small>{{$review->product->brand->name}}</small>
        </td>
        <td class="text-center">{{$review->rating}}</td>
        <td class="text-center">{{$review->user->name}}</td>
        <td class="text-center">{{$review->created_at}}</td>

        @if(isset($deletedView) && $deletedView == true)
        <td>{{$review->deleted_at}}</td>
        <td>{{$review->deleted_by}}</td>
        <td class="text-right table-col-x-wide">
            @include('partials.admin_partials.table_actions.show-btn-modal', [
              'showUrl' => 'admin.reviews.show', 
              'dataId' => $review->id 
            ])
            @include('partials.admin_partials.table_actions.edit-delete', [
              'editLink' => 'admin.reviews.restore',
              'editTxt' => 'Restore',
              'deleteUrl' => 'admin.reviews.delete.final',
              'dataId' => $review->id,
              'deleteTxt' => 'Delete',
              'confirmationText' => [
                'item' => 'review',
                'text' => 'This action is irreversible.'
              ],
              'protectedDelete' => true
            ])
        </td>
        @else
        <td class="text-right table-col-w-md">
            @include('partials.admin_partials.table_actions.show-btn-modal', [
              'showUrl' => 'admin.reviews.show', 
              'dataId' => $review->id 
            ])
            @include('partials.admin_partials.table_actions.delete-form-btn', [
              'deleteUrl' => 'admin.reviews.delete',
              'dataId' => $review->id,
              'confirmationText' => [
                'item' => 'review',
                'text' => 'Review will be deactivated and can be found in deleted reviews.'
              ]
            ])
        </td>
        @endif
      </tr>
      @endforeach
    @endslot
  @endcomponent
   