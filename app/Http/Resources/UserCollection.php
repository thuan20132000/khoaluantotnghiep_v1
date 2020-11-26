<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
                'phone_number' => $this->phone_number,
                'id_card'=>$this->idcard,

            ],
            'relationships'=>[
                'occupations'=>$this->occupations
            ]

        ];
    }
}
