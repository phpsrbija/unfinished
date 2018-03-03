<?php

declare(strict_types=1);
namespace MeetupRegister\Service;

use MeetupRegister\Filter\RegisterFilter;
use Std\FilterException;
use ReCaptcha\ReCaptcha;
use Symfony\Component\Config\Definition\Exception\Exception;

class RegisterService
{
    private $filter;

    private $captcha;

    public function __construct(RegisterFilter $filter, ReCaptcha $captcha)
    {
        $this->filter = $filter;
        $this->captcha = $captcha;
    }

    public function sendNotice($data)
    {
        $resp = $this->captcha->verify($data['g-recaptcha-response'], $data['clientIp']);
        if ($resp->isSuccess()) {

        } else {
//            $errors = $resp->getErrorCodes();

            throw new Exception('Captcha was not solved properly.', 400);
        }

        $filter = $this->filter->getInputFilter()->setData($data);

        if (!$filter->isValid()) {
            throw new FilterException($filter->getMessages(), 400);
        }

        $data = $filter->getValues();

        return true;
    }
}