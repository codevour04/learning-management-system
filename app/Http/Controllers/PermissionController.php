<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(): JsonResponse
    {
        $permission = Permission::select(["id", "name"])->get();

        return response()->json($permission);
    }

    public function fetch(): JsonResponse
    {
        $permissions = Permission::select(["id", "name"])->get();

        return response()->json($permissions);
    }
}
