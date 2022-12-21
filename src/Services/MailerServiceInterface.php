<?php

declare(strict_types=1);

namespace App\Services;

interface MailerServiceInterface
{
    /**
     * @param string $from
     * @param string $to
     * @param string $subject
     * @param string $htmlTemplate
     * @param string $textTemplate
     * @param array $params
     * @return mixed
     */
    public function send(string $from, string $to, string $subject, string $htmlTemplate, string $textTemplate, array $params);
}
