<?php

declare(strict_types=1);

namespace Article\Test\Filter;

class ArticleFilterTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInputFilterShouldReturnExpectedInstance()
    {
        $articleFilter = new \Article\Filter\ArticleFilter();
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
        $articleFilter = new \Article\Filter\ArticleFilter();
        $articleFilter->setInputFilter($inputInterface);
    }
}
