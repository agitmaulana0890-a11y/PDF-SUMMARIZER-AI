@extends('layouts.app')

@section('title', 'Masuk Akun Pengguna - EduSummarize AI')

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
            <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Selamat Datang Kembali</h2>
            <p class="mt-1 text-xs sm:text-sm text-slate-500">
                Masuk untuk mengakses ringkasan jurnal dan slide presentasi Anda.
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

        <!-- Alert Session Info / Success -->
        @if (session('info'))
            <div class="p-3.5 rounded-xl bg-blue-50 border border-blue-200/80 text-xs text-blue-700 flex items-start space-x-2">
                <svg class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('info') }}</span>
            </div>
        @endif

        @if (session('success'))
            <div class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200/80 text-xs text-emerald-700 flex items-start space-x-2">
                <svg class="w-4 h-4 text-emerald-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Form Login -->
        <form class="space-y-4" action="{{ route('login.submit') }}" method="POST" x-data="{ showPassword: false }">
            @csrf

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">
                    Alamat Email
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
                        autofocus
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
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="block text-xs font-semibold text-slate-700">
                        Kata Sandi
                    </label>
                    <a href="javascript:void(0)" onclick="alert('Fitur reset kata sandi dapat dihubungkan ke email administrator.')" class="text-[11px] font-medium text-indigo-600 hover:text-indigo-800 transition-colors">
                        Lupa kata sandi?
                    </a>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <input 
                        id="password" 
                        name="password" 
                        :type="showPassword ? 'text' : 'password'" 
                        required 
                        autocomplete="current-password"
                        placeholder="••••••••"
                        class="w-full pl-10 pr-10 py-2.5 rounded-xl border border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm transition-all focus:outline-none focus:ring-2 shadow-xs"
                    >
                    <button 
                        type="button" 
                        @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none text-xs"
                    >
                        <span x-show="!showPassword" title="Lihat kata sandi">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </span>
                        <span x-show="showPassword" x-cloak title="Sembunyikan kata sandi">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                        </span>
                    </button>
                </div>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input 
                    id="remember" 
                    name="remember" 
                    type="checkbox" 
                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-slate-300 rounded cursor-pointer"
                >
                <label for="remember" class="ml-2 block text-xs text-slate-600 cursor-pointer">
                    Ingat saya di perangkat ini
                </label>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-md shadow-indigo-500/20 text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:-translate-y-0.5 active:translate-y-0"
            >
                Masuk Sekarang &rarr;
            </button>
        </form>

        <!-- Divider -->
        <div class="relative my-4">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-slate-200"></div>
            </div>
            <div class="relative flex justify-center text-xs">
                <span class="px-3 bg-white text-slate-400">atau masuk dengan</span>
            </div>
        </div>

        <!-- Google OAuth Button -->
        <div>
            <a 
                href="{{ route('simulation.index') }}#dropzone" 
                class="w-full flex items-center justify-center gap-2.5 px-4 py-2.5 border border-slate-300 rounded-xl bg-white hover:bg-slate-50 text-slate-700 font-semibold text-xs transition-all shadow-xs"
            >
                <svg class="w-4 h-4" viewBox="0 0 24 24">
                    <path fill="#EA4335" d="M12 5c1.6 0 3 .6 4.1 1.6l3.1-3.1C17.3 1.7 14.8 1 12 1 7.5 1 3.7 3.6 1.9 7.3l3.7 2.9C6.5 7.4 9 5 12 5z"/>
                    <path fill="#4285F4" d="M23.5 12.3c0-.8-.1-1.7-.2-2.3H12v4.5h6.5c-.3 1.5-1.1 2.8-2.4 3.7l3.7 2.9c2.2-2 3.7-5 3.7-8.8z"/>
                    <path fill="#FBBC05" d="M5.6 14.8c-.2-.7-.4-1.5-.4-2.8s.2-2.1.4-2.8L1.9 6.3C.7 8.7 0 10.3 0 12s.7 3.3 1.9 5.7l3.7-2.9z"/>
                    <path fill="#34A853" d="M12 23c3.2 0 6-1.1 8-3l-3.7-2.9c-1.1.7-2.5 1.2-4.3 1.2-3 0-5.5-2-6.4-4.8L1.9 16.4C3.7 20.4 7.5 23 12 23z"/>
                </svg>
                <span>Masuk dengan Akun Google</span>
            </a>
        </div>

        <!-- Links Footer -->
        <div class="border-t border-slate-100 pt-4 text-center space-y-2">
            <p class="text-xs text-slate-500">
                Belum memiliki akun? 
                <a href="{{ route('register') }}" class="font-bold text-indigo-600 hover:text-indigo-800 transition-colors">
                    Daftar Akun Baru
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
