<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Services\MailerServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;

class MailerController extends AbstractController
{

    /**
     * @param MailerServiceInterface $mailerService
     * @param SerializerInterface $serializer
     */
    public function __construct(
        private MailerServiceInterface $mailerService,
        private SerializerInterface $serializer
    )
    {
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/api/contact', name: 'app_mailer', methods: 'POST')]
    public function contact(Request $request): JsonResponse
    {
        $json = $request->getContent();

        try {
            $contact = $this->serializer->deserialize($json, Contact::class, 'json');

            $this->mailerService->send(
                $contact->getFrom(),
                $contact->getTo(),
                $contact->getSubject(),
                'contact/contact.html.twig',
                'contact/contact.text.twig',
                ['contact' => $contact->getData()]
            );

            return $this->json($contact, 201);

        } catch (NotEncodableValueException $exception) {
            return $this->json([
                'status' => 400,
                'message' => $exception->getMessage()
            ], 400);
        }
    }
}
