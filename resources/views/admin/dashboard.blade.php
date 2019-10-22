@extends('layouts.admin')

@section('title')
<h1 class="topnav-heading">Dashboard</h1>
@endsection

@section('content')
            <div class="row">
              <div class="col-md-6">
                <div class="card border-secondary mb-3">
                  <div class="card-header card-header-dark text-uppercase">App Info</div>
                  <div class="card-body">
                    <ul class="list-group">
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        Pages
                        <span class="badge badge-success badge-pill">{{$pages}}</span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        Categories
                      <span class="badge badge-success badge-pill">{{$categories}}</span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        Brands
                      <span class="badge badge-success badge-pill">{{$brands}}</span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        Products
                        <span class="badge badge-success badge-pill">{{$products}}</span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        Reviews
                          <span class="badge badge-success badge-pill">{{$reviews}}</span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        Registered Users
                            <span class="badge badge-success badge-pill">{{$users}}</span>
                          </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        Administrators
                        <span class="badge badge-success badge-pill">{{$admins}}</span>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                  <div class="card border-secondary mb-3">
                      <div class="card-header card-header-dark text-uppercase">Order Info</div>
                      <div class="card-body">
                        <ul class="list-group">
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total Orders
                            <span class="badge badge-success badge-pill">{{$orders}}</span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            Completed Orders
                          <span class="badge badge-success badge-pill">{{$ordersComplete}}</span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            Orders In Process
                            <span class="badge badge-success badge-pill">{{$ordersInProcess}}</span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total Sales Amount
                            <span class="badge badge-success badge-pill">{{displayPrice($totalSales)}}</span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total Sales Paid
                            <span class="badge badge-success badge-pill">{{displayPrice($totalSalesPaid)}}</span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total Sales Unpaid
                            <span class="badge badge-success badge-pill">{{displayPrice($totalSalesUnpaid)}}</span>
                          </li>
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            Average Order Amount
                            <span class="badge badge-success badge-pill">{{displayPrice($avgOrderAmount)}}</span>
                          </li>
                        </ul>
                      </div>
                    </div>
              </div>
            </div>  
@endsection
