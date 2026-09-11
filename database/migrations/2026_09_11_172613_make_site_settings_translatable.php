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
            Schema::table('site_settings', function (Blueprint $table): void {
                $table->json('value')->nullable()->change();
            });

            return;
        }

        DB::statement("ALTER TABLE site_settings ALTER COLUMN value TYPE jsonb USING (CASE WHEN value IS NULL THEN NULL ELSE jsonb_build_object('en', value) END)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::connection()->getDriverName() === 'sqlite') {
            Schema::table('site_settings', function (Blueprint $table): void {
                $table->text('value')->nullable()->change();
            });

            return;
        }

        DB::statement("ALTER TABLE site_settings ALTER COLUMN value TYPE text USING value->>'en'");
    }
};
