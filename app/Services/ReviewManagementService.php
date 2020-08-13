<?php
namespace App\Services;

use App\Exceptions\FilteringException;
use App\Exceptions\ModelModificationException;
use App\Services\Filters\FilterService;
use App\Services\Filters\SortService;
use App\Models\Review;
use App\Models\Product;

class ReviewManagementService 
{
    private $pagination = 10;
    private $filter;
    private $sorter;

    public function __construct(){
        $this->filter = new FilterService('review');
        $this->sorter = new SortService('review');
    }

    /**
     * Return a paginated listing of all reviews
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAll()
    {
       return Review::with('product.brand')->DefaultSort()->paginate($this->pagination);
    }

    /**
     * Return a paginated listing of deleted reviews 
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getDeleted()
    {
        return Review::onlyTrashed()->WithRelatedProduct()->DefaultSort()->paginate($this->pagination);
    }

     /**
     * Return a paginated listing of reviews based on request query and calling params along with applied filter and sorting names 
     * @param String $specific (optional) - defines additional filter types except request query
     * @return Array
     */
    public function getFiltered($specific = false)
    {
        $filters = [];
        $sort = [];
        $reviews = [];

        try{
            if(!request()->isFilterable()){
                if($specific && $specific == 'deleted'){
                    $reviews = $this->getDeleted();
                }
                else{
                    $reviews = $this->getAll();
                }
            }else{
                //Apply query filters
                $reviews = $this->filter->apply();

                //Apply additional filters if exist
                if($specific && $specific == 'deleted'){
                    $reviews = $reviews->onlyTrashed()->WithRelatedProduct();
                }else{
                    $reviews = $reviews->with('product.brand');
                }

                //Apply Sorting
                if(request()->isSortable()){
                    $reviews = $this->sorter->apply($reviews);
                    $sort = $this->sorter->getApplied();
                }
                $filters = $this->filter->getApplied();
                $reviews = $reviews->paginate($this->pagination);
            }
            return [
                'reviews' => $reviews,
                'filters' => $filters,
                'sort' => $sort
            ];
        }catch(\Exception $e){
            throw new FilteringException($e->getMessage());
        }
    }

    /**
     * Retrieves single review by id, including deactivated reviews, with related product
     * @param Int $id
     * @return App\Model\Review
     */
    public function getOne($id)
    {
        return Review::withTrashed()->where('id', $id)->WithRelatedProduct(true)->firstOrFail();
    }

    //SOFT DELETE FUNCTIONALITY
    /**
     * Sets a review as deleted - sets deleted_at, delete_reason and deleted_by properties
     * @param App\Models\Review $review
     * @param String $reason 
     * @return Void
     */
    public function deactivate(Review $review, String $reason = null)
    {
        try{
            if(auth()->user() instanceof \App\Models\User){
                $reason = 'author_delete';
            }
            if(!$reason){
                abort(422, 'Delete reason is required');
            }
            $review->markAsDeleted($reason);
            $review->save();
        }catch(\Exception $e){
            throw new ModelModificationException($e->getMessage());
        }
    }

    /**
     * Restores a review - sets deleted_at, delete_reason and deleted_by properties to null
     * @param Int $id
     * @return Void
     */
    public function restore($id)
    {
        try{
            $review = Review::onlyTrashed()->where('id', $id)->first();
            if(!$review->restoreAllowed()){
                abort(403, 'Reviews deleted by their author cannot be restored');
            }
            $review->markAsRestored();
            $review->save();
        }catch(\Exception $e){
            throw new ModelModificationException($e->getMessage());
        }
    }

    /**
     * Deletes a review from database
     * @param Int $id
     * @return Void
     */
    public function delete($id)
    {
        try{
            Review::onlyTrashed()->where('id', $id)->forceDelete();
        }catch(\Exception $e){
            throw new ModelModificationException($e->getMessage());
        }
    }

    // USER SIDE FUNCTIONALITY
    /**
     * Retrieves authenticated users ordered products with associated reviews
     * @return Illuminate\Pagination\LengthAwarePaginator
     */
    public function getUsersProductsWithReviews()
    {
        return auth()->user()->orderedProducts()->withCurrentUsersReviews()->paginate($this->pagination);
    }

    /**
     * Creates a new review by authenticated user for specified product
     * @param App\Models\Product
     * @return App\Models\Review
     */
    public function createReview(Product $product){
        $review = auth()->user()->reviews()->create([
            'rating' => request()->rating,
            'review' => request()->review,
            'product_id' => $product->id,
           ]);
        return $review;
    }

    /**
     * Updates a review (author only)
     * @param App\Models\Review
     * @return App\Models\Review
     */
    public function updateReview(Review $review){
        if(!$review->authorAccess()){
            abort(403, 'You are not authorized to perform this action.');
        }
        $review->rating = request()->rating;
        $review->review = request()->review;
        $review->save();
        return $review;
    }
}