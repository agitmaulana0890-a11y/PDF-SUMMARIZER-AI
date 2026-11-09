@extends('layouts.app')

@section('title', 'EduSummarize AI - Ubah Jurnal & Materi Kuliah PDF Jadi Ringkasan & PPT Instan')

@section('content')
<div class="relative overflow-hidden bg-gradient-to-b from-indigo-50/50 via-white to-slate-50 min-h-screen pb-16" x-data="simulationApp()">
    
    <!-- Decorative background glow -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-96 bg-gradient-to-tr from-indigo-200/40 via-purple-100/30 to-pink-100/40 blur-3xl pointer-events-none -z-10"></div>

    <!-- Header Navigation -->
    <header class="border-b border-slate-200/80 bg-white/80 backdrop-blur-md sticky top-0 z-30">
        <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center text-white shadow-md shadow-indigo-500/20 font-bold text-lg">
                    AI
                </div>
                <div>
                    <span class="font-extrabold text-xl tracking-tight text-slate-900">EduSummarize<span class="text-indigo-600">.ai</span></span>
                    <span class="hidden sm:inline-block ml-2 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wider rounded-full bg-indigo-100 text-indigo-700">Akademik Pro</span>
                </div>
            </div>
            
            <div class="flex items-center space-x-3 text-sm">
                <span class="hidden md:flex items-center text-xs text-slate-500 font-medium">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse mr-2"></span>
                    AI Model v4.5 Aktif
                </span>
                <a href="#dropzone" class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-medium shadow-sm transition-all text-xs sm:text-sm">
                    Mulai Ringkas Gratis
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 pt-10 sm:pt-16">
        
        <!-- Hero Section -->
        <div class="text-center space-y-4 max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-200/60 text-indigo-700 text-xs font-semibold shadow-xs">
                <svg class="w-4 h-4 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                </svg>
                <span>Generasi Presentasi & Ekstraksi Jurnal Otomatis</span>
            </div>

            <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                Ubah Jurnal & Materi Kuliah PDF Jadi <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-600">Ringkasan & PPT Instan</span>
            </h1>

            <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-2xl mx-auto">
                Hemat waktu belajar Anda hingga 90%. Cukup unggah dokumen riset atau bab materi, sistem AI kami akan mengekstrak metodologi, kesimpulan, dan langsung menghasilkan slide PowerPoint (.pptx) siap presentasi.
            </p>
        </div>

        <!-- Stage 1: Dropzone Box -->
        <div id="dropzone" class="mt-10 max-w-2xl mx-auto">
            <div 
                class="relative border-2 border-dashed rounded-3xl p-8 sm:p-12 text-center transition-all duration-300 bg-white/80 backdrop-blur-sm shadow-xl shadow-indigo-100/50"
                :class="isDragging ? 'border-indigo-500 bg-indigo-50/50 scale-[1.01]' : 'border-slate-300 hover:border-indigo-400'"
                @dragover.prevent="isDragging = true"
                @dragleave.prevent="isDragging = false"
                @drop.prevent="handleDrop($event)"
                x-show="stage === 'idle'"
            >
                <input 
                    type="file" 
                    id="fileInput" 
                    class="hidden" 
                    accept=".pdf,.docx,.doc,.pptx,.ppt,.txt" 
                    @change="handleFileSelect($event)"
                >

                <div class="mx-auto w-16 h-16 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 mb-4 shadow-inner">
                    <svg class="w-8 h-8 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                </div>

                <h3 class="text-lg font-bold text-slate-800">Tarik & Lepas File PDF Jurnal Anda ke Sini</h3>
                <p class="text-sm text-slate-500 mt-1 mb-5">Mendukung format PDF, DOCX, dan PPTX (Maks. 25 MB)</p>

                <label 
                    for="fileInput" 
                    class="cursor-pointer inline-flex items-center justify-center px-6 py-3 rounded-xl font-semibold text-sm text-white bg-indigo-600 hover:bg-indigo-700 shadow-md shadow-indigo-500/25 transition-all transform hover:-translate-y-0.5 active:translate-y-0"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Pilih File dari Komputer
                </label>

                <div class="mt-8 pt-6 border-t border-slate-100 flex flex-wrap items-center justify-center gap-6 text-xs text-slate-400 font-medium">
                    <span class="flex items-center"><svg class="w-4 h-4 text-emerald-500 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg> Enkripsi SSL 256-Bit</span>
                    <span class="flex items-center"><svg class="w-4 h-4 text-emerald-500 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg> Auto-Generate 8 Slide PPT</span>
                    <span class="flex items-center"><svg class="w-4 h-4 text-emerald-500 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg> 100% Gratis Akademisi</span>
                </div>
            </div>

            <!-- Stage 2: Client-side Fake Processing Progress Bar -->
            <div 
                class="bg-white rounded-3xl p-8 sm:p-10 border border-indigo-100 shadow-xl shadow-indigo-100/60"
                x-show="stage === 'processing'"
                x-cloak
            >
                <!-- File Info Card -->
                <div class="flex items-center p-4 rounded-2xl bg-indigo-50/70 border border-indigo-100 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-rose-500 text-white flex items-center justify-center font-bold text-xs uppercase shadow-sm mr-4">
                        <span x-text="selectedFile.extension.replace('.', '') || 'PDF'"></span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-bold text-slate-800 truncate" x-text="selectedFile.name"></h4>
                        <p class="text-xs text-slate-500 mt-0.5" x-text="selectedFile.formattedSize + ' • Membaca struktur dokumen...'"></p>
                    </div>
                    <div class="text-right">
                        <span class="text-lg font-extrabold text-indigo-600 font-mono" x-text="progress + '%'"></span>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="relative w-full bg-slate-100 rounded-full h-3.5 overflow-hidden mb-4 p-0.5">
                    <div 
                        class="bg-gradient-to-r from-indigo-500 via-purple-500 to-indigo-600 h-full rounded-full transition-all duration-300 relative shadow-sm"
                        :style="`width: ${progress}%`"
                    >
                        <div class="absolute inset-0 bg-white/20 animate-pulse"></div>
                    </div>
                </div>

                <!-- Progressive Status Messages -->
                <div class="flex items-center justify-between text-xs text-slate-600 font-medium">
                    <div class="flex items-center space-x-2">
                        <svg class="animate-spin h-4 w-4 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="font-semibold text-indigo-900" x-text="progressMessage"></span>
                    </div>
                    <span class="text-slate-400">Estimasi: ~2 detik lagi</span>
                </div>
            </div>

            <!-- Stage 3 & 4: Blurred Summary Results + Call-to-Action Modal -->
            <div 
                class="relative mt-2"
                x-show="stage === 'completed'"
                x-cloak
            >
                <!-- Realistic Blurred Preview Background (Pretext) -->
                <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 filter blur-[5px] select-none pointer-events-none opacity-60">
                    <div class="flex items-center justify-between border-b pb-4 mb-4">
                        <div>
                            <span class="text-xs font-semibold px-2.5 py-0.5 bg-emerald-100 text-emerald-800 rounded">Ringkasan Selesai Di-generate</span>
                            <h2 class="text-lg font-bold text-slate-800 mt-2">Draf Ringkasan Eksekutif & Struktur Slide PPT</h2>
                        </div>
                        <span class="text-xs text-slate-400">Total: 8 Slide • 1,240 Kata</span>
                    </div>

                    <div class="space-y-4 text-xs text-slate-600">
                        <div class="p-3 bg-slate-50 rounded-xl">
                            <h4 class="font-bold text-slate-800 mb-1">Slide 1: Latar Belakang & Rumusan Masalah</h4>
                            <p>Penelitian ini meninjau efisiensi algoritma transformer modern dalam pemrosesan teks akademik berbahasa Indonesia...</p>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-xl">
                            <h4 class="font-bold text-slate-800 mb-1">Slide 2: Metodologi & Sampel Data Riset</h4>
                            <p>Menggunakan metodologi komparatif kuantitatif dengan baseline parameter 120 epoch dan cross-validation...</p>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-xl">
                            <h4 class="font-bold text-slate-800 mb-1">Slide 3: Temuan Kunci & Rekomendasi</h4>
                            <p>Ditemukan peningkatan throughput sebesar 34.8% pada waktu pemrosesan dokumen besar tanpa kehilangan konteks...</p>
                        </div>
                    </div>
                </div>

                <!-- Floating CTA Modal Card -->
                <div class="absolute inset-0 flex items-center justify-center p-4">
                    <div class="bg-white/95 backdrop-blur-xl border border-indigo-200/80 rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl shadow-indigo-500/20 text-center transform transition-all duration-300">
                        
                        <!-- Success Badge Icon -->
                        <div class="w-14 h-14 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-600 flex items-center justify-center mx-auto mb-4 shadow-sm">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>

                        <span class="inline-block px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-bold uppercase tracking-wider mb-2">
                            Pemrosesan Selesai 100%
                        </span>

                        <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                            Ringkasan & Slide PPT Anda Siap!
                        </h3>

                        <p class="text-xs sm:text-sm text-slate-600 mt-2 mb-6 leading-relaxed">
                            Dokumen <span class="font-semibold text-slate-800" x-text="selectedFile.name"></span> berhasil diolah menjadi ringkasan eksekutif dan paket 8 slide presentasi PowerPoint.
                            <br><span class="text-indigo-600 font-medium">Masuk dengan akun Google untuk mengunduh hasil ringkasan (.pdf & .pptx).</span>
                        </p>

                        <!-- Google OAuth Simulation CTA Button -->
                        <div class="space-y-3">
                            <button 
                                type="button" 
                                @click="handleGoogleLoginClick()"
                                :disabled="isSubmitting"
                                class="w-full flex items-center justify-center gap-3 px-6 py-3.5 border border-slate-300 rounded-xl bg-white hover:bg-slate-50 text-slate-700 font-semibold text-sm shadow-md hover:shadow-lg transition-all duration-200 group active:scale-[0.98]"
                            >
                                <svg class="w-5 h-5" viewBox="0 0 24 24">
                                    <path fill="#EA4335" d="M12 5c1.6 0 3 .6 4.1 1.6l3.1-3.1C17.3 1.7 14.8 1 12 1 7.5 1 3.7 3.6 1.9 7.3l3.7 2.9C6.5 7.4 9 5 12 5z"/>
                                    <path fill="#4285F4" d="M23.5 12.3c0-.8-.1-1.7-.2-2.3H12v4.5h6.5c-.3 1.5-1.1 2.8-2.4 3.7l3.7 2.9c2.2-2 3.7-5 3.7-8.8z"/>
                                    <path fill="#FBBC05" d="M5.6 14.8c-.2-.7-.4-1.5-.4-2.8s.2-2.1.4-2.8L1.9 6.3C.7 8.7 0 10.3 0 12s.7 3.3 1.9 5.7l3.7-2.9z"/>
                                    <path fill="#34A853" d="M12 23c3.2 0 6-1.1 8-3l-3.7-2.9c-1.1.7-2.5 1.2-4.3 1.2-3 0-5.5-2-6.4-4.8L1.9 16.4C3.7 20.4 7.5 23 12 23z"/>
                                </svg>
                                <span x-show="!isSubmitting">Masuk dengan Google untuk Unduh (.pptx & .pdf)</span>
                                <span x-show="isSubmitting" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-slate-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Menghubungkan ke otentikasi...
                                </span>
                            </button>

                            <p class="text-[11px] text-slate-400">
                                🔒 Kami tidak pernah membagikan data dokumen Anda kepada pihak ketiga.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pretext Features / Social Proof (Enhances Realism) -->
        <div class="mt-20 border-t border-slate-200 pt-12">
            <div class="text-center mb-8">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Telah Digunakan Oleh Ribuan Mahasiswa & Peneliti</h4>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h5 class="text-sm font-bold text-slate-800">Ekstraksi Jurnal Cerdas</h5>
                    <p class="text-xs text-slate-500 mt-1">Mengidentifikasi abstrak, rumusan masalah, metodologi, dan kesimpulan secara otomatis.</p>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                    </div>
                    <h5 class="text-sm font-bold text-slate-800">Ekspor PowerPoint (.pptx)</h5>
                    <p class="text-xs text-slate-500 mt-1">Menghasilkan tata letak slide presentasi yang siap diedit dengan tipografi modern.</p>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
                    <div class="w-10 h-10 rounded-xl bg-pink-50 text-pink-600 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h5 class="text-sm font-bold text-slate-800">Proses Kilat 5 Detik</h5>
                    <p class="text-xs text-slate-500 mt-1">Didukung kluster server inferensi AI berkecepatan tinggi tanpa antrean.</p>
                </div>
            </div>
        </div>

    </main>
