<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BoardCommentResource extends JsonResource
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
            'board_id' => $this->board_id,
            'board_item_id' => $this->board_item_id,
            'uesr_id' => $this->user_id,
            'contents' => $this->contents,
            'user' => UserResource::make($this->user)->resolve(),
            'is_hidden' => $this->is_hidden,
        ];
    }
}
