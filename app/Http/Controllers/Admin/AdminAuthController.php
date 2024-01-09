<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\Admin\AdminProfileRequest;
use App\Http\Requests\Admin\ChangeAdminPasswordRequest;
use App\Http\Requests\Admin\CreateAdminRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Lcobucci\JWT\Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminAuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $payload = collect($request->validated());

        try {
            $token = auth()->attempt($payload->toArray());

            if ($token) {
                return $this->createNewToken($token);
            } else {
                return $this->unauthorized();
            }
        } catch (Exception $e) {
            return $e;
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function createAdmin(CreateAdminRequest $request)
    {
        $payload = collect($request->validated());
        $payload['password'] = bcrypt($payload['password']);

        DB::beginTransaction();

        try {

            $admin = Admin::create($payload->toArray());
            $admin->assignRole('admin');
            DB::commit();

            return $this->success('Admin created successfully', $admin);
        } catch (Exception $e) {
            DB::rollback();

            return $e;
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function editOwnProfile(AdminProfileRequest $request)
    {
        $payload = collect($request->validated());

        DB::beginTransaction();

        try {
            $admin = Admin::findOrFail(Auth::id());

            $admin->update($payload->toArray());

            DB::commit();

            return $this->success('Admin updated successfully', $admin);
        } catch (Exception $e) {
            DB::rollback();

            return $e;
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function editAdminProfile(AdminProfileRequest $request, $id)
    {
        $payload = collect($request->validated());

        DB::beginTransaction();

        try {
            $admin = Admin::find($id);
            if (is_null($admin)) {
                return response()->json([
                    "message" => "Admin not found"
                ]);
            }

            $admin->update($payload->toArray());

            DB::commit();

            return $this->success('Admin updated successfully', $admin);
        } catch (Exception $e) {
            DB::rollback();

            return $e;
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function changeAdminPassword(Request $request, $id)
    {
        $validated = $request->validateWithBag('updatePassword', [
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        DB::beginTransaction();

        try {
            $admin = Admin::findOrFail($id);
            $admin->update(['password' => bcrypt($validated['password'])]);

            DB::commit();

            return $this->success('Admin password successfully changed', $admin);
        } catch (Exception $e) {
            DB::rollback();
            return $e;
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function changeOwnPassword(Request $request)
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', "current_password"],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        DB::beginTransaction();

        try {
            $request->user()->update([
                'password' => bcrypt($validated['password']),
            ]);
            auth()->logout();

            DB::commit();

            return $this->success('Admin password successfully changed');
        } catch (Exception $e) {
            DB::rollback();
            return $e;
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    protected function createNewToken($token)
    {
        return $this->success('Admin successfully signed in', [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 3600,
            'admin' => auth()->user(),
        ]);
    }

    public function refreshToken()
    {
        $token = JWTAuth::parseToken()->refresh();

        return response()->json([
            'token' => $token,
        ]);
    }

    public function logout()
    {
        auth()->logout();

        return $this->success('You Successfully signed out', null);
    }
}
