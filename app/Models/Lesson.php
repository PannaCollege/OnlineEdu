<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Lesson extends BaseModel
{
    protected $fillable = [
        'course_id',
        'title',
        'content',
        'order',
    ];

    public function scopeFilter($query, Request $request): Builder
    {
        return $query
            ->when($request->query('search'), function ($query) use ($request) {
                $query
                    ->where('title', 'ilike', "%{$request->query('search')}%")
                    ->orWhere('content', 'ilike', "%{$request->query('search')}%");
            });
    }

    /**
     * relations
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function coverImage(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function video(): MorphOne
    {
        return $this->morphOne(Video::class, 'videoable');
    }

    /**
     * get lesson title
     * 
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * get lesson content
     * 
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * get lesson order
     * 
     * @return int
     */
    public function getOrder(): int
    {
        return $this->order;
    }

    /**
     * get lesson cover image
     * 
     * @return mixed
     */
    public function getCoverImage(): mixed
    {
        return $this->coverImage ? get_image_url($this->coverImage->path) : null;
    }
}
