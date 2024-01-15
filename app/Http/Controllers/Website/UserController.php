<?php

namespace App\Http\Controllers\Website;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends WebController
{
    public function profile()
    {
        $profile = User::where("id", Auth::id())->latest("id")->get();

        return $this->success("Your Profile", $profile);
    }

    public function userProfile(string $id)
    {
        $profile = User::where("id", $id)->latest("id")->get();

        return $this->success("User Profile", $profile);
    }
}
