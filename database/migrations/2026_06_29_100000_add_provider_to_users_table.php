<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Adds a `provider` column alongside the existing `provider_id`
     * column. `provider_id` alone is ambiguous once more than one OAuth
     * provider is in play (e.g. a Google "12345" and a future Facebook
     * "12345" would collide); pairing it with `provider` makes account
     * lookup unambiguous and lets us safely unique-index the pair.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('provider')->nullable()->after('provider_id');
            $table->unique(['provider', 'provider_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['provider', 'provider_id']);
            $table->dropColumn('provider');
        });
    }
};
