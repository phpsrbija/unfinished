<?php

namespace Test\Core\Filter;


class AdminUserFilterTest extends \PHPUnit_Framework_TestCase
{

    public function testGetInputFilterShouldReturnInputFilterInstanceWithExpectedValues()
    {
        $dbAdapter = $this->getMockBuilder(\Zend\Db\Adapter\Adapter::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $adminUserFilter = new \Core\Filter\AdminUserFilter($dbAdapter);
        $values = array(
            'first_name' => null,
            'last_name' => null,
            'email' => null,
            'password' => null,
            'confirm_password' => null,
            'status' => null,
        );
        /* @var \Zend\InputFilter\InputFilter $inputFilter */
        $inputFilter = $adminUserFilter->getInputFilter();
        $this->assertSame($values, $inputFilter->getValues());
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Not used
     */
    public function testSetInputFilterShouldThrowException()
    {
        $inputFilter = $this->getMockBuilder(\Zend\InputFilter\InputFilterInterface::class)
            ->getMockForAbstractClass();
        $dbAdapter = $this->getMockBuilder(\Zend\Db\Adapter\Adapter::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $adminUserFilter = new \Core\Filter\AdminUserFilter($dbAdapter);
        $adminUserFilter->setInputFilter($inputFilter);
    }
}