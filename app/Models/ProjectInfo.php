<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class ProjectInfo extends Model
{
    protected $table = 'projects_info';
    protected $fillable = [
        'user_id',
        'project_name',
        'project_description',
    ];

    public function attachment(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachable');
    }
}
