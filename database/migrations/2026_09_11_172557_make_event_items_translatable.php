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
            Schema::table('event_items', function (Blueprint $table): void {
                $table->json('title')->change();
                $table->json('description')->change();
                $table->json('location')->nullable()->change();
            });

            return;
        }

        DB::statement("ALTER TABLE event_items ALTER COLUMN title TYPE jsonb USING jsonb_build_object('en', title)");
        DB::statement("ALTER TABLE event_items ALTER COLUMN description TYPE jsonb USING jsonb_build_object('en', description)");
        DB::statement("ALTER TABLE event_items ALTER COLUMN location TYPE jsonb USING (CASE WHEN location IS NULL THEN NULL ELSE jsonb_build_object('en', location) END)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::connection()->getDriverName() === 'sqlite') {
            Schema::table('event_items', function (Blueprint $table): void {
                $table->string('title')->change();
                $table->text('description')->change();
                $table->string('location')->nullable()->change();
            });

            return;
        }

        DB::statement("ALTER TABLE event_items ALTER COLUMN title TYPE varchar(255) USING title->>'en'");
        DB::statement("ALTER TABLE event_items ALTER COLUMN description TYPE text USING description->>'en'");
        DB::statement("ALTER TABLE event_items ALTER COLUMN location TYPE varchar(255) USING location->>'en'");
    }
};
