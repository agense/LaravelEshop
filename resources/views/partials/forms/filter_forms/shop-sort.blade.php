<div class="dropdown">
    <button class="btn dropdown-toggle border-btn" type="button" id="sortListBtn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span>Sort</span>
    <span><i class="fas fa-chevron-down"></i></span>
    </button>
        <div class="dropdown-menu" aria-labelledby="sortListBtn">
            <a href="{{ route('pages.shop.index', ['category' => request()->category,'sort' => 'price:asc'])}}"
                class="sort-list-item shop-sorter" data-filter="price:asc">
                Price (Low to High)
            </a>
            <a href="{{ route('pages.shop.index', ['category' => request()->category,'sort' => 'price:desc'])}}"
                class="sort-list-item shop-sorter" data-filter="price:desc">
                Price (High to Low)
            </a>         
        </div>
</div>  