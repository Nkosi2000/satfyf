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
        // SQLite (the test suite's in-memory DB) has no ALTER COLUMN TYPE
        // with a data-transforming USING clause, but test databases start
        // empty anyway — a plain type change covers it. Postgres needs the
        // real data-preserving statement, since this runs against live data.
        if (DB::connection()->getDriverName() === 'sqlite') {
            Schema::table('articles', function (Blueprint $table): void {
                $table->json('title')->change();
                $table->json('excerpt')->change();
                $table->json('body')->change();
            });

            return;
        }

        DB::statement("ALTER TABLE articles ALTER COLUMN title TYPE jsonb USING jsonb_build_object('en', title)");
        DB::statement("ALTER TABLE articles ALTER COLUMN excerpt TYPE jsonb USING jsonb_build_object('en', excerpt)");
        DB::statement("ALTER TABLE articles ALTER COLUMN body TYPE jsonb USING jsonb_build_object('en', body)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::connection()->getDriverName() === 'sqlite') {
            Schema::table('articles', function (Blueprint $table): void {
                $table->string('title')->change();
                $table->string('excerpt')->change();
                $table->text('body')->change();
            });

            return;
        }

        DB::statement("ALTER TABLE articles ALTER COLUMN title TYPE varchar(255) USING title->>'en'");
        DB::statement("ALTER TABLE articles ALTER COLUMN excerpt TYPE varchar(255) USING excerpt->>'en'");
        DB::statement("ALTER TABLE articles ALTER COLUMN body TYPE text USING body->>'en'");
    }
};
