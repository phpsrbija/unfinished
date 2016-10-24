<?php
declare(strict_types = 1);
namespace Core\Factory\Middleware;

use Core\Middleware\ErrorNotFound;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class ErrorNotFoundFactory.
 *
 * @package Core\Factory\Middleware
 */
class ErrorNotFoundFactory
{
    /**
     * Executed when factory is invoked.
     *
     * @param ContainerInterface $container container
     *
     * @return ErrorNotFound
     */
    public function __invoke(ContainerInterface $container) : ErrorNotFound
    {
        return new ErrorNotFound(
            $container->get(TemplateRendererInterface::class)
        );
    }
}
