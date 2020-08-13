<div class="form-group">
    <label for="featured">Featured Product</label>
    <select name="featured" id="featured" class="form-control">
        @if($product->featured == null)
            <option value="0" {{old('featured') == 0 ? "selected": "" }}>No</option>
            <option value="1" {{old('featured') == 1 ? "selected": "" }}>Yes</option>
        @else
            <option value="0" {{$product->featured == 0 ? 'selected': ''}}>No</option>
            <option value="1" {{$product->featured == 1 ? 'selected': ''}}>Yes</option>
        @endif
    </select>
    @if ($errors->has('featured'))
    <span class="fm-error">{{ $errors->first('featured')  }}</span>
    @endif
</div>