<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Logbook;
use App\Services\LogbookService;
use Illuminate\Http\Request;
use App\Http\Requests\Logbook\StoreLogbookRequest;
use App\Http\Requests\Logbook\UpdateLogbookRequest;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LogbooksExport;
use Barryvdh\DomPDF\Facade\Pdf;

class LogbookController extends Controller
{

    protected $logbookService;

    public function __construct(LogbookService $logbookService)
    {
        $this->logbookService = $logbookService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $filters = $request->only(['user_id', 'status', 'start_date', 'end_date']);
            $logbooks = $this->logbookService->getLogbooks($request->user(), $filters);
            $users = User::orderBy('name')->get();

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'data' => $logbooks], 200);
            }
            return view('logbooks.index', compact('logbooks', 'users'));

        } catch (\Exception $e) {
            Log::error('Error get logbooks: ' . $e->getMessage());
            return $this->handleError($request, 'Gagal mengambil data logbook.', 500);
        }
    }

    public function exportExcel(Request $request)
    {
        $filters = $request->only(['user_id', 'status', 'start_date', 'end_date']);
        $logbooks = $this->logbookService->getLogbooks($request->user(), $filters, false);
        return Excel::download(new LogbooksExport($logbooks), 'Laporan_Logbook_'.date('Ymd').'.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $filters = $request->only(['user_id', 'status', 'start_date', 'end_date']);
        $logbooks = $this->logbookService->getLogbooks($request->user(), $filters, false);
        $pdf = Pdf::loadView('logbooks.export-pdf', ['data' => $logbooks]);
        return $pdf->download('Laporan_Logbook_'.date('Ymd').'.pdf');
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
    public function store(StoreLogbookRequest $request)
    {
        try {
            $logbook = $this->logbookService->storeLogbook($request->user(), $request->validated());

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'data' => $logbook], 201);
            }
            return redirect()->back()->with('success', 'Logbook hari ini berhasil disimpan.');
        } catch (\Exception $e) {
            Log::error('Error store logbook: ' . $e->getMessage());
            return $this->handleError($request, 'Gagal menyimpan logbook.', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Logbook $logbook)
    {
        $user = $request->user();

        // Proteksi URL: Cegah User A mengintip logbook User B
        $isOwner = $logbook->user_id === $user->id;
        $canViewAll = $user->can('logbooks.manage_all');

        if (!$isOwner && !$canViewAll) {
            return $this->handleError($request, 'Anda tidak memiliki akses melihat logbook ini.', 403);
        }

        try {
            $logbook->load('user');

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'data' => $logbook], 200);
            }
            return view('logbooks.show', compact('logbook'));

        } catch (\Exception $e) {
            Log::error('Error show logbook: ' . $e->getMessage());
            return $this->handleError($request, 'Gagal menampilkan detail logbook.', 500);
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
    public function update(UpdateLogbookRequest $request, Logbook $logbook)
    {
        if ($logbook->status === 'approved') {
            return $this->handleError($request, 'Logbook yang sudah disetujui tidak dapat diedit.', 403);
        }

        try {
            $validated = $request->validated();
            if ($logbook->status === 'revision') {
                $validated['status'] = 'pending';
                $validated['rejection_note'] = null;
            }

            $updatedLogbook = $this->logbookService->updateLogbook($logbook, $validated);

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'data' => $updatedLogbook], 200);
            }
            return redirect()->back()->with('success', 'Logbook berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error update logbook: ' . $e->getMessage());
            return $this->handleError($request, 'Gagal memperbarui logbook.', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Logbook $logbook)
    {
        // Validasi ekstra: Hanya Superadmin/Admin atau Pemilik yang bisa menghapus
        if (!$request->user()->can('logbooks.manage_all') && $logbook->user_id !== $request->user()->id) {
            return $this->handleError($request, 'Akses ditolak.', 403);
        }

        if ($logbook->status !== 'pending' && !$request->user()->can('logbooks.manage_all')) {
            return $this->handleError($request, 'Hanya logbook dengan status pending yang dapat dihapus.', 403);
        }

        try {
            $this->logbookService->deleteLogbook($logbook);

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Logbook dihapus'], 200);
            }
            return redirect()->route('logbooks.index')->with('success', 'Logbook berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error delete logbook: ' . $e->getMessage());
            return $this->handleError($request, 'Gagal menghapus logbook.', 500);
        }
    }

    public function updateStatus(Request $request, Logbook $logbook)
    {
        if (!$request->user()->can('logbooks.manage_all')) {
            return $this->handleError($request, 'Akses ditolak.', 403);
        }

        $request->validate([
            'status' => 'required|in:approved,revision',
            'rejection_note' => 'nullable|string'
        ]);

        try {
            $logbook->update([
                'status' => $request->status,
                'rejection_note' => $request->status === 'revision' ? $request->rejection_note : null
            ]);
            return redirect()->back()->with('success', 'Status logbook berhasil diperbarui.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error update status logbook: ' . $e->getMessage());
            return $this->handleError($request, 'Gagal memperbarui status.', 500);
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
