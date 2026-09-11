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
            Schema::table('programs', function (Blueprint $table): void {
                $table->json('title')->change();
                $table->json('description')->change();
            });

            return;
        }

        DB::statement("ALTER TABLE programs ALTER COLUMN title TYPE jsonb USING jsonb_build_object('en', title)");
        DB::statement("ALTER TABLE programs ALTER COLUMN description TYPE jsonb USING jsonb_build_object('en', description)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::connection()->getDriverName() === 'sqlite') {
            Schema::table('programs', function (Blueprint $table): void {
                $table->string('title')->change();
                $table->text('description')->change();
            });

            return;
        }

        DB::statement("ALTER TABLE programs ALTER COLUMN title TYPE varchar(255) USING title->>'en'");
        DB::statement("ALTER TABLE programs ALTER COLUMN description TYPE text USING description->>'en'");
    }
};
