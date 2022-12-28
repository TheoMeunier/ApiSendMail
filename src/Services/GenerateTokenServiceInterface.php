<?php

namespace App\Services;

interface GenerateTokenServiceInterface
{
    /**
     * @param int $length
     * @return mixed
     */
    public function generateToken(int $length): mixed;
}