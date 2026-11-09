@extends('layouts.app')

@section('title', 'Admin Telemetri Dashboard - Security Awareness Simulation')

@section('styles')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
@endsection

@section('content')
<div class="bg-slate-50 min-h-screen pb-16" x-data="{ resetModalOpen: false }">
    
    <!-- Top Admin Bar -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-bold text-sm shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-base font-extrabold text-slate-900 tracking-tight leading-none">Security Awareness Telemetry</h1>
                    <span class="text-[11px] text-slate-500">EduSummarize AI Simulation Pretext</span>
                </div>
            </div>

            <div class="flex items-center space-x-3">
                <a 
                    href="{{ route('simulation.index') }}" 
                    target="_blank"
                    class="hidden sm:inline-flex items-center px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-semibold text-slate-600 hover:text-indigo-600 hover:border-indigo-300 transition-colors"
                >
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Buka Halaman Simulasi
                </a>

                <a 
                    href="{{ route('admin.export') }}" 
                    class="inline-flex items-center px-3.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-xs transition-colors"
                >
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Export CSV
                </a>

                <button 
                    type="button" 
                    @click="resetModalOpen = true"
                    class="inline-flex items-center px-3.5 py-1.5 rounded-lg bg-rose-50 border border-rose-200 hover:bg-rose-100 text-rose-700 text-xs font-semibold transition-colors"
                >
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Reset Data
                </button>

                <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="p-1.5 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-100 transition-colors" title="Keluar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Content Container -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">

        <!-- Flash Notifications -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center justify-between">
                <span class="flex items-center">
                    <svg class="w-5 h-5 text-emerald-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ session('success') }}
                </span>
            </div>
        @endif

        @if(session('db_error'))
            <div class="mb-6 p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-sm flex items-center justify-between">
                <span class="flex items-center">
                    <svg class="w-5 h-5 text-amber-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span><strong>Peringatan Database:</strong> {{ session('db_error') }}</span>
                </span>
            </div>
        @endif

        <!-- Summary KPI Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            
            <!-- Card 1: Total Visits -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">1. Total Pengunjung</span>
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-3xl font-extrabold text-slate-900">{{ number_format($totalVisits) }}</span>
                    <span class="text-xs text-slate-400 block mt-1">Pengunjung awal mendarat di pretext</span>
                </div>
            </div>

            <!-- Card 2: Files Selected -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">2. Memilih Dokumen</span>
                    <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-3xl font-extrabold text-slate-900">{{ number_format($totalFilesSelected) }}</span>
                    <span class="text-xs text-amber-600 font-semibold block mt-1">{{ $uploadRate }}% dari total pengunjung</span>
                </div>
            </div>

            <!-- Card 3: CTA Clicked -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">3. Terjebak Klik Login</span>
                    <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-3xl font-extrabold text-rose-600">{{ number_format($totalCtaClicked) }}</span>
                    <span class="text-xs text-rose-600 font-semibold block mt-1">{{ $sunkCostRate }}% dari pengguna yang memilih file</span>
                </div>
            </div>

            <!-- Card 4: Vulnerability Conversion Rate -->
            <div class="bg-gradient-to-br from-indigo-900 to-slate-900 text-white rounded-2xl p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-indigo-200">Tingkat Kerentanan</span>
                    <div class="w-10 h-10 rounded-xl bg-white/10 text-rose-400 flex items-center justify-center font-bold">
                        ⚠️
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-3xl font-black text-white">{{ $vulnerabilityRate }}%</span>
                    <span class="text-xs text-slate-300 block mt-1">Persentase pengunjung yang terjebak CTA</span>
                </div>
            </div>

        </div>

        <!-- Charts Grid (Chart.js) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            
            <!-- Funnel Stage Bar Chart -->
            <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Alur Konversi Simulasi (Simulation Funnel)</h3>
                        <p class="text-xs text-slate-500">Melihat penurunan peserta di setiap tahapan rekayasa sosial</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-[11px] font-semibold">Real-Time</span>
                </div>
                <div class="h-64 sm:h-72">
                    <canvas id="funnelChart"></canvas>
                </div>
            </div>

            <!-- File Extension Pie / Donut Chart -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs flex flex-col">
                <div class="mb-4">
                    <h3 class="text-sm font-bold text-slate-900">Proporsi Ekstensi Dokumen</h3>
                    <p class="text-xs text-slate-500">Jenis file yang paling sering dipilih peserta</p>
                </div>
                <div class="h-56 relative flex-1 flex items-center justify-center">
                    <canvas id="extensionChart"></canvas>
                </div>
                <div class="mt-2 text-center text-[11px] text-slate-400">
                    *Dicatat client-side via File API tanpa menyimpan isi dokumen
                </div>
            </div>

        </div>

        <!-- Activity Log Table -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            
            <!-- Table Header & Filters -->
            <div class="p-5 sm:px-6 border-b border-slate-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Log Aktivitas Sesi Pengunjung</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar rekaman telemetri tahapan interaksi per sesi pengguna</p>
                </div>

                <!-- Filter Tabs -->
                <div class="flex items-center gap-1.5 bg-slate-100 p-1 rounded-xl text-xs font-medium">
                    <a href="{{ route('admin.dashboard') }}" class="px-3 py-1.5 rounded-lg {{ !request('stage') ? 'bg-white shadow-xs font-bold text-indigo-600' : 'text-slate-600 hover:text-slate-900' }}">Semua ({{ $totalVisits }})</a>
                    <a href="{{ route('admin.dashboard', ['stage' => 'cta']) }}" class="px-3 py-1.5 rounded-lg {{ request('stage') === 'cta' ? 'bg-white shadow-xs font-bold text-rose-600' : 'text-slate-600 hover:text-slate-900' }}">Terjebak ({{ $totalCtaClicked }})</a>
                    <a href="{{ route('admin.dashboard', ['stage' => 'file']) }}" class="px-3 py-1.5 rounded-lg {{ request('stage') === 'file' ? 'bg-white shadow-xs font-bold text-amber-600' : 'text-slate-600 hover:text-slate-900' }}">Pilih File ({{ $totalFilesSelected }})</a>
                    <a href="{{ route('admin.dashboard', ['stage' => 'debrief']) }}" class="px-3 py-1.5 rounded-lg {{ request('stage') === 'debrief' ? 'bg-white shadow-xs font-bold text-emerald-600' : 'text-slate-600 hover:text-slate-900' }}">Debrief ({{ $totalDebriefViewed }})</a>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider text-[10px]">
                        <tr>
                            <th class="py-3 px-4">Sesi Token</th>
                            <th class="py-3 px-4">Waktu</th>
                            <th class="py-3 px-4">IP (Masked)</th>
                            <th class="py-3 px-4">Browser & OS</th>
                            <th class="py-3 px-4">File Terpilih</th>
                            <th class="py-3 px-4">Metode Interaksi (Auth)</th>
                            <th class="py-3 px-4">Tahap Terakhir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($logs as $log)
                            @php
                                $stage = $log->latest_stage;
                                $authBadge = $log->auth_method_badge;
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3 px-4 font-mono text-slate-900 font-medium">
                                    <span title="{{ $log->session_token }}">{{ Str::limit($log->session_token, 12, '...') }}</span>
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap text-slate-500">
                                    {{ $log->created_at?->diffForHumans() ?? '-' }}
                                    <span class="block text-[10px] text-slate-400">{{ $log->created_at?->format('d/m/Y H:i') }}</span>
                                </td>
                                <td class="py-3 px-4 font-mono text-slate-600">
                                    {{ $log->ip_address ?? 'xxx.xxx.xxx.xxx' }}
                                </td>
                                <td class="py-3 px-4">
                                    <span class="font-semibold text-slate-800">{{ $log->browser }}</span>
                                    <span class="text-slate-400">/ {{ $log->platform }}</span>
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap">
                                    @if($log->file_selected)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                            {{ $log->file_extension ?? '.pdf' }}
                                        </span>
                                        <span class="text-slate-400 text-[10px] ml-1">({{ $log->file_size_kb }} KB)</span>
                                    @else
                                        <span class="text-slate-300">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap">
                                    <div class="flex flex-col gap-0.5">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold border {{ $authBadge['color'] }} w-fit">
                                            <span>{{ $authBadge['icon'] }}</span>
                                            <span>{{ $authBadge['label'] }}</span>
                                        </span>
                                        @if(!empty($log->masked_target))
                                            <span class="text-[10px] text-slate-500 font-mono pl-1">
                                                Target: <span class="text-indigo-600 font-semibold">{{ $log->masked_target }}</span>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $stage['color'] }}">
                                        @if($stage['step'] === 4)
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                        @elseif($stage['step'] === 3)
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5"></span>
                                        @elseif($stage['step'] === 2)
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span>
                                        @else
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400 mr-1.5"></span>
                                        @endif
                                        {{ $stage['name'] }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-slate-400 text-sm">
                                    Belum ada data telemetri simulasi yang tercatat. Kunjungi halaman beranda untuk memulai!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($logs->hasPages())
                <div class="p-4 border-t border-slate-200">
                    {{ $logs->links() }}
                </div>
            @endif

        </div>

    </main>

    <!-- Reset Data Confirmation Modal -->
    <div 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs"
        x-show="resetModalOpen"
        x-cloak
    >
        <div 
            class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-slate-200"
            @click.away="resetModalOpen = false"
        >
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>

            <h3 class="text-lg font-bold text-slate-900">Konfirmasi Reset Data Simulasi</h3>
            <p class="text-xs text-slate-600 mt-2 mb-6 leading-relaxed">
                Tindakan ini akan mengosongkan seluruh log aktivitas dan metrik grafik telemetri secara permanen. Apakah Anda yakin ingin melanjutkan?
            </p>

            <div class="flex items-center justify-end space-x-3">
                <button 
                    type="button" 
                    @click="resetModalOpen = false" 
                    class="px-4 py-2.5 rounded-xl border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors"
                >
                    Batal
                </button>

                <form action="{{ route('admin.reset') }}" method="POST">
                    @csrf
                    <button 
                        type="submit" 
                        class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold shadow-sm transition-colors"
                    >
                        Ya, Kosongkan Data
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    
    // --- Funnel Stage Bar Chart ---
    const funnelCtx = document.getElementById('funnelChart');
    if (funnelCtx) {
        new Chart(funnelCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($funnelData['labels']) !!},
                datasets: [{
                    label: 'Jumlah Pengguna',
                    data: {!! json_encode($funnelData['counts']) !!},
                    backgroundColor: [
                        'rgba(99, 102, 241, 0.85)', // Indigo
                        'rgba(245, 158, 11, 0.85)', // Amber
                        'rgba(239, 68, 68, 0.85)',  // Rose
                        'rgba(16, 185, 129, 0.85)', // Emerald
                    ],
                    borderColor: [
                        'rgb(79, 70, 229)',
                        'rgb(217, 119, 6)',
                        'rgb(220, 38, 38)',
                        'rgb(5, 150, 105)',
                    ],
                    borderWidth: 1.5,
                    borderRadius: 10,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        padding: 12,
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleFont: { size: 12, family: 'Inter' },
                        bodyFont: { size: 12, family: 'Inter' },
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            font: { size: 11, family: 'Inter' }
                        },
                        grid: {
                            color: 'rgba(226, 232, 240, 0.6)'
                        }
                    },
                    x: {
                        ticks: {
                            font: { size: 11, family: 'Inter', weight: '500' }
                        },
                        grid: { display: false }
                    }
                }
            }
        });
    }

    // --- File Extension Donut Chart ---
    const extCtx = document.getElementById('extensionChart');
    if (extCtx) {
        new Chart(extCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($extensionLabels) !!},
                datasets: [{
                    data: {!! json_encode($extensionCounts) !!},
                    backgroundColor: [
                        '#ef4444', // Red (.pdf)
                        '#3b82f6', // Blue (.docx)
                        '#f59e0b', // Amber (.pptx)
                        '#10b981', // Emerald (.xlsx)
                        '#8b5cf6', // Violet
                        '#94a3b8'  // Gray
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '68%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 14,
                            font: { size: 11, family: 'Inter' }
                        }
                    },
                    tooltip: {
                        padding: 10,
                        backgroundColor: 'rgba(15, 23, 42, 0.9)'
                    }
                }
            }
        });
    }
});
</script>
@endsection
