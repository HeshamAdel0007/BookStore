<?php

namespace Modules\Book\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            "id"    => $this->id,
            "name"  => $this->name,
            "slug"  => $this->slug,
            "published_date" => $this->published_date,
            "price" => $this->price,
            "average_rating" => $this->average_rating,
            "review_count" => $this->review_count,
            "book_cover" => $this->getFirstMediaUrl('bookCover'),
            "description" => $this->description,
        ];
    }
}
