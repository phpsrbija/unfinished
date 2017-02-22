<?php
declare(strict_types = 1);
namespace Web\Factory\Legacy;

use Web\Legacy\SingleAction;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Core\Service\Article\PostService;


/**
 * Class SingleFactory.
 *
 * @package Web\Factory\Action
 */
class SingleFactory
{
    /**
     * Executed when factory is invoked.
     *
     * @param ContainerInterface $container container
     *
     * @return SingleAction
     */
    public function __invoke(ContainerInterface $container) : SingleAction
    {
        return new SingleAction(
            $container->get(TemplateRendererInterface::class),
            $container->get(PostService::class)
        );
    }
}
