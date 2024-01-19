<?php

namespace App\Http\Controllers\Website;

use App\Mail\CustomResetPasswordMail;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class PasswordController extends WebController
{

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        $userName = $user->name;

        if (is_null($user)) {
            return $this->notFound('Email not found');
        }

        // Generate 6-digit code
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $code = '';
        for ($i = 0; $i <= 6; $i++) {
            $code .= $characters[rand(0, $charactersLength - 1)];
        }

        // Store code in password_resets table
        PasswordReset::updateOrCreate(
            ['email' => $user->email],
            ['token' => Hash::make($code), 'created_at' => now()]
        );

        // Send password reset email
        $expiration = 10;
        $user->sendPasswordResetNotification($code, $userName, $expiration);

        return $this->success('Password reset code has been sent to provided email.');
    }


    public function reset(Request $request)
    {
        // Check if code is valid and not expired
        $passwordReset = PasswordReset::where('email', $request->email)->first();
        $expiresAt = now()->subMinutes(10);

        if (is_null($passwordReset) || !Hash::check($request->code, $passwordReset->token)) {
            return $this->validationError("Invalid Code", null);
        }
        if ($passwordReset->created_at < $expiresAt) {
            return $this->validationError("Code expired", null);
        }

        // Use the Password facade to reset the password
        $response = Password::broker()->reset(
            $this->credentials($request),
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        // Handle the response from the password broker (e.g., show success or error message)
        if ($response == Password::PASSWORD_RESET) {
            // Password reset was successful
            return $this->success(trans($response));
        } else {
            // Password reset failed
            return $this->validationError(trans($response), null);
        }


        // Delete the password reset record
        $passwordReset->delete();

        // Return a JSON response based on the password reset status
        return $response == Password::PASSWORD_RESET
            ? response()->json(['message' => trans($response)])
            : response()->json(['message' => trans($response)], 422);
    }
}
