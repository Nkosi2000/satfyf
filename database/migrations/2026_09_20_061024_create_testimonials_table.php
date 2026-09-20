<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Neon's pooled (PgBouncer transaction-mode) connection does not
     * reliably honour a multi-statement transaction for DDL — the postgres
     * grammar emits the primary key as a separate `alter table add primary
     * key` statement after `create table`, and wrapping both in one
     * transaction against the pooler fails with "current transaction is
     * aborted". Running each statement auto-committed avoids it. See the
     * same fix on make_team_members_translatable.php.
     */
    public $withinTransaction = false;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('role')->nullable();
            // Created after translatable support already existed, so this
            // starts as jsonb directly — no separate string-to-jsonb
            // migration needed the way the earlier models required.
            $table->jsonb('quote');
            $table->string('photo_path')->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->boolean('published')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
