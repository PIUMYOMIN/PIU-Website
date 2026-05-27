<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('curriculums') || !Schema::hasColumn('curriculums', 'description')) {
            return;
        }

        DB::statement('ALTER TABLE curriculums MODIFY description TEXT NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('curriculums') || !Schema::hasColumn('curriculums', 'description')) {
            return;
        }

        DB::statement('ALTER TABLE curriculums MODIFY description VARCHAR(255) NOT NULL');
    }
};

