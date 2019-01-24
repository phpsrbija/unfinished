<?php

namespace MeetupRegister\Web\Action;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface as Template;

class FormActionFactory
{
    public function __invoke(ContainerInterface $container): FormAction
    {
        return new FormAction(
            $container->get(Template::class)
        );
    }
}