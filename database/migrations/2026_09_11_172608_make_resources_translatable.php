<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Neon's pooled (PgBouncer transaction-mode) connection does not
     * reliably honour a multi-statement transaction for DDL — statements
     * can partially commit even when Laravel reports the transaction as
     * rolled back. Running each ALTER as its own auto-committed statement
     * avoids that.
     */
    public $withinTransaction = false;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::connection()->getDriverName() === 'sqlite') {
            Schema::table('resources', function (Blueprint $table): void {
                $table->json('title')->change();
                $table->json('description')->nullable()->change();
                $table->json('category')->nullable()->change();
            });

            return;
        }

        DB::statement("ALTER TABLE resources ALTER COLUMN title TYPE jsonb USING jsonb_build_object('en', title)");
        DB::statement("ALTER TABLE resources ALTER COLUMN description TYPE jsonb USING (CASE WHEN description IS NULL THEN NULL ELSE jsonb_build_object('en', description) END)");
        DB::statement("ALTER TABLE resources ALTER COLUMN category TYPE jsonb USING (CASE WHEN category IS NULL THEN NULL ELSE jsonb_build_object('en', category) END)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::connection()->getDriverName() === 'sqlite') {
            Schema::table('resources', function (Blueprint $table): void {
                $table->string('title')->change();
                $table->text('description')->nullable()->change();
                $table->string('category')->nullable()->change();
            });

            return;
        }

        DB::statement("ALTER TABLE resources ALTER COLUMN title TYPE varchar(255) USING title->>'en'");
        DB::statement("ALTER TABLE resources ALTER COLUMN description TYPE text USING description->>'en'");
        DB::statement("ALTER TABLE resources ALTER COLUMN category TYPE varchar(255) USING category->>'en'");
    }
};
