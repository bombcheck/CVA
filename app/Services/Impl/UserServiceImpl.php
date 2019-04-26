<?php

namespace App\Services\Impl;


use App\Brand;
use App\Filters\ApiRequest;
use App\Filters\FilterConstants;
use App\Services\UserService;
use App\User;

class UserServiceImpl implements UserService
{
    private $allowFilters = [
        'partial' =>FilterConstants::USER_PARTIAL,
        'exact' =>FilterConstants::USER_EXACT,
    ];
    private $allowIncludes = FilterConstants::USER_INCLUDES;
    /**
     * Find All
     *
     * @return User|\Illuminate\Http\JsonResponse|mixed
     */
    public function findAll()
    {
        return ApiRequest::applyQuery($this->allowFilters,$this->allowIncludes,User::class)->get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return ApiRequest::applyQuery([],$this->allowIncludes,User::class)
            ->where('id',$id)
            ->first();
    }

    /**
     * Save new
     *
     * @param User $user
     * @param array $brands
     * @return User|\Illuminate\Http\JsonResponse|mixed
     */
    public function save(User $user, $brands = [])
    {
        if($user->role_id == 2)
        {
            $brands = Brand::where('client_id', $user->client_id)->pluck('id');
        }
        elseif($brands != [])
        {
            $brands = Brand::where('client_id', $user->client_id)->whereIn('id', $brands)->pluck('id');
        }
        $user->save();

        $user->brands()->attach($brands);
        return $user;
    }

    /**
     * Update by id
     *
     * @param User $user
     * @return User|\Illuminate\Http\JsonResponse|mixed
     */
    public function update(User $user)
    {
        $user->update();

        return $user;
    }

    /**
     * Delete
     *
     * @param $id
     * @return User|\Illuminate\Http\JsonResponse|mixed
     */
    public function delete($id)
    {
        $user = User::findOrFail($id);
        if(\Auth::user()->id == $id)
            return response(['errors' => ['general'=> ['You cannot delete your account!']]], 403);
        $user->delete();
    }

    public function addUserBrand($userId, $brandId, $flag)
    {
        $user = User::findOrFail($userId);
        $brand = Brand::where('client_id', $user->client_id)->where('id', $brandId)->pluck('id');
        if ($flag == "add") {
            $user->brands()->attach($brand);
        } else {
            $user->brands()->detach($brand);
        }
    }
}