<?php

namespace App\Http\Controllers\Website;

use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends WebController
{

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Fetch the user
        $user = User::where('email', $request->email)->first();

        if (is_null($user)) {
            return $this->notFound('Email not found');
        }

        // Generate 6-digit token
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $token = '';
        for ($i = 0; $i < 6; $i++) {
            $token .= $characters[rand(0, $charactersLength - 1)];
        }

        // Hash the token
        // $hashedToken = bcrypt($token);

        // Store token in password_resets table
        PasswordReset::updateOrCreate(
            ['email' => $user->email],
            [
                'token' => $token,
                'created_at' => now()
            ]
        );

        // Send password reset email
        $expiration = 10; // Assuming this is the expiration time in minutes
        $user->sendPasswordResetNotification($token, $user->name, $expiration);

        return $this->success('Password reset token has been sent to the provided email.');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $token = $request->token;
        $password = $request->password;

        // Hash the token before searching for it
        // $hashedToken = bcrypt($token);

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
        PasswordReset::where('token', $token)->delete();

        return response()->json(['message' => 'Password has been reset successfully']);
    }
}
