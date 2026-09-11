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
            Schema::table('faq_items', function (Blueprint $table): void {
                $table->json('question')->change();
                $table->json('answer')->change();
            });

            return;
        }

        DB::statement("ALTER TABLE faq_items ALTER COLUMN question TYPE jsonb USING jsonb_build_object('en', question)");
        DB::statement("ALTER TABLE faq_items ALTER COLUMN answer TYPE jsonb USING jsonb_build_object('en', answer)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::connection()->getDriverName() === 'sqlite') {
            Schema::table('faq_items', function (Blueprint $table): void {
                $table->string('question')->change();
                $table->text('answer')->change();
            });

            return;
        }

        DB::statement("ALTER TABLE faq_items ALTER COLUMN question TYPE varchar(255) USING question->>'en'");
        DB::statement("ALTER TABLE faq_items ALTER COLUMN answer TYPE text USING answer->>'en'");
    }
};
