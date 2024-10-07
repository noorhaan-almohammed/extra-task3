<?php

namespace App\Http\Controllers\Editor;

use App\Models\User;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Services\CategoryService;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\Category\storeCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->categoryService->listCategories();
        if ($categories->isEmpty()) {
            return parent::errorResponse("No Categories Found", 404);
        }
        return parent::successResponse('Categories',
        CategoryResource::collection($categories)->response()->getData(true),  // response with Metadata
                                               "Categories retrieved successfully",
                                               200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(storeCategoryRequest $categoryRequest)
    {
        $this->authorize('create_book', User::class);
        $category = $categoryRequest->validated();
        $response = $this->categoryService->createCategory($category);
        return parent::successResponse('categories', new CategoryResource($response), "Category created successfully", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return parent::successResponse('category', new CategoryResource($category), "Category retrieved successfully", 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $categoryRequest, Category $category)
    {
        $data = $categoryRequest->validated();
        $response = $this->categoryService->updateCategory($data, $category);
        return parent::successResponse('categories', new CategoryResource($response), "Category updated successfully", 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->categoryService->destroy($category);
        return parent::successResponse('category', new CategoryResource($category), "Category Deleted successfully", 200);
    }
}
