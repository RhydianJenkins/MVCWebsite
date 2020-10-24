<?php
namespace Application\Model;

use Laminas\Mail\Message;
use Laminas\Mail\Transport\SendMail;
use Laminas\Mail\Headers;
use Laminas\Mime\Message as MimeMessage;
use Laminas\Mime\Mime;
use Laminas\Mime\Part as MimePart;

class Emailer {
    /**
     * The email address of the membership secretary.
     */
    const MEMBERSHIP_EMAIL = "membership@tatasteelsailing.org.uk";

    /**
     * The 'from' name people will see on the email.
     */
    const FROM_NAME = "Tata Steel Sailing Club";

    /**
     * Sends an email.
     */
    public function sendMail($address, $name, $subject, $html, $text = NULL, $from = self::MEMBERSHIP_EMAIL, $fromName = self::FROM_NAME) {
        if ($text === NULL) {
            $text = $html;
        }

        $html = new MimePart($text);
        $html->type = Mime::TYPE_HTML;

        $text = new MimePart($text);
        $text->type = Mime::TYPE_TEXT;

        $body = new MimeMessage();
        $body->setParts([$text, $html]);

        $message = new Message();
        $message->setBody($body);
        $message->setFrom($from, $fromName);
        $message->addReplyTo(self::MEMBERSHIP_EMAIL, self::FROM_NAME);
        $message->addTo($address, $name);
        $message->setSubject($subject);

        $contentTypeHeader = $message->getHeaders()->get('Content-Type');
        $contentTypeHeader->setType('multipart/alternative');

        $transport = new SendMail();
        $transport->send($message);
    }
}