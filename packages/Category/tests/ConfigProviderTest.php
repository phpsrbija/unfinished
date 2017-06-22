<?php
declare(strict_types = 1);
namespace Category\Test;

class ConfigProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokeShouldReturnAdminConfigProvider()
    {
        $configProvider = new \Category\ConfigProvider();
        static::assertInternalType('array', $configProvider());
    }
}
