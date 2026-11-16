<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'is_published' => (bool) $this->is_published,
            'views_count' => (int) $this->views_count,
            'author' => [
                'id' => $this->user?->id,
                'name' => $this->user?->name,
                'email' => $this->user?->email,
            ],
            // Связь BelongsTo
            'category' => new CategoryResource($this->whenLoaded('category')),
            // Связь BelongsToMany
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            // Полиморфная связь MorphMany
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'deleted_at' => $this->deleted_at?->toDateTimeString(),
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
