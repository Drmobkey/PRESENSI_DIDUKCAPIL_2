<?php

namespace App\Http\Requests\WorkSchedule;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWorkScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('work_schedules.update');
    }

    public function rules(): array
    {
        $workScheduleId = $this->route('workschedule')->id ?? $this->route('work_schedule')->id;
        
        return [
            'day_of_week' => [
                'required',
                'integer',
                'min:0',
                'max:6',
                Rule::unique('work_schedules')->ignore($workScheduleId),
            ],
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
