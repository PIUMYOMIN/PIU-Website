<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseComment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function createComment($data)
    {
        return self::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'message' => $data['message'],
            'course_id' => $data['course_id'],
            'user_id' => $data['user_id'],
            'course_link' => $data['course_link'],
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}