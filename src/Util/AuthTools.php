<?php

namespace App\Util;

/**
 * Authentication tools (such as PIN checker)
 * @package App\Util
 */
class AuthTools
{
    private $passwordHash;

    public function __construct($passwordHash)
    {
        $this->passwordHash = $passwordHash;
    }

    public function isValidPassword($password) {
        return md5($password) == $this->passwordHash;
    }
}