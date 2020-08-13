<div class="form-group">
    @foreach($options as $key => $value)
    <div class="{{isset($addClasses) ? $addClasses : ""}}">
    <div class="custom-control custom-radio">
        <input class="custom-control-input" type="radio" name="{{$name}}" id="{{$value}}" 
        value="{{$value}}" {{ (old($name) == $value) ? 'checked' : ''}}>
        <label class="custom-control-label" for="{{$value}}">
        {{$key}}
        </label>
    </div>
    </div>
    @endforeach
    @if ($errors->has($name))
        <span class="fm-error d-block mb-2">{{ $errors->first($name)  }}</span>
    @endif
</div>