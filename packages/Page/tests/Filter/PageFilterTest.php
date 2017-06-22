<?php
declare(strict_types = 1);
namespace Page\Test\Filter;

class PageFilterTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInputFilterShouldReturnExpectedInstance()
    {
        $pageFilter = new \Page\Filter\PageFilter();
        static::assertInstanceOf(\Zend\InputFilter\InputFilter::class, $pageFilter->getInputFilter());
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Not used
     */
    public function testSetInputShouldThrowException()
    {
        $inputInterface = $this->getMockBuilder(\Zend\InputFilter\InputFilterInterface::class)
            ->getMockForAbstractClass();
        $pageFilter = new \Page\Filter\PageFilter();
        $pageFilter->setInputFilter($inputInterface);
    }
}