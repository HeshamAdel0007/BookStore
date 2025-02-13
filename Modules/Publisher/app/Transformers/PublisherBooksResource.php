<?php

namespace Modules\Publisher\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Book\Transformers\BookResource;

class PublisherBooksResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            "books" => BookResource::collection($this->books),
        ];
    }
}
