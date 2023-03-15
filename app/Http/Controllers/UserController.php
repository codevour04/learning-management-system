<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $user = User::select(["id", "name", "email"])->orderBy("created_at", "DESC")->get();

        return response()->json($user);
    }

    public function getAuthUser(): JsonResponse
    {
        $user = User::findOrFail(Auth::user()->id);

        $data = [
            "user" => $user,
            "permissions" => $user->getPermissionNames()
        ];

        return response()->json($data);
    }

    public function store(Request $request): void
    {
        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);

        $user = User::select(["name", "email"])->get();
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

    public function logout()
    {
        Session::flush();

        Auth::logout();

        return redirect('login');
    }
}
