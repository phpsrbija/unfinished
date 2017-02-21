<?php
declare(strict_types = 1);
namespace Web\Factory\Legacy;

use Web\Legacy\ListAction;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Core\Service\Article\PostService;
use UploadHelper\Upload;

/**
 * Class ListFactory.
 *
 * @package Web\Factory\Action
 */
class ListFactory
{
    /**
     * Executed when factory is invoked.
     *
     * @param ContainerInterface $container container
     *
     * @return ListAction
     */
    public function __invoke(ContainerInterface $container) : ListAction
    {
        $config = $container->get('config')->upload;
        $upload = new Upload($config['public_path'], $config['non_public_path']);

        return new ListAction(
            $container->get(TemplateRendererInterface::class),
            $container->get(PostService::class),
            $upload
        );
    }
}
