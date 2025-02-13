<?php

namespace Modules\Roles\Http\Controllers;

use App\Helper\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    public function getAllPermissions()
    {
        $permissions = Permission::all();
        return Helpers::successResponse(null, $permissions);
    }
}
