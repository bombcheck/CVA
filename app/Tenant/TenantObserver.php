<?php

namespace App\Tenant;


use Illuminate\Database\Eloquent\Model;

class TenantObserver
{
    public function creating(Model $model)
    {
        if (auth()->user() != null ) {
            if( \Auth::user()->getClientId() != null){
                $model->setAttribute('client_id', \Auth::user()->getClientId());
            }
            elseif (request()->has('client_id')) {
                $model->setAttribute('client_id', request('client_id'));
            }
        }
        elseif (request()->has('client_id')) {
            $model->setAttribute('client_id', request('client_id'));
        }

    }

}
