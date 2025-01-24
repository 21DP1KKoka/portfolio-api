<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class PersonalInfo extends Model
{
    protected $table = 'personal_info';
    protected $fillable = [
        'user_id',
        'name',
        'contents',
    ];

    public function attachment(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachable');
    }
}
