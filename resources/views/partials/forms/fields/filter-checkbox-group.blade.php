<div class="form-group">
    @foreach($options as $key => $value)
    <div class="filter-checkbox-holder custom-control custom-checkbox">
        <input type="checkbox" name="{{isset($inputPrefix) ? $inputPrefix : null}}{{$name}}" id="{{$value}}" 
        value="{{$value}}" {{ isActiveFilter($name, $value, $filters) ? "checked" : "" }}
        class="custom-control-input">
        <label for="{{$value}}" class="custom-control-label">
            {{$key}}
        </label>
    </div>
    @endforeach
</div>