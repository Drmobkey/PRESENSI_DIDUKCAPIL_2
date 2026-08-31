<?php

namespace App\Http\Controllers;

use App\Models\Tpdk;
use App\Services\TpdkService;
use App\Http\Requests\Tpdk\StoreTpdkRequest;
use App\Http\Requests\Tpdk\UpdateTpdkRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TpdkController extends Controller
{
    protected $tpdkService;

    public function __construct(TpdkService $tpdkService)
    {
        $this->tpdkService = $tpdkService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $tpdks = $this->tpdkService->getAllTpdks();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Daftar TPDK berhasil diambil',
                    'data' => $tpdks
                ], 200);
            }

            return view('tpdk.index', compact('tpdks'));
        } catch (\Exception $e) {
            Log::error('Error get TPDKs: ' . $e->getMessage());
            return $this->handleError($request, 'Gagal memuat data TPDK.', 500);
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
    public function store(StoreTpdkRequest $request)
    {
        try {
            $tpdk = $this->tpdkService->createTpdk($request->validated());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Titik TPDK berhasil ditambahkan',
                    'data' => $tpdk
                ], 201);
            }

            return redirect()->route('tpdk.index')->with('success', 'Titik TPDK berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('Error create TPDK: ' . $e->getMessage());
            return $this->handleError($request, 'Gagal menambahkan titik TPDK: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Tpdk $tpdk)
    {
        try {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Detail TPDK berhasil diambil',
                    'data' => $tpdk
                ], 200);
            }

            return view('tpdk.show', compact('tpdk'));
        } catch (\Exception $e) {
            Log::error('Error show TPDK: ' . $e->getMessage());
            return $this->handleError($request, 'Gagal memuat detail TPDK.', 500);
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
    public function update(UpdateTpdkRequest $request, Tpdk $tpdk)
    {
        try {
            $updatedTpdk = $this->tpdkService->updateTpdk($tpdk, $request->validated());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data TPDK berhasil diperbarui',
                    'data' => $updatedTpdk
                ], 200);
            }

            return redirect()->route('tpdk.index')->with('success', 'Data TPDK berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Error update TPDK: ' . $e->getMessage());
            return $this->handleError($request, 'Gagal memperbarui TPDK: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Tpdk $tpdk)
    {
        try {
            $this->tpdkService->deleteTpdk($tpdk);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data TPDK berhasil dihapus'
                ], 200);
            }

            return redirect()->route('tpdk.index')->with('success', 'Data TPDK berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error delete TPDK: ' . $e->getMessage());
            return $this->handleError($request, $e->getMessage(), 400);
        }

    }
    private function handleError(Request $request, string $message, int $statusCode)
    {
        if ($request->expectsJson()) {
            return response()->json(['success' => false, 'message' => $message], $statusCode);
        }
        return redirect()->back()->withInput()->with('error', $message);
    }
}
