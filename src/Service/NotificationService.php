<?php

namespace App\Service;

use App\Entity\Booking;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class NotificationService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    // Email pour informer l'hôte d'une nouvelle réservation
    public function sendNewBooking(Booking $booking): void
    {
        $email = (new TemplatedEmail())
            ->from('contact@bnb.fr')
            ->to($booking->getRoom()->getHost()->getEmail())
            ->priority(Email::PRIORITY_HIGH)
            ->subject('New booking : ' . $booking->getNumber())
            ->htmlTemplate('emails/new-booking.html.twig')
        ;
        $this->mailer->send($email);
    }

    // Email pour la confirmation de reservation par l'hote

    // Email pour la confirmation de reservation

    // Email pour pour la confirmation de paiement
}