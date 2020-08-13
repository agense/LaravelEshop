<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReviewValidationRequest;
use App\Services\ReviewManagementService;
use App\Models\Product;
use App\Models\Review;

class ReviewsController extends Controller
{
    private $reviewService;

    /**
     * Create a new controller instance .
     * @return void
     */
    public function __construct(ReviewManagementService $service)
    {
        $this->reviewService = $service;
    }

    /**
     * Show all products the authenticated user has ordered with their reviews written by this user
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $products = $this->reviewService->getUsersProductsWithReviews();
        return view('users.reviews')->with('products', $products);
    }

    /**
     * Store a newly created review in DB
     * @param  \App\Http\Requests\ReviewValidationRequest  $request
     * @param  App\Models\Product $product
     * @return \Illuminate\Http\Response 
     */
    public function store(ReviewValidationRequest $request, Product $product)
    {
        $review = $this->reviewService->createReview($product);
        $request->session()->flash('success_message', 'Thank you for reviewing our product!');
        return response()->json($review);
    }

    /**
     * Update the review in DB
     * @param  \App\Http\Requests\ReviewValidationRequest $request
     * @param \App\Models\Review $review
     * @return \Illuminate\Http\Response
     */
    public function update(ReviewValidationRequest $request, Review $review)
    {   
        $review = $this->reviewService->updateReview($review);
        $request->session()->flash('success_message', 'Thank you for reviewing our product!');
        return response()->json($review);
    }

    /**
     * Soft delete the specific review.
     * Review will no longer appear in frontend, but it can only be hard deleted by site administrators. 
     * @param  \App\Models\Review $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        // Check if the review belongs to the user
        if(!$review->authorAccess()){
            abort(403, 'You are not the author of this review.');
        }
        $this->reviewService->deactivate($review);
        return redirect()->route('user.reviews.index')->with('success_message', 'Your review has been deleted!');
    }


}
