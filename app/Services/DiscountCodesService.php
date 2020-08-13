<?php
namespace App\Services;

use App\Exceptions\ModelModificationException;
use App\Models\DiscountCode;

class DiscountCodesService
{
    private $pagination;

    /**
     * Set class properties
     */
    public function __construct(Int $pagination = 10){
        $this->pagination = $pagination;
    }

    /**
     * Return a paginated listing of discount codes that are active or will become active
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getActiveAndFuture(){
        return DiscountCode::activeAndFuture()->orderByActivationDate()->paginate($this->pagination);
    }

    /**
     * Return a paginated listing of inactive discount codes 
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getInactive(){
        return DiscountCode::onlyTrashed()->paginate($this->pagination);
    }

    /**
     * Return a paginated listing of expired discount codes 
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getExpired(){
        return DiscountCode::expired()->orderByExpirationDate()->paginate($this->pagination);
    }

    /**
     * Return a collection of public active discount codes 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getPublicActive(){
        return DiscountCode::public()->active()->orderByExpirationDate()->get();
    }

    /**
     * Create new discount code or update existing one
     * @param Array $data - validated request data
     * @param App\Models\DiscountCode $code (optional)
     * @return App\Models\DiscountCode
     */
    public function saveCode($data, $code = null){
        $code = $code instanceof DiscountCode ? $code : new DiscountCode();
        $code->fill($data);
        $code->save();
        return $code;
    }

    // SOFT DELETE FUNCTIONALITY
    /**
     * Set codes deleted_at property
     * @param App\Models\DiscountCode
     * @return Void
     */
    public function deactivate(DiscountCode $code){
        try{
            $code->delete();
        }catch(\Exception $e){
            throw new ModelModificationException($e->getMessage());
        } 
    }

    /**
     * Set codes deleted_at property to null
     * @param Int $id
     * @return Void
     */
    public function restore($id){
        try{
            DiscountCode::onlyTrashed()->where('id', $id)->restore();
        }catch(\Exception $e){
            throw new ModelModificationException($e->getMessage());
        } 
    }

    /**
     * Delete code from database
     * @param Int $id
     * @return Void
     */
    public function delete($id){
        try{
            DiscountCode::onlyTrashed()->where('id', $id)->forceDelete();
        }catch(\Exception $e){
            throw new ModelModificationException($e->getMessage());
        } 
    }

    /**
     * Toggles code's public property
     * @param int $id - code id
     * @return int code public property
     */
    public function toggleAccess($id)
    {
        $code = DiscountCode::findOrFail($id);
        if($code->public == 0){
            $code->public = 1;
        }else{
            $code->public = 0;
        }
        $code->save();
        return $code->public;
    }

    /**
     * If discount code is found and valid, store it in a session
     * @return void
     */
    public function applyCode(){
         session()->put('discount_code', [
            'code'=> request()->code,
        ]);
    }

    /**
     * Remove discount code from the session
     * @return void
     */
    public function removeCode(){
        session()->forget('discount_code');
    }

} 