<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserAuthController extends Controller
{
    /**
     * Tampilkan formulir login user.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('simulation.index')->with('info', 'Anda sudah masuk sebagai ' . Auth::user()->name);
        }

        return view('auth.login');
    }

    /**
     * Proses autentikasi login user.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        try {
            if (Auth::attempt($credentials, $remember)) {
                $request->session()->regenerate();

                return redirect()->intended(route('simulation.index'))
                    ->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
            }

            return back()->withErrors([
                'email' => 'Email atau kata sandi yang Anda masukkan salah.',
            ])->onlyInput('email');
        } catch (\Throwable $e) {
            return back()->withErrors([
                'email' => 'Koneksi database bermasalah: ' . $e->getMessage() . '. Pastikan MySQL di XAMPP sudah aktif atau database lokal sudah dibuat.',
            ])->onlyInput('email');
        }
    }

    /**
     * Tampilkan formulir registrasi user baru.
     */
    public function showRegisterForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('simulation.index');
        }

        return view('auth.register');
    }

    /**
     * Proses pendaftaran user baru.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar. Silakan gunakan email lain atau masuk.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->route('simulation.index')
                ->with('success', 'Akun berhasil dibuat! Selamat datang di EduSummarize AI, ' . $user->name . '.');
        } catch (\Throwable $e) {
            return back()->withErrors([
                'email' => 'Gagal mendaftar karena kendala database: ' . $e->getMessage(),
            ])->withInput();
        }
    }

    /**
     * Proses logout user.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('simulation.index')->with('info', 'Anda telah berhasil keluar.');
    }
}
