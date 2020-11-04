<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OccupationCollection extends JsonResource
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
                'image'=>$this->image,
                'status'=>$this->status
            ],
            'relationships'=>[
                'category'=>$this->category,
                'collaborators'=>$this->collaborators()
            ],
            'include'=>[
                'jobs'=>$this->jobs
            ]
        ];
    }
}
