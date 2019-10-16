<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class AdminFileManager extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $table = 'admin_file_managers';
    protected $fillable = ['active','title'];

    public function scopeOrderByTitle($query)
    {
        $query->orderBy('title');
    }

    public function setActiveAttribute($value)
    {
        $this->attributes['active'] = (bool) json_decode(strtolower($value));
    }

}
