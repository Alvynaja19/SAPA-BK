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
        Schema::table('questionnaire_results', function (Blueprint $table) {
            $table->text('tindak_lanjut')->nullable()->after('score');
            $table->foreignId('tindak_lanjut_by')->nullable()->after('tindak_lanjut')->constrained('users')->nullOnDelete();
            $table->timestamp('tindak_lanjut_at')->nullable()->after('tindak_lanjut_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questionnaire_results', function (Blueprint $table) {
            $table->dropForeign(['tindak_lanjut_by']);
            $table->dropColumn(['tindak_lanjut', 'tindak_lanjut_by', 'tindak_lanjut_at']);
        });
    }
};
