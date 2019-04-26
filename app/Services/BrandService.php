<?php

namespace App\Services;

use App\Brand;

interface BrandService
{
    /**
     * Find All
     *
     * @return Brand|\Illuminate\Http\JsonResponse|mixed
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
     * @param Brand $brand
     * @return Brand|\Illuminate\Http\JsonResponse|mixed
     */
    public function save(Brand $brand);


    /**
     * Update by id
     *
     * @param Brand $brand
     * @return Brand|\Illuminate\Http\JsonResponse|mixed
     */
    public function update(Brand $brand);

    /**
     * Delete
     *
     * @param $id
     * @return Brand|\Illuminate\Http\JsonResponse|mixed
     */
    public function delete($id);

    public function getByClientId($client_id);
}