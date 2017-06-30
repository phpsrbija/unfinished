<?php
declare(strict_types=1);
namespace Menu\View\Helper;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Helper\UrlHelper;

class MenuUrlHelperFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new MenuUrlHelper(
            $container->get(UrlHelper::class)
        );
    }
}
