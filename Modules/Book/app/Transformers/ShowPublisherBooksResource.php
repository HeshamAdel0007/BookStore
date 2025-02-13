<?php

namespace Modules\Book\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowPublisherBooksResource extends JsonResource
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
            "publisher" => $this->publisher->name,
            "category" => $this->category->name,
            "published_date" => $this->published_date,
            "isbn" => $this->isbn,
            "price" => $this->price,
            "sku" => $this->sku,
            "stock_quantity" => $this->stock_quantity,
            "book_cover" => $this->getFirstMediaUrl('bookCover'),
            "description" => $this->description,
        ];
    }
}
