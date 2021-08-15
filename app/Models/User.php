<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'province',
        'city',
        'location',
        'description',
        'cellphone',
        'image',
        'role',
    ];


    const ROLE_SUPERADMIN = 'ROLE_SUPERADMIN';
    const ROLE_BUSINESS = 'ROLE_BUSINESS';
    const ROLE_STUDENT = 'ROLE_STUDENT';

    private const ROLES_HIERARCHY = [
        self::ROLE_SUPERADMIN => [self::ROLE_BUSINESS],
        self::ROLE_BUSINESS => [self::ROLE_STUDENT],
        self::ROLE_STUDENT => []
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function publications()
    {
        return $this->belongsToMany('App\Models\Publication')->withTimestamps();
    }
    /*
    public function businessPublications()
    {
        return $this->hasMany('App\Models\Publications','user_id');
    }*/
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }
    public function cviates()
    {
        return $this->hasOne('App\Models\CVitae');
    }
    public function isGranted($role)
    {
        if ($role === $this->role) {
        return true;
    }
    return self::isRoleInHierarchy($role, self::ROLES_HIERARCHY[$this->role]);
    }
    private static function isRoleInHierarchy($role, $role_hierarchy)
    {
        if (in_array($role, $role_hierarchy)) {
        return true;
        }
        foreach ($role_hierarchy as $role_included) 
        {
            if(self::isRoleInHierarchy($role,self::ROLES_HIERARCHY[$role_included]))
            {
                return true;
            }
        }
        return false;
    }
    public function userable()
    {
    return $this->morphTo();
    }
}