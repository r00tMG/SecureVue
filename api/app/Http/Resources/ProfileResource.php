<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'address' => $this->resource->address,
            'hobbies' => $this->resource->hobbies,
            'job' => $this->resource->job,
            'skill' => $this->resource->skill,
            'user' => new UserResource(
                $this->resource->user
            )
        ];
    }
}
