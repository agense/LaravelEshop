<?php
namespace App\Filters\SortFilters;
use App\Filters\SortFilters\Sort;

class Order extends Sort {

    protected $sorts = [
        'order_status' => 'status',
        'billing_total' => 'billing_total',
        'order_date' =>'created_at', 
        'complete_date' => 'completed_at'
    ];
}