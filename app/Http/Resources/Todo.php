<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Todo extends JsonResource
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
            "id"            =>  $this->id,
            "title"         =>  $this->title,
            "description"   =>  $this->description,
            "is_completed"  =>  $this->is_completed,
            "slug"          =>  $this->slug
        ];
    }

    public function with($request)
    {
        return [
            'version' => '1.0.0',
        ];
    }
}
