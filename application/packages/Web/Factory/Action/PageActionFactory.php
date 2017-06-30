<?php

declare(strict_types=1);

namespace Web\Factory\Action;

use Page\Service\PageService;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Web\Action\PageAction;

/**
 * Class PageActionFactory.
 *
 * @package Web\Factory\Action
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
