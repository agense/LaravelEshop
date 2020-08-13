@if(isset($editLink) && $editLink && is_string($editLink))
<a href="{{route($editLink, $dataId)}}" class="btn btn-success btn-sm">
    @if(isset($editTxt) && $editTxt && is_string($editTxt))
        {{$editTxt}}
    @else
    <i class=" fi fi-pencil"></i>
    @endif
</a>
@else
<button type="button" class="btn btn-success btn-sm edit-modal" data-id="{{$dataId}}"><i class="fi fi-pencil"></i></button>
@endif