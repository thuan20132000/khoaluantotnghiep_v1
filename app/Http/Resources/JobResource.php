<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
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
            'id'=>$this->id,
            'attributes'=>[
                'name'=>$this->name,
                'slug'=>$this->slug,
                'description'=>$this->description,
                'suggestion_price'=>$this->suggestion_price,
                'status'=>$this->status,
                'images'=>$this->images || "",
                'created_at'=>$this->created_at,
                'updated_at'=>$this->updated_at,
            ],
            'relationships'=>[
                'location'=>$this->location,
                'author'=>$this->user,
                'occupation'=>$this->occupation,
                'candidates'=>$this->candidates()
            ]

        ];
    }
}
