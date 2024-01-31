<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Website\WebController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\Website\EditProfileRequest;
use App\Http\Requests\Website\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Lcobucci\JWT\Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserAuthController extends WebController
{

    public function login(LoginRequest $request)
    {
        $payload = collect($request->validated());

        try {
            $token = auth('api')->attempt($payload->toArray());

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

    public function register(RegisterRequest $request)
    {
        $payload = collect($request->validated());
        $payload['password'] = bcrypt($payload['password']);

        DB::beginTransaction();

        try {

            $user = User::create($payload->toArray());
            DB::commit();

            return $this->success('User registered successfully', $user);
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

    public function changePassword(Request $request)
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

            return $this->success('User password changed successfully');
        } catch (Exception $e) {
            DB::rollback();

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
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user(),
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
