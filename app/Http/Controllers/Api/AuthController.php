<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'no_hp'       => null,
            'alamat'      => null,
            'foto_profil' => null
        ]);

        // Otomatis login setelah register 
        Auth::login($user);

        return response()->json([
            'status'  => 'success',
            'message' => 'Registrasi Berhasil!',
            'data'    => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email
            ]
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // buat session baru setelah login

            return response()->json([
                'status'  => 'success',
                'message' => 'Login Berhasil!',
                'data'    => Auth::user()
            ], 200);
        }

        return response()->json([
            'status'  => 'error',
            'message' => 'Login Gagal! Email atau Password salah.'
        ], 401);
    }

    // Tambahan Wajib untuk Web: Fitur Logout
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'status'  => 'success',
            'message' => 'Logout Berhasil!'
        ], 200);
    }

    public function me(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'data'   => $request->user()
        ], 200);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name'   => 'nullable|string|max:255',
            'no_hp'  => 'nullable|string|max:20',
            'alamat' => 'nullable|string'
        ]);

        $user->update([
            'name'   => $request->name ?? $user->name,
            'no_hp'  => $request->no_hp ?? $user->no_hp,
            'alamat' => $request->alamat ?? $user->alamat
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Profil berhasil diperbarui',
            'data'    => $user
        ]);
    }

    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'foto_profil' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $user = $request->user();

        // hapus foto lama jika ada
        if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
            Storage::disk('public')->delete($user->foto_profil);
        }

        $path = $request->file('foto_profil')->store('profile', 'public');

        $user->update([
            'foto_profil' => $path
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Foto profil berhasil diupload',
            'data'    => $user
        ]);
    }

    public function deletePhoto(Request $request)
    {
        $user = $request->user();

        if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
            Storage::disk('public')->delete($user->foto_profil);
        }

        $user->update([
            'foto_profil' => null
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Foto profil berhasil dihapus'
        ]);
    }

    public function getPhoto(Request $request)
    {
        $user = $request->user();
    
        if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
            return response()->file(
                storage_path('app/public/' . $user->foto_profil)
            );
        } else {
            return response()->json(['message' => 'Foto tidak ditemukan'], 404);
        }
    }
}