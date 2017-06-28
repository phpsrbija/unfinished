<?php
declare(strict_types = 1);
namespace Meetup\Test;

class ConfigProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokeShouldReturnAdminConfigProvider()
    {
        $configProvider = new \Meetup\ConfigProvider();
        static::assertInternalType('array', $configProvider());
    }
}
