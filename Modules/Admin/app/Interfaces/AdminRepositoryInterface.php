<?php

namespace Modules\Admin\Interfaces;

interface AdminRepositoryInterface
{
    public function getAllAdmin();
    public function getAllPublisher();
    public function getAllCustomer();
    public function showUser($modelResource, $modelName, int $id);
    public function adminProfile(int $id);
    public function create($request);
    public function editUser($modelName, $modelResource, int $id, $request);
    public function destroy(int $id);
} // end of interface
