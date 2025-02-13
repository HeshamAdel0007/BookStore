<?php

namespace Modules\Admin\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            "id"    => $this->id,
            "name"  => $this->name,
            "email" => $this->email,
            "phone" => $this->phone,
            "status" => $this->getActive(),
            "email_verified_at" => $this->email_verified_at,
            "role"  => $this->roles()->pluck('name'),
            "permissions" => $this->getDirectPermissions()->pluck('name'),
        ];
    }
}
