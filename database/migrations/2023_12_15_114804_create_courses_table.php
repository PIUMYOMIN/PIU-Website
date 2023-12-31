<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('slug');
            $table->text('description');
            $table->text('eligibility');
            $table->text('requirement');
            $table->text('fees');
            $table->text('apply');
            $table->text('start_date');
            $table->text('end_date');
            $table->text('duration');
            $table->text('total_seat');
            $table->string('ic_name');
            $table->string('ic_phone');
            $table->unsignedBigInteger('course_category_id');
            $table->string('user_id');
            $table->string('is_active')->default(false);
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};