<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Services\RoleService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $roles = $this->roleService->getAllRoles();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Daftar Role berhasil diambil',
                    'data' => $roles
                ], 200);
            }

            return view('roles.index', compact('roles'));
        } catch (\Exception $e) {
            Log::error('Error get all roles: ' . $e->getMessage());

            if ($request->expectsJson()) {

                return response()->json([
                    'success' => false,
                    'message' => 'gagal mengambil data' . $e->getMessage(),
                ], 500);
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data');

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
    public function store(StoreRoleRequest $request)
    {
        try {
            $role = $this->roleService->createRole($request->validated());
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Role berhasil ditambahkan',
                    'data' => $role
                ], 201);
            }

            return redirect()->route('roles.index')->with('success', 'Role berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('Error create role: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membuat Role: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->withInput()->with('error', 'Gagal membuat Role');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Role $role)
    {
        try {

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil mengambil data role',
                    'data' => $role,
                ], 200);
            }

            return view('roles.show', compact('role'));



        } catch (Exception $e) {
            Log::error('Error mengambil data role : ' . $e->getMessage());
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengambil data role' . $e->getMessage(),
                ], 500);
            }

            return redirect()->back()->withInput()->with('error', 'Gagal memuat Role');

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
    public function update(UpdateRoleRequest $request, Role $role)
    {
        try {
            $updatedRole = $this->roleService->updateRole($role, $request->validated());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Role berhasil diperbarui',
                    'data' => $updatedRole,
                ], 200);
            }

            return redirect()->route('roles.index')->with('success', 'Role berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Error update role: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui Role: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui Role: ' . $e->getMessage());

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Role $role)
    {
        try {
            $this->roleService->deleteRole($role);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Role berhasil dihapus'
                ], 200);
            }

            return redirect()->route('roles.index')->with('success', 'Role berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error delete role' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengapus role',
                ], 500);
            }

            return redirect()->back()->with('error', 'Gagal menghapus role');
        }
        //
    }
}
