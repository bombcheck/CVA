<?php

namespace App\Services\Impl;

use App\Brand;
use App\Filters\ApiRequest;
use App\Filters\FilterConstants;
use App\Services\BrandService;

class BrandServiceImpl implements BrandService
{
    private $allowFilters = [
    'exact' =>FilterConstants::BRAND_EXACT,
    'partial' => FilterConstants::BRAND_PARTIAL,
    ];
    private $allowIncludes = FilterConstants::BRAND_INCLUDES;

    /**
     * Find All
     *
     * @return Brand|\Illuminate\Http\JsonResponse|mixed
     */
    public function findAll()
    {
        $brands = ApiRequest::applyQuery($this->allowFilters,$this->allowIncludes,Brand::class)->orderBy('created_at')->get();
        return $brands;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        Brand::findOrFail($id);
        return ApiRequest::applyQuery([],$this->allowIncludes,Brand::class)
            ->where('id',$id)
            ->first();
    }

    /**
     * Save new
     *
     * @param Brand $brand
     * @return Brand|\Illuminate\Http\JsonResponse|mixed
     */
    public function save(Brand $brand)
    {
        $brand->save();

        return $brand;
    }

    /**
     * Update by id
     *
     * @param Brand $brand
     * @return Brand|\Illuminate\Http\JsonResponse|mixed
     */
    public function update(Brand $brand)
    {
        $brand->update();

        return $brand;
    }

    /**
     * Delete
     *
     * @param $id
     * @return Brand|\Illuminate\Http\JsonResponse|mixed
     */
    public function delete($id)
    {
        $brand = Brand::findOrFail($id);

        $brand->delete();
    }

    public function getByClientId($client_id)
    {
        return ApiRequest::applyQuery($this->allowFilters, $this->allowIncludes, Brand::class)->where('client_id', $client_id)->orderBy('created_at')->get();
    }
}
