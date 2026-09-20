<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * See create_testimonials_table.php — Neon's pooled connection doesn't
     * reliably honour a multi-statement DDL transaction, so each of this
     * migration's two `alter table add column` statements runs
     * auto-committed instead.
     */
    public $withinTransaction = false;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->jsonb('role')->nullable()->after('url');
            $table->jsonb('description')->nullable()->after('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn(['role', 'description']);
        });
    }
};
