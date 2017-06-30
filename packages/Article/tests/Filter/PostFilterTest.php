<?php

declare(strict_types=1);

namespace Article\Test\Filter;

class PostFilterTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInputFilterShouldReturnExpectedInstance()
    {
        $postFilter = new \Article\Filter\PostFilter();
        static::assertInstanceOf(\Zend\InputFilter\InputFilter::class, $postFilter->getInputFilter());
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Not used
     */
    public function testSetInputShouldThrowException()
    {
        $inputInterface = $this->getMockBuilder(\Zend\InputFilter\InputFilterInterface::class)
            ->getMockForAbstractClass();
        $postFilter = new \Article\Filter\PostFilter();
        $postFilter->setInputFilter($inputInterface);
    }
}
