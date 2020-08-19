<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
        'title' => $this->title,
        'location' => $this->location,
        'description' => $this->description,
        'user_id' => $this->user_id,
        'charges' => $this->charges,
        'status' => $this->status,
        'is_available' => $this->is_available,
        'image1' => $this->image1,
        'image2' => $this->image2,
        'image3' => $this->image3,
        'image4' => $this->image4,
        'created_at' => (string) $this->created_at,
        'updated_at' => (string) $this->updated_at,
        'user' => $this->user,
        'ratings' => $this->ratings,
        'comments' => $this->comments
      ];
    }
}
