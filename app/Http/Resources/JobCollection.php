<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'attributes'=>[
                'name'=>$this->name,
                'slug'=>$this->slug,
                'description'=>$this->description,
                'suggestion_price'=>$this->suggestion_price,
                'images'=>$this->images,
                'created_at'=>$this->created_at,
                'status'=>$this->status,

            ],
            'relationships'=>[
                'location'=>$this->location,
                'author'=>$this->user,
                'occupation'=>$this->occupation,
                'candidates'=> $this->candidates()
            ]

        ];
    }
}
