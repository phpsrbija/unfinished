<?php

declare(strict_types=1);

namespace ContactUs\Test;

/**
 * Class ConfigProviderTest
 *
 * @package ContactUs
 * @author  Djordje Stojiljkovic <djordjestojilljkovic@gmail.com>
 */
class ConfigProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokeShouldReturnContactUsConfigProvider()
    {
        $configProvider = new \ContactUs\ConfigProvider();
        static::assertInternalType('array', $configProvider());
    }
}
