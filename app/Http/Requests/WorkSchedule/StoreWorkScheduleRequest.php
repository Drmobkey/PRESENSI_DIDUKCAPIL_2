<?php

namespace App\Http\Requests\WorkSchedule;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('work_schedules.store');
    }

    public function rules(): array
    {
        return [
            'day_of_week' => 'required|integer|min:0|max:6|unique:work_schedules,day_of_week',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
        ];
    }

    public function messages(): array
    {
        return [
            'day_of_week.unique' => 'Jadwal untuk hari ini sudah ada.',
            'end_time.after' => 'Jam selesai harus setelah jam mulai.',
        ];
    }
}
