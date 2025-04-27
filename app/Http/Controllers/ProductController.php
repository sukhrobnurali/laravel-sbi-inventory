<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Services\ProductService;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProductController extends Controller
{
    private ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index(): AnonymousResourceCollection
    {
        return ProductResource::collection($this->service->list());
    }

    public function store(ProductRequest $request): ProductResource
    {
        $product = $this->service->create($request->validated());
        return new ProductResource($product);
    }

    public function show(int $id): ProductResource
    {
        $product = $this->service->get($id);
        return new ProductResource($product);
    }

    public function update(ProductRequest $request, int $id): ProductResource
    {
        $product = $this->service->update($id, $request->validated());
        return new ProductResource($product);
    }

    public function destroy(int $id): Response
    {
        $this->service->delete($id);
        return response(null, ResponseAlias::HTTP_NO_CONTENT);
    }
}
