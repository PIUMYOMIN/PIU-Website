<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'image_tag', 'tag_link', 'description', 'slide_image', 'user_id', 'is_active'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}