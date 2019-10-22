<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Review;

class ReviewsController extends Controller
{
    /**
     * Create a new controller instance and assign middleware.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show autheniticated user's ordered product list with review link for each product
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
       $orders = auth()->user()->orders()->with(['products.reviews' => function ($query) {
            $query->where('user_id', auth()->user()->id);
        }, 'products.brand'])->get();
       //get a collection of unique users products
       $products = [];
       $productIds = [];
        foreach($orders as $order){
            foreach($order->products as $product){
                if(!in_array($product->id, $productIds)){
                    $products[] = $product;
                    $productIds[] = $product->id;
                }
            }
        }
       $products = collect($products)->paginate(5);
       return view('users.reviews.index')->with('products', $products);
    }

    /**
     * Store a newly created review in DB
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @param  App\Product;
     */
    public function store(Request $request, Product $product)
    {
        //Validate data
        $this->validate($request, array(
            'rating' => 'required|integer|between:1,5',
            'review' => 'required|string|max:2000|regex:/^[a-zA-Z0-9,.?!\\s-]*$/',
         ));

        // create review via user relation
        auth()->user()->reviews()->create([
        'rating' => $request->rating,
        'review' => $request->review,
        'product_id' => $product->id,
       ]);
       return redirect()->route('user.reviews')->with('success_message', 'Thank you for reviewing our product!');
    }

    /**
     * Show the form for editing the review.
     * @param  int  $id (review id)
     * @param  App\Product;
     * @param App\Review;
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review, Product $product)
    {
        // Check if the review belongs to the user
        if($review->user_id !== auth()->user()->id){
            return redirect()->back()->with('error_message', 'Sorry, this action is not allowed.');
        }
        return view('users.reviews.edit')->with('review', $review)->with('product', $product);
    }

    /**
     * Update the review in DB
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Product;
     * @param App\Review;
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review, Product $product)
    {   
        // Check if the review belongs to the user
        if($review->user_id !== auth()->user()->id){
            return redirect()->back()->with('error_message', 'Sorry, this action is not allowed.');
        }

         //Validate data
         $this->validate($request, array(
            'rating' => 'required|integer|between:1,5',
            'review' => 'required|string|max:2000|regex:/^[a-zA-Z0-9,.?!\\s-]*$/',
         ));

        // update review
        $review->rating = $request->rating;
        $review->review = $request->review;
        $review->save();
        return redirect()->route('user.reviews')->with('success_message', 'Your review has been updated!');
    }

    /**
     * Soft delete the specific review.
     * Review will no longer appear in frontend, but it can only be hard deleted by site administrators. 
     * @param  App\Review;
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        // Check if the review belongs to the user
        if($review->user_id !== auth()->user()->id){
             return redirect()->back()->with('error_message', 'Sorry, this action is not allowed.');
        }
        $review->deleted_by = auth()->user()->name;
        $review->deleted_at = formatDateForDB(time());
        $review->save();
        return redirect()->route('user.reviews')->with('success_message', 'Your review has been deleted!');
    }
}
