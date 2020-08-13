<form action="{{route($targetUrl)}}" method="GET" class="search-form" id="search-form" >
    <input type="text" name="search" id="search" class="form-control" 
    value="{{array_key_exists('search', $filters) ? $filters['search'] : ""}}"
    placeholder="{{isset($text) ? $text : 'Search'}}">
    <button type="submit" class="btn btn-primary btn-sm search-btn"><i class="fas fa-search"></i></button>
</form>
