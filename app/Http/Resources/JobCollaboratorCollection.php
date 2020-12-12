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
                'confirmed_price'=>$this->confirmed_price,
                'description'=>$this->description,
                'start_at'=>$this->start_at,
                'finish_at'=>$this->finish_at,
                'status'=>$this->status,
                'updated_at'=>$this->updated_at,
                'created_at'=>$this->created_at


            ],
            'relationship'=>[
                'job'=>$this->job,
                'collaborators'=>$this->collaborators(),
                'job_images'=>$this->job->images,
                'job_author'=>$this->job->user,
                'job_location'=>$this->job->location

            ]
        ];
    }
}
