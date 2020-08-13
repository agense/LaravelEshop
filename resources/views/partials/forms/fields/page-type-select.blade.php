<div class="form-group">
    <label for="type">Page Type</label>
    <select name="type" id="type" class="form-control">
        @if($page->type == null)
            <option value="" disabled {{null == old('type') ? "selected" : ""}} >...</option>
            @foreach($pageTypes as $type)
            <option value="{{$type}}" {{old('type') == $type ? "selected" : ""}}>{{ucfirst($type)}}</option>
            @endforeach
        @else 
            @foreach($pageTypes as $type)
            <option value="{{$type}}" {{$page->type == $type ? "selected" : ""}}>{{ucfirst($type)}}</option>
            @endforeach
        @endif
    </select>
    @if ($errors->has('type'))
    <span class="fm-error">{{ $errors->first('type')  }}</span>
    @endif
</div>
