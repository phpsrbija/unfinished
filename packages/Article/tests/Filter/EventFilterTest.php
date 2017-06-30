<?php

declare(strict_types=1);

namespace Article\Test\Filter;

class EventFilterTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInputFilterShouldReturnExpectedInstance()
    {
        $eventFilter = new \Article\Filter\EventFilter();
        static::assertInstanceOf(\Zend\InputFilter\InputFilter::class, $eventFilter->getInputFilter());
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Not used
     */
    public function testSetInputShouldThrowException()
    {
        $inputInterface = $this->getMockBuilder(\Zend\InputFilter\InputFilterInterface::class)
            ->getMockForAbstractClass();
        $eventFilter = new \Article\Filter\EventFilter();
        $eventFilter->setInputFilter($inputInterface);
    }
}
