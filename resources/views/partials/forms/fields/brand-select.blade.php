<div class="form-group">  
    <label for="brand_id">Brand</label>      
    <select name="brand_id" id="brand_id" class="form-control">
            @if($product->brand == null)
                <option value="" {{ old('brand_id') == null ? "selected" : "" }} disabled>...</option>
                @foreach($brands as $brand)
                    <option value="{{$brand->id}}" {{old('brand_id') == $brand->id ? "selected=selected": ""}}>{{$brand->name}}</option>
                @endforeach
            @else 
                @foreach($brands as $brand)
                <option value="{{$brand->id}}" {{$product->brand->id == $brand->id ? "selected=selected": ""}}>{{$brand->name}}</option>
                @endforeach
            @endif
    </select> 
    @if ($errors->has('brand_id'))
    <span class="fm-error">{{ $errors->first('brand_id')  }}</span>
    @endif  
</div>