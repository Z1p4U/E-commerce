<?php

namespace App\Http\Controllers\Website;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends WebController
{
    public function userProfile()
    {
        $profile = User::where("id", Auth::id())->latest("id")->get();

        return response()->json([
            "message" => "Your Profile",
            "user-profile" => $profile
        ]);
    }
}
