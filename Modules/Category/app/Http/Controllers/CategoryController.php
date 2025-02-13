<?php

namespace Modules\Category\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Category\Http\Requests\CreateCategoryRequest;
use Modules\Category\Http\Requests\EditCategoryRequest;
use Modules\Category\Interfaces\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    protected CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    } //end of __construct

    public function index()
    {
        return $this->categoryRepository->getAllCategories();
    } // end of index

    public function store(CreateCategoryRequest $request)
    {
        return $this->categoryRepository->createCategory($request);
    } //end of store

    public function show(int $id)
    {
        return $this->categoryRepository->getCategoryById($id);
    } //end of show

    public function update(EditCategoryRequest $request, int $id)
    {
        return $this->categoryRepository->updateCategory($id, $request);
    } //end of update

    public function destroy(int $id)
    {
        return $this->categoryRepository->deleteCategory($id);
    } //end of destroy
}
