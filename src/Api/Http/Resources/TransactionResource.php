<?php

namespace OpenWallet\Api\Http\Resources;

use Illuminate\Http\Request;
use OpenWallet\Http\Resources\JsonResource;
use OpenWallet\Models\Transaction;

class TransactionResource extends JsonResource
{
    /** @var Transaction */
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
            'amount' => $this->resource->getAttribute('amount'),
            'description' => $this->resource->getAttribute('description'),
            'source_account' => new AccountResource($this->whenLoaded('sourceAccount')),
            'category' => new CategoryResource($this->whenLoaded('category')),
        ];
    }
}
