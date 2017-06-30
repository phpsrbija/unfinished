<?php
declare(strict_types = 1);
namespace Admin\Factory\Action;

use Admin\Action\IndexAction;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Class IndexFactory.
 *
 * @package Admin\Factory\Action
 */
final class IndexFactory
{
    /**
     * Factory method.
     *
     * @param ContainerInterface $container container
     *
     * @return IndexAction
     */
    public function __invoke(ContainerInterface $container) : IndexAction
    {
        return new IndexAction(
            $container->get(TemplateRendererInterface::class)
        );
    }
}
