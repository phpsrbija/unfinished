<?php
declare(strict_types = 1);
namespace Menu\Test\Filter;

class MenuFilterTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInputFilterShouldReturnExpectedInstance()
    {
        $articleFilter = new \Category\Filter\CategoryFilter();
        static::assertInstanceOf(\Zend\InputFilter\InputFilter::class, $articleFilter->getInputFilter());
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Not used
     */
    public function testSetInputShouldThrowException()
    {
        $inputInterface = $this->getMockBuilder(\Zend\InputFilter\InputFilterInterface::class)
            ->getMockForAbstractClass();
        $articleFilter = new \Category\Filter\CategoryFilter();
        $articleFilter->setInputFilter($inputInterface);
    }
}