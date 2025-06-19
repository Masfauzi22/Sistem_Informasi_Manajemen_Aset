<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Hash; // Panggil Hash Facade untuk password

class UserController extends Controller
{
    // Menambahkan trait untuk otorisasi
    use AuthorizesRequests;

    public function index()
    {
        // Hanya yang punya izin 'manage users' boleh melihat halaman ini
        $this->authorize('manage users');
        $users = User::with('roles')->paginate(10);
        return view('pages.users.index', compact('users'));
    }

    public function create()
    {
        $this->authorize('manage users');
        // Ambil semua peran untuk ditampilkan di dropdown
        $roles = Role::all();
        return view('pages.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->authorize('manage users');

        // Validasi data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'exists:roles,name'],
        ]);

        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password
        ]);

        // Berikan peran yang dipilih
        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        // Fungsi ini sengaja dikosongkan seperti di kode awal
    }

    public function edit(User $user)
    {
        // Hanya yang punya izin 'manage users' boleh mengakses form edit
        $this->authorize('manage users');
        $roles = Role::all();
        return view('pages.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        // Hanya yang punya izin 'manage users' boleh memproses update
        $this->authorize('manage users');
        $request->validate([
            'role' => 'required|exists:roles,name'
        ]);
        $user->syncRoles($request->role);
        return redirect()->route('users.index')->with('success', 'Peran pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        // Hanya yang punya izin 'manage users' boleh menghapus
        $this->authorize('manage users');

        // Logika pengaman agar tidak bisa hapus diri sendiri
        if ($user->id == auth()->user()->id) {
            return redirect()->route('users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}