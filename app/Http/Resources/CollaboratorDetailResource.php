<?php

namespace App\Http\Resources;

use App\Model\JobCollaborator;
use Illuminate\Http\Resources\Json\JsonResource;

class CollaboratorDetailResource extends JsonResource
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
                'name' => $this->name,
                'email' => $this->slug,
                'phonenumber' => $this->image,
                'idcard' => $this->status,
                'address'=>$this->address,
                'profile_image'=>$this->profile_image
            ],
            'relationships'=>[
                'occupations'=>$this->occupations,
                'activity_images'=>$this->images
            ],
            'reviews'=>$this->getReviews()


        ];
    }
}
