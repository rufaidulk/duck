<?php

namespace App;

use Exception;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    const STATUS_PENDING = 1;
    const STATUS_ACTIVE = 2;
    const ROLE_ADMIN = 'admin';
    const ROLE_COMPANY = 'company';
    const ROLE_MANAGER = 'manager';
    const ROLE_DEVELOPER = 'developer';
    const ROLE_TESTER = 'tester';

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

    public function projectUsers()
    {
        return $this->hasMany(ProjectUser::class);
    }

    public function assignedIssue()
    {
        return $this->hasOne(Issue::class, 'assignee_user_id');
    }

    public function authoredIssue()
    {
        return $this->hasOne(Issue::class, 'author_user_id');
    }

    public function createModel($attributes)
    {
        try
        {
            $this->fill($attributes);
            $this->company_id = $attributes['company_id'];
            $this->password = Hash::make($attributes['password']);
            $this->status = self::STATUS_ACTIVE;

            $this->save();
        }
        catch (Exception $e) { 
            throw $e;
        }
    }

    public function updateModel($attributes)
    {
        try
        {
            $this->fill($attributes);
            $this->company_id = $attributes['company_id'];
            if (!empty($this->password)) {
                $this->password = Hash::make($attributes['password']);
            }
            else {
                $this->password = $this->getOriginal('password');
            }

            $this->status = self::STATUS_ACTIVE;

            $this->save();
        }
        catch (Exception $e) { 
            throw $e;
        }
    }

    /**
     * @return array
     */
    public static function getCompanyRoles()
    {
        return [
            self::ROLE_COMPANY,
            self::ROLE_MANAGER,
            self::ROLE_DEVELOPER,
            self::ROLE_TESTER
        ];
    }

    /**
     * @return array
     */
    public static function getCompanyUserRoles()
    {
        return [
            self::ROLE_MANAGER,
            self::ROLE_DEVELOPER,
            self::ROLE_TESTER
        ];
    }

    public function getCompanyUsers()
    {
        return $this->whereHas('roles', function($query) {
                $query->whereIn('name', self::getCompanyRoles());
            })->get();
    }

    public function getUsersByCompanyId(int $company_id)
    {
        return $this->whereHas('roles', function($query) {
                    $query->whereIn('name', self::getCompanyRoles());
                })
                ->where(['company_id' => $company_id]);   
    }
}
