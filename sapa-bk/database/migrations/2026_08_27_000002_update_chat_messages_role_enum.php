<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Mendukung role: user, assistant, system, counselor
        if (DB::getDriverName() === 'sqlite') {
            // Re-create table untuk update CHECK constraint di SQLite
            Schema::disableForeignKeyConstraints();

            DB::statement('CREATE TABLE "chat_messages_temp" (
                "id" integer primary key autoincrement not null,
                "session_id" integer not null,
                "role" varchar check ("role" in (\'user\', \'assistant\', \'system\', \'counselor\')) not null,
                "content" text not null,
                "metadata" text,
                "created_at" datetime,
                "updated_at" datetime,
                foreign key("session_id") references "chat_sessions"("id") on delete cascade
            )');

            DB::statement('INSERT INTO "chat_messages_temp" SELECT * FROM "chat_messages"');
            DB::statement('DROP TABLE "chat_messages"');
            DB::statement('ALTER TABLE "chat_messages_temp" RENAME TO "chat_messages"');

            Schema::enableForeignKeyConstraints();
        } else {
            Schema::table('chat_messages', function (Blueprint $table) {
                $table->enum('role', ['user', 'assistant', 'system', 'counselor'])->change();
            });
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            Schema::disableForeignKeyConstraints();

            DB::statement('CREATE TABLE "chat_messages_temp" (
                "id" integer primary key autoincrement not null,
                "session_id" integer not null,
                "role" varchar check ("role" in (\'user\', \'assistant\')) not null,
                "content" text not null,
                "metadata" text,
                "created_at" datetime,
                "updated_at" datetime,
                foreign key("session_id") references "chat_sessions"("id") on delete cascade
            )');

            DB::statement('INSERT INTO "chat_messages_temp" SELECT * FROM "chat_messages" WHERE "role" IN (\'user\', \'assistant\')');
            DB::statement('DROP TABLE "chat_messages"');
            DB::statement('ALTER TABLE "chat_messages_temp" RENAME TO "chat_messages"');

            Schema::enableForeignKeyConstraints();
        } else {
            Schema::table('chat_messages', function (Blueprint $table) {
                $table->enum('role', ['user', 'assistant'])->change();
            });
        }
    }
};
