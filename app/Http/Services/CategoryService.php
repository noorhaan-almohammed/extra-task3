<?php
namespace App\Http\Services;

use Exception;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryService
{

    public function listCategories()
    {
        try {
            return Category::paginate(5);
        } catch (Exception $e) {
            Log::error('Error Founding Categories' . $e->getMessage());
            throw new Exception('There is something wrong with server');
        }
    }
    public function createCategory(array $category)
    {
        try {
            return Category::create($category);
        } catch (Exception $e) {
            Log::error('Error Creating Category' . $e->getMessage(), ['category' => $category]);
            throw new Exception('There is something wrong with server');
        }
    }
    public function updateCategory(array $data, Category $category)
    {
        try {
            $category->name = $data['name'] ?? $category->name;
            $category->description = $data['description'] ?? $category->description;
            $category->save();
            return $category;
        } catch (Exception $e) {
            Log::error('Error Updating Category' . $e->getMessage(), ['category' => $category]);
            throw new Exception('There is something wrong with server');
        }
    }
    public function destroy(Category $category)
    {
        try {
            return $category->delete();
        } catch (Exception $e) {
            Log::error('Error Deleting Category' . $e->getMessage());
            throw new Exception('There is something wrong with server');
        }
    }
}

