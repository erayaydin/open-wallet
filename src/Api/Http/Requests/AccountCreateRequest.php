<?php

namespace OpenWallet\Api\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenWallet\Models\AccountType;
use OpenWallet\Models\User;

class AccountCreateRequest extends FormRequest
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
        $types = array_map(fn ($c) => $c->value, AccountType::cases());
        $currencies = $user->currencies()
            ->pluck('currency');
        $uniqueName = Rule::unique('accounts')
            ->where('user_id', $user->getAttribute('id'));

        return [
            'name' => ['required', 'min:3', 'string', $uniqueName],
            'currency' => ['required', 'string', Rule::in($currencies)],
            'number' => ['nullable'],
            'color' => ['nullable', 'max:6', 'string'],
            'type' => ['nullable', Rule::in($types)],
            'limit' => ['nullable', 'decimal:0,2', 'exclude_if:type,cash'],
            'deadline' => ['nullable', 'min:1', 'max:31', 'exclude_if:type,cash'],
        ];
    }
}
