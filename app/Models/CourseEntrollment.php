<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseEntrollment extends BaseModel
{
    protected $fillable = [
        'course_id',
        'user_id',
        'enrollment_at'
    ];

    protected $casts = [
        'enrollment_at' => 'datetime'
    ];

    /**
     * relations
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * get course enrollment date
     * 
     * @return Carbon
     */
    public function getEnrollmentDate(): Carbon
    {
        return $this->enrollment_at;
    }
}
