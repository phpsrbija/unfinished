<?php

use Zend\ConfigAggregator\ConfigAggregator;
use Zend\ConfigAggregator\PhpFileProvider;

$configManager = new ConfigAggregator([

    // App packages
    \Category\ConfigProvider::class,
    \Article\ConfigProvider::class,
    \Menu\ConfigProvider::class,
    \Admin\ConfigProvider::class,
    \Newsletter\ConfigProvider::class,
    \Page\ConfigProvider::class,
    \Meetup\ConfigProvider::class,
    \Register\ConfigProvider::class,
    \Web\ConfigProvider::class,
    \ContactUs\ConfigProvider::class,


    new PhpFileProvider('config/autoload/{{,*.}global,{,*.}local}.php'),
]);

return new ArrayObject($configManager->getMergedConfig());
