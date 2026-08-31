<?php

namespace App\Http\Controllers;

use App\Services\AttendanceService;
use App\Http\Requests\Attendance\StoreCheckInRequest;
use App\Http\Requests\Attendance\StoreCheckOutRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    protected $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    public function checkIn(StoreCheckInRequest $request)
    {
        try {
            $attendance = $this->attendanceService->checkIn($request->user(), $request->validated());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Check In berhasil',
                    'data' => $attendance
                ], 201);
            }
            return redirect()->back()->with('success', 'Check In berhasil!');

        } catch (\Exception $e) {
            Log::error('Error Check In: ' . $e->getMessage()); // Mencatat error secara diam-diam ke log sistem[cite: 1]

            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function checkOut(StoreCheckOutRequest $request)
    {
        try {
            $attendance = $this->attendanceService->checkOut($request->user(), $request->validated());

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Check Out berhasil', 'data' => $attendance], 200);
            }
            return redirect()->back()->with('success', 'Check Out berhasil!');

        } catch (\Exception $e) {
            Log::error('Error Check Out: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Data difilter otomatis oleh Service berdasarkan permission[cite: 1]
            $attendances = $this->attendanceService->getAttendances($request->user());

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'data' => $attendances], 200);
            }
            return view('attendances.index', compact('attendances'));

        } catch (\Exception $e) {
            Log::error('Error get attendances: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Gagal mengambil data presensi.'], 500);
            }
            return redirect()->back()->with('error', 'Gagal mengambil data presensi.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, \App\Models\Attendance $attendance)
    {
        $user = $request->user();

        // Lapisan Otorisasi: Cegah User A mengintip data presensi User B via parameter URL
        $isOwner = $attendance->user_id === $user->id;
        $canViewAll = $user->can('attendances.view_all');

        if (!$isOwner && !$canViewAll) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Anda tidak memiliki akses melihat presensi ini.'], 403);
            }
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        try {
            $attendance->load(['user', 'tpdk']); // Eager load relasi untuk detail

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'data' => $attendance], 200);
            }
            return view('attendances.show', compact('attendance'));

        } catch (\Exception $e) {
            Log::error('Error show attendance: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Gagal menampilkan detail presensi.'], 500);
            }
            return redirect()->back()->with('error', 'Gagal menampilkan detail presensi.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
