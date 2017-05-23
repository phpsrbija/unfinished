<?php

use Zend\ConfigAggregator\ConfigAggregator;
use Zend\ConfigAggregator\PhpFileProvider;

$configManager = new ConfigAggregator([
    // FW modules
    \Zend\Router\ConfigProvider::class,
    \Zend\Validator\ConfigProvider::class,

    // App modules
    \Web\ConfigProvider::class,
    \Category\ConfigProvider::class,
    \Article\ConfigProvider::class,
    \Menu\ConfigProvider::class,
    \Admin\ConfigProvider::class,
    \Core\ConfigProvider::class,
    \Newsletter\ConfigProvider::class,

    new PhpFileProvider('config/autoload/{{,*.}global,{,*.}local}.php'),
]);

return new ArrayObject($configManager->getMergedConfig());
