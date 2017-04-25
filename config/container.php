<?php

use Zend\ServiceManager\Config;
use Zend\ServiceManager\ServiceManager;

$config    = require __DIR__ . '/config.php';                                   // Load configuration
$container = new ServiceManager();                                              // Build container
(new Config($config['dependencies']))->configureServiceManager($container);
$container->setService('config', $config);                        // Inject config

return $container;