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
        Schema::create('gradings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students');
            $table->foreignId('course_id')->constrained('courses');
            $table->foreignId('assignment_id')->constrained('assignments');
            $table->foreignId('semester_id')->nullable();
            $table->foreignId('module_id');
            $table->foreignId('term_id')->nullable();
            $table->foreignId('year_id');
            $table->foreignId('user_id')->constrained('users');
            $table->decimal('mark', 8, 2);
            $table->decimal('grade_point', 8, 2);
            $table->string('grade_value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gradings');
    }
};