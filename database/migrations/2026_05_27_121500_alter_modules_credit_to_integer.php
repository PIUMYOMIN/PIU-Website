<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('modules') || !Schema::hasColumn('modules', 'credit')) {
            return;
        }

        DB::statement('ALTER TABLE modules MODIFY credit TINYINT UNSIGNED NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('modules') || !Schema::hasColumn('modules', 'credit')) {
            return;
        }

        DB::statement('ALTER TABLE modules MODIFY credit VARCHAR(255) NOT NULL');
    }
};

