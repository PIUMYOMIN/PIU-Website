<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function curriculums()
    {
        return $this->hasMany(Curriculum::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function gradings()
    {
        return $this->hasMany(Grading::class);
    }

    public function studentAssignments()
    {
        return $this->hasMany(StudentAssignment::class);
    }
}
