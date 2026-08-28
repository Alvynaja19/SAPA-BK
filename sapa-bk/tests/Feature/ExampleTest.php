<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test public landing page returns 200.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Test student dashboard loads successfully with authenticated student.
     */
    public function test_student_dashboard_accessible_by_student(): void
    {
        $student = User::factory()->create([
            'role'      => 'siswa',
            'is_active' => true,
        ]);

        $response = $this->actingAs($student)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Ruang Pendampingan Siswa');
    }

    /**
     * Test counselor dashboard loads successfully with authenticated counselor.
     */
    public function test_counselor_dashboard_accessible_by_counselor(): void
    {
        $counselor = User::factory()->create([
            'role'      => 'guru_bk',
            'is_active' => true,
        ]);

        $response = $this->actingAs($counselor)->get('/bk/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Pusat Kendali Bimbingan Konseling');
    }
}
