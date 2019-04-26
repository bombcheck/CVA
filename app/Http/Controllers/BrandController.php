<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Http\Requests\BrandSaveRequest;
use App\Http\Requests\BrandUpdateRequest;
use App\Services\BrandService;

class BrandController extends Controller
{
    private $service;

    public function __construct(BrandService $brandService)
    {
        $this->service = $brandService;
    }

    public function index()
    {
        return $this->service->findAll();
    }

    public function show($id)
    {
        return $this->service->show($id);
    }

    public function store(BrandSaveRequest $request)
    {
        $brand = new Brand();

        $brand->name = $request->json("name");
        $brand->client_id = $request->json("client_id");

        return  $this->service->save($brand);
    }

    public function update(BrandUpdateRequest $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $brand->name = $request->json("name");
        $brand->client_id = $request->json("client_id");

        return $this->service->update($brand);
    }

    public function destroy($id)
    {
        return $this->service->delete($id);
    }

    public function getByClientId($client_id)
    {
        return $this->service->getByClientId($client_id);
    }
}