</div>
@endsection

@section('scripts')
<script>
function simulationApp() {
    return {
        stage: 'idle', // 'idle' -> 'processing' -> 'completed'
        isDragging: false,
        isSubmitting: false,
        progress: 0,
        progressMessage: 'Membaca struktur dokumen...',
        selectedFile: {
            name: '',
            extension: '',
            sizeKb: 0,
            formattedSize: ''
        },
        sessionToken: '',

        init() {
            // Retrieve or generate persistent UUID session token
            let storedToken = localStorage.getItem('sim_session_uuid');
            if (!storedToken) {
                storedToken = (typeof crypto.randomUUID === 'function') 
                    ? crypto.randomUUID() 
                    : 'sim_' + Math.random().toString(36).substring(2, 15) + Date.now().toString(36);
                localStorage.setItem('sim_session_uuid', storedToken);
            }
            this.sessionToken = storedToken;

            // Auto-record initial visit telemetry
            this.sendTelemetry('/api/telemetry/visit', {
                session_token: this.sessionToken
            });
        },

        handleDrop(event) {
            this.isDragging = false;
            const files = event.dataTransfer.files;
            if (files && files.length > 0) {
                this.processFileMetadata(files[0]);
            }
        },

        handleFileSelect(event) {
            const files = event.target.files;
            if (files && files.length > 0) {
                this.processFileMetadata(files[0]);
            }
        },

        /**
         * Privacy-by-Design File Metadata Processing.
         * JANGAN kirim file asli ke server.
         * Hanya ambil ekstensi dan ukuran via Browser File API.
         */
        processFileMetadata(file) {
            const fileName = file.name || 'Dokumen.pdf';
            const sizeInKb = Math.round(file.size / 1024) || 1;
            const extensionMatch = fileName.lastIndexOf('.') !== -1 
                ? fileName.substring(fileName.lastIndexOf('.')).toLowerCase() 
                : '.pdf';

            // Format human-readable size
            let formatted = sizeInKb > 1024 
                ? (sizeInKb / 1024).toFixed(1) + ' MB' 
                : sizeInKb + ' KB';

            this.selectedFile = {
                name: fileName,
                extension: extensionMatch,
                sizeKb: sizeInKb,
                formattedSize: formatted
            };

            // Switch to processing stage
            this.stage = 'processing';
            this.progress = 0;

            // Send telemetry event: File Selected
            this.sendTelemetry('/api/telemetry/file-selected', {
                session_token: this.sessionToken,
                file_extension: this.selectedFile.extension,
                file_size_kb: this.selectedFile.sizeKb
            });

            // Start simulated progressive loading (approx 4 seconds)
            this.startSimulatedLoading();
        },

        startSimulatedLoading() {
            const stages = [
                { percent: 25, message: 'Membaca struktur dokumen & ekstraksi teks...' },
                { percent: 55, message: 'Mengidentifikasi metodologi & poin-poin kunci jurnal...' },
                { percent: 85, message: 'Menyusun draf slide presentasi (.pptx) & ringkasan...' },
                { percent: 100, message: 'Menyempurnakan format & visual slide... Selesai!' }
            ];

            let step = 0;
            const interval = setInterval(() => {
                if (step < stages.length) {
                    this.progress = stages[step].percent;
                    this.progressMessage = stages[step].message;
                    step++;
                } else {
                    clearInterval(interval);
                    setTimeout(() => {
                        this.stage = 'completed';
                    }, 500);
                }
            }, 900);
        },

        /**
         * Call-to-Action Trigger: User clicks Google Login Button.
         * Privacy-by-Design: No password form or credentials stored.
         * Immediately records telemetry and redirects to /debriefing.
         */
        handleGoogleLoginClick() {
            if (this.isSubmitting) return;
            this.isSubmitting = true;

            // Send CTA Telemetry
            this.sendTelemetry('/api/telemetry/cta-clicked', {
                session_token: this.sessionToken
            }).then(response => {
                const redirectUrl = (response && response.redirect_url) 
                    ? response.redirect_url 
                    : '/debriefing?token=' + encodeURIComponent(this.sessionToken);

                // Direct redirect to education debriefing page
                window.location.href = redirectUrl;
            }).catch(() => {
                // Fallback redirect if network error
                window.location.href = '/debriefing?token=' + encodeURIComponent(this.sessionToken);
            });
        },

        async sendTelemetry(endpoint, payload) {
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const response = await fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken || ''
                    },
                    body: JSON.stringify(payload)
                });
                return await response.json();
            } catch (err) {
                console.warn('Telemetry event logged locally:', endpoint);
                return null;
            }
        }
    }
}
</script>
@endsection
