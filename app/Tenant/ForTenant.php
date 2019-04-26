<?php

namespace App\Tenant;


trait ForTenant
{
    public static function bootForTenant()
    {
        static::addGlobalScope(
            new TenantScope()
        );

        static::observe(
            app()->make(TenantObserver::class)
        );
    }
}