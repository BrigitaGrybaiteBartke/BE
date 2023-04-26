<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => (string)$this->id,

            'attributes' => [
                'id' => (string)$this->id,
                'title' => $this->title,
                'excerpt' => $this->excerpt,
                'body' => $this->body,
                'min_to_read' => $this->min_to_read,
                'image_path' => $this->image_path,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ],

            'user' => [
                'id' => (string)$this->user->id,
                'user_name' => $this->user->name,
                'user_email' => $this->user->email,

            ],

            'comments' => (CommentResource::collection($this->whenLoaded('comments'))),

        ];

        return $data;
    }
}
