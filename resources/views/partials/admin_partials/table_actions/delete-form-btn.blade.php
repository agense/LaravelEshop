<form action="{{ route($deleteUrl, $dataId) }}" method="POST" class="d-inline item-delete-form">
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
    @if(isset($confirmationText))
      @if(is_array($confirmationText))
        <input type="hidden" class="confirmation-details" 
            data-item="{{isset($confirmationText['item']) ? $confirmationText['item'] : ""}}"
            data-text="{{isset($confirmationText['text']) ? $confirmationText['text'] : ""}}"
          >
      @else
        <input type="hidden" class="confirmation-details" data-text="{{$confirmationText}}">
      @endif
    @endif
    <button type="submit" class="btn btn-primary btn-sm">
        @if(isset($deleteTxt) && $deleteTxt && is_string($deleteTxt))
           {{$deleteTxt}}
        @else     
            <i class="fi fi-recycle-bin-line"></i>
        @endif
    </button>
</form>