<div class="process-box mb-3">
    @if(isset($title))
      <div class="mini-header {{ (isset($flex) && $flex == true) ? "d-lg-flex justify-content-between align-items-baseline" : ""}}">
        {{$title}}
      </div>
      <div class="separator-narrow"></div>
    @endif
    {{$content}}
  </div>