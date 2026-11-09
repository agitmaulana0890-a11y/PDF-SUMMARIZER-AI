@extends('layouts.app')

@section('title', 'Peringatan Edukasi Keamanan Siber - Security Awareness Debriefing')

@section('content')
<div class="bg-gradient-to-b from-slate-100 via-white to-slate-50 min-h-screen py-10 sm:py-16">
    <div class="max-w-4xl mx-auto px-4">
        
        <!-- Main Alert Banner -->
        <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xl overflow-hidden mb-8">
            
            <!-- Top Hero Alert Header -->
            <div class="bg-gradient-to-r from-amber-500 via-rose-500 to-indigo-600 p-1">
                <div class="bg-white px-6 py-8 sm:p-10 text-center">
                    
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-3xl bg-amber-50 border-2 border-amber-200 text-amber-600 flex items-center justify-center mx-auto mb-4 shadow-inner">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>

                    <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                        Upss! <span class="text-transparent bg-clip-text bg-gradient-to-r from-rose-600 to-amber-600">ketipu nihh yeee</span> <span class="inline-block select-none" style="color: initial; font-family: 'Apple Color Emoji', 'Segoe UI Emoji', 'Noto Color Emoji', sans-serif;">&#128540;</span>
                    </h1>

                    <p class="mt-3 text-sm sm:text-base text-slate-600 max-w-2xl mx-auto leading-relaxed">
                        Chill ajaaaa, <span class="font-bold text-slate-800">akun dan data tetap 100% aman!</span> ini cuma simulasi terkontrol tanpa risiko untuk menguji dan melatih kepekaan Anda terhadap serangan rekayasa sosial (social engineering) berbasis iming-iming alat AI gratis.
                    </p>
                </div>
            </div>

            <!-- Privacy-by-Design Transparency Card -->
            <div class="bg-slate-50 border-t border-b border-slate-200/80 p-6 sm:px-10">
                <div class="flex items-start gap-4">
                    <div class="p-2.5 rounded-xl bg-emerald-100 text-emerald-700 mt-0.5">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div class="flex-1 text-xs sm:text-sm text-slate-700">
                        <h3 class="font-bold text-slate-900 text-base mb-1">Jaminan Privasi Anda (Privacy-by-Design)</h3>
                        <p class="leading-relaxed text-slate-600">
                            Aplikasi simulasi ini dibangun dengan etika privasi mutlak:
                        </p>
                        <ul class="mt-2 space-y-1 list-disc list-inside text-slate-600">
                            <li><span class="font-medium text-slate-900">File dokumen Anda tidak pernah diunggah atau disimpan di server</span> (hanya metadata ukuran & ekstensi yang dibaca sementara oleh browser Anda).</li>
                            <li><span class="font-medium text-slate-900">Kata sandi atau informasi akun yang Anda ketikkan tidak pernah disimpan</span> ke database ataupun server demi menjaga etika privasi (Privacy-by-Design).</li>
                            <li>Sistem hanya mencatat metrik tahapan interaksi edukasi (Token: <code class="px-1.5 py-0.5 bg-slate-200 rounded text-slate-800 font-mono text-xs">{{ Str::limit($token ?? 'sim_session', 14) }}</code>, Ekstensi: <code class="px-1.5 py-0.5 bg-indigo-100 text-indigo-800 font-mono text-xs">{{ $log->file_extension ?? '.pdf' }}</code>).</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Deep Dive: Anatomy of Attack -->
            <div class="p-6 sm:p-10 space-y-8">
                
                <div>
                    <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                        <span class="w-7 h-7 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs font-bold">1</span>
                        Bedah Anatomi Serangan: Mengapa Anda Mengklik Login?
                    </h2>
                    <p class="text-sm text-slate-600 mt-1 mb-5">
                        Penyerang siber modern tidak hanya mengandalkan kode teknis, melainkan memanfaatkan bias psikologis manusia (Cognitive Biases):
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        
                        <!-- Baiting Card -->
                        <div class="p-5 rounded-2xl bg-amber-50/60 border border-amber-200">
                            <div class="w-8 h-8 rounded-lg bg-amber-500 text-white flex items-center justify-center font-bold text-xs mb-3 shadow-xs">
                                🪤
                            </div>
                            <h4 class="font-bold text-sm text-slate-900 mb-1">Taktik Umpan (Baiting)</h4>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Menawarkan layanan yang sangat Anda butuhkan ("Ubah jurnal jadi ringkasan instan gratis") tanpa biaya. Rasa penasaran dan urgensi mengalahkan kewaspadaan awal.
                            </p>
                        </div>

                        <!-- Sunk-Cost Fallacy Card -->
                        <div class="p-5 rounded-2xl bg-rose-50/60 border border-rose-200">
                            <div class="w-8 h-8 rounded-lg bg-rose-500 text-white flex items-center justify-center font-bold text-xs mb-3 shadow-xs">
                                ⏳
                            </div>
                            <h4 class="font-bold text-sm text-slate-900 mb-1">Sunk-Cost Fallacy</h4>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Loading palsu selama 4 detik membuat Anda merasa telah "berinvestasi waktu". Saat hasil diringkas dikaburkan (blurred), Anda terdorong mengklik login demi tidak menyia-nyiakan proses.
                            </p>
                        </div>

                        <!-- OAuth Pretexting Card -->
                        <div class="p-5 rounded-2xl bg-indigo-50/60 border border-indigo-200">
                            <div class="w-8 h-8 rounded-lg bg-indigo-500 text-white flex items-center justify-center font-bold text-xs mb-3 shadow-xs">
                                🔑
                            </div>
                            <h4 class="font-bold text-sm text-slate-900 mb-1">Ilusi Kepercayaan (SSO)</h4>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Tombol "Sign in with Google" sering disalahgunakan untuk menyematkan aplikasi jahat (OAuth Consent Phishing) yang meminta izin akses Google Drive atau email tanpa disadari.
                            </p>
                        </div>

                    </div>
                </div>

                <!-- Danger Indicators in Real-World -->
                <div class="border-t border-slate-100 pt-8">
                    <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2 mb-4">
                        <span class="w-7 h-7 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center text-xs font-bold">2</span>
                        Bahaya Nyata Jika Ini Terjadi di Situs Phishing Sungguhan
                    </h2>

                    <div class="space-y-3">
                        <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-slate-200/60">
                            <span class="text-rose-500 font-bold text-base mt-0.5">⚠️</span>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900">Pencurian Kekayaan Intelektual & Kebocoran Dokumen</h4>
                                <p class="text-xs text-slate-600 mt-0.5 leading-relaxed">Jika Anda mengunggah draf skripsi, data penelitian belum dipublikasi, atau dokumen rahasia instansi, penyerang dapat menyalin dan menyalahgunakannya.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-slate-200/60">
                            <span class="text-rose-500 font-bold text-base mt-0.5">⚠️</span>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900">Pencurian Sesi & Kredensial Akun (Account Takeover)</h4>
                                <p class="text-xs text-slate-600 mt-0.5 leading-relaxed">Penyerang dapat membuat pop-up login Google palsu (Reverse Proxy / Modlishka) yang mampu menembus verifikasi 2 Langkah (2FA/OTP) secara real-time.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actionable Checklist -->
                <div class="border-t border-slate-100 pt-8">
                    <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2 mb-4">
                        <span class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-bold">3</span>
                        Panduan Cek 3 Langkah Sebelum Menggunakan Tools AI Asing
                    </h2>

                    <div class="bg-emerald-50/50 rounded-2xl border border-emerald-200/80 p-5 space-y-3 text-xs sm:text-sm text-slate-700">
                        <div class="flex items-center gap-3">
                            <span class="w-5 h-5 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold text-xs flex-shrink-0">✓</span>
                            <span><strong>Cek URL Domain:</strong> Jangan percaya hanya pada tampilan visual. Selalu periksa domain di address bar browser.</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="w-5 h-5 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold text-xs flex-shrink-0">✓</span>
                            <span><strong>Periksa Jendela OAuth:</strong> Jika diminta Sign in with Google, pastikan URL jendela popup beralamat resmi di <code>https://accounts.google.com</code>.</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="w-5 h-5 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold text-xs flex-shrink-0">✓</span>
                            <span><strong>Prinsip Minimalisasi Data:</strong> Jangan pernah mengunggah data sensitif (NIK, password, draf riset paten) ke situs gratis tanpa reputasi jelas.</span>
                        </div>
                    </div>
                </div>

                <!-- Call to Action / Completion Buttons -->
                <div class="border-t border-slate-200 pt-8 flex items-center justify-center">
                    <a 
                        href="{{ route('simulation.index') }}" 
                        class="inline-flex items-center justify-center px-8 py-3 rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-sm shadow-xs transition-all hover:-translate-y-0.5"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Home
                    </a>
                </div>

            </div>

        </div>

    </div>
</div>
@endsection
