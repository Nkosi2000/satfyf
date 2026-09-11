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
            Schema::table('team_members', function (Blueprint $table): void {
                $table->json('role')->change();
                $table->json('bio')->nullable()->change();
            });

            return;
        }

        DB::statement("ALTER TABLE team_members ALTER COLUMN role TYPE jsonb USING jsonb_build_object('en', role)");
        DB::statement("ALTER TABLE team_members ALTER COLUMN bio TYPE jsonb USING (CASE WHEN bio IS NULL THEN NULL ELSE jsonb_build_object('en', bio) END)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::connection()->getDriverName() === 'sqlite') {
            Schema::table('team_members', function (Blueprint $table): void {
                $table->string('role')->change();
                $table->text('bio')->nullable()->change();
            });

            return;
        }

        DB::statement("ALTER TABLE team_members ALTER COLUMN role TYPE varchar(255) USING role->>'en'");
        DB::statement("ALTER TABLE team_members ALTER COLUMN bio TYPE text USING bio->>'en'");
    }
};
