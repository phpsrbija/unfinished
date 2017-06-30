<?php

declare(strict_types=1);

namespace Menu\Test\Filter;

class MenuFilterTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInputFilterShouldReturnExpectedInstance()
    {
        $dbMock = $this->getMockBuilder(\Zend\Db\Adapter\Adapter::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $menuFilter = new \Menu\Filter\MenuFilter($dbMock);
        static::assertInstanceOf(\Zend\InputFilter\InputFilter::class, $menuFilter->getInputFilter());
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Not used
     */
    public function testSetInputShouldThrowException()
    {
        $inputInterface = $this->getMockBuilder(\Zend\InputFilter\InputFilterInterface::class)
            ->getMockForAbstractClass();
        $dbMock = $this->getMockBuilder(\Zend\Db\Adapter\Adapter::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $menuFilter = new \Menu\Filter\MenuFilter($dbMock);
        $menuFilter->setInputFilter($inputInterface);
    }
}
