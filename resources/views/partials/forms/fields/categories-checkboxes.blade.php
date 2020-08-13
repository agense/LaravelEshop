<div class="form-group">
    @if($product->categories->count() == 0)
        @foreach($categories as $category)
        <div class="custom-control custom-checkbox">
            <input type="checkbox" name="categories[]" value="{{$category->id}}" class="custom-control-input" id="{{$category->name}}"
            {{ (old('categories') && in_array($category->id, old('categories'))) ? "checked" : ""}} >
            <label for="{{$category->name}}" class="custom-control-label">{{$category->name}}</label>
        </div>
        @endforeach
    @else
        @foreach($categories as $category)
        <div class="custom-control custom-checkbox">
            @if(in_array($category->id, $product->category_ids))
                <input type="checkbox" name="categories[]" value="{{$category->id}}" checked  class="custom-control-input" id="{{$category->name}}">
                <label for="{{$category->name}}" class="custom-control-label">{{$category->name}}</label>
            @else
                <input type="checkbox" name="categories[]" value="{{$category->id}}" class="custom-control-input" id="{{$category->name}}"> 
                <label for="{{$category->name}}" class="custom-control-label">{{$category->name}}</label>
            @endif
        </div>
        @endforeach
    @endif
    @if ($errors->has('categories'))
    <span class="fm-error">{{ $errors->first('categories')  }}</span>
    @elseif($errors->has('categories.*'))
    <span class="fm-error">{{ $errors->first('categories.*')  }}</span>
    @endif
</div>

