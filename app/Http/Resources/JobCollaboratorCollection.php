<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobCollaboratorCollection extends JsonResource
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
                'expected_price'=>$this->expected_price,
                'description'=>$this->description,
                'start_at'=>$this->start_at,
                'finish_at'=>$this->finish_at,

            ],
            'relationship'=>[
                'job'=>$this->job,
                'collaborators'=>$this->collaborators()
            ]
        ];
    }
}
