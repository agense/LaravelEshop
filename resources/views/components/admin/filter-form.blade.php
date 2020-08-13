<div class="pt-2 pb-4 {{!empty(array_except($filters, ['search'])) ? "" : "collapse"}}" id="filter-collapse">
    <form action="{{route($targetUrl)}}" method="GET" id="filter-form" class="filter-form">  
        <div class="filter-box-holder">
            <div class="form-mini-grid">
                {{$left}}
            </div> 
            <div class="form-mini-grid">
                {{$middle}}
            </div> 
            <div class="form-mini-grid">
                {{$right}}
            </div> 
            <button class="btn btn-dark btn-sm">Filter</button>
        </div>
    </form>
</div>
@if(!empty($filters))
<div class="text-right pb-1">
    <a href="{{route($targetUrl)}}" class="filter-remover">
        <i class="fas fa-times mr-1"></i>Clear All Filters
    </a>
</div>
@endif