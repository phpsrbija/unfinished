<?php

declare(strict_types=1);

namespace Page\Test;

class ConfigProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokeShouldReturnAdminConfigProvider()
    {
        $configProvider = new \Page\ConfigProvider();
        static::assertInternalType('array', $configProvider());
    }
}
