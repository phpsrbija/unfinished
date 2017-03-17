<?php
declare(strict_types = 1);
namespace Web\Factory\Legacy;

use Web\Legacy\IndexAction;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;


/**
 * Class IndexFactory.
 *
 * @package Web\Factory\Action
 */
class IndexFactory
{
    /**
     * Executed when factory is invoked.
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
