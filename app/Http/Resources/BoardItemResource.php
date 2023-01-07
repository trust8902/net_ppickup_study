<?php

namespace App\Http\Resources;

use App\Models\Board;
use Illuminate\Http\Resources\Json\JsonResource;

class BoardItemResource extends JsonResource
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
            'title' => $this->title,
            'contents' => $this->contents,
            'board' => BoardResource::make($this->board)->resolve(),
            'user' => UserResource::make($this->user)->resolve(),
            'board_comments' => BoardCommentResource::collection($this->boardComments),
            'board_comments' => $this->boardComments,
            'is_hidden' => $this->is_hidden,
        ];
    }
}
