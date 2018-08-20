<?php

namespace App\Services;

use Hash;
use App\Models\User;

class AccountService
{
    /**
     * Check given user password.
     */
    public function checkUserPasswordHash(string $hash, string $password)
    {
        return Hash::check($hash, $password) ? true : false;
    }

     /**
     * Check if new_email_token is correct. Compare two strings.
     */
    public function isNewEmailTokenCorrect(User $user, string $token)
    {
        return ($user->new_email_token() === $token) ? true : false;
    }

    /**
     * Make hash (using SHAHasher) from value.
     */
    public function makeHashFromString(string $value): string
    {
        return Hash::make($value);
    }

    /**
     * Generate PIN code.
     */
    public function generatePinCode(): string
    {
        return mt_rand(10000, 99999);
    }
}
