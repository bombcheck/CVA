<?php

namespace App;

use App\Tenant\ForTenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use ForTenant;

    protected $table = 'brands';

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('age', function (Builder $builder) {
            if(\Auth::user()->role_id == 3 || \Auth::user()->role_id == 4) {
                $user_id = \Auth::user()->id;
                $builder->whereHas('users', function ($q) use ($user_id) {
                    $q->where('user_id', $user_id);
                });
            }
        });
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
