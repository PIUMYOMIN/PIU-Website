<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'course_id',
        'module_id',
        'student_id',
        'body',
        'attach_file',
        'is_submitted'
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}