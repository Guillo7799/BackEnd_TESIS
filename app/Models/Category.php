<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['designation'];
    public static function boot()
    {
    parent::boot();
    static::creating(function ($category) {
    $category->user_id = Auth::id();
    });
    }

    public function publication()
    {
        return $this->belongsTo('App\Publication')->withTimestamps();
    }

    public function user()
    {
    return $this->belongsTo('App\Models\User');
    }
}