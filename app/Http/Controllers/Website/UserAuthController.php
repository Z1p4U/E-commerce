<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Website\WebController;
use App\Http\Requests\ChangePasswordRequest;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\User\EditProfileRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Lcobucci\JWT\Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserAuthController extends WebController
{

    public function register(RegisterRequest $request)
    {
        $payload = collect($request->validated());
        $payload['password'] = bcrypt($payload['password']);

        DB::beginTransaction();

        try {

            $user = User::create($payload->toArray());
            DB::commit();

            return $this->success('User created successfully', $user);
        } catch (Exception $e) {
            DB::rollback();

            return $e;
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function editProfile(EditProfileRequest $request)
    {
        $payload = collect($request->validated());

        DB::beginTransaction();

        try {
            $user = User::find(Auth::id());
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

    public function changePassword(ChangePasswordRequest $request, $id)
    {
        $payload = collect($request->validated());
        $payload['password'] = bcrypt($payload['password']);
        $authId = auth()->user()->id;

        if ($authId !== $id) {
            return $this->unauthenticated('you do not have permission to change password');
        }

        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);
            $user->update($payload->toArray());
            DB::commit();

            return $this->success('User is successfully change new password', $user);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

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

    public function logout()
    {
        auth()->logout();

        return $this->success('User successfully signed out', null);
    }

    protected function createNewToken($token)
    {
        return $this->success('User successfully signed in', [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 3600,
            'user' => auth()->user(),
        ]);
    }

    public function refreshToken()
    {
        $token = JWTAuth::parseToken()->refresh();

        return response()->json([
            'token' => $token,
        ]);
    }
}
