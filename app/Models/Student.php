<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class Student extends Model implements Authenticatable
{
    use HasFactory, AuthenticatableTrait;

    protected $fillable = [
        'fname',
        'lname',
        'email',
        'phone',
        'address',
        'permanent_address',
        'password',
        'city',
        'country',
        'dob',
        'year_id',
        'marital_sts',
        'gender_sts',
        'student_id',
        'profile',
        'course_id',
        'is_active',
        'user_id',
        'national_id',
        'passport_id',
        'education_certificate',
        'other_documents',
    ];

    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'student_course_years')
            ->withPivot('year_id');
    }

    public function years()
    {
        return $this->belongsTo(Year::class, 'student_course_years');
    }

    public function semester()
    {
        return $this->belongsToMany(Semester::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}