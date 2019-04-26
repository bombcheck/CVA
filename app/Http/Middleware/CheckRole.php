<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $user = \Auth::user();
        if(!$user)
            return response(['errors' => ['general' => [ 'You are not authorized' ]] ], 403);

        $roleName = $user->role->name;

        if($role == 'client viewer')
            return $next($request);

        if($roleName == 'super admin' ){
            return $next($request);
        }
        switch($role)
        {
            case 'super admin':
                return response(['errors' => ['general' => [ 'You are not authorized' ]] ], 403);
                break;
            case 'client admin':
                if($roleName == $role)
                    return $next($request);
                return response(['errors' => ['general' => [ 'You are not authorized' ]] ], 403);
                break;
            case 'client user':
                if($roleName == $role || $roleName == 'client admin')
                    return $next($request);
                return response(['errors' => ['general' => [ 'You are not authorized' ]] ], 403);
        }
        return response(['errors' => ['general' => [ 'You are not authorized' ]] ], 403);

    }
}
