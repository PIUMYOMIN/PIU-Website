<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'application_sts' => 'boolean',
    ];

    //image url accessor
    protected $appends = ['image_url'];

    /**
     * Get the full URL for the image.
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->image) {
                    // Check if it's already a full URL
                    if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                        return $this->image;
                    }

                    // Check if it starts with storage/
                    if (strpos($this->image, 'storage/') === 0) {
                        return asset($this->image);
                    }

                    // Assume it's in storage
                    return asset('storage/' . $this->image);
                }
                return null;
            },
        );
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(CourseCategory::class, 'course_category_id');
    }

    public function years()
    {
        return $this->belongsToMany(Year::class, 'student_course_years')
            ->withPivot('student_id')
            ->withTimestamps();
    }
}
