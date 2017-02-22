<?php
declare(strict_types = 1);
namespace Web\Factory\Legacy;

use Web\Legacy\JoinAction;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;


/**
 * Class SingleFactory.
 *
 * @package Web\Factory\Action
 */
class JoinFactory
{
    /**
     * Executed when factory is invoked.
     *
     * @param ContainerInterface $container container
     *
     * @return JoinAction
     */
    public function __invoke(ContainerInterface $container) : JoinAction
    {
        return new JoinAction(
            $container->get(TemplateRendererInterface::class)
        );
    }
}
