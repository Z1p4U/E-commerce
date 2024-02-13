<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\Website\EditProfileRequest;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Lcobucci\JWT\Exception;
use Laravel\Passport\Token;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminController extends Controller
{
    public function showAdminLists()
    {
        DB::beginTransaction();
        try {
            $admins = Admin::searchQuery()
                ->sortingQuery()
                ->paginationQuery();

            return $this->success("Admin Lists", $admins);
        } catch (Exception $e) {
            DB::rollback();

            return $e;
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function adminProfile()
    {
        $profile = Admin::where("id", Auth::id())->latest("id")->get();

        return response()->json([
            "message" => "Admin Profile",
            "admin-profile" => $profile
        ]);
    }

    public function checkAdminProfile($id)
    {
        $admin = Admin::find($id);

        if (is_null($admin)) {
            return response()->json([
                "error" => "Admin not found"
            ], 404);
        }

        return response()->json([
            "message" => "Admin",
            "admin" => $admin
        ]);
    }

    public function showUserLists()
    {
        $users = User::searchQuery()
            ->sortingQuery()
            ->paginationQuery();

        return $this->success("User Lists", $users);
    }

    public function checkUserProfile($id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return response()->json([
                "error" => "User not found"
            ], 404);
        }

        return response()->json([
            "message" => "User",
            "users" => $user
        ]);
    }

    public function editUserProfile(EditProfileRequest $request, $id)
    {
        $payload = collect($request->validated());

        DB::beginTransaction();

        try {
            $user = User::find($id);
            if (is_null($user)) {
                return response()->json([
                    "message" => "User not found"
                ]);
            }

            $user->update($payload->toArray());

            DB::commit();

            return $this->success('User updated successfully', $user);
        } catch (Exception $e) {
            DB::rollback();

            return $e;
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function changeUserPassword(Request $request, $id)
    {
        $validated = $request->validateWithBag('updatePassword', [
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);

            $user->update(['password' => bcrypt($validated['password'])]);

            DB::commit();

            return $this->success('User password successfully changed', $user);
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            $errorMessage = 'User not found';
            return response()->json(['error' => $errorMessage], 404);
        } catch (Exception $e) {
            DB::rollback();
            return $e;
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function refreshToken()
    {
        $token = JWTAuth::parseToken()->refresh();

        return response()->json([
            'token' => $token,
        ]);
    }
}
