<?php
declare(strict_types = 1);
namespace Web\Factory\Action;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class TemplateFactory.
 *
 * @package Web\Factory\Action
 */
class TemplateFactory
{
    /**
     * Executed when factory is invoked.
     *
     * @param ContainerInterface $container     container
     * @param string             $requestedName requested name
     *
     * @return mixed
     */
    public function __invoke(ContainerInterface $container, $requestedName)
    {
        // check if class exist
        
        return new $requestedName(
            $container->get(TemplateRendererInterface::class)
        );
    }
}
