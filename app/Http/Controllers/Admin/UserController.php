<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog; // model untuk activity log
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Menampilkan daftar user.
     * Hanya menampilkan role 'user' dan 'admin'.
     */
    public function index()
    {
        // Ambil semua user dengan role user atau admin
        $users = User::whereIn('role', ['user', 'admin'])->get();

        // Redirect ke halaman index user
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form untuk membuat user baru.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Menyimpan user baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'role'      => 'required|in:user,admin',
            'password'  => 'required|min:6',
        ]);

        // Buat user baru
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);

        // Simpan activity log
        ActivityLog::create([
            'user_id'     => auth()->id(), // siapa yang melakukan aksi
            'action'      => 'create',
            'description' => 'Menambahkan user baru: ' . $user->name,
            'details'     => json_encode($user),
        ]);

        return redirect()->route('admin.users.index')
                         ->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit user berdasarkan id.
     */
    public function edit($id)
    {
        // Cari user, jika tidak ditemukan otomatis 404
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Mengupdate data user yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validasi input
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'role'      => 'required|in:user,admin',
            'password'  => 'nullable|min:6',
        ]);

        // Simpan data lama untuk log
        $oldData = $user->toArray();

        // Update data user
        $user->name  = $request->name;
        $user->email = $request->email;
        $user->role  = $request->role;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Catat activity log
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'update',
            'description' => 'Mengupdate user: ' . $user->name,
            'details'     => json_encode([
                'old' => $oldData,
                'new' => $user->toArray(),
            ]),
        ]);

        return redirect()->route('admin.users.index')
                         ->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Menghapus user berdasarkan id.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Cegah user menghapus dirinya sendiri
        if (auth()->id() == $user->id) {
            return back()->with('error', 'Kamu tidak bisa menghapus akunmu sendiri.');
        }

        // Simpan data untuk log sebelum dihapus
        $oldData = $user->toArray();

        $user->delete();

        // Catat activity log
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'action'      => 'delete',
            'description' => 'Menghapus user: ' . $oldData['name'],
            'details'     => json_encode($oldData),
        ]);

        return back()->with('success', 'User berhasil dihapus.');
    }
}
