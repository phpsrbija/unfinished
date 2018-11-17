<?php

declare(strict_types=1);

namespace Admin\Factory\Action;

use Admin\Action\ImageUploadAction;
use Interop\Container\ContainerInterface;
use UploadHelper\Upload;

/**
 * Class IndexFactory.
 */
final class ImageUploadFactory
{
    /**
     * Factory method.
     *
     * @param ContainerInterface $container container
     *
     * @return ImageUploadAction
     */
    public function __invoke(ContainerInterface $container) : ImageUploadAction
    {
        $config = $container->get('config')['upload'];
        $upload = new Upload($config['public_path'], $config['non_public_path']);

        return new ImageUploadAction(
            $upload
        );
    }
}
