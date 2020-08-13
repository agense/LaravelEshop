<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ReviewResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $res =  [
            'id' => $this->id,
            'rating' => $this->rating,
            'review' => $this->review,
            'product' => $this->product->name,
            'brand' => $this->product->brand->name,
            'user' => $this->user->name,
        ];
        if($this->deleted_at !== null){
            $res['deleted_review'] = 'true';
            $res['deleted_by'] = $this->deleted_by;
            $res['deleted_at'] = $this->deleted_at;
            $res['delete_reason'] = $this->delete_reason;
        }

        return $res;
    }
}
