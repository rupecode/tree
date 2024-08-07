<?php

namespace App\Services;

class PasswordService
{
    public function hash(string $value): string
    {
        return sha1($value . '.salt');
    }
}