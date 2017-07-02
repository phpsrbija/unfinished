<?php

declare(strict_types=1);

namespace Admin\Test\Filter;

class AdminUserFilterTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInputFilterShouldReturnExpectedInstance()
    {
        $adapterMock = $this->getMockBuilder(\Zend\Db\Adapter\Adapter::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $adminUserFilter = new \Admin\Filter\AdminUserFilter($adapterMock);
        static::assertInstanceOf(\Zend\InputFilter\InputFilter::class, $adminUserFilter->getInputFilter());
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Not used
     */
    public function testSetInputShouldThrowException()
    {
        $adapterMock = $this->getMockBuilder(\Zend\Db\Adapter\Adapter::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $inputInterface = $this->getMockBuilder(\Zend\InputFilter\InputFilterInterface::class)
            ->getMockForAbstractClass();
        $adminUserFilter = new \Admin\Filter\AdminUserFilter($adapterMock);
        $adminUserFilter->setInputFilter($inputInterface);
    }
}
