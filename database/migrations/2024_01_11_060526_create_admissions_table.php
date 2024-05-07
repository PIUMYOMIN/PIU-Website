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
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
$table->string('email');

            $table->string('phone');
            $table->string('country');
            $table->string('city');
            $table->string('address');
            $table->dob('dob');
            $table->string('profile');
            $table->string('zipcode');
            $table->string('gender');
            $table->string('national_id');
            $table->string('marital_sts');
            $table->string('alumni_sts');
            $table->string('student_id')->nullable()->default('');
            $table->string('language_proficiency')->nullable()->default('');
            $table->string('personal_statement');
            $table->string('education_certificate');
            $table->string('other_document')->nullable()->default('');
            $table->foreignId('course_id');
            $table->string('verification_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};