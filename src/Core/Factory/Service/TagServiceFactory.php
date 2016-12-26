<?php
declare(strict_types = 1);
namespace Core\Factory\Service;

use Core\Mapper\TagsMapper;
use Core\Service\TagService;
use Interop\Container\ContainerInterface;

class TagServiceFactory
{
    /**
     * Executed when factory is invoked.
     *
     * @param ContainerInterface $container container
     * @return AdminUserService
     */
    public function __invoke(ContainerInterface $container) : TagService
    {
        return new TagService(
            $container->get(TagsMapper::class)
        );
    }
}
