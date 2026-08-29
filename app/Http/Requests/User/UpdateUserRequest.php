<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => ['sometimes', 'required', 'email', Rule::unique('users')->ignore($this->route('user'))],
            'password' => 'nullable|string|min:8',
            'status' => 'sometimes|in:pending,approved,rejected',
            'primary_tpdk_id' => 'sometimes|exists:tpdk,id',
            'role' => 'sometimes|exists:roles,name'
        ];
    }
}
