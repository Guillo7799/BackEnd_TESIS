<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;

    public static function boot()
    {
        parent::boot();
        static::creating(function ($publication) {
            $publication->user_id = Auth::id();
        });
    }

    protected $fillable = ['career', 'description', 'hours', 'date'];

    public function category()
    {
        return $this->hasMany('App\Category');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
