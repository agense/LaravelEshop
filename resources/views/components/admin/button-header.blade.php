@if(isset($flex) && $flex == true)
<div class="header-button-block mb-4 {{ isset($addClass) ? $addClass : '' }}">
    {{$slot}}
</div>
@else
<div class="btn-block-right mb-4  {{ isset($addClass) ? $addClass : '' }}">
    {{$slot}}
</div>
@endif

