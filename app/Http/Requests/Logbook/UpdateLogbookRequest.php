<?php

namespace App\Http\Requests\Logbook;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLogbookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $logbook = $this->route('logbook');
        $user = $this->user();

        // Superadmin/Admin dengan akses universal bisa mengedit (opsional untuk koreksi)
        if ($user->can('view_all_data')) {
            return true;
        }

        // User biasa hanya bisa mengedit logbook miliknya sendiri
        return $logbook->user_id === $user->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'description' => 'required|string|min:10'
        ];
    }
}
