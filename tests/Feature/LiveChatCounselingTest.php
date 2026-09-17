<?php

namespace Tests\Feature;

use App\Models\ChatMessage;
use App\Models\ChatSession;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LiveChatCounselingTest extends TestCase
{
    use RefreshDatabase;

    protected User $student;

    protected User $teacherA;

    protected User $teacherB;

    protected function setUp(): void
    {
        parent::setUp();

        $this->student = User::factory()->create([
            'name' => 'Siswa Andi Pratama',
            'email' => 'andi@student.sch.id',
            'role' => 'siswa',
            'kelas' => 'XII MIPA 2',
            'is_active' => true,
        ]);

        $this->teacherA = User::factory()->create([
            'name' => 'Dra. Hj. Siti Rahayu, M.Pd.',
            'email' => 'siti.rahayu@guru.sch.id',
            'role' => 'guru_bk',
            'is_active' => true,
        ]);

        $this->teacherB = User::factory()->create([
            'name' => 'Budi Santoso, S.Pd., Kons.',
            'email' => 'budi.santoso@guru.sch.id',
            'role' => 'guru_bk',
            'is_active' => true,
        ]);
    }

    public function test_student_can_fetch_list_of_active_guru_bk(): void
    {
        $this->actingAs($this->student);

        $response = $this->getJson(route('api.chat.teachers'));

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonFragment(['name' => 'Dra. Hj. Siti Rahayu, M.Pd.'])
            ->assertJsonFragment(['name' => 'Budi Santoso, S.Pd., Kons.']);
    }

    public function test_student_can_start_live_counseling_with_specific_guru_bk(): void
    {
        $this->actingAs($this->student);

        $response = $this->postJson(route('api.chat.send'), [
            'mode' => 'guru_bk',
            'teacher_id' => $this->teacherA->id,
            'message' => 'Selamat pagi Ibu Siti, saya ingin konsultasi mengenai SNBP.',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'mode' => 'guru_bk',
                'status' => 'active',
            ]);

        $session = ChatSession::where('user_id', $this->student->id)
            ->where('teacher_id', $this->teacherA->id)
            ->where('status', 'active')
            ->first();

        $this->assertNotNull($session);
        $this->assertEquals('guru_bk', $session->mode);
        $this->assertEquals($this->teacherA->id, $session->teacher_id);
    }

    public function test_student_cannot_have_more_than_one_active_counseling_session(): void
    {
        $this->actingAs($this->student);

        // Sesi pertama dibuat
        ChatSession::create([
            'user_id' => $this->student->id,
            'teacher_id' => $this->teacherA->id,
            'title' => 'Konsultasi Pertama',
            'mode' => 'guru_bk',
            'status' => 'active',
            'started_at' => now(),
        ]);

        // Siswa mencoba membuat sesi aktif baru
        $response = $this->postJson(route('api.chat.send'), [
            'mode' => 'guru_bk',
            'teacher_id' => $this->teacherB->id,
            'message' => 'Saya mau tanya ke Pak Budi juga.',
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
            ])
            ->assertJsonFragment([
                'message' => 'Anda masih memiliki 1 sesi konseling aktif dengan Guru BK.',
            ]);

        $this->assertEquals(1, ChatSession::where('user_id', $this->student->id)->where('mode', 'guru_bk')->count());
    }

    public function test_teacher_queue_is_isolated_and_teacher_b_cannot_see_teacher_a_queue(): void
    {
        // Siswa membuat sesi dengan Teacher A
        $session = ChatSession::create([
            'user_id' => $this->student->id,
            'teacher_id' => $this->teacherA->id,
            'title' => 'Konsultasi SNBP',
            'mode' => 'guru_bk',
            'status' => 'active',
            'started_at' => now(),
        ]);

        ChatMessage::create([
            'session_id' => $session->id,
            'sender_id' => $this->student->id,
            'role' => 'user',
            'content' => 'Pagi bu Siti.',
        ]);

        // 1. Teacher A login dan melihat antrean
        $this->actingAs($this->teacherA);
        $responseA = $this->getJson(route('bk.live-chat.queue'));

        $responseA->assertStatus(200)
            ->assertJson(['success' => true, 'count' => 1])
            ->assertJsonFragment(['name' => 'Siswa Andi Pratama']);

        // 2. Teacher B login dan melihat antrean
        $this->actingAs($this->teacherB);
        $responseB = $this->getJson(route('bk.live-chat.queue'));

        $responseB->assertStatus(200)
            ->assertJson(['success' => true, 'count' => 0])
            ->assertJsonMissing(['name' => 'Siswa Andi Pratama']);
    }

    public function test_teacher_b_cannot_access_or_view_teacher_a_chat_messages(): void
    {
        $session = ChatSession::create([
            'user_id' => $this->student->id,
            'teacher_id' => $this->teacherA->id,
            'title' => 'Konsultasi Rahasia',
            'mode' => 'guru_bk',
            'status' => 'active',
            'started_at' => now(),
        ]);

        // Teacher B mencoba mengakses pesan Teacher A
        $this->actingAs($this->teacherB);
        $response = $this->getJson(route('bk.live-chat.messages', $session->id));

        $response->assertStatus(403)
            ->assertJsonFragment([
                'message' => 'Akses ditolak. Sesi konseling ini ditangani oleh Guru BK lain.',
            ]);
    }

    public function test_teacher_can_reply_message_to_student(): void
    {
        $session = ChatSession::create([
            'user_id' => $this->student->id,
            'teacher_id' => $this->teacherA->id,
            'title' => 'Konsultasi SNBP',
            'mode' => 'guru_bk',
            'status' => 'active',
            'started_at' => now(),
        ]);

        $this->actingAs($this->teacherA);
        $response = $this->postJson(route('bk.live-chat.send', $session->id), [
            'message' => 'Halo Andi, silakan ke ruang BK jam istirahat ya.',
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonPath('message.role', 'counselor');

        $this->assertDatabaseHas('chat_messages', [
            'session_id' => $session->id,
            'sender_id' => $this->teacherA->id,
            'role' => 'counselor',
            'content' => 'Halo Andi, silakan ke ruang BK jam istirahat ya.',
        ]);
    }

    public function test_teacher_can_close_session_which_locks_chat(): void
    {
        $session = ChatSession::create([
            'user_id' => $this->student->id,
            'teacher_id' => $this->teacherA->id,
            'title' => 'Konsultasi Selesai',
            'mode' => 'guru_bk',
            'status' => 'active',
            'started_at' => now(),
        ]);

        $this->actingAs($this->teacherA);
        $closeResponse = $this->postJson(route('bk.live-chat.close', $session->id));

        $closeResponse->assertStatus(200)
            ->assertJson([
                'success' => true,
                'status' => 'closed',
            ]);

        $session->refresh();
        $this->assertEquals('closed', $session->status);
        $this->assertNotNull($session->closed_at);
        $this->assertEquals($this->teacherA->id, $session->closed_by);

        // Uji penguncian input chat: pengiriman pesan baru harus ditolak
        $sendAttemptTeacher = $this->postJson(route('bk.live-chat.send', $session->id), [
            'message' => 'Pesan tambahan setelah closed',
        ]);
        $sendAttemptTeacher->assertStatus(422);

        // Uji penguncian dari sisi siswa
        $this->actingAs($this->student);
        $sendAttemptStudent = $this->postJson(route('api.chat.send'), [
            'session_id' => $session->id,
            'mode' => 'guru_bk',
            'message' => 'Terima kasih banyak bu.',
        ]);
        $sendAttemptStudent->assertStatus(422)
            ->assertJsonFragment([
                'message' => 'Sesi konseling ini telah diakhiri oleh Guru BK.',
            ]);
    }
}
