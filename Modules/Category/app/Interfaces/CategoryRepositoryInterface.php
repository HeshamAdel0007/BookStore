<?php

namespace Modules\Category\Interfaces;

interface CategoryRepositoryInterface
{
    public function getAllCategories();
    public function getCategoryById(int $id);
    public function createCategory($request);
    public function updateCategory(int $id, $request);
    public function deleteCategory(int $id);
}
