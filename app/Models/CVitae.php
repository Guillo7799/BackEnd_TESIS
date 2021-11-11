<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CVitae extends Model
{
    use HasFactory;
    protected $fillable = [
        'university',
        'career',        
        'language',
        'level_language',
        'habilities',
        'certificates',
        'highschool_degree',
        'work_experience',
        'image',
        'link',
    ];
    public static function boot()
    {
        parent::boot();
        static::creating(function ($cvitae) {
            $cvitae->user_id = Auth::id();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}