<?php


namespace App\Services;


use App\User;

interface UserService
{
    /**
     * Find All
     *
     * @return User|\Illuminate\Http\JsonResponse|mixed
     */
    public function findAll();

    /**
     * @param $id
     * @return mixed
     */
    public function show($id);

    /**
     * Save new
     *
     * @param User $user
     * @param array $brands
     * @return User|\Illuminate\Http\JsonResponse|mixed
     */
    public function save(User $user, $brands = []);


    /**
     * Update by id
     *
     * @param User $user
     * @return User|\Illuminate\Http\JsonResponse|mixed
     */
    public function update(User $user);

    /**
     * Delete
     *
     * @param $id
     * @return User|\Illuminate\Http\JsonResponse|mixed
     */
    public function delete($id);

    public function addUserBrand($userId, $brandId, $flag);
}