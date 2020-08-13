<span class="btn-sm featured-item" data-url="{{route($route, $item->id)}}">
    @if($item->$property == 1)
    <i class="fi fi-check-mark"></i>
    @else 
    <i class="fi fi-square-line"></i>
    @endif
  </span>