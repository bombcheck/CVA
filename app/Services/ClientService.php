<?php

namespace App\Services;


use App\Client;

interface ClientService
{
    /**
     * Find All
     *
     * @return Client|\Illuminate\Http\JsonResponse|mixed
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
     * @param Client $client
     * @return Client|\Illuminate\Http\JsonResponse|mixed
     */
    public function save(Client $client);


    /**
     * Update by id
     *
     * @param Client $client
     * @return Client|\Illuminate\Http\JsonResponse|mixed
     */
    public function update(Client $client);

    /**
     * Delete
     *
     * @param $id
     * @return Client|\Illuminate\Http\JsonResponse|mixed
     */
    public function delete($id);
}