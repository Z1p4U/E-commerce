<?php

namespace App\Traits;

trait RandomNumberGenerator
{
    public function generateRandomNumber($model, $column, $strCount)
    {
        // Define the characters to use for generating the random string
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);

        // Generate a random string
        $randomString = '';
        for ($i = 0; $i < $strCount; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        // Check if the generated voucher number already exists in the database
        $existingVoucher = $model::where($column, $randomString)->exists();

        // If the voucher number already exists, generate a new one recursively
        if ($existingVoucher) {
            return $this->generateRandomNumber($model, $column, $strCount);
        }

        // If the voucher number is unique, return it
        return $randomString;
    }
}
