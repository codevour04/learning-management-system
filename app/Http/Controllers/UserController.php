<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $has_search = $request->keyword;

        $user = User::select(["id", "name", "email"])
            ->with("permissions")
            ->when($has_search,
            function ($query) use ($has_search) {
                $query->where('name', 'LIKE', "$has_search%");
            })
            ->orderBy("created_at", "DESC")
            ->get();

        return response()->json($user);
    }

    public function getAuthUser()
    {
        $user = User
            ::select('id', 'name', 'email')
            ->with('permissions:id,name')
            ->where('id', Auth::user()->id)
            ->firstOrFail();

        return response()->json($user);
    }

    public function store(Request $request): void
    {
        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);
    }

    public function update(User $user, Request $request): void
    {
        $user->update([
            "name" => $request->name,
            "email" => $request->email
        ]);
    }

    public function destroy(User $user): void
    {
        $user->delete();
    }

    public function givePermissionTo(User $user, Request $request): void
    {
        if ($request->action === "add") {
            if ($user->hasPermissionTo($request->permission_name)) {
                //do nothing
            } else {
                $user->givePermissionTo($request->permission_name);
            }
        } else {
            $user->revokePermissionTo($request->permission_name);
        }
    }

    public function getAuthUserPermissions(): JsonResponse
    {
        $user = User::findOrFail(Auth::user()->id);

        return response()->json($user->getPermissionNames());
    }

    public function getPermissionsUser(User $user): JsonResponse
    {
        $permission_names = User::findOrFail($user->id)->getPermissionNames();

        return response()->json($permission_names);
    }

    public function logout()
    {
        Session::flush();

        Auth::logout();

        return redirect('login');
    }
}
