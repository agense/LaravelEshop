<?php
namespace App\Filters\SortFilters;
use App\Filters\SortFilters\Sort;

class Review extends Sort {
     
    protected $sorts = [
        'rating' => 'rating',
        'review_date' => 'created_at',
        'delete_date' => 'deleted_at'
    ];
}