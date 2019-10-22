@extends('layouts.admin')

@section('title')
<h1 class="topnav-heading">Orders</h1>
@endsection
@section('content')
<div class="mb-3 d-flex align-items-baseline">
      <a class="btn-filter" data-toggle="collapse" href="#search-collapse" role="button" aria-expanded="false" aria-controls="search-collapse">
          Search <i class="fas fa-chevron-down"></i>
      </a>
      <a class="btn-filter" data-toggle="collapse" href="#filter-collapse" role="button" aria-expanded="false" aria-controls="filter-collapse">
        Filter <i class="fas fa-chevron-down"></i>
      </a>
</div>

    <div id="search-collapse" class="my-4 {{$searchName == '' ? 'collapse' : ''}}">
      <div class="separator"></div>  
      <form action="#" method="GET" class="form-inline" id="order-search-form">
      <div class="mr-3">Search By</div>
        <select id="search-name" class="form-control mr-3 filter">
          <option value="" disabled {{$searchName == '' ? 'selected' : ""}}>...</option>
          <option value="name" {{$searchName == 'name' ? 'selected' : ""}}>Customer Name</option>
          <option value="ordernr" {{$searchName == 'ordernr' ? 'selected' : ""}}>Order Number</option>
        </select>
        <input type="text" value="" class="form-control mr-3" id="search-value">
        <button type="submit" class="btn btn-success btn-md">Search</button>
      </form>
    </div>

    <div id="filter-collapse" class="my-4 {{$filterName == '' ? 'collapse' : ''}}">  
      <div class="separator"></div>  
      <form action="#" method="GET" class="form-inline" id="order-filter-form">
        <div class="mr-3">Filter By</div> 
        <select id="filter-name" class="form-control mr-3 filter">
          <option value="" disabled {{$filterName == '' ? 'selected' : ""}}>...</option>
          <option value="orderstatus" {{$filterName == 'orderstatus' ? 'selected' : ""}}>Order Status</option>
          <option value="paymentstatus" {{$filterName == 'paymentstatus' ? 'selected' : ""}}>Payment Status</option>
          <option value="deliverystatus" {{$filterName == 'deliverystatus' ? 'selected' : ""}}>Delivery Status</option>
        </select>
        <select id="filter-value" class="form-control mr-3 filter">
        </select>
        <button type="submit" class="btn btn-success btn-md">Filter</button>
      </form>
    </div>

  <div class="separator"></div>
@if(count($orders))
<table class="table table-hover table-sm">
    <thead>
          <tr>
            <td>Id</td>
            <td>Order Nr. </td>
            <td>Order Date</td>
            <td>Order Status</td>
            <td>Billing Name</td>
            <td>Billing Amount</td>
            <td>Payment Status</td>
            <td>Delivery Status</td>   
            <td style="width:120px"></td>
          </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr class="{{$order->order_status == 2 ? 'order-complete' : ''}}">
          <td>{{$order->id}}</td>  
          <td>{{$order->order_nr}}</td>
          <td>{{formatDate($order->created_at)}}</td>
          <td>{!!orderStatus($order)!!}</td>
          <td>{{$order->billing_name}}</td>
          <td>{{displayPrice($order->billing_total)}}</td>
          <td>{{orderPaymentStatus($order)}}</td>
          <td>{{orderDeliveryStatus($order)}}</td>
          <td class="text-right">
            <a href="{{route('admin.orders.show', $order->id)}}" class="btn btn-warning btn-sm"><i class="fi fi-eye"></i></a>
            <a href="{{route('admin.orders.edit', $order->id)}}" class="btn btn-success btn-sm"><i class=" fi fi-pencil"></i></a>
          </td>
        </tr>
        @endforeach
    </tbody>
</table>  
<div class="mt-5">
  {{ $orders->appends(request()->input())->links() }}
</div>
@else 
<div class="no-items">No Orders Where Found.</div>
@endif 
@endsection

@section('extra-footer')
<script>
(function(){
  /* FILTERS FUNCTIONALITY */
  var orderStatuses = {};
  var paymentStatuses = {};
  var deliveryStatuses = {};

  const url = "/admin/orders";
  const fm = $('#order-filter-form');
  const filter = $('#filter-name');
  const filterValue = $('#filter-value');
 
  if(filter.val() !== null){
    setFilters();
  }

   // fill selectable items array
   filter.on('change', ()=>{
    setFilters();
  });
  
 function setFilters(){
   console.log($.isEmptyObject(orderStatuses));
    //filter by brand
    filterValue.children().remove();
    if(filter.val() == 'orderstatus'){
      if(!$.isEmptyObject(orderStatuses)){
        setFilterValues(orderStatuses);
      }else{
        getOrderStatuses('orderStatuses');
      }
    }
    else if(filter.val() == 'paymentstatus'){
      if(!$.isEmptyObject(paymentStatuses)){
        setFilterValues(paymentStatuses);
      }else{
        getOrderStatuses('paymentStatuses');
      }  
    }
    else if(filter.val() == 'deliverystatus'){
      if(!$.isEmptyObject(deliveryStatuses)){
        setFilterValues(deliveryStatuses);
      }else{
        getOrderStatuses('deliveryStatuses');
      }  
    }else{
      filterValue.children().remove();
    }
  }

  //get order statuses
  function getOrderStatuses(search){
    axios.get('orders/statuses')
    .then(function (response){
      console.log(response);
      //set the values to variables to prevent additional http requests
       orderStatuses = response.data.orderStatuses;
       paymentStatuses = response.data.paymentStatuses;
       deliveryStatuses = response.data.deliveryStatuses;
       //set filter values
       for(let key in response.data){
         if(search == key){
          setFilterValues(response.data[key]);
         }
       }
    })
    .catch(function(error){
      console.log(error);
    });
  }

  function setFilterValues(obj){
    //get query string to set current value
    let queryStr = window.location.search;
    let start = queryStr.indexOf("=");
    let filterV = queryStr.substr(start+1);  
    console.log(filterV);

    let filterItems = "";
    $.each(obj, function(key,val){
      filterItems += `<option value="${val}" ${(filterV == val) ? "selected" : ""}>${key}</option>`
    });
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
  const search = $('#search-name');
  const searchValue = $('#search-value');
  
  searchfm.on('submit', (e)=>{
    e.preventDefault();
    let searchName = search.val();
    let searchVal = searchValue.val();
    if(searchName && searchVal){
      let query = encodeURI('?'+searchName+'='+searchVal);
      window.location.replace(url+query);
    }
  });
   /*END OF SEARCH FUNCTIONALITY*/
  })();
</script>
@endsection