<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('student_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('assignment_id')->references('id')->on('assignments')->onDelete('cascade');
            $table->unsignedInteger('course_id');
            $table->unsignedInteger('module_id');
            $table->unsignedInteger('student_id');
            $table->text('body')->nullable();
            $table->string('attach_file')->nullable();
            $table->boolean('is_turned_in')->default(false);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_assignments');
    }
};