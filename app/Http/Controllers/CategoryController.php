<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Services\CategoryService;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CategoryController extends Controller
{
    private CategoryService $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    public function index(): AnonymousResourceCollection
    {
        return CategoryResource::collection($this->service->list());
    }

    public function store(CategoryRequest $request): CategoryResource
    {
        $category = $this->service->create($request->validated());
        return new CategoryResource($category);
    }

    public function show(int $id): CategoryResource
    {
        $category = $this->service->get($id);
        return new CategoryResource($category->load('products'));
    }

    public function update(CategoryRequest $request, int $id): CategoryResource
    {
        $category = $this->service->update($id, $request->validated());
        return new CategoryResource($category);
    }

    public function destroy(int $id): Response
    {
        $this->service->delete($id);
        return response(null, ResponseAlias::HTTP_NO_CONTENT);
    }
}
