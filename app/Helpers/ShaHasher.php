<?php

/**
 * Im not a author of this helper.
 */

namespace App\Helpers;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class ShaHasher implements HasherContract
{
    public function make($value, array $options = [])
    {
        $hash = sha1($value, true);
        $hash = sha1($hash);

        return '*'.strtoupper($hash);
    }

    /**
     * Check the given plain value against a hash.
     *
     * @param string $value
     * @param string $hashedValue
     * @param array  $options
     *
     * @return bool
     */
    public function check($value, $hashedValue, array $options = [])
    {
        return $this->make($value) === $hashedValue;
    }

    /**
     * Check if the given hash has been hashed using the given options.
     *
     * @param string $hashedValue
     * @param array  $options
     *
     * @return bool
     */
    public function needsRehash($hashedValue, array $options = [])
    {
        return false;
    }
}
