<?php
declare(strict_types = 1);
namespace Admin\Test;

class ConfigProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokeShouldReturnAdminConfigProvider()
    {
        $configProvider = new \Admin\ConfigProvider();
        static::assertInternalType('array', $configProvider());
    }
}
