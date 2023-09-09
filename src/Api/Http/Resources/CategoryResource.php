<?php

namespace OpenWallet\Api\Http\Resources;

use Illuminate\Http\Request;
use OpenWallet\Http\Resources\JsonResource;
use OpenWallet\Models\Category;

class CategoryResource extends JsonResource
{
    /** @var Category */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->getAttribute('id'),
            'name' => $this->resource->getAttribute('name'),
            'color' => $this->resource->getAttribute('color'),
            'icon' => $this->resource->getAttribute('icon'),
            'type' => $this->resource->getAttribute('type'),
            'subs' => CategoryResource::collection($this->whenLoaded('subs')),
        ];
    }
}
