<?php

namespace App\Services\Impl;


use App\Filters\ApiRequest;
use App\Client;
use App\Filters\FilterConstants;
use App\Services\ClientService;

class ClientServiceImpl implements ClientService
{
    private $allowFilters = [
    'exact' =>FilterConstants::CLIENT_EXACT,
        'partial' => FilterConstants::CLIENT_PARTIAL
        ];
    private $allowIncludes = FilterConstants::CLIENT_INCLUDES;
    /**
     * Find All
     *
     * @return Client|\Illuminate\Http\JsonResponse|mixed
     */
    public function findAll()
    {
        $clients = ApiRequest::applyQuery($this->allowFilters,$this->allowIncludes,Client::class)->get();
        return $clients;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        Client::findOrFail($id);
        return ApiRequest::applyQuery([],$this->allowIncludes,Client::class)
            ->where('id',$id)
            ->first();
    }

    /**
     * Save new
     *
     * @param Client $client
     * @return Client|\Illuminate\Http\JsonResponse|mixed
     */
    public function save(Client $client)
    {
        $client->save();

        return $client;
    }

    /**
     * Update by id
     *
     * @param Client $client
     * @return Client|\Illuminate\Http\JsonResponse|mixed
     */
    public function update(Client $client)
    {
        $client->update();

        return $client;
    }

    /**
     * Delete
     *
     * @param $id
     * @return Client|\Illuminate\Http\JsonResponse|mixed
     */
    public function delete($id)
    {
        $client = Client::findOrFail($id);

        $client->delete();
    }
}
