<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SimulationLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class SimulationController extends Controller
{
    /**
     * Show the interactive simulation landing page.
     */
    public function index(): View
    {
        return view('simulation.index');
    }

    /**
     * Record the initial visit telemetry.
     */
    public function recordVisit(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'session_token' => 'required|string|max:64',
        ]);

        try {
            $anonymizedIp = SimulationLog::anonymizeIp($request->ip());
            $userAgent = $request->userAgent() ?? 'Unknown';

            $log = SimulationLog::firstOrCreate(
                ['session_token' => $validated['session_token']],
                [
                    'ip_address' => $anonymizedIp,
                    'user_agent' => $userAgent,
                    'file_selected' => false,
                    'cta_login_clicked' => false,
                    'debrief_viewed' => false,
                ]
            );

            return response()->json([
                'status' => 'success',
                'session_token' => $log->session_token,
            ]);
        } catch (\Throwable $e) {
            Log::warning("Telemetry visit error: " . $e->getMessage());
            return response()->json([
                'status' => 'fallback',
                'session_token' => $validated['session_token'],
            ]);
        }
    }

    /**
     * Record client-side file selection metadata (Privacy-by-Design: No file is uploaded).
     */
    public function recordFileSelected(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'session_token' => 'required|string|max:64',
            'file_extension' => 'nullable|string|max:20',
            'file_size_kb' => 'nullable|integer|min:0|max:1048576',
        ]);

        try {
            $log = SimulationLog::firstOrNew(['session_token' => $validated['session_token']]);

            if (!$log->exists) {
                $log->ip_address = SimulationLog::anonymizeIp($request->ip());
                $log->user_agent = $request->userAgent() ?? 'Unknown';
            }

            $log->file_selected = true;
            if (!empty($validated['file_extension'])) {
                $ext = strtolower(trim($validated['file_extension']));
                $log->file_extension = str_starts_with($ext, '.') ? $ext : '.' . $ext;
            }
            $log->file_size_kb = $validated['file_size_kb'] ?? 0;
            $log->save();

            return response()->json([
                'status' => 'success',
                'message' => 'File metadata recorded safely (Privacy-by-Design)',
            ]);
        } catch (\Throwable $e) {
            Log::warning("Telemetry file selected error: " . $e->getMessage());
            return response()->json([
                'status' => 'fallback',
                'message' => 'Handled safely via fallback',
            ]);
        }
    }

    /**
     * Record CTA login button click (vulnerability trigger).
     */
    public function recordCtaClicked(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'session_token' => 'required|string|max:64',
        ]);

        $redirectUrl = route('simulation.debrief', ['token' => $validated['session_token']]);

        try {
            $log = SimulationLog::firstOrNew(['session_token' => $validated['session_token']]);

            if (!$log->exists) {
                $log->ip_address = SimulationLog::anonymizeIp($request->ip());
                $log->user_agent = $request->userAgent() ?? 'Unknown';
            }

            $log->cta_login_clicked = true;
            $log->save();
        } catch (\Throwable $e) {
            Log::warning("Telemetry CTA error: " . $e->getMessage());
        }

        return response()->json([
            'status' => 'success',
            'redirect_url' => $redirectUrl,
        ]);
    }

    /**
     * Display the educational debriefing page.
     */
    public function debrief(Request $request): View
    {
        $token = $request->query('token');
        $log = null;

        if ($token) {
            try {
                $log = SimulationLog::where('session_token', $token)->first();
                if ($log) {
                    $log->update(['debrief_viewed' => true]);
                }
            } catch (\Throwable $e) {
                Log::warning("Telemetry debrief error: " . $e->getMessage());
            }
        }

        return view('simulation.debrief', [
            'log' => $log,
            'token' => $token,
        ]);
    }
}
