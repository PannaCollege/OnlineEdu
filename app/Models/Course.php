<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Course extends BaseModel
{
    protected $fillable = [
        'title',
        'parent_id',
        'start_date',
        'end_date',
        'is_active',
        'instructor_id',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * scopes
     */
    public function scopeActive($query, bool $isActive = true): Builder
    {
        return $query
            ->where('is_active', $isActive);
    }

    public function scopeFilter($query, Request $request): Builder
    {
        return $query
            ->when($request->query('search'), fn ($query) => $query->where('title', 'ilike', "%{$request->query('search')}%"))
            ->when($request->date('start_date'), fn ($query) => $query->whereDate('start_date', '<=', $request->date('start_date')))
            ->when($request->date('end_date'), fn ($query) => $query->whereDate('end_date', '>=', $request->date('end_date')))
            ->when($request->filled('is_active'), fn ($query) => $query->active($request->boolean('is_active')));
    }

    /**
     * relations
     */
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function coverImage(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * get course title
     * 
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * get course start date
     * 
     * @return Carbon
     */
    public function getStartDate(): Carbon
    {
        return $this->start_date;
    }

    /**
     * get course end date
     * 
     * @return Carbon
     */
    public function getEndDate(): Carbon
    {
        return $this->end_date;
    }

    /**
     * get course is active or not
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * get course cover image
     * 
     * @return mixed
     */
    public function getCoverImage(): mixed
    {
        return $this->coverImage ? get_image_url($this->coverImage->path) : null;
    }
}
