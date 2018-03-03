<?php

declare(strict_types=1);

namespace Register\Service;

use Register\Filter\RegisterFilter;
use Std\FilterException;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Message;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

class RegisterService
{
    private $registerFilter;
    private $mailTransport;

    public function __construct(RegisterFilter $registerFilter, SmtpTransport $mailTransport)
    {
        $this->registerFilter = $registerFilter;
        $this->mailTransport  = $mailTransport;
    }

    public function handleRegistration($data)
    {
        $filter = $this->registerFilter->getInputFilter()->setData($data);

        if (!$filter->isValid()) {
            throw new FilterException($filter->getMessages());
        }

        $data       = $filter->getValues();
        $htmlString = '<h1>Nova prijava za članstvo!</h1><br/><br/>';
        foreach ($data as $title => $userInput) {
            $htmlString .= "$title: $userInput<br/>";
        }

        $this->sendEmail($htmlString);
    }

    private function sendEmail($htmlString)
    {
        $html       = new MimePart($htmlString);
        $html->type = "text/html";
        $body       = new MimeMessage();
        $body->addPart($html);

        $message = new Message();
        $message->setBody($body);
        $message->setFrom('pr@phpsrbija.rs');
        $message->addTo('pr@phpsrbija.rs');
        $message->setSubject('Nova prijava za članstvo :)');

        $this->mailTransport->send($message);
    }
}