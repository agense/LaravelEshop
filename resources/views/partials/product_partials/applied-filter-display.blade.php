@if(isset($filters) && count(array_except($filters, ['category','sort','page'])) > 0)
    <div class="applied-filters">   
        <div class="applied-filters-header">
            <div>Filtered By</div>
            <a href="{{route('pages.shop.index', ['category' => request()->category,request()->sort])}}" class="filter-remover">
                Clear All<i class="fas fa-times ml-1"></i>
            </a>
        </div>
        <div class="applied-filter-holder">
            @foreach(array_except($filters, ['category','sort','page']) as $name => $value)
            <div class="applied-filter">
                <div class="fname">{{formatAsText($name)}}:</div>
                @if(is_string($value))
                    <span><i class="fas fa-check-circle mr-1"></i>
                        {{formatAsText($value)}}
                    </span>
                @else 
                    @foreach($value as $val)
                        <span><i class="fas fa-check-circle mr-1"></i>
                            {{formatAsText($val)}}
                        </span>
                    @endforeach
                @endif
            </div>
            @endforeach
        </div>
    </div>
@endif