<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_tag',
        'link1',
        'link2',
        'image',
        'user_id',
        'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}