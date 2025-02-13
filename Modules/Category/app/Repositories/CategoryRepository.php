<?php

namespace Modules\Category\Repositories;

use App\Helper\Helpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Modules\Category\Models\Category;
use Symfony\Component\HttpFoundation\Response;
use Modules\Category\Interfaces\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{

    public function getAllCategories(): JsonResponse
    {
        try {
            $categories = Category::withCount('books')->get();
            return Helpers::successResponse('Book retrieved successfully.', $categories);
        } catch (\Exception $ex) {
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse('Failed to retrieved categories. Please try again.');
        }
    } //end of getAllCategories

    public function getCategoryById(int $id): JsonResponse
    {
        try {
            $category = $this->findCategory($id);
            return Helpers::successResponse('book found', $category);
        } catch (\Exception $ex) {
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse();
        }
    } //end of getCategoryById

    public function createCategory($request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $category        = new Category();
            $category->name  = $request->name;
            $category->save();
            DB::commit();
            return Helpers::successResponse('create category successfully.', $category, Response::HTTP_CREATED);
        } catch (\Exception $ex) {
            DB::rollBack();
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse('Failed to create category. Please try again.');
        }
    } //end of createCategory

    public function updateCategory($id, $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $category = $this->findCategory($id);
            $category->name  = $request->name;
            $category->save();
            DB::commit();
            return Helpers::successResponse('update category successfully.', $category);
        } catch (\Exception $ex) {
            DB::rollBack();
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse();
        }
    } //end of updateCategory

    public function deleteCategory(int $id): JsonResponse
    {
        try {
            $category = $this->findCategory($id);
            $category->delete();
            return Helpers::successResponse('category deleted successfully.');
        } catch (\Exception $ex) {
            Helpers::logErrorDetails($ex);
            return Helpers::serverErrorResponse();
        }
    } //end of deleteCategory

    private function findCategory(int $id)
    {
        $category = Category::find($id);
        if (!$category) {
            throw new \Exception('category not found with the given ID.');
        }
        return $category;
    } //end of findCategory
}
