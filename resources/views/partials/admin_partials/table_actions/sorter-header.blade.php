<div class="d-flex justify-content-between align-items-center">
    <span class="col-name" data-target={{$sortKey}}>{{isset($colname) ? $colname : ucfirst($sortKey)}}</span>
    <div class="sorter {{!empty($sort['column']) && $sort['column'] == $sortKey ? 'active-sort' : ''}}">
      @if(!empty($sort['column']) && $sort['column'] == $sortKey && $sort['order'] == 'ASC')
        <i class="fas fa-sort-{{isset($type) ? $type.'-up' : 'amount-up-alt'}}"></i>
      @else
        <i class="fas fa-sort-{{isset($type) ? $type.'-down' : 'amount-down-alt'}}"></i>
      
      @endif
    </div>
</div>