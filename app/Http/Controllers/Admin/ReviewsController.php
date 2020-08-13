<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ReviewManagementService;
use App\Http\Resources\ReviewResource;
use App\Models\Review;

class ReviewsController extends Controller
{
    private $reviewService;

    /**
     * Create a new controller instance.
     * Inject ReviewManagementService
     *
     * @return void
     */
    public function __construct(ReviewManagementService $service)
    {   
        $this->reviewService = $service;
    }

    /**
     * Display a listing of all reviews
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->reviewService->getFiltered();
        return view('admin.reviews.index')->with([
            'reviews'=> $data['reviews'],
            'filters' => $data['filters'], 
            'sort' => $data['sort']
        ]);
    }

    /**
     * Display the specified review.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if (!$request->wantsJson()) {
           return redirect()->route('admin.reviews.index');
        }
        $review = $this->reviewService->getOne($id);
        return new ReviewResource($review);
    }

    /**
     * Sof delete the review passing the name of the admin who deleted it
     * @param  App\Models\Review $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        $this->reviewService->deactivate($review, 'admin_delete');
        return redirect()->back()->with('success_message', 'Review has been deactivated'); 
    }

    /**
     * Show all soft deleted reviews
     * @return \Illuminate\Http\Response
     */
    public function deleted()
    {    
        $data = $this->reviewService->getFiltered('deleted');
        return view('admin.reviews.deleted')->with([
            'reviews'=> $data['reviews'],
            'filters' => $data['filters'], 
            'sort' => $data['sort']
        ]);
    }

    /**
     * Restore a deleted review
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {  
        $this->reviewService->restore($id);
        return redirect()->back()->with('success_message', 'Review has been restored');
    }

    /**
     * Remove the specified review from DB
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function finalDelete($id)
    {
        $this->authorize('isAdmin');
        $this->reviewService->delete($id);
        return redirect()->back()->with('success_message', 'Review has been deleted');
    }
}
