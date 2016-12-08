<?php
declare(strict_types = 1);

namespace Admin\Validator;

class ArticleValidator implements \Admin\Validator\ValidatorInterface
{
    /**
     * @var \Zend\Stdlib\ArrayObject
     */
    private $messages;

    /**
     * Perform data validation for article entity.
     *
     * @param array $postData request post data
     *
     * @throws ValidatorException
     *
     * @return void
     */
    public function validate($postData)
    {
        $textValidator = new \Zend\Validator\StringLength();
        $textValidator->setMin(4);

        $this->messages = new \Zend\Stdlib\ArrayObject();
        if (!$textValidator->isValid($postData['title'])) {
            $this->messages->offsetSet('title', array_values($textValidator->getMessages()));
        }

        if (!$textValidator->isValid($postData['lead'])) {
            $this->messages->offsetSet('lead', array_values($textValidator->getMessages()));
        }

        //@TODO implement custom validator for article body (html structure) validation
        if (!$textValidator->isValid($postData['body'])) {
            $this->messages->offsetSet('body', array_values($textValidator->getMessages()));
        }

        if ($this->messages->count()) {
            throw new \Admin\Validator\ValidatorException('Data is not valid');
        }
    }

    /**
     * Messages getter method.
     *
     * @return \Zend\Stdlib\ArrayObject
     */
    public function getMessages() : \Zend\Stdlib\ArrayObject
    {
        return $this->messages;
    }
}
