<?php
namespace Application\Model;

use Laminas\Mail\Message;
use Laminas\Mail\Transport\Sendmail;
use Laminas\Mail\Headers;

class Emailer {
    /**
     * The email address of the membership secretary.
     */
    const MEMBERSHIP_EMAIL = "membership@tatasteelsailing.org.uk";

    /**
     * The 'from' name people will see on the email.
     */
    const FROM_NAME = "Tata Steel Sailing Club";

    public function sendMail($address, $name, $subject, $message, $from = self::MEMBERSHIP_EMAIL, $fromName = self::FROM_NAME) {
        $mail = new Message();
        $mail->setBody($message);
        $mail->setFrom($from, $fromName);
        $mail->addTo($address, $name);
        $mail->setSubject($subject);
        $mail->getHeaders()
        ->addHeaderLine('Content-Type', 'text/html')
        ->addHeaderLine('charset', 'UTF-8');

        $transport = new Sendmail();
        $transport->send($mail);
    }
}