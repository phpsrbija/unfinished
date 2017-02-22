<?php
declare(strict_types = 1);
namespace Web\Factory\Legacy;

use Web\Legacy\AboutAction;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;


/**
 * Class AboutFactory.
 *
 * @package Web\Factory\Action
 */
class AboutFactory
{
    /**
     * Executed when factory is invoked.
     *
     * @param ContainerInterface $container container
     *
     * @return AboutAction
     */
    public function __invoke(ContainerInterface $container) : AboutAction
    {
        return new AboutAction(
            $container->get(TemplateRendererInterface::class)
        );
    }
}
