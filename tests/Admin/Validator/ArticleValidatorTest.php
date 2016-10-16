<?php
declare(strict_types = 1);

namespace Test\Admin\Validator;

class ArticleValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testValidateMethodShouldSucceed()
    {
        $articleValidator = new \Admin\Validator\ArticleValidator();
        $validData = array(
            'title' => 'test title',
            'lead' => 'test lead',
            'body' => 'test body'
        );
        $articleValidator->validate($validData);

        static::assertCount(0, $articleValidator->getMessages());
    }

    public function testValidateMethodWithInvalidDataShouldThrowExceptionAndReturnAllMessages()
    {
        $articleValidator = new \Admin\Validator\ArticleValidator();
        $invalidData = array(
            'title' => '',
            'lead' => '',
            'body' => ''
        );
        try {
            $articleValidator->validate($invalidData);
        } catch (\Exception $e) {
            static::assertSame(array_keys($invalidData), array_keys($articleValidator->getMessages()->getArrayCopy()));
        }
    }
}
