<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class FeatureResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'options' => $this->options,
            'option_updates' => [
                'add' => [
                    'url' => route("admin.features.options.add", $this->id),
                    'method' => 'PUT'
                ],
                'remove' => [
                    'url' => route("admin.features.options.delete", $this->id),
                    'method' => 'DELETE'
                ],
                
            ]
        ];
    }
}
