<?php

namespace App\Services;

interface GenerateTokenServiceInterface
{
    public function generateToken(int $length);
}