<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send($toEmail, $toName, $subject, $content)
    {
        $email = (new Email())
            ->from('mailtrap@demomailtrap.com')
            ->to($toEmail)
            ->subject($subject)
            ->html($content);

        $this->mailer->send($email);
    }
}
