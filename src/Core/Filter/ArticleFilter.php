<?php

namespace Core\Filter;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class ArticleFilter implements InputFilterAwareInterface
{
    protected $inputFilter;

    public function getInputFilter()
    {
        if(!$this->inputFilter){
            $inputFilter = new InputFilter();

            $inputFilter->add([
                'name'       => 'slug',
                'required'   => true,
                'filters'    => [['name' => 'StringTrim']],
                'validators' => [
                    ['name' => 'NotEmpty'],
                    ['name' => 'StringLength', 'options' => ['min' => 2, 'max' => 100]],
                ],
            ]);

            $inputFilter->add([
                'name'       => 'published_at',
                'required'   => true,
                'filters'    => [['name' => 'StringTrim']],
                'validators' => [['name' => 'NotEmpty'], ['name' => 'Date', 'options' => ['format' => 'Y-m-d H:i:s']]]
            ]);

            $inputFilter->add([
                'name'       => 'status',
                'required'   => true,
                'filters'    => [['name' => 'StringTrim']],
                'validators' => [['name' => 'NotEmpty'], ['name' => 'Digits']]
            ]);

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
}