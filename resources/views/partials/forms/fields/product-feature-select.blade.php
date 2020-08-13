<div class="form-group">  
    <label for="{{$feature->slug}}">{{$feature->name}}</label>      
    <select name="{{$feature->slug}}" id="{{$feature->slug}}" class="form-control">
    <?php $selected = old($feature->slug) ?? $product->feature_list[$feature->slug] ?? null; ?>
        <option value="" {{null == $selected ? "selected" : ""}}>...</option>
        @foreach($feature->options as $option)
            <option value="{{formatTextToValue($option, false)}}" 
            {{$selected == formatTextToValue($option, false) ? "selected" : ""}}>{{formatToText($option)}}
        </option>
        @endforeach
    </select> 
    @if ($errors->has($feature->slug))
    <span class="fm-error">{{ $errors->first($feature->slug) }}</span>
    @endif
</div>