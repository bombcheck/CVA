<?php

namespace App\Providers;

use App\Services\BrandService;
use App\Services\CampaignService;
use App\Services\ClientService;
use App\Services\Impl\BrandServiceImpl;
use App\Services\Impl\CampaignServiceImpl;
use App\Services\Impl\ClientServiceImpl;
use App\Services\Impl\UserServiceImpl;
use App\Services\UserService;
use App\Tenant\TenantObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ClientService::class,ClientServiceImpl::class);
        $this->app->bind(BrandService::class,BrandServiceImpl::class);
        $this->app->bind(CampaignService::class,CampaignServiceImpl::class);
        $this->app->bind(UserService::class,UserServiceImpl::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        $this->app->singleton(TenantObserver::class, function (){
            return new TenantObserver();
        });
    }
}
