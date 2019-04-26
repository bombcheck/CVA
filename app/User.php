<?php

namespace App;

use App\Tenant\ForTenant;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, ForTenant;

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

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class);
    }

    public function getClientId()
    {
        return $this->client_id;
    }

    public function hasRole($role)
    {
        return $this->role->name == $role;
    }
}
