<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(CourseCategory::class);
    }

    public function years()
    {
        return $this->belongsToMany(Year::class, 'student_course_years')
            ->withPivot('student_id')
            ->withTimestamps();
    }
}