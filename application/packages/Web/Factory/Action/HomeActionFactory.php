<?php

declare(strict_types=1);

namespace Web\Factory\Action;

use Page\Service\PageService;
use Web\Action\HomeAction;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class HomeActionFactory.
 *
 * @package Web\Factory\Action
 */
class HomeActionFactory
{
    /**
     * @param ContainerInterface $container
     * @return HomeAction
     */
    public function __invoke(ContainerInterface $container): HomeAction
    {
        return new HomeAction(
            $container->get(TemplateRendererInterface::class),
            $container->get(PageService::class)
        );
    }
}
