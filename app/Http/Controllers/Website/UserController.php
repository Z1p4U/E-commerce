<?php

namespace App\Http\Controllers\Website;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends WebController
{
    public function profile()
    {
        $profile = User::find(Auth::id());
        if (!$profile) {
            return $this->notFound("User not found");
        }
        return $this->success("Your Profile", $profile);
    }

    public function userProfile(string $id)
    {
        $profile = User::find($id);
        if (!$profile) {
            return $this->notFound("User not found");
        }
        return $this->success("User Profile", $profile);
    }
}
