<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use Notifiable;
    
    protected $table = 'customers';
    protected $fillable = [
        'name', 'email', 'password','phone','adress'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function transactions ()
    {
        return $this->hasMany('App\Transaction','customer_id','id');
    }
}