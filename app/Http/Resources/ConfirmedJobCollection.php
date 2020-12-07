<?php

namespace App\Http\Resources;

use App\Model\JobCollaborator;
use Illuminate\Http\Resources\Json\JsonResource;

class ConfirmedJobCollection extends JsonResource
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
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
                'suggestion_price' => $this->suggestion_price,
                'images' => $this->images,
                'created_at' => $this->created_at,
                'status' => $this->status,

            ],
            'relationships' => [
                'location' => $this->location,
                'occupation' => $this->occupation,
                'candidate'=>JobCollaborator::where('job_id',$this->id)->first()->user,
                'confirm'=>$this->jobCollaborators->where('status',JobCollaborator::CONFIRMED)->first()
            ]

        ];
    }
}
