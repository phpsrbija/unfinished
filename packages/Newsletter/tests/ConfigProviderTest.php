<?php
declare(strict_types = 1);
namespace Article\Test;

class ConfigProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokeShouldReturnAdminConfigProvider()
    {
        $configProvider = new \Article\ConfigProvider();
        static::assertInternalType('array', $configProvider());
    }
}