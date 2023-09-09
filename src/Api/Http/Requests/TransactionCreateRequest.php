<?php

namespace OpenWallet\Api\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $userId = $this->user('sanctum')->id;
        $existsSourceAccount = Rule::exists('accounts', 'id')
            ->where('user_id', $userId);
        $existsCategory = Rule::exists('categories', 'id')
            ->where('user_id', $userId);

        return [
            'amount' => ['required', 'decimal:0,8', 'not_in:0'],
            'source_account' => ['required', 'uuid', $existsSourceAccount],
            'category' => ['nullable', 'uuid', $existsCategory],
            'description' => ['nullable', 'string'],
        ];
    }
}
