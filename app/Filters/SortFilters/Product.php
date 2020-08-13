<?php
namespace App\Filters\SortFilters;
use App\Filters\SortFilters\Sort;

class Product extends Sort{

    protected $sorts = [
        'name' => 'name',
        'price' => 'price',
        'quantity' => 'availability',
        'featured' => 'featured'
    ];
}