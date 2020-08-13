<div class="form-group">
    @if((isset($label) && $label !== ''))
      <label for="{{$name}}">{{$label}}</label>
    @elseif(!isset($label)) 
      <label for="{{$name}}">{{strtoupper(str_replace('_', ' ', $name))}}</label>
    @endif
    <select name="{{$name}}" id="{{$name}}" class="form-control">
        @foreach($loop as $key => $value)
        <option value="{{$value}}" {{ (strtolower($selected) == strtolower($value)) ? 'selected=selected' : ""}}>
          {{$key}}
        </option>
        @endforeach
    </select>
    @if ($errors->has($name))
    <span class="fm-error">{{ $errors->first($name)}}</span>
    @endif
</div>