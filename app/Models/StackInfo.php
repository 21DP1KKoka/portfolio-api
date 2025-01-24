<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class StackInfo extends Model
{
    protected $table = 'stack_info';
    protected $fillable = [
        'user_id',
        'technology_name',
        'proficiency',
    ];
    public function attachment(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachable');
    }
}
