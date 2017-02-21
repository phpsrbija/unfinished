<?php
declare(strict_types = 1);
namespace Web\Factory\Legacy;

use Web\Legacy\StatutAction;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;


/**
 * Class StatutFactory.
 *
 * @package Web\Factory\Action
 */
class StatutFactory
{
    /**
     * Executed when factory is invoked.
     *
     * @param ContainerInterface $container container
     *
     * @return StatutAction
     */
    public function __invoke(ContainerInterface $container) : StatutAction
    {
        return new StatutAction(
            $container->get(TemplateRendererInterface::class)
        );
    }
}
