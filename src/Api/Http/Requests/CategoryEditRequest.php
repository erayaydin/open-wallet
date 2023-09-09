<?php

namespace OpenWallet\Api\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenWallet\Models\AccountType;
use OpenWallet\Models\CategoryType;

class CategoryEditRequest extends FormRequest
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
        $types = array_map(fn ($c) => $c->value, CategoryType::cases());
        $parentExists = Rule::exists('categories', 'id')
            ->where('user_id', $this->user('sanctum')->id);

        return [
            'name' => ['min:3', 'string'],
            'color' => ['nullable', 'max:6', 'string'],
            'icon' => ['nullable', 'string'],
            'type' => ['nullable', Rule::in($types)],
            'parent' => [$parentExists]
        ];
    }
}
