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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('lname')->nullable()->default('');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('address');
            $table->string('permanent_address')->nullable();
            $table->string('password');
            $table->string('city');
            $table->string('country');
            $table->string('dob')->nullable();
            $table->string('year_id');
            $table->string('marital_sts');
            $table->string('gender_sts');
            $table->string('student_id')->unique();
            $table->string('profile')->nullable()->default('');
            $table->foreignId('course_id')->nullable();
            $table->boolean('is_active')->default(false);
            $table->foreignId('user_id');
            $table->string('national_id');
            $table->string('passport_id')->nullable();
            $table->string('education_certificate');
            $table->string('other_documents')->nullable()->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};