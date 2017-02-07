<?php

namespace Test\Core\Filter;


class PostFilterTest extends \PHPUnit_Framework_TestCase
{

    public function testGetInputFilterShouldReturnInputFilterInstanceWithExpectedValues()
    {
        $dbAdapter = $this->getMockBuilder(\Zend\Db\Adapter\Adapter::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $adminUserFilter = new \Core\Filter\PostFilter($dbAdapter);
        $values = array(
            'title' => null,
            'body' => null,
            'lead' => null,
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
        $adminUserFilter = new \Core\Filter\PostFilter($dbAdapter);
        $adminUserFilter->setInputFilter($inputFilter);
    }
}