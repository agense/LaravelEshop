<!--Features-->
<form action="{{route('pages.shop.index')}}" method="GET" id="shop-filter-form" class="mb-3">
    <div class="filter-holder">
        <div class="single-filter">
            <a class="shop-filter-link brand-filter" id="brand-filter" data-toggle="collapse" href="#" role="button" aria-expanded="false" aria-controls="filter-collapse">
                Brand<i class="fas fa-chevron-down"></i>
            </a>
            <div id="brand" class="brand-filter-holder shop-filter-holder brand collapse">
                @foreach($brands as $brand)
                    <div class="filter-checkbox-holder custom-control custom-checkbox">
                        <input type="checkbox" name="brand" id="{{$brand->slug}}" value="{{$brand->slug}}"
                        {{ isActiveFilter('brand', $brand->slug, $filters) ? "checked" : "" }}
                        class="custom-control-input">
                        <label for="{{$brand->slug}}" class="custom-control-label">
                            {{$brand->name}}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
            @foreach($features as $feature)
            <div class="single-filter">
            <a href="#" class="shop-filter-link {{$feature->slug."-filter"}}" id="{{$feature->slug."-filter"}}" data-toggle="collapse" 
                role="button" aria-expanded="false" aria-controls="filter-collapse">
                    {{$feature->name}}<i class="fas fa-chevron-down"></i>
                </a>
                <div id="{{$feature->slug}}" data-type="ft_{{$feature->slug}}" 
                    class="features {{$feature->slug."-filter-holder"}} shop-filter-holder collapse">
                    @include('partials.forms.fields.filter-checkbox-group', [
                        'inputPrefix' => 'ft_',
                        'name' => $feature->slug,
                        'options' => optionList($feature->options),
                    ])
                </div>
            </div>
            @endforeach
    </div>  
    <button type="submit" class="btn btn-md btn-dark w-100 mt-4">Filter</button>
</form>  
<!--End Features-->