<?php
namespace Application\Model;

use Laminas\Mail\Message;
use Laminas\Mail\Transport\Sendmail;

class Emailer {
    /**
     * The email address of the membership secretary.
     */
    const MEMBERSHIP_EMAIL = "test@gmail.com";

    /**
     * The 'from' name people will see on the email.
     */
    const FROM_NAME = "Testie McTestFace";

    public function sendMail($address, $name, $subject, $message, $from = self::MEMBERSHIP_EMAIL, $fromName = self::FROM_NAME) {
        $mail = new Message();
        $mail->setBody($message);
        $mail->setFrom($from, $fromName);
        $mail->addTo($address, $name);
        $mail->setSubject($subject);

        $transport = new Sendmail();
        $transport->send($mail);
    }
}