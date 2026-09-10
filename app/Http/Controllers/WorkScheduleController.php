<?php

namespace App\Http\Controllers;

use App\Models\WorkSchedule;
use App\Services\WorkScheduleService;
use App\Http\Requests\WorkSchedule\StoreWorkScheduleRequest;
use App\Http\Requests\WorkSchedule\UpdateWorkScheduleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WorkScheduleController extends Controller
{
    protected $workScheduleService;

    public function __construct(WorkScheduleService $workScheduleService)
    {
        $this->workScheduleService = $workScheduleService;
    }

    public function index(Request $request)
    {
        $schedules = $this->workScheduleService->getSchedules();
        
        $days = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            0 => 'Minggu',
        ];

        return view('workschedules.index', compact('schedules', 'days'));
    }

    public function store(StoreWorkScheduleRequest $request)
    {
        try {
            $this->workScheduleService->store($request->validated());
            return redirect()->route('workschedules.index')->with('success', 'Jadwal kerja berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error store workschedule: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan jadwal kerja.');
        }
    }

    public function update(UpdateWorkScheduleRequest $request, WorkSchedule $workschedule)
    {
        try {
            $this->workScheduleService->update($workschedule, $request->validated());
            return redirect()->route('workschedules.index')->with('success', 'Jadwal kerja berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error update workschedule: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui jadwal kerja.');
        }
    }

    public function destroy(WorkSchedule $workschedule)
    {
        if (!auth()->user()->can('work_schedules.destroy')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki wewenang menghapus jadwal.');
        }

        try {
            $this->workScheduleService->destroy($workschedule);
            return redirect()->route('workschedules.index')->with('success', 'Jadwal kerja berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error delete workschedule: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus jadwal kerja.');
        }
    }
}
