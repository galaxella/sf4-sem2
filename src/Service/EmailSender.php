<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

/**
 * Service chargé de créer et envoyer des emails
 */
class EmailSender
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {

        $this->mailer = $mailer;
    }

    /**
     * Créer un email préconfiguré
     * @param string $subjet Le sujet du mail
     */
    private function createTemplatedEmail(string $subjet): TemplatedEmail
    {
        return (new TemplatedEmail())
            ->from(new Address('galaxella8@gmx.com', 'gala'))  # Expéditeur #
            ->subject("\u{1F3A7} Kritik | $subjet")  # objet de l'email #
            ;
    }

    /**
     * Envoyer un email de confirmation de compte suite à l'inscription
     * $param User $user     l'utilisateur devant confirmer son compte
     */
    public function sendAccountConfirmationEmail(User $user): void
    {
        $email = $this->createTemplatedEmail('Confirmation du compte')
            ->to(new Address($user->getEmail(), $user->getPseudo()))          # Déstinateur #
            ->htmlTemplate('email/account_confirmation.html.twig')    # template twig du message #
            ->context([                                                       # Variables du template #
                'user' => $user,
            ])
        ;

        // Envoi de l'email
        $this->mailer->send($email);
    }

}