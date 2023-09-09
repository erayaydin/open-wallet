<?php

namespace OpenWallet\Api\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CurrencyCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $currencies = array_keys(config('money.currencies'));
        $unique = Rule::unique('currencies')
            ->where('user_id', $this->user('sanctum')->id);

        return [
            'currency' => ['required', Rule::in($currencies), $unique],
            'exchange_buy' => ['required', 'decimal:0,5'],
            'exchange_sell' => ['required', 'decimal:0,5'],
        ];
    }
}
