<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'attributes' => [
                'id' => (string)$this->id,
                'commentText' => $this->commentText,
                'created_at' => $this->created_at,
            ],
            'comment_author' => [
                'id' => (string)$this->user->id,
                'user_name' => $this->user->name,
                'user_email' => $this->user->email,
            ],
            'post' => [
                'id' => (string)$this->post->id,
            ]
        ];
    }
}
