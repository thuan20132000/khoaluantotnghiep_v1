<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OccupationResource extends JsonResource
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
            'attributes' => [
                'name' => $this->name,
                'slug' => $this->slug,
                'image' => $this->image,
                'status' => $this->status
            ],
            'relationships' => [
                'category' => $this->category,
                'collaborators' => $this->collaborators()
            ],
            'include' => [
                'jobs' => $this->jobs
            ]
        ];
    }
}
