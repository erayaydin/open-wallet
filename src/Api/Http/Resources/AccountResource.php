<?php

namespace OpenWallet\Api\Http\Resources;

use Illuminate\Http\Request;
use OpenWallet\Http\Resources\JsonResource;
use OpenWallet\Models\User;

class AccountResource extends JsonResource
{
    /** @var User */
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
            'number' => $this->resource->getAttribute('number'),
            'type' => $this->resource->getAttribute('type'),
            'color' => $this->resource->getAttribute('color'),
            'currency' => new CurrencyResource($this->whenLoaded('currency')),
        ];
    }
}
