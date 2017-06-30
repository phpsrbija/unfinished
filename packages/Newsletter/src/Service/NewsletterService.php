<?php

declare(strict_types=1);

namespace Newsletter\Service;

use Newsletter\Mapper\NewsletterMapper;

class NewsletterService
{
    private $newsletterMapper;

    public function __construct(NewsletterMapper $newsletterMapper)
    {
        $this->newsletterMapper = $newsletterMapper;
    }

    public function registerNew($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Email is not valid!', 400);
        }

        $current = $this->newsletterMapper->select(['email' => $email])->current();

        if (!$current) {
            return $this->newsletterMapper->insert(['email' => $email]);
        }
    }
}
