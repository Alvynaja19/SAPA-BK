<?php

namespace Tests\Feature;

use App\Models\Ebook;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EbookModuleTest extends TestCase
{
    use RefreshDatabase;

    protected function createStudent(): User
    {
        return User::factory()->create([
            'name' => 'Siswa Perpustakaan Test',
            'email' => 'siswa.test@sman4jember.sch.id',
            'role' => 'siswa',
            'is_active' => true,
        ]);
    }

    protected function createGuruBk(): User
    {
        return User::factory()->create([
            'name' => 'Guru BK Test',
            'email' => 'gurubk.test@sman4jember.sch.id',
            'role' => 'guru_bk',
            'is_active' => true,
        ]);
    }

    public function test_student_can_access_ebook_portal(): void
    {
        $student = $this->createStudent();
        $this->actingAs($student);

        $ebook = Ebook::create([
            'title' => 'Panduan Karir Masa Depan Siswa',
            'description' => 'Modul eksplorasi karir dan perguruan tinggi.',
            'file_path' => 'ebooks/panduan_karir_test.pdf',
            'is_public' => true,
            'uploaded_by' => $student->id,
        ]);

        $response = $this->get(route('siswa.ebook'));

        $response->assertStatus(200);
        $response->assertSee('Perpustakaan E-Book &amp; Modul Siswa', false);
        $response->assertSee('Panduan Karir Masa Depan Siswa');
    }

    public function test_stream_pdf_serves_valid_pdf_content(): void
    {
        Storage::fake('public');
        $student = $this->createStudent();
        $this->actingAs($student);

        // Buat file PDF valid di storage palsu
        $dummyPdf = "%PDF-1.4\n1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n2 0 obj\n<< /Type /Pages /Kids [] /Count 0 >>\nendobj\nxref\n0 3\n0000000000 65535 f \n0000000009 00000 n \n0000000058 00000 n \ntrailer\n<< /Size 3 /Root 1 0 R >>\nstartxref\n115\n%%EOF\n";
        Storage::disk('public')->put('ebooks/test_stream.pdf', $dummyPdf);

        $ebook = Ebook::create([
            'title' => 'Modul Uji Alir PDF',
            'description' => 'Uji aliran data dokumen PDF ke browser.',
            'file_path' => 'ebooks/test_stream.pdf',
            'is_public' => true,
            'uploaded_by' => $student->id,
        ]);

        $response = $this->get(route('ebook.stream', $ebook->id));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }

    public function test_download_pdf_serves_download_response(): void
    {
        Storage::fake('public');
        $student = $this->createStudent();
        $this->actingAs($student);

        $dummyPdf = "%PDF-1.4\n1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n2 0 obj\n<< /Type /Pages /Kids [] /Count 0 >>\nendobj\nxref\n0 3\n0000000000 65535 f \n0000000009 00000 n \n0000000058 00000 n \ntrailer\n<< /Size 3 /Root 1 0 R >>\nstartxref\n115\n%%EOF\n";
        Storage::disk('public')->put('ebooks/test_unduh.pdf', $dummyPdf);

        $ebook = Ebook::create([
            'title' => 'Modul Unduh PDF',
            'description' => 'Uji unduhan berkas PDF.',
            'file_path' => 'ebooks/test_unduh.pdf',
            'is_public' => true,
            'uploaded_by' => $student->id,
        ]);

        $response = $this->get(route('ebook.download', $ebook->id));

        $response->assertStatus(200);
        $response->assertHeader('Content-Disposition');
    }

    public function test_missing_ebook_returns_404(): void
    {
        $student = $this->createStudent();
        $this->actingAs($student);

        $response = $this->get(route('ebook.stream', 999999));
        $response->assertStatus(404);
    }

    public function test_guru_bk_can_upload_ebook(): void
    {
        Storage::fake('public');
        $counselor = $this->createGuruBk();
        $this->actingAs($counselor);

        $file = UploadedFile::fake()->create('modul_bk_baru.pdf', 500, 'application/pdf');

        $response = $this->post(route('bk.ebook.store'), [
            'title' => 'Panduan Sukses Siswa 2026',
            'description' => 'Deskripsi modul bimbingan',
            'file' => $file,
            'is_public' => '1',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('ebooks', [
            'title' => 'Panduan Sukses Siswa 2026',
        ]);
    }
}
