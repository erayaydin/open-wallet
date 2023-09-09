<?php

namespace OpenWallet\Api\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenWallet\Models\AccountType;

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
        $types = array_map(fn ($c) => $c->value, AccountType::cases());

        return [
            'name' => ['required', 'min:3', 'string', Rule::unique('accounts')->where('user_id', $this->user('sanctum')->id)],
            'number' => ['nullable'],
            'color' => ['nullable', 'max:6', 'string'],
            'type' => ['nullable', Rule::in($types)],
            'limit' => ['nullable', 'decimal:0,2', 'exclude_if:type,cash'],
            'deadline' => ['nullable', 'min:1', 'max:31', 'exclude_if:type,cash'],
        ];
    }
}
