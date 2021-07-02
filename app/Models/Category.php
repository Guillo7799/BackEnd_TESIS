<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['designation'];

    public function publication()
    {
        return $this->belongsTo('App\Publication')->withTimestamps();
    }
}
