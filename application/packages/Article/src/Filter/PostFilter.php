<?php

declare(strict_types=1);

namespace Article\Filter;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class PostFilter implements InputFilterAwareInterface
{
    protected $inputFilter;

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(
                [
                    'name'       => 'title',
                    'required'   => true,
                    'filters'    => [['name' => 'StringTrim']],
                    'validators' => [
                        ['name' => 'NotEmpty'],
                        ['name' => 'StringLength', 'options' => ['min' => 2, 'max' => 100]],
                    ],
                ]
            );

            $inputFilter->add(
                [
                    'name'       => 'body',
                    'required'   => true,
                    'filters'    => [['name' => 'StringTrim']],
                    'validators' => [
                        ['name' => 'NotEmpty'],
                        ['name' => 'StringLength', 'options' => ['min' => 2, 'max' => 100000]],
                    ],
                ]
            );

            $inputFilter->add(
                [
                    'name'       => 'lead',
                    'required'   => true,
                    'filters'    => [['name' => 'StringTrim']],
                    'validators' => [
                        ['name' => 'NotEmpty'],
                        ['name' => 'StringLength', 'options' => ['min' => 2, 'max' => 50000]],
                    ],
                ]
            );

            $inputFilter->add(
                [
                    'name'     => 'has_layout',
                    'required' => false,
                    'filters'  => [['name' => 'Boolean']],
                ]
            );

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception('Not used');
    }
}
