<?php

declare(strict_types=1);
namespace MeetupRegister\Service;

use MeetupRegister\Filter\RegisterFilter;
use Std\FilterException;
use ReCaptcha\ReCaptcha;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Message;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

class RegisterService
{
    private $filter;

    private $captcha;

    private $mailTransport;

    public function __construct(RegisterFilter $filter, ReCaptcha $captcha, SmtpTransport $mailTransport)
    {
        $this->filter = $filter;
        $this->captcha = $captcha;
        $this->mailTransport  = $mailTransport;
    }

    public function sendNotice($data)
    {
        $resp = $this->captcha->verify($data['g-recaptcha-response'], $data['clientIp']);
        if ($resp->isSuccess()) {

        } else {
//            $errors = $resp->getErrorCodes();

            throw new \Exception('Captcha was not solved properly.', 400);
        }

        $filter = $this->filter->getInputFilter()->setData($data);

        if (!$filter->isValid()) {
            throw new FilterException($filter->getMessages(), 400);
        }

        $data = $filter->getValues();
        $htmlString = '<h1>Nova prijava za meetup predavače!</h1><br/><br/>';
        foreach ($data as $title => $userInput) {
            $htmlString .= "$title: $userInput<br/>";
        }

        $this->sendEmail($htmlString);

        return true;
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
        $message->setSubject('Nova prijava za meetup predavače :)');

        $this->mailTransport->send($message);
    }
}