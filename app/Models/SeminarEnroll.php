<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeminarEnroll extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function seminar()
    {
        return $this->belongsTo(Seminar::class);
    }
}