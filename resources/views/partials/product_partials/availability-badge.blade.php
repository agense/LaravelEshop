<span class="badge badge-rounded">
@if($availability > 3)
   In Stock
@elseif($availability <= 3 && $availability > 0)
   Only {{$availability}} {{ $availability == 1 ? ' item ' : ' items '}} left
@else
   Sold Out
@endif
</span>