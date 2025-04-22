<?php
namespace App;

use App\Permission;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $table = 'users';
    
    protected $fillable = [
        'id','name', 'email', 'password', 'role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role ()
    {
        return $this->belongsTo('App\Role');
    }

    public function hasPermission (Permission $permission)
    {
        return !! optional(optional($this->role)->permissions)->contains($permission);
    }

    public function isSuperAdmin()
    {
        return $this->id == 1;
    }

    public function articles ()
    {
        return $this->hasMany('App\Article','user_id','id');
    }
}