<?php
declare(strict_types = 1);
namespace Web\Factory\Legacy;

use Web\Legacy\ContactAction;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;


/**
 * Class ContactFactory.
 *
 * @package Web\Factory\Action
 */
class ContactFactory
{
    /**
     * Executed when factory is invoked.
     *
     * @param ContainerInterface $container container
     *
     * @return ContactAction
     */
    public function __invoke(ContainerInterface $container) : ContactAction
    {
        return new ContactAction(
            $container->get(TemplateRendererInterface::class)
        );
    }
}
