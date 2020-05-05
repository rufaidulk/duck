<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    const STATUS_PENDING = 1;
    const STATUS_ACTIVE = 2;
    const ROLE_ADMIN = 'admin';
    const ROLE_COMPANY = 'company';
    
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    
    public function company()
    {
        return $this->belongsTo(Company::class, 'id', 'user_id');
    }

    /**
     * @return array
     */
    public static function getCompanyRoles()
    {
        return [
            self::ROLE_COMPANY
        ];
    }

    public function getCompanyUsers()
    {
        return $this->whereHas('roles', function($query) {
                $query->whereIn('name', self::getCompanyRoles());
            })->get();
    }
}
