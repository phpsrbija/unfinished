<?php
declare(strict_types = 1);
namespace Menu\Test;

class ConfigProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokeShouldReturnAdminConfigProvider()
    {
        $configProvider = new \Menu\ConfigProvider();
        static::assertInternalType('array', $configProvider());
    }
}
