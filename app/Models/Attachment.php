<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attachment extends Model
{
    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }
}
