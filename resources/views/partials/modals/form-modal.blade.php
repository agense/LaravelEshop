<div class="modal fade" id="{{$type.'FormModal'}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            @if($type == 'slider')
              <span class="dynamic-title">Add New</span>&nbsp;Slide
            @else
              <span class="dynamic-title">Add New</span>&nbsp;{{$type}}
            @endif
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="modal-form-holder">
                @include('partials.forms.'.$type.'-form')
            </div>
        </div>
        <div class="modal-footer"></div>
      </div>
    </div>
  </div>