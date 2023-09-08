<?php

namespace OpenWallet\UserAccess\Interface\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class AuthenticateRequest extends FormRequest
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
     * @return array<string, mixed>
     *
     * @noinspection PhpArrayShapeAttributeCanBeAddedInspection
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'min:3'],
            'device_name' => ['required', 'min:3'],
        ];
    }
}
