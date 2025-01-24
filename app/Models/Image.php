<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Image extends Model
{
    protected $fillable = [
        'attachment_id',
        'url',
    ];


    public function attachment(): hasOne
    {
        return $this->hasOne(Images::class);
    }
}
