<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;
    protected $fillable = [
        'ruc',
        'business_name',
        'business_type',
        'business_age',
        'role',
    ];
    public $timestamps=false;
    public function user()
    {
    return $this->morphOne('App\Models\User', 'userable');
    }
}