<?php

declare(strict_types=1);

namespace Web\Factory\Action;

use Interop\Container\ContainerInterface;
use Page\Service\PageService;
use Web\Action\PageAction;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class PageActionFactory.
 */
class PageActionFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @return PageAction
     */
    public function __invoke(ContainerInterface $container): PageAction
    {
        return new PageAction(
            $container->get(TemplateRendererInterface::class),
            $container->get(PageService::class)
        );
    }
}
