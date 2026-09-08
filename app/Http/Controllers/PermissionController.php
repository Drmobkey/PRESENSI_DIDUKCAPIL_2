<?php

namespace App\Http\Controllers;

use App\Http\Requests\Permission\StorePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use App\Services\PermissionService;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{

    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $permissions = $this->permissionService->getAllPermission();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Daftar permission berhasil diambil',
                    'data' => $permissions,
                ], 200);
            }

            return view('Setup.Permission.index', compact('permissions'));
        } catch (\Exception $e) {
            Log::error('Error get all permission' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'gagal mengambil data' . $e->getMessage(),
                ], 500);
            }

            return redirect()->back()->with('error', 'Gagal memuat data permission');
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
    public function store(StorePermissionRequest $request)
    {
        try {
            $permission = $this->permissionService->createPermission($request->validated());
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Permission berhasil dibuat',
                    'data' => $permission,

                ], 200);

            }
            return redirect()->route('setup.permissions.index')->with('success', 'Permission berhasil dibuat');
        } catch (\Exception $e) {
            Log::error('Error create permission:' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membuat permission' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->withInput()->with('error', 'Gagal membuat permission');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission, Request $request)
    {
        try {

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Permission berhasil diambil',
                    'data' => $permission,
                ], 200);
            }

            return view('Setup.Permission.show', compact('permission'));
        } catch (\Exception $e) {
            Log::error(('Error get permission: ' . $e->getMessage()));
            if ($request->expectsJson()) {

                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengambil data permission' . $e->getMessage()

                ], 500);
            }

            return redirect()->back()->withInput()->with('error', 'Gagal memuat data permission');
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
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        try {
            $permission = $this->permissionService->updatePermission($permission, $request->validated());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Permission berhasil diperbarui',
                    'data' => $permission,

                ], 200);
            }

            return redirect()->route('setup.permissions.index')->with('success', 'Permission berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Error update permission:' . $e->getMessage());
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui permission' . $e->getMessage(),

                ], 500);
            }

            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui permission');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Permission $permission)
    {
        try {
            $this->permissionService->deletePermission($permission);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Permission berhasil dihapus',
                    'data' => $permission,
                ], 200);
            }

            return redirect()->route('setup.permissions.index')->with('success', 'Permission berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error delete permission' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus permission' . $e->getMessage(),
                ], 500);
            }

            return redirect()->back()->with('error', 'Gagal menghapus permission');
        }
    }
}
