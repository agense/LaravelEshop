@extends('layouts.admin')

@section('title')
<h1 class="topnav-heading">Products</h1>
@endsection
@section('content')
<div class="d-lg-flex justify-content-between align-items-baseline">
  <div class="mb-3 d-flex align-items-baseline">
      <a class="btn-filter" data-toggle="collapse" href="#filter-collapse" role="button" aria-expanded="false" aria-controls="filter-collapse">
          Filter <i class="fas fa-chevron-down"></i>
        </a>
        <a class="btn-filter" data-toggle="collapse" href="#search-collapse" role="button" aria-expanded="false" aria-controls="search-collapse">
            Search <i class="fas fa-chevron-down"></i>
        </a>
  </div>
    @can('isAdmin')
    <a href="{{route('products.create')}}" class="btn btn-success btn-md">Add New</a>
    @endcan
</div>

<div id="filter-collapse" class="my-4 {{$filterName == '' ? 'collapse' : ''}}">  
<div class="separator"></div>  
<form action="#" method="GET" class="form-inline" id="filter-form">
    <div class="mr-3">FILTER BY</div>
    <select id="filter-name" class="form-control mr-3 filter">
      <option value="" disabled {{$filterName == '' ? 'selected' : ""}}>...</option>
      <option value="brand" {{$filterName == 'brand' ? 'selected' : ""}}>Brand</option>
      <option value="category" {{$filterName == 'category' ? 'selected' : ""}}>Category</option>
      <option value="availability" {{$filterName == 'availability' ? 'selected' : ""}}>Availability</option>
      <option value="price" {{$filterName == 'price' ? 'selected' : ""}}>Price</option>
      <option value="featured" {{$filterName == 'featured' ? 'selected' : ""}}>Featured</option>
    </select>
    <select id="filter-value" class="form-control mr-3 filter">
    </select>
    <button type="submit" class="btn btn-success btn-md">Filter</button>
  </form>
</div>

<div id="search-collapse" class="my-4 {{$searchName == '' ? 'collapse' : ''}}">
    <div class="separator"></div>  
    <form action="#" method="GET" class="form-inline" id="order-search-form">
    <div class="mr-3">SEARCH BY NAME</div>
      <input type="text" value="" class="form-control mr-3" id="search-value">
      <button type="submit" class="btn btn-success btn-md">Search</button>
    </form>
</div>
<div class="separator"></div>

@if(count($products) > 0)
<table class="table table-hover table-sm">
    <thead>
          <tr>
            <td></td>
            <td>Name</td>
            <td>Brand</td>
            <td>Price</td>
            <td class="text-center col-w-md">Quantity</td>
            <td class="text-center">Featured</td>
            <td></td>
          </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
          <td>
            <div class="table-img">
              <img src="{{ asset($product->featuredImage())}}" alt="{{$product->name}}">
            </div>
          </td>  
          <td>{{$product->name}}</td>
          <td>{{strtoupper($product->brand->name)}}</td>
          <td>{{$product->displayPrice()}}</td>
          <td class="d-flex justify-content-around align-items-center col-w-md" data-id="{{$product->id}}" data-toggle="modal" data-target="#editQtyModal">
            <span class="product-quantity product-quantity-boxed">{{$product->availability}} </span>
            @can('isAdmin')
            <a href="#" class="btn btn-success btn-sm"><i class=" fi fi-pencil"></i></a>
            @endcan
          </td>
          <td class="text-center">
            <span class="btn-sm featured-item" data-id="{{$product->id}}">
            @if($product->featured == 1)
            <i class="fi fi-check-mark"></i>
            @else 
            <i class="fi fi-square-line"></i>
            @endif
          </span>
          </td>
          <td class="text-right">
            <a href="{{route('products.show', $product->id)}}" class="btn btn-warning btn-sm"><i class="fi fi-eye"></i></a>
            @can('isAdmin')
            <a href="{{route('products.edit', $product->id)}}" class="btn btn-success btn-sm"><i class=" fi fi-pencil"></i></a>
            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Delete this product?')"><i class="fi fi-recycle-bin-line"></i></button>
            </form>
            @endcan
          </td>
        </tr>
        @endforeach
    </tbody>
</table>  
<div class="mt-5">
  {{ $products->appends(request()->input())->links() }}
</div>
 
<!-- Modal -->
<div class="modal modal-custom fade" id="editQtyModal" tabindex="-1" role="dialog" aria-labelledby="editQtyModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editQtyModalTitle">Update Product Quantity</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-errors alert alert-danger hide"></div>
          <div class="form-success alert alert-success hide"></div>
          <form action="#" id="qtyUpdateForm" class="form-inline justify-content-between">
          <div class="form-group">
            <label for="newquantity">New Quantity</label>
            <input type="number" min="0" id="newquantity" class="form-control form-control-narrow">
          </div>
          <button type="submit" class="btn btn-success btn-md">Update</button>
        </form>
        </div>
      </div>
    </div>
  </div>
  <!--End Modal-->
  @else 
  <div class="no-items">No products were found.</div>
  @endif 
@endsection

