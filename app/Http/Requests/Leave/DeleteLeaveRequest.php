<?php

namespace App\Http\Requests\Leave;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DeleteLeaveRequest extends FormRequest
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
            //
        ];
    }
}
