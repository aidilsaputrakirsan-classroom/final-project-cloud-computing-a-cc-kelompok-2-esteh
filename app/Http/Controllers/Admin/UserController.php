<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
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
        // Ambil data user berdasarkan role
        $users = User::whereIn('role', ['user', 'admin'])->get();

        // Arahkan ke halaman index user
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
     * Menyimpan user baru ke dalam database.
     */
    public function store(Request $request)
    {
        // Validasi input form
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'role'      => 'required|in:user,admin',
            'password'  => 'required|min:6',
        ]);

        // Simpan user baru
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => $request->role,
            'password' => Hash::make($request->password), // Enkripsi password
        ]);

        // Kembali ke halaman daftar user
        return redirect()->route('admin.users.index')
                         ->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit user berdasarkan id.
     */
    public function edit($id)
    {
        // Cari user berdasarkan id, jika tidak ditemukan maka 404
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Mengupdate data user yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        // Cari user berdasarkan id
        $user = User::findOrFail($id);

        // Validasi input
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $user->id, // email boleh sama jika email miliknya sendiri
            'role'      => 'required|in:user,admin',
            'password'  => 'nullable|min:6', // password opsional saat update
        ]);

        // Update data user
        $user->name  = $request->name;
        $user->email = $request->email;
        $user->role  = $request->role;

        // Update password hanya jika ada input baru
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        // Simpan perubahan
        $user->save();

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

        // Hapus user
        $user->delete();

        return back()->with('success', 'User berhasil dihapus.');
    }
}
