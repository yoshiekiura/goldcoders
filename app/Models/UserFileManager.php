<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class UserFileManager extends Model implements HasMedia
{
    use HasMediaTrait;

    // public function scopeOrderByTitle($query)
    // {
    //     $query->orderBy('title');
    // }
    // public function setActiveAttribute($value)
    // {
    //     $this->attributes['active'] = (bool) json_decode(strtolower($value));
    // }

    /**
     * @var array
     */
    protected $fillable = ['member_id', 'file_id', 'date_submitted', 'date_approved', 'approved'];

    /**
     * @var string
     */
    protected $table = 'user_file_managers';

    /**
     * @return mixed
     */
    public function file()
    {
        return $this->belongsTo(AdminFileManager::class, 'file_id');
    }

    /**
     * @return mixed
     */
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }
}
