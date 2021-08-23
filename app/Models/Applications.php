<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applications extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'last_name',
        'message',
        'publication_id',
    ];
    public static function boot()
    {
        parent::boot();
        static::creating(function ($application) {
            $application->user_id = Auth::id();
        });
    }

    public function user()
    {
    return $this->belongsTo('App\Models\User');
    }

    public function publication()
    {
    return $this->belongsTo('App\Models\Publication');
    }
    
}