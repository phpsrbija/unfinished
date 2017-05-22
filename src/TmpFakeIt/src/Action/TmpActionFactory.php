<?php

declare(strict_types = 1);

namespace TmpFakeIt\Action;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class TmpActionFactory.
 *
 * @package TmpFakeIt\Action
 */
class TmpActionFactory
{
    /**
     * @param ContainerInterface $container
     * @return TmpAction
     */
    public function __invoke(ContainerInterface $container): TmpAction
    {
        return new TmpAction(
            $container->get(TemplateRendererInterface::class)
        );
    }
}
