@extends('layouts.app')

@section('title', 'Daftar Akun Baru - EduSummarize AI')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden bg-gradient-to-b from-indigo-50/50 via-white to-slate-50">
    
    <!-- Background Glow -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-4xl h-96 bg-gradient-to-tr from-indigo-200/40 via-purple-100/30 to-pink-100/40 blur-3xl pointer-events-none -z-10"></div>

    <div class="max-w-md w-full space-y-6 bg-white/90 backdrop-blur-xl p-8 sm:p-10 rounded-3xl border border-slate-200/90 shadow-2xl shadow-indigo-100/50">
        
        <!-- Header & Logo -->
        <div class="text-center">
            <a href="{{ route('simulation.index') }}" class="inline-flex items-center space-x-2.5 mb-3 group">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-600 flex items-center justify-center text-white shadow-md shadow-indigo-500/25 font-extrabold text-lg group-hover:scale-105 transition-transform">
                    AI
                </div>
                <span class="font-extrabold text-2xl tracking-tight text-slate-900">EduSummarize<span class="text-indigo-600">.ai</span></span>
            </a>
            <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Buat Akun Gratis</h2>
            <p class="mt-1 text-xs sm:text-sm text-slate-500">
                Mulai ringkas puluhan halaman jurnal dan buat slide presentasi instan.
            </p>
        </div>

        <!-- Alert Error Global -->
        @if ($errors->any())
            <div class="p-3.5 rounded-xl bg-rose-50 border border-rose-200/80 text-xs text-rose-700 flex items-start space-x-2">
                <svg class="w-4 h-4 text-rose-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <!-- Form Register -->
        <form class="space-y-4" action="{{ route('register.submit') }}" method="POST">
            @csrf

            <!-- Name Field -->
            <div>
                <label for="name" class="block text-xs font-semibold text-slate-700 mb-1.5">
                    Nama Lengkap
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input 
                        id="name" 
                        name="name" 
                        type="text" 
                        value="{{ old('name') }}" 
                        required 
                        autofocus
                        placeholder="Contoh: Muhammad Budi"
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border {{ $errors->has('name') ? 'border-rose-400 focus:ring-rose-400' : 'border-slate-300 focus:border-indigo-500 focus:ring-indigo-500' }} text-sm transition-all focus:outline-none focus:ring-2 shadow-xs"
                    >
                </div>
                @error('name')
                    <p class="mt-1 text-[11px] text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">
                    Alamat Email Kampus / Pribadi
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <input 
                        id="email" 
                        name="email" 
                        type="email" 
                        value="{{ old('email') }}" 
                        required 
                        autocomplete="email"
                        placeholder="nama@gmail.com"
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border {{ $errors->has('email') ? 'border-rose-400 focus:ring-rose-400' : 'border-slate-300 focus:border-indigo-500 focus:ring-indigo-500' }} text-sm transition-all focus:outline-none focus:ring-2 shadow-xs"
                    >
                </div>
                @error('email')
                    <p class="mt-1 text-[11px] text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-xs font-semibold text-slate-700 mb-1.5">
                    Kata Sandi (Minimal 8 karakter)
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <input 
                        id="password" 
                        name="password" 
                        type="password" 
                        required 
                        autocomplete="new-password"
                        placeholder="••••••••"
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border {{ $errors->has('password') ? 'border-rose-400 focus:ring-rose-400' : 'border-slate-300 focus:border-indigo-500 focus:ring-indigo-500' }} text-sm transition-all focus:outline-none focus:ring-2 shadow-xs"
                    >
                </div>
                @error('password')
                    <p class="mt-1 text-[11px] text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password Field -->
            <div>
                <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 mb-1.5">
                    Konfirmasi Kata Sandi
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <input 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        type="password" 
                        required 
                        autocomplete="new-password"
                        placeholder="••••••••"
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm transition-all focus:outline-none focus:ring-2 shadow-xs"
                    >
                </div>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-md shadow-indigo-500/20 text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:-translate-y-0.5 active:translate-y-0"
            >
                Daftar & Mulai Gunakan &rarr;
            </button>
        </form>

        <!-- Links Footer -->
        <div class="border-t border-slate-100 pt-4 text-center space-y-2">
            <p class="text-xs text-slate-500">
                Sudah memiliki akun? 
                <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-800 transition-colors">
                    Masuk di Sini
                </a>
            </p>
            <div>
                <a href="{{ route('simulation.index') }}" class="text-xs text-slate-400 hover:text-slate-600 inline-flex items-center gap-1 transition-colors">
                    &larr; Kembali ke Beranda
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
