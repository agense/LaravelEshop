
<div class="filters">
     <div class="single-filter">
        <a href="#" class="filter-link cat-filter"  id="cat-filter">Categories <i class="fas fa-chevron-down"></i></a>
        <div class="f-list cat-filter-holder">
            <ul class="filter-list mb-3">
                @foreach($categories as $category)
                <li class="filter-list-item {{ setActiveCategory($category->slug) }}"> 
                    {{--Attaching a query string to url--}}
                    <a href="{{ route('pages.shop.index', ['category' => $category->slug]) }}">
                        @if(request()->category == $category->slug)
                            <i class="fa fa-arrow-circle-right px-1"></i>
                        @endif
                    <span>{{ $category->name }}</span> 
                    <span>({{$category->products->count()}})</span>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div>
        <a href="#" class="filter-link all-filters"  id="all-filters">Filters <i class="fas fa-chevron-down"></i></a>
        <div class="f-list all-filters-holder">
            @include('partials.product_partials.applied-filter-display')
            @include('partials.forms.filter_forms.shop-filter-form')
        </div>
    </div>
</div> 