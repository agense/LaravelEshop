<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Review;

class ReviewsController extends Controller
{
    /**
     * Create a new controller instance.
     * Set Controllers Middleware
     *
     * @return void
     */
    public function __construct()
    {   
        //set the middleware guard to admin
        $this->middleware('auth:admin');
        //set the middleware to only allow users with superadmin or admin priviledges
        $this->middleware('adminUser')->except('index','show');
    }

    /**
     * Display a listing of all reviews
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = Review::with('product.brand','user')->orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.reviews.index')->with('reviews', $reviews);
    }

    /**
     * Display the specified review.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if (!$request->wantsJson()) {
           return redirect()->route('admin.reviews');
        }
        $review = Review::where('id', $id)->withTrashed()->with('product.brand','user')->first();
        $revObj = new \stdClass(); 
        $revObj->rating = $review->rating;
        $revObj->review = $review->review;
        $revObj->product = $review->product->name;
        $revObj->brand = $review->product->brand->name;
        $revObj->user = $review->user->name;
        return response()->json($revObj);
    }

    /**
     * Remove the specified review from db.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        //sof delete the review passing the name of the admin who deleted it
        $review->deleted_by = auth()->user()->name;
        $review->deleted_at = formatDateForDB(time());
        $review->save();
        return redirect()->back()->with('success_message', 'Review has been deactivated'); 
    }

    /**
     * Show all soft deleted reviews
     * @return \Illuminate\Http\Response
     */
    public function deleted()
    {    
       $deleted = Review::onlyTrashed()->paginate(10);
       return view('admin.reviews.deleted')->with('reviews', $deleted);
    }

    /**
     * Restore a deleted review
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {  
      $review = Review::onlyTrashed()->where('id', $id)->first();
      if($review->deleted_by == $review->user->name){
        return redirect()->back()->with('error_message', 'Reviews deleted by user cannot be restored');
      }
      $review->restore();
      return redirect()->back()->with('success_message', 'Review has been restored');
    }

    /**
     * Remove the specified review from DB
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function finalDelete($id)
    {
        $review = Review::onlyTrashed()->where('id', $id)->first();
        $review->forceDelete();
        return redirect()->back()->with('success_message', 'Review has been deleted');   
    }
}
