<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function approve(Request $request, User $user)
    {
        $request->validate([
            'tpdk_id' => 'required|array',
            'tpdk_id.*' => 'exists:tpdk,id',

        ]);

        try {
            $this->userService->approveUser($user, $request->tpdk_id);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User berhasil disetujui dan akses TPDK telah diatur.'
                ], 200);
            }

            return redirect()->back()->with('success', 'User berhasil disetujui.');


        } catch (\Exception $e) {
            Log::error('Error approve user: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyetujui user.'
                ], 500);
            }

            return redirect()->back()->with('error', 'Gagal menyetujui user.');
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $users = $this->userService->getAllUser();
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'user berhasil diambil',
                    'data' => $users
                ], 200);
            }

            return view('users.index', compact('users'));
        } catch (\Exception $e) {
            Log::error('Error get users: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengambil user',

                ], 500);
            }

            return redirect()->back()->with('error', 'Gagal memuat data user');
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
    public function store(StoreUserRequest $request)
    {
        try {
            $user = $this->userService->createUser($request->validated());
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User berhasil ditambahkan',
                    'data' => $user
                ], 201);
            }

            return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');

        } catch (\Exception $e) {

            Log::error('Error create user: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan user'
                ], 500);
            }

            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan user.');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $user)
    {
        try {
            // Memanggil fungsi getUserById dari service (otomatis me-load relasi)
            $user = $this->userService->getUserById($user);

            // Jika request berupa API / JSON
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Detail user berhasil diambil',
                    'data' => $user
                ], 200);
            }

            // Jika request berupa web browser
            return view('users.show', compact('user'));

        } catch (\Exception $e) {
            Log::error('Error get user detail: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengambil detail user',
                ], 500);
            }

            return redirect()->route('users.index')->with('error', 'Gagal memuat detail user');
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
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $user = $this->userService->updateUser($user, $request->validated());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User berhasil diperbarui',
                    'data' => $user,

                ], 200);
            }

            return redirect()->route('user.index')->with('success', 'User berhasil diperbarui');

        } catch (\Exception $e) {
            Log::error('Error update user:' . $e->getMessage());
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui user' . $e->getMessage(),

                ], 500);
            }

            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui user');

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user)
    {
        try {
            $this->userService->deleteUser($user);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User berhasil dihapus',
                    'data' => $user,
                ], 200);
            }

            return redirect()->route('user.index')->with('success', 'User berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Error delete user' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus user' . $e->getMessage(),
                ], 500);
            }

            return redirect()->back()->with('error', 'Gagal menghapus user');
        }
    }
}
