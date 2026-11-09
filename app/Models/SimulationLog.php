<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimulationLog extends Model
{
    use HasFactory;

    protected $table = 'simulation_logs';

    protected $fillable = [
        'session_token',
        'ip_address',
        'user_agent',
        'file_selected',
        'file_extension',
        'file_size_kb',
        'cta_login_clicked',
        'debrief_viewed',
    ];

    protected $casts = [
        'file_selected' => 'boolean',
        'cta_login_clicked' => 'boolean',
        'debrief_viewed' => 'boolean',
        'file_size_kb' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Anonymize IP address for privacy-by-design compliance.
     * Example: 192.168.1.45 => 192.168.1.xxx
     */
    public static function anonymizeIp(?string $ip): string
    {
        if (empty($ip)) {
            return 'Unknown';
        }

        // IPv4
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $parts = explode('.', $ip);
            if (count($parts) === 4) {
                $parts[3] = 'xxx';
                return implode('.', $parts);
            }
        }

        // IPv6
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $parts = explode(':', $ip);
            if (count($parts) > 2) {
                return $parts[0] . ':' . $parts[1] . ':xxxx:xxxx';
            }
        }

        return 'xxx.xxx.xxx.xxx';
    }

    /**
     * Determine the latest stage achieved by the user.
     */
    public function getLatestStageAttribute(): array
    {
        if ($this->debrief_viewed) {
            return [
                'name' => 'Debrief Dibaca',
                'color' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                'step' => 4,
            ];
        }

        if ($this->cta_login_clicked) {
            return [
                'name' => 'Klik Login (Terjebak)',
                'color' => 'bg-rose-100 text-rose-800 border-rose-300',
                'step' => 3,
            ];
        }

        if ($this->file_selected) {
            return [
                'name' => 'Pilih File',
                'color' => 'bg-amber-100 text-amber-800 border-amber-300',
                'step' => 2,
            ];
        }

        return [
            'name' => 'Kunjungan Landing',
            'color' => 'bg-slate-100 text-slate-800 border-slate-300',
            'step' => 1,
        ];
    }

    /**
     * Extract browser name from user agent.
     */
    public function getBrowserAttribute(): string
    {
        $ua = $this->user_agent ?? '';
        if (stripos($ua, 'Edg') !== false) return 'Edge';
        if (stripos($ua, 'Chrome') !== false) return 'Chrome';
        if (stripos($ua, 'Safari') !== false) return 'Safari';
        if (stripos($ua, 'Firefox') !== false) return 'Firefox';
        if (stripos($ua, 'Opera') !== false || stripos($ua, 'OPR') !== false) return 'Opera';
        return 'Browser';
    }

    /**
     * Extract OS name from user agent.
     */
    public function getPlatformAttribute(): string
    {
        $ua = $this->user_agent ?? '';
        if (stripos($ua, 'Windows') !== false) return 'Windows';
        if (stripos($ua, 'Macintosh') !== false || stripos($ua, 'Mac OS') !== false) return 'macOS';
        if (stripos($ua, 'Android') !== false) return 'Android';
        if (stripos($ua, 'iPhone') !== false || stripos($ua, 'iPad') !== false) return 'iOS';
        if (stripos($ua, 'Linux') !== false) return 'Linux';
        return 'OS';
    }
}
