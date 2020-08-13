@component('components.admin.filter-form', ['targetUrl' => $targetUrl, 'filters' => $filters])
  @slot('left') 
    <!--Category and Brand-->    
    <div class="form-group">
        <label for="category">Category</label>
        <select name="category" id="category" class="form-control">
            <option value=""> -- </option>
            @foreach($categories as $category)
            <option value="{{$category->slug}}" 
                {{ (array_key_exists('category', $filters) && $filters['category'] == $category->slug ? "selected=selected" : "")}}> 
            {{$category->name}} 
            </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="brand">Brand</label>
        <select name="brand" id="brand" class="form-control">
            <option value=""> -- </option>
            @foreach($brands as $brand)
            <option value="{{$brand->slug}}" 
                {{ (array_key_exists('brand', $filters) && $filters['brand'] == $brand->slug ? "selected=selected" : "")}}> 
            {{$brand->name}} 
            </option>
            @endforeach
        </select>
    </div>
    <!--End Category and Brand-->
  @endslot

  @slot('middle')
    <!--Price-->
    <div class="form-group">
        <label for="price_min">Price From</label>
        <input type="number" id="price_min" name="price_min"  min="0" class="form-control"
        value="{{array_key_exists('price_min', $filters) ? $filters['price_min'] : ''}}">
    </div>
    
    <div class="form-group">
        <label for="price_max">Price To</label>
        <input type="number" id="price_max" name="price_max"  min="100" class="form-control"
        value="{{array_key_exists('price_max', $filters) ? $filters['price_max'] : ''}}">
    </div>
  <!--End Price-->
  @endslot

  @slot('right')
    <!--Availability-->
    <div class="form-group">
        <label for="availability">Availability</label>
        <input type="number" id="availability" name="availability"  min="0" step="1" class="form-control"
        value="{{array_key_exists('availability', $filters) ? $filters['availability'] : ''}}">
    </div>
    <!--End availability-->
    <!--Featured-->
        <div class="form-group">
            <label for="featured">Featured</label>
            <select name="featured" id="featured" class="form-control">
                <option value=""> -- </option>
                <option value="1" {{(array_key_exists('featured', $filters) && $filters['featured'] == 1 ? "selected=selected" : "")}}> 
                Yes
                </option>
                <option value="0" {{(array_key_exists('featured', $filters) && $filters['featured'] == 0 ? "selected=selected" : "")}}> 
                    No
                </option>
            </select>
        </div>
    <!--End Featured-->
  @endslot
@endcomponent
