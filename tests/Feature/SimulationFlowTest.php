<?php

namespace Tests\Feature;

use App\Models\SimulationLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SimulationFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_can_be_rendered(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('EduSummarize');
        $response->assertSee('Mulai Ringkas Gratis');
        $response->assertSee('Pilih File dari Komputer');
    }

    public function test_telemetry_visit_records_visitor_anonymously(): void
    {
        $response = $this->postJson('/api/telemetry/visit', [
            'session_token' => 'test-uuid-123456',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);

        $this->assertDatabaseHas('simulation_logs', [
            'session_token' => 'test-uuid-123456',
            'file_selected' => false,
            'cta_login_clicked' => false,
        ]);
    }

    public function test_file_selected_records_metadata_without_uploading_file(): void
    {
        $this->postJson('/api/telemetry/visit', [
            'session_token' => 'test-uuid-123456',
        ]);

        $response = $this->postJson('/api/telemetry/file-selected', [
            'session_token' => 'test-uuid-123456',
            'file_extension' => '.pdf',
            'file_size_kb' => 1024,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('simulation_logs', [
            'session_token' => 'test-uuid-123456',
            'file_selected' => true,
            'file_extension' => '.pdf',
            'file_size_kb' => 1024,
        ]);
    }

    public function test_cta_login_clicked_records_vulnerability_trigger(): void
    {
        $this->postJson('/api/telemetry/visit', [
            'session_token' => 'test-uuid-123456',
        ]);

        $response = $this->postJson('/api/telemetry/cta-clicked', [
            'session_token' => 'test-uuid-123456',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['status', 'redirect_url']);

        $this->assertDatabaseHas('simulation_logs', [
            'session_token' => 'test-uuid-123456',
            'cta_login_clicked' => true,
        ]);
    }

    public function test_debriefing_page_marks_debrief_viewed(): void
    {
        SimulationLog::create([
            'session_token' => 'test-uuid-123456',
            'ip_address' => '127.0.0.xxx',
            'user_agent' => 'PHPUnit',
            'file_selected' => true,
            'file_extension' => '.pdf',
            'file_size_kb' => 500,
            'cta_login_clicked' => true,
            'debrief_viewed' => false,
        ]);

        $response = $this->get('/debriefing?token=test-uuid-123456');
        $response->assertStatus(200);
        $response->assertSee('Simulasi Kesadaran Keamanan Siber');
        $response->assertSee('Privacy-by-Design');

        $this->assertDatabaseHas('simulation_logs', [
            'session_token' => 'test-uuid-123456',
            'debrief_viewed' => true,
        ]);
    }

    public function test_admin_requires_pin_login_and_shows_dashboard(): void
    {
        // Unauthenticated access redirects to login
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/admin/login');

        // Login with correct PIN
        $loginResponse = $this->post('/admin/login', [
            'pin' => 'admin123',
        ]);
        $loginResponse->assertRedirect('/admin/dashboard');

        // Authenticated dashboard view
        $dashboardResponse = $this->withSession(['admin_authenticated' => true])->get('/admin/dashboard');
        $dashboardResponse->assertStatus(200);
        $dashboardResponse->assertSee('Security Awareness Telemetry');
    }
}
