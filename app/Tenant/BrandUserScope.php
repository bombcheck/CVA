<?php

namespace App\Tenant;


use App\Brand;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class BrandUserScope implements Scope
{

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {

        if(\Auth::user()->role_id == 3 || \Auth::user()->role_id == 4) {
            $user_id = \Auth::user()->id;
            $brand_ids = Brand::whereHas('users', function ($q) use ($user_id) {
                $q->where('user_id', $user_id);
            })->pluck('id');
            $builder->whereIn('id', $brand_ids);
        }
    }
}