<?php
declare(strict_types = 1);
namespace Article\Test\Filter;

class VideoFilterTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInputFilterShouldReturnExpectedInstance()
    {
        $videoFilter = new \Article\Filter\VideoFilter();
        static::assertInstanceOf(\Zend\InputFilter\InputFilter::class, $videoFilter->getInputFilter());
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Not used
     */
    public function testSetInputShouldThrowException()
    {
        $inputInterface = $this->getMockBuilder(\Zend\InputFilter\InputFilterInterface::class)
            ->getMockForAbstractClass();
        $videoFilter = new \Article\Filter\VideoFilter();
        $videoFilter->setInputFilter($inputInterface);
    }
}
