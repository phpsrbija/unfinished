<?php

declare(strict_types=1);

namespace Newsletter\Test;

class ConfigProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokeShouldReturnAdminConfigProvider()
    {
        $configProvider = new \Newsletter\ConfigProvider();
        static::assertInternalType('array', $configProvider());
    }
}
