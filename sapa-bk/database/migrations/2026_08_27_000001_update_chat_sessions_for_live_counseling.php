<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chat_sessions', function (Blueprint $table) {
            if (!Schema::hasColumn('chat_sessions', 'type')) {
                $table->enum('type', ['bot', 'human'])->default('bot')->after('title');
            }
            if (!Schema::hasColumn('chat_sessions', 'counselor_id')) {
                $table->foreignId('counselor_id')->nullable()->constrained('users')->onDelete('set null')->after('type');
            }
            if (!Schema::hasColumn('chat_sessions', 'status')) {
                $table->enum('status', ['active', 'waiting', 'closed'])->default('active')->after('counselor_id');
            }
            if (!Schema::hasColumn('chat_sessions', 'requested_at')) {
                $table->timestamp('requested_at')->nullable()->after('status');
            }
        });

        Schema::table('counselor_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('counselor_profiles', 'is_available')) {
                $table->boolean('is_available')->default(true)->after('spesialisasi');
            }
            if (!Schema::hasColumn('counselor_profiles', 'last_seen_at')) {
                $table->timestamp('last_seen_at')->nullable()->after('is_available');
            }
        });
    }

    public function down(): void
    {
        Schema::table('chat_sessions', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('chat_sessions', 'type')) $columns[] = 'type';
            if (Schema::hasColumn('chat_sessions', 'counselor_id')) {
                $table->dropForeign(['counselor_id']);
                $columns[] = 'counselor_id';
            }
            if (Schema::hasColumn('chat_sessions', 'status')) $columns[] = 'status';
            if (Schema::hasColumn('chat_sessions', 'requested_at')) $columns[] = 'requested_at';

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });

        Schema::table('counselor_profiles', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('counselor_profiles', 'is_available')) $columns[] = 'is_available';
            if (Schema::hasColumn('counselor_profiles', 'last_seen_at')) $columns[] = 'last_seen_at';

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
