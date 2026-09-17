<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('chat_sessions', function (Blueprint $table) {
            $table->foreignId('teacher_id')
                ->nullable()
                ->after('user_id')
                ->constrained('users')
                ->nullOnDelete();

            $table->enum('status', ['active', 'closed'])
                ->default('active')
                ->after('mode');

            $table->timestamp('started_at')->nullable()->after('status');
            $table->timestamp('closed_at')->nullable()->after('started_at');
            $table->foreignId('closed_by')->nullable()->after('closed_at')->constrained('users')->nullOnDelete();

            // Indexes for fast queue queries and active session checks
            $table->index(['user_id', 'mode', 'status'], 'idx_student_active_session');
            $table->index(['teacher_id', 'mode', 'status'], 'idx_teacher_active_queue');
        });

        Schema::table('chat_messages', function (Blueprint $table) {
            $table->foreignId('sender_id')->nullable()->after('session_id')->constrained('users')->nullOnDelete();
            $table->boolean('is_read')->default(false)->after('content');
            $table->timestamp('read_at')->nullable()->after('is_read');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->dropForeign(['sender_id']);
            $table->dropColumn(['sender_id', 'is_read', 'read_at']);
        });

        Schema::table('chat_sessions', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->dropForeign(['closed_by']);
            $table->dropIndex('idx_student_active_session');
            $table->dropIndex('idx_teacher_active_queue');
            $table->dropColumn(['teacher_id', 'status', 'started_at', 'closed_at', 'closed_by']);
        });
    }
};
