<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;
    protected $fillable = [
        'business_name',
        'career',
        'description', 
        'hours', 
        'date',
        'city',
        'contact_email',
        'category_id'
    ];
    public static function boot()
    {
        parent::boot();
        static::creating(function ($publication) {
            $publication->user_id = Auth::id();
        });
    }

    public function category()
    {
        return $this->hasMany('App\Models\Category');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }

    public function application()
    {
    return $this->hasMany('App\Models\Application');
    }
}