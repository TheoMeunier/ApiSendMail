<?php

declare(strict_types=1);

namespace App\Services;

class GenerateTokenService implements GenerateTokenServiceInterface
{
    /**
     * @param int $length
     * @return string
     */
    public function generateToken(int $length = 16): string
    {
        $permitted_chart = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $random_string = '';

        for ($i = 0; $i < $length; $i++) {
            $random_character = $permitted_chart[mt_rand(0, $length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
    }
}
