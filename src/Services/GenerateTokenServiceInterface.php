<?php

declare(strict_types=1);

namespace App\Services;

interface GenerateTokenServiceInterface
{
    /**
     * @param int $length
     * @return mixed
     */
    public function generateToken(int $length): mixed;
}
