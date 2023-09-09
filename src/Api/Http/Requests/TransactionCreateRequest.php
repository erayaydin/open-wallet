<?php

namespace OpenWallet\Api\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenWallet\Models\User;

class TransactionCreateRequest extends FormRequest
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
        /** @var User $user */
        $user = $this->user('sanctum');
        $existsSourceAccount = Rule::exists('accounts', 'id')
            ->where('user_id', $user->getAttribute('id'));
        $currencies = $user->currencies()
            ->pluck('currency');
        $existsCategory = Rule::exists('categories', 'id')
            ->where('user_id', $user->getAttribute('id'));

        return [
            'amount' => ['required', 'decimal:0,8', 'not_in:0'],
            'currency' => ['required', 'string', Rule::in($currencies)],
            'source_account' => ['required', 'uuid', $existsSourceAccount],
            'category' => ['nullable', 'uuid', $existsCategory],
            'description' => ['nullable', 'string'],
        ];
    }
}
