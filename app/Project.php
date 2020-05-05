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
}
