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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nis', 30)->nullable()->index();
            $table->string('nisn', 20)->nullable()->index();
            $table->string('nama', 150);
            $table->string('kelas', 50)->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->enum('status', ['terdaftar', 'aktif'])->default('terdaftar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
