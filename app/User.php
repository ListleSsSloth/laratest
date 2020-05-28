<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;



class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $fillable  = [
        'login',
        'password',
        'ldap',
        'remember_token',
        'is_active',
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
    

    public function roles()
    {
        return $this->belongsToMany('App\Role')->withPivot('added_on', 'added_by');
    }
    
}
