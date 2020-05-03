<?php

namespace App;

use App\Http\Requests\CompanyRequest;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    const STATUS_ACTIVE = 1;
    const STATUS_PENDING = 2;

    protected $fillable = ['name', 'description'];

    public function createModel($attributes)
    {
        try
        {
            $this->fill($attributes);
            $this->user_id = $attributes['user_id'];
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
            $this->user_id = $attributes['user_id'];
            $this->status = self::STATUS_ACTIVE;

            $this->save();
        }
        catch (Exception $e) { 
            throw $e;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
   
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
