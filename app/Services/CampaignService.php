<?php

namespace App\Services;


use App\Campaign;

interface CampaignService
{
    /**
     * Find All
     *
     * @return Campaign|\Illuminate\Http\JsonResponse|mixed
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
     * @param Campaign $campaign
     * @return Campaign|\Illuminate\Http\JsonResponse|mixed
     */
    public function save(Campaign $campaign);


    /**
     * Update by id
     *
     * @param Campaign $campaign
     * @return Campaign|\Illuminate\Http\JsonResponse|mixed
     */
    public function update(Campaign $campaign);

    /**
     * Delete
     *
     * @param $id
     * @return Campaign|\Illuminate\Http\JsonResponse|mixed
     */
    public function delete($id);

    public function getByClientId($client_id);

    public function getByBrandId($brand_id);
}