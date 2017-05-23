<?php

declare(strict_types=1);

namespace Newsletter\Web\Action;

use Interop\Container\ContainerInterface;
use Newsletter\Service\NewsletterService;

class HandlePostActionFactory
{
    public function __invoke(ContainerInterface $container): HandlePostAction
    {
        return new HandlePostAction(
            $container->get(NewsletterService::class)
        );
    }
}
