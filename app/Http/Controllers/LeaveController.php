<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Services\LeaveService;
use App\Http\Requests\Leave\StoreLeaveRequest;
use App\Http\Requests\Leave\UpdateLeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LeaveController extends Controller
{
    protected $leaveService;

    public function __construct(LeaveService $leaveService)
    {
        $this->leaveService = $leaveService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $leaves = $this->leaveService->getLeaves($request->user());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Daftar izin berhasil diambil',
                    'data' => $leaves
                ], 200);
            }

            return view('leaves.index', compact('leaves'));


        } catch (\Exception $e) {
            Log::error('Error get leaves: ' . $e->getMessage());
            return $this->handleError($request, 'Gagal mengambil data pengajuan izin.', 500);
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
    public function store(StoreLeaveRequest $request)
    {
        try {
            $leave = $this->leaveService->createLeave($request->user(), $request->validated());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pengajuan izin berhasil dibuat',
                    'data' => $leave
                ], 201);
            }
            return redirect()->route('leaves.index')->with('success', 'Pengajuan izin berhasil dibuat.');

        } catch (\Exception $e) {
            Log::error('Error create leave: ' . $e->getMessage());
            return $this->handleError($request, 'Gagal membuat pengajuan izin.', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Leave $leave)
    {
        // Lapis Keamanan Ekstra: Cegah User A melihat detail izin User B via URL
        $user = $request->user();
        $isOwner = $leave->user_id === $user->id;
        $isSuperadmin = $user->can('leaves.manage_all');

        // Pengecekan Admin Cabang (Apakah user yang mengajukan izin satu TPDK dengan Admin?)
        $isBranchAdmin = $user->can('leaves.manage_branch') &&
            $leave->user->primary_tpdk_id === $user->primary_tpdk_id;

        if (!$isOwner && !$isSuperadmin && !$isBranchAdmin) {
            return $this->handleError($request, 'Anda tidak memiliki akses untuk melihat data ini.', 403);
        }

        try {
            // Load relasi user untuk ditampilkan di view/JSON
            $leave->load('user');

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Detail izin berhasil diambil',
                    'data' => $leave
                ], 200);
            }

            return view('leaves.show', compact('leave'));

        } catch (\Exception $e) {
            Log::error('Error show leave: ' . $e->getMessage());
            return $this->handleError($request, 'Gagal menampilkan detail izin.', 500);
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
    public function update(UpdateLeaveRequest $request, Leave $leave)
    {
        try {
            $updatedLeave = $this->leaveService->updateLeave($leave, $request->validated());

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Pengajuan izin diperbarui', 'data' => $updatedLeave], 200);
            }
            return redirect()->back()->with('success', 'Pengajuan izin berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error('Error update leave: ' . $e->getMessage());
            return $this->handleError($request, 'Gagal memperbarui pengajuan izin.', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Leave $leave)
    {
        $user = $request->user();

        // Cek: Apakah ini pemiliknya sendiri (dan masih pending) ATAU dia adalah Superadmin?
        $isOwnerAndPending = $leave->user_id === $user->id && $leave->status === 'pending';
        $canManageAll = $user->can('leaves.manage_all');

        if (!$isOwnerAndPending && !$canManageAll) {
            return $this->handleError($request, 'Anda tidak berhak menghapus data ini atau izin sudah diproses.', 403);
        }

        try {
            $this->leaveService->deleteLeave($leave);

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Pengajuan izin dibatalkan'], 200);
            }
            return redirect()->route('leaves.index')->with('success', 'Pengajuan izin dibatalkan.');

        } catch (\Exception $e) {
            Log::error('Error delete leave: ' . $e->getMessage());
            return $this->handleError($request, 'Gagal membatalkan pengajuan izin.', 500);
        }
    }

    public function approve(Request $request, Leave $leave)
    {
        $user = $request->user();

        // Hanya Admin/Superadmin yang boleh mengeksekusi ini
        if (!$user->can('leaves.manage_all') && !$user->can('leaves.manage_branch')) {
            return $this->handleError($request, 'Anda tidak memiliki wewenang menyetujui izin.', 403);
        }

        try {
            $approvedLeave = $this->leaveService->approvalLeave($leave);

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Izin disetujui', 'data' => $approvedLeave], 200);
            }
            return redirect()->back()->with('success', 'Pengajuan izin berhasil disetujui.');

        } catch (\Exception $e) {
            Log::error('Error approve leave: ' . $e->getMessage());
            return $this->handleError($request, 'Gagal menyetujui pengajuan izin.', 500);
        }
    }

    private function handleError(Request $request, $message, $code)
    {
        if ($request->expectsJson()) {
            return response()->json(['success' => false, 'message' => $message], $code);
        }
        return redirect()->back()->with('error', $message);
    }
}
