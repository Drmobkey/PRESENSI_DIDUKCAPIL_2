<?php

namespace App\Http\Requests\Leave;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLeaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $leave = $this->route('leave');
        $user = $this->user();

        // 1. KEKUASAAN MUTLAK (Superadmin)
        // Bypass semua aturan: Bisa edit milik siapa saja, dalam status apa saja (approved/rejected/pending).
        if ($user->can('leaves.bypass_status')) {
            return true;
        }

        // 2. KEKUASAAN ADMIN
        // Bisa edit milik user lain, TAPI syaratnya data tersebut belum diproses (masih 'pending').
        if ($user->can('leaves.manage_all') && $leave->status === 'pending') {
            return true;
        }

        // 3. KEKUASAAN USER BIASA
        // Hanya bisa edit izin miliknya sendiri, DAN syaratnya masih 'pending'.
        return $leave->user_id === $user->id && $leave->status === 'pending';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'sometimes|required|in:sakit,cuti,dinas_luar',
            'start_date' => 'sometimes|required|date|before_or_equal:end_date',
            'end_date' => 'sometimes|required|date|after_or_equal:start_date',
            'reason' => 'sometimes|required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }
}
