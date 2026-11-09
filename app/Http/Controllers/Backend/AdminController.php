<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SimulationLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    /**
     * Show admin login view.
     */
    public function showLogin(): View|RedirectResponse
    {
        if (session('admin_authenticated')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    /**
     * Authenticate admin via PIN / Passphrase.
     */
    public function login(Request $request): RedirectResponse
    {
        $adminPin = config('app.admin_pin', env('ADMIN_PIN', 'admin123'));

        $request->validate([
            'pin' => 'required|string',
        ]);

        if ($request->input('pin') === (string)$adminPin) {
            session(['admin_authenticated' => true]);
            return redirect()->route('admin.dashboard')->with('success', 'Berhasil masuk ke Dashboard Admin!');
        }

        return back()->withErrors(['pin' => 'Password tidak valid.']);
    }

    /**
     * Logout admin.
     */
    public function logout(): RedirectResponse
    {
        session()->forget('admin_authenticated');
        return redirect()->route('admin.login')->with('info', 'Anda telah keluar dari Dashboard Admin.');
    }

    /**
     * Telemetry Admin Dashboard.
     */
    public function dashboard(Request $request): View|RedirectResponse
    {
        // Auth check (simple session-based PIN security)
        if (!session('admin_authenticated')) {
            return redirect()->route('admin.login');
        }

        try {
            // Metrics Summary
            $totalVisits = SimulationLog::count();
            $totalFilesSelected = SimulationLog::where('file_selected', true)->count();
            $totalCtaClicked = SimulationLog::where('cta_login_clicked', true)->count();
            $totalDebriefViewed = SimulationLog::where('debrief_viewed', true)->count();

            $vulnerabilityRate = $totalVisits > 0 
                ? round(($totalCtaClicked / $totalVisits) * 100, 1) 
                : 0;

            $uploadRate = $totalVisits > 0 
                ? round(($totalFilesSelected / $totalVisits) * 100, 1) 
                : 0;

            $sunkCostRate = $totalFilesSelected > 0 
                ? round(($totalCtaClicked / $totalFilesSelected) * 100, 1) 
                : 0;

            // Funnel Chart Data
            $funnelData = [
                'labels' => ['Kunjungan Landing', 'Pilih Dokumen', 'Klik Login (Terjebak)', 'Baca Debriefing'],
                'counts' => [$totalVisits, $totalFilesSelected, $totalCtaClicked, $totalDebriefViewed],
            ];

            // File Extensions Distribution (Pie/Donut Chart)
            $extensionStats = SimulationLog::whereNotNull('file_extension')
                ->where('file_extension', '!=', '')
                ->select('file_extension', DB::raw('count(*) as total'))
                ->groupBy('file_extension')
                ->orderByDesc('total')
                ->get();

            $extensionLabels = $extensionStats->pluck('file_extension')->toArray();
            $extensionCounts = $extensionStats->pluck('total')->toArray();

            if (empty($extensionLabels)) {
                $extensionLabels = ['Belum Ada File'];
                $extensionCounts = [0];
            }

            // Recent activity query
            $query = SimulationLog::latest();

            // Optional filter
            if ($filter = $request->query('stage')) {
                if ($filter === 'cta') {
                    $query->where('cta_login_clicked', true);
                } elseif ($filter === 'file') {
                    $query->where('file_selected', true);
                } elseif ($filter === 'debrief') {
                    $query->where('debrief_viewed', true);
                }
            }

            $logs = $query->paginate(15)->withQueryString();
        } catch (\Throwable $e) {
            Log::error("Dashboard database query error: " . $e->getMessage());

            $totalVisits = 0;
            $totalFilesSelected = 0;
            $totalCtaClicked = 0;
            $totalDebriefViewed = 0;
            $vulnerabilityRate = 0;
            $uploadRate = 0;
            $sunkCostRate = 0;
            $funnelData = [
                'labels' => ['Kunjungan Landing', 'Pilih Dokumen', 'Klik Login (Terjebak)', 'Baca Debriefing'],
                'counts' => [0, 0, 0, 0],
            ];
            $extensionLabels = ['Belum Ada File'];
            $extensionCounts = [0];
            $logs = new LengthAwarePaginator([], 0, 15);

            session()->flash('db_error', 'Koneksi database bermasalah: ' . $e->getMessage());
        }

        return view('admin.dashboard', compact(
            'totalVisits',
            'totalFilesSelected',
            'totalCtaClicked',
            'totalDebriefViewed',
            'vulnerabilityRate',
            'uploadRate',
            'sunkCostRate',
            'funnelData',
            'extensionLabels',
            'extensionCounts',
            'logs'
        ));
    }

    /**
     * Export all simulation logs to CSV.
     */
    public function exportCsv(): StreamedResponse|RedirectResponse
    {
        if (!session('admin_authenticated')) {
            return redirect()->route('admin.login');
        }

        $fileName = 'simulation_telemetry_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM for Microsoft Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // CSV Header
            fputcsv($handle, [
                'ID',
                'Session Token',
                'Masked IP Address',
                'Platform / OS',
                'Browser',
                'File Selected',
                'File Extension',
                'File Size (KB)',
                'CTA Login Clicked',
                'Debrief Viewed',
                'Latest Stage',
                'Timestamp (UTC)',
            ]);

            try {
                SimulationLog::chunk(100, function ($records) use ($handle) {
                    foreach ($records as $log) {
                        $stage = $log->latest_stage['name'] ?? 'Unknown';
                        fputcsv($handle, [
                            $log->id,
                            $log->session_token,
                            $log->ip_address,
                            $log->platform,
                            $log->browser,
                            $log->file_selected ? 'YES' : 'NO',
                            $log->file_extension ?? '-',
                            $log->file_size_kb ?? 0,
                            $log->cta_login_clicked ? 'YES' : 'NO',
                            $log->debrief_viewed ? 'YES' : 'NO',
                            $stage,
                            $log->created_at?->toIso8601String(),
                        ]);
                    }
                });
            } catch (\Throwable $e) {
                fputcsv($handle, ['Error reading database logs: ' . $e->getMessage()]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Reset / Clear all simulation logs.
     */
    public function resetData(): RedirectResponse
    {
        if (!session('admin_authenticated')) {
            return redirect()->route('admin.login');
        }

        try {
            SimulationLog::truncate();
            return redirect()->route('admin.dashboard')->with('success', 'Semua log telemetri simulasi berhasil direset (dikosongkan)!');
        } catch (\Throwable $e) {
            return redirect()->route('admin.dashboard')->with('db_error', 'Gagal mereset database: ' . $e->getMessage());
        }
    }
}
