<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\User\EditProfileRequest;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Lcobucci\JWT\Exception;

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

    public function changeUserPassword(ChangePasswordRequest $request, $id)
    {
        $payload = collect($request->validated());
        $payload['password'] = bcrypt($payload['password']);

        DB::beginTransaction();

        try {
            $admin = User::findOrFail($id);

            $admin->update($payload->toArray());

            DB::commit();

            return $this->success('User password successfully changed', $admin);
        } catch (Exception $e) {
            DB::rollback();
            return $e;
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
