<form action="{{$product->id == null ? route('admin.products.store') : route('admin.products.update', $product->id)}}" method="POST" enctype="multipart/form-data">    
    {{ csrf_field() }}
    @if($product->id !== null)
        {{ method_field('PUT')}}
    @endif
    <div class="grid-2 product-form-section">
        <div>
            <div class="form-group">
                <label for="name">Name</label>
                <input  type="text" name="name" id="name" value="{{old('name', $product->name)}}" class="form-control">
                @if ($errors->has('name'))
                <span class="fm-error">{{ $errors->first('name')  }}</span>
                @endif
            </div>
            
            @include('partials.forms.fields.brand-select')

            <div class="form-group">
                    <label for="price">Price</label>
                    <input  type="text" name="price" id="price" value="{{old('price', $product->price)}}" class="form-control">
                    @if ($errors->has('price'))
                    <span class="fm-error">{{ $errors->first('price')  }}</span>
                    @endif
            </div>
            <div class="form-group">
                    <label for="availability">Availability</label>
                    <input  type="number" min="0" name="availability" id="availability" value="{{old('availability', $product->availability)}}" class="form-control">
                    @if ($errors->has('availability'))
                    <span class="fm-error">{{ $errors->first('availability')  }}</span>
                    @endif
            </div>
            @include('partials.forms.fields.featured-select')
        </div>
        <div>
            @include('partials.forms.fields.product-image-uploads')
        </div>
    </div>

    <div class="mini-header">Categories</div>
    <div class="separator-narrow"></div>
    <div class="product-form-section">
         @include('partials.forms.fields.categories-checkboxes')
    </div>

    <div class="mini-header">Specifications</div>
    <div class="separator-narrow"></div> 
    <div class="product-form-section grid-3">
        @foreach($features as $feature)
            @include('partials.forms.fields.product-feature-select')
        @endforeach
    </div>

    <div class="mini-header">Description</div>
    <div class="separator-narrow"></div>   
    <div class="product-form-section">              
        <div class="form-group">
            <label for="description" class="hide">Description</label>
            <textarea name="description" id="description">{{old('description', $product->description)}}</textarea>
            @if ($errors->has('description'))
            <span class="fm-error">{{ $errors->first('description')  }}</span>
            @endif
        </div>
    </div>  
    <div class="text-right">
        <div class="separator-narrow mb-4"></div> 
        <button type="submit" class="btn btn-success btn-md">
            {{$product->id == null ? 'Create Product' : 'Update Product'}}
        </button>
    </div>
</form>   