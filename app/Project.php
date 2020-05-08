<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    const STATUS_NEW =  1;
    const STATUS_ACTIVE = 2;
    const STATUS_ON_HOLD = 3;
    const STATUS_CANCELED = 4;
    const STATUS_COMPLETED = 5;
    const STATUS_CLOSED = 6;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'status'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function getProjectUsersGroupByRole($project_id)
    {
        return ProjectUser::leftJoin('users', 'project_user.user_id', '=', 'users.id')
                    ->leftJoin('model_has_roles', function($join) {
                        $join->on('model_has_roles.model_id', '=', 'users.id');
                        $join->where('model_has_roles.model_type', User::class);
                    })
                    ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->select(['roles.name as role', 'users.email'])
                    ->where('project_user.project_id', $project_id)
                    ->groupBy(['role', 'users.email'])
                    ->get()
                    ->groupBy('role');
    }

}
