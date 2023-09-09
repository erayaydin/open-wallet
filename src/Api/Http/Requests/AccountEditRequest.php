<?php

namespace OpenWallet\Api\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenWallet\Models\AccountType;
use OpenWallet\Models\User;

class AccountEditRequest extends FormRequest
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
        $uniqueName = Rule::unique('accounts')
            ->where('user_id', $user->getAttribute('id'))
            ->ignore($this->route()->parameter('account'));

        $types = implode(',', array_map(fn ($c) => $c->value, AccountType::cases()));

        return [
            'name' => ['min:3', 'string', $uniqueName],
            'number' => ['nullable'],
            'color' => ['nullable', 'max:6', 'string'],
            'type' => ['nullable', Rule::in($types)],
            'limit' => ['nullable', 'decimal:0,2', 'exclude_if:type,cash'],
            'deadline' => ['nullable', 'min:1', 'max:31', 'exclude_if:type,cash'],
        ];
    }
}
