<?php

namespace Modules\Admin\Interfaces;

interface AdminSoftDeleteInterface
{
    // soft delete a user, marking the record as deleted without permanent removal.
    public function softDeleteUsers($modelName, int $id);

    // retrieve all soft-deleted users or a specific soft-deleted user.
    public function getTrashedUsers($modelName);

    // restored specific user from trashed.
    public function restoredUser($modelName, int $id);

    // permanently delete a user, removing the record from storage.
    public function forceDeleteUser($modelName, int $id);
} // end of interface
