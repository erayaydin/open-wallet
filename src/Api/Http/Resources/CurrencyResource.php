<?php

namespace OpenWallet\Api\Http\Resources;

use Illuminate\Http\Request;
use OpenWallet\Http\Resources\JsonResource;
use OpenWallet\Models\Category;

class CurrencyResource extends JsonResource
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
        $config = config('money.currencies.'.$this->resource->getAttribute('currency'));

        return [
            'currency' => $this->resource->getAttribute('currency'),
            'name' => $config['name'],
            'exchange_buy' => $this->resource->getAttribute('exchange_buy'),
            'exchange_sell' => $this->resource->getAttribute('exchange_sell'),
            'symbol' => $config['symbol'],
            'code' => $config['code'],
            'precision' => $config['precision'],
            'subunit' => $config['subunit'],
            'symbol_first' => $config['symbol_first'],
            'decimal_mark' => $config['decimal_mark'],
            'thousands_separator' => $config['thousands_separator'],
        ];
    }
}
