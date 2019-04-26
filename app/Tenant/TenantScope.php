<?php

namespace App\Tenant;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if(auth()->user()) {
            if(!\Auth::user()->hasRole('super admin')) {
                return $builder->where('client_id', '=', \Auth::user()->getClientId());
            }
        }
        return $builder;
    }
}