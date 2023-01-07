<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BoardResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'alias' => $this->alias,
            'description' => $this->description,
            'custom_fields' => $this->custom_fields,
            'status' => $this->status,
        ];
    }
}
