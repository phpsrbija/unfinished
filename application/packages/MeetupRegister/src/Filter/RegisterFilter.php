<?php

namespace MeetupRegister\Filter;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class RegisterFilter implements InputFilterAwareInterface
{
    protected $inputFilter;

    public function getInputFilter()
    {
        $inputFilter = new InputFilter();

        $inputFilter->add(
            [
                'name'       => 'firstName',
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
                'name'       => 'lastName',
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
                'name'       => 'email',
                'required'   => true,
                'filters'    => [['name' => 'StringTrim']],
                'validators' => [
                    ['name' => 'NotEmpty'],
                    ['name' => 'EmailAddress'],
                ],
            ]
        );

        $inputFilter->add(
            [
                'name'       => 'subject',
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
                'name'       => 'slideUrl',
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
                'name'       => 'description',
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
                'name'       => 'bio',
                'required'   => true,
                'filters'    => [['name' => 'StringTrim']],
                'validators' => [
                    ['name' => 'NotEmpty'],
                    ['name' => 'StringLength', 'options' => ['min' => 2, 'max' => 50000]],
                ],
            ]
        );

        return $inputFilter;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception('Not used');
    }
}