<?php

declare(strict_types=1);

namespace App\Services;

use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class MailerService implements MailerServiceInterface
{
    /**
     * @param MailerInterface $mailer
     * @param LoggerInterface $logger
     */
    public function __construct(
        private MailerInterface $mailer,
        private LoggerInterface $logger
    ) {
    }

    /**
     * @param string $from
     * @param string $to
     * @param string $subject
     * @param string $htmlTemplate
     * @param string $textTemplate
     * @param array $params
     * @return void
     */
    public function send(string $from, string $to, string $subject, string $htmlTemplate, string $textTemplate, array $params): void
    {
        $email = (new TemplatedEmail())
            ->from($from)
            ->to(new Address($to))
            ->subject($subject)
            ->htmlTemplate($htmlTemplate)
            ->textTemplate($textTemplate)
            ->context($params);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $exception) {
            $this->logger->error("Un problème est survenue lors de l'envoye de mail", [
                'exception' => $exception,
            ]);
        }
    }
}
