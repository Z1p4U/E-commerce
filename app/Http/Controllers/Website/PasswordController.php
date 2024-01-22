<?php

namespace App\Http\Controllers\Website;

use App\Mail\CustomResetPasswordMail;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset as EventsPasswordReset;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        // Generate 6-digit token
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $token = '';
        for ($i = 0; $i <= 6; $i++) {
            $token .= $characters[rand(0, $charactersLength - 1)];
        }

        // Store token in password_resets table
        PasswordReset::updateOrCreate(
            ['email' => $user->email],
            ['token' => $token, 'created_at' => now()],
        );

        // Send password reset email
        $expiration = 10;
        $user->sendPasswordResetNotification($token, $userName, $expiration);

        return $this->success('Password reset token has been sent to provided email.');
    }


    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $token = $request->input('token');
        $password = $request->input('password');

        $resetRecord = PasswordReset::where('token', $token)->first();

        if (!$resetRecord) {
            return response()->json(['error' => 'Invalid reset code'], 404);
        }

        // Check if the reset token is expired
        $createdAt = strtotime($resetRecord->created_at);
        $expiresAt = $createdAt + (10 * 60); // 10 minutes expiration time
        $now = time();

        if ($now > $expiresAt) {
            return response()->json(['error' => 'Reset token has expired'], 422);
        }

        // Update the user's password
        $user = User::where("email", $resetRecord->email)->first();
        $user->password = Hash::make($password);
        $user->save();

        // Delete the reset token record
        DB::table('password_resets')->where('token', $token)->delete();

        return response()->json(['message' => 'Password has been reset successfully']);
    }
}
