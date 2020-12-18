<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class UserCollection extends JsonResource
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
                'email' => $this->email,
                'profile_image' => $this->profile_image,
                'phone_number' => $this->phonenumber,
                'id_card'=>$this->idcard,
                'address'=>$this->address,

            ],
            'relationships'=>[
                'occupations'=>$this->occupations,
                'activity_images'=>$this->images
            ],
            'reviews'=>$this->getReviews(),
        ];
    }
}
