@extends('layouts.app')

@section('title', 'Login Administrator - Security Awareness Dashboard')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-slate-50">
    <div class="max-w-md w-full space-y-8 bg-white p-8 sm:p-10 rounded-3xl border border-slate-200/90 shadow-xl shadow-slate-100">
        
        <div class="text-center">
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 border border-indigo-200 text-indigo-600 flex items-center justify-center mx-auto mb-4 shadow-sm">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Admin Gagah</h2>
            <p class="mt-1 text-xs text-slate-500">
                Masuk untuk melihat metrik dan log kesadaran simulasi keamanan siber.
            </p>
        </div>

        @if ($errors->any())
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-700">
                {{ $errors->first() }}
            </div>
        @endif

        @if (session('info'))
            <div class="p-4 rounded-xl bg-blue-50 border border-blue-200 text-xs text-blue-700">
                {{ session('info') }}
            </div>
        @endif

        <form class="mt-6 space-y-5" action="{{ route('admin.login.submit') }}" method="POST">
            @csrf

            <div>
                <label for="pin" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Password
                </label>
                <div class="relative">
                    <input 
                        id="pin" 
                        name="pin" 
                        type="password" 
                        required 
                        autofocus
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-mono tracking-widest"
                    >
                </div>
            </div>

            <button 
                type="submit" 
                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-md shadow-indigo-500/20 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all"
            >
                Masuk ke Dashboard &rarr;
            </button>
        </form>

        <div class="border-t border-slate-100 pt-4 text-center">
            <a href="{{ route('simulation.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">
                &larr; Kembali ke Halaman Simulasi
            </a>
        </div>

    </div>
</div>
@endsection
