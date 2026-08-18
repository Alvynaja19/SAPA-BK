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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 20)->nullable()->after('role');
            }
            if (!Schema::hasColumn('users', 'avatar_path')) {
                $table->string('avatar_path', 255)->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('avatar_path');
            }
        });

        if (!Schema::hasTable('student_profiles')) {
            Schema::create('student_profiles', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
                $table->string('nisn', 20)->nullable();
                $table->string('kelas', 20)->nullable();
                $table->string('jurusan', 50)->nullable();
                $table->year('tahun_masuk')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('counselor_profiles')) {
            Schema::create('counselor_profiles', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
                $table->string('nip', 30)->nullable();
                $table->string('spesialisasi', 100)->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counselor_profiles');
        Schema::dropIfExists('student_profiles');

        Schema::table('users', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('users', 'phone')) $columns[] = 'phone';
            if (Schema::hasColumn('users', 'avatar_path')) $columns[] = 'avatar_path';
            if (Schema::hasColumn('users', 'is_active')) $columns[] = 'is_active';

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
