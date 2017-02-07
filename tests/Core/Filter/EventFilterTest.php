<?php

namespace Test\Core\Filter;


class EventFilterTest extends \PHPUnit_Framework_TestCase
{

    public function testGetInputFilterShouldReturnInputFilterInstanceWithExpectedValues()
    {
        $dbAdapter = $this->getMockBuilder(\Zend\Db\Adapter\Adapter::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $adminUserFilter = new \Core\Filter\EventFilter($dbAdapter);
        $values = array(
            'title' => null,
            'sub_title' => null,
            'place_name' => null,
            'body' => null,
            'start_at' => null,
            'end_at' => null,
            'longitude' => null,
            'latitude' => null,
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
        $adminUserFilter = new \Core\Filter\EventFilter($dbAdapter);
        $adminUserFilter->setInputFilter($inputFilter);
    }
}