@section('extra-footer')
<script>
(function(){
  /* FILTERS FUNCTIONALITY */
  let brands = [];
  let categories = [];
  let featuredOptions = [
    { name : 'Yes', value: 1}, 
    { name : 'No', value: false }
  ];
  const availabilityOptions = [
    { name : 'Sold Out', value: 'filter&to=0'},
    { name : 'Low (1 - 5) ', value: 'filter&from=1&to=5' },
    { name : 'Medium (6 - 20)', value: 'filter&from=6&to=20' },
    { name : 'High ( > 20)', value: 'filter&from=20' }
  ];
  const priceOptions = [
    { name : '< 1000 ', value: 'filter&to=1000'},
    { name : '1000 - 2000', value: 'filter&from=1001&to=2000' },
    { name : '2000 - 10000', value: 'filter&from=2000' }
  ];

  const url = "/admin/products";
  const fm = $('#filter-form');
  const filter = $('#filter-name');
  const filterValue = $('#filter-value');

  if(filter.val() !== null){
    setFilters();
  }

  // fill selectable items array
  filter.on('change', ()=>{
    setFilters();
  });

  //item filters
  function setFilters(){
    //filter by brand
    filterValue.children().remove();
    if(filter.val() == 'brand'){
      if(brands.length > 0){
        setFilterValues(brands);
      }else{
        getBrands();
      }
    }
    else if(filter.val() == 'category'){
      if(categories.length > 0){
        setFilterValues(categories);
      }else{
        getCategories();
      }  
    }
    else if(filter.val() == 'featured'){
        setFilterValues(featuredOptions);
    }
    else if(filter.val() == 'availability'){
        setFilterValues(availabilityOptions);
    }
    else if(filter.val() == 'price'){
        setFilterValues(priceOptions);
    }else{
      filterValue.children().remove();
    }
  }

  //get all brands
  function getBrands(){
    axios.get('brands/list')
    .then(function (response){
      brands = response.data;
      setFilterValues(brands);
    })
    .catch(function(error){
      toastr.error('Sorry, no brands were found');
    });
  }

  //get all categories
    function getCategories(){
    axios.get('categories/list')
    .then(function (response){
      categories = response.data;
      setFilterValues(categories);
    })
    .catch(function(error){
      toastr.error('Sorry, no categories were found');
    });
  }
  
  //create option for select lists, using data from ajax response
  function setFilterValues(items){
    //get query string to set current value
    let queryStr = window.location.search;
    let start = queryStr.indexOf("=");
    let filterV = queryStr.substr(start+1);  

    let filterItems = "";
    for(let key in items){
      let obj = items[key];
      if(obj.hasOwnProperty('slug')){
        filterItems += `<option value="${obj.slug}" ${filterV == obj.slug ? "selected" : ""}>${obj.name}</option>`
      }else if(obj.hasOwnProperty('value')){
        filterItems += `<option value="${obj.value}" ${filterV == obj.value ? "selected" : ""}>${obj.name}</option>`
      }
    }
      filterValue.append(filterItems);
  }

  //filter items on submit
  fm.on('submit', (e)=>{
    e.preventDefault();
    let filterName = filter.val();
    let filterVal = filterValue.val();
    if(filterName && filterVal){
      let query = encodeURI('?'+filterName+'='+filterVal);
      window.location.replace(url+query);
    }
  });
/* END OF FILTERS FUNCTIONALITY*/

/*SEARCH FUNCTIONALITY*/
const searchfm = $('#order-search-form');
const searchValue = $('#search-value');
  
searchfm.on('submit', (e)=>{
    e.preventDefault();
    let searchVal = searchValue.val();
    if(searchVal){
      let query = encodeURI('?name'+'='+searchVal);
      window.location.replace(url+query);
    }
});
  /*END OF SEARCH FUNCTIONALITY*/

/*FEATURED PRODUCTS FUNCTIONALITY*/
const  featuredItems = $('.featured-item');

$(featuredItems).each(function(index, element){
   $(element).on('click', function(e){
     let holder = e.target.parentElement;
     let id = holder.getAttribute('data-id');    

    axios.get(`products/featured/${id}`)
    .then((response)=>{
      if(response.data.status == "success"){
        if(response.data.featured == 1){
        holder.innerHTML = '<i class="fi fi-check-mark"></i>';
        holder.style.color = "#18BC9C";
      }else{
        holder.innerHTML = '<i class="fi fi-square-line"></i>';
        holder.style.color = "#989898";
      }
      }
    })
    .catch(function(error){
      toastr.error('There was an error.');
    });
   })
});
/* END OF FEATURED PRODUCTS FUNCTIONALITY*/
})();  

/* EDIT QUANTITY & MODAL FUNCTIONALITY */
$('#editQtyModal').on('show.bs.modal', function (e) {
  let targetProduct = e.relatedTarget;
  let productId = targetProduct.getAttribute('data-id');
  $('#qtyUpdateForm').on('submit', function(){
     let qty = $('#newquantity').val();

     //front end error validation
     if(qty == ""){
      $('.form-errors').html('Quantity is required').slideDown('hide').delay(3000).slideUp();
     }else if(qty < 0){
      $('.form-errors').html('Quantity cannot be less than 0').slideDown('hide').delay(3000).slideUp();
     }else{
        axios.post(`/admin/product/updateQuantity/${productId}`, {
          'newquantity' : qty
        })
        .then(function (response) {
          if(response.data.status == "success"){
           $('.form-success').html(`${response.data.msg}`).slideDown('hide').delay(300)
              .slideUp(300, function() {
                  // Hide Modal
                  $('#editQtyModal').modal('hide');
               });
             // change quantity in dom
              $(targetProduct).find('span.product-quantity').html(qty);
              //clear input field
              $('#newquantity').val('');   
          }else{
            //display errors
            let errors = "";
            $(response.data.errors.newquantity).each(function(index, element){
              errors += '<div>'+ element + '</div>';
            })
            $('.form-errors').html(errors).slideDown('hide').delay(5000).slideUp();
          }
        })
        .catch(function (error) {
          $('.form-errors').html(error.message).slideDown('hide').delay(3000).slideUp();
        });
     }
  })
})
/* END OF EDIT QUANTITY & MODAL FUNCTIONALITY */
</script>
@endsection