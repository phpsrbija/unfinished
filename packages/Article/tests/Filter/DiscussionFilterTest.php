<?php
declare(strict_types = 1);
namespace Article\Test\Filter;

class DiscussionFilterTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInputFilterShouldReturnExpectedInstance()
    {
        $discussionFilter = new \Article\Filter\DiscussionFilter();
        static::assertInstanceOf(\Zend\InputFilter\InputFilter::class, $discussionFilter->getInputFilter());
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Not used
     */
    public function testSetInputShouldThrowException()
    {
        $inputInterface = $this->getMockBuilder(\Zend\InputFilter\InputFilterInterface::class)
            ->getMockForAbstractClass();
        $discussionFilter = new \Article\Filter\DiscussionFilter();
        $discussionFilter->setInputFilter($inputInterface);
    }
}