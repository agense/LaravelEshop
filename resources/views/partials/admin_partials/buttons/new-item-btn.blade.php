@if(isset($modal) && $modal == 'true')
<button type="button" class="btn btn-dark-border btn-md" data-toggle="modal" data-target="#{{$target}}">
    Add New
</button>
@else
    <a href="{{route($target)}}" class="btn btn-dark-border btn-md">Add New</a>
@endif