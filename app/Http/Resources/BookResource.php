<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'Published at' => $this->published_at,
            'Active' =>(bool) $this->is_active,
            'Book\'s category' => $this->category_name ?? 'no category',
            'Created By' => $this->user->name ?? 'unknown',
            'Borrowed By' => $this->user->name ?? 'no one'
        ];
    }
}
