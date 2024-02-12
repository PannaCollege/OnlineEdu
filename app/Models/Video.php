<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;

class Video extends BaseModel
{
    protected $fillable = [
        'name',
        'path',
        'size',
        'extension',
    ];

    /**
     * relations
     */
    public function videoable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * get image name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * get image path
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * get image size
     */
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * get image extension
     */
    public function getExtension(): string
    {
        return $this->extension;
    }
}
