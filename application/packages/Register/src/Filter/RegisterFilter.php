<?php

namespace Register\Filter;

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
                'name'       => 'full_name',
                'required'   => true,
                'filters'    => [['name' => 'StringTrim'], ['name' => 'StripTags'], ['name' => 'StripNewlines']],
                'validators' => [
                    ['name' => 'NotEmpty'],
                    ['name' => 'StringLength', 'options' => ['min' => 2, 'max' => 1000]],
                ],
            ]
        );

        $inputFilter->add(
            [
                'name'       => 'email',
                'required'   => true,
                'filters'    => [['name' => 'StringTrim'], ['name' => 'StripTags'], ['name' => 'StripNewlines']],
                'validators' => [
                    ['name' => 'NotEmpty'],
                    ['name' => 'EmailAddress'],
                ],
            ]
        );

        $inputFilter->add(
            [
                'name'       => 'phone',
                'required'   => true,
                'filters'    => [['name' => 'StringTrim'], ['name' => 'StripTags'], ['name' => 'StripNewlines']],
                'validators' => [
                    ['name' => 'NotEmpty'],
                    ['name' => 'StringLength', 'options' => ['min' => 2, 'max' => 30]],
                ],
            ]
        );

        $inputFilter->add(
            [
                'name'       => 'url',
                'required'   => true,
                'filters'    => [['name' => 'StringTrim'], ['name' => 'StripTags'], ['name' => 'StripNewlines']],
                'validators' => [
                    ['name' => 'NotEmpty'],
                    ['name' => 'StringLength', 'options' => ['min' => 2, 'max' => 1000]],
                ],
            ]
        );

        $inputFilter->add(
            [
                'name'       => 'cover_letter',
                'required'   => true,
                'filters'    => [['name' => 'StringTrim'], ['name' => 'StripTags'], ['name' => 'StripNewlines']],
                'validators' => [
                    ['name' => 'NotEmpty'],
                    ['name' => 'StringLength', 'options' => ['min' => 10, 'max' => 10000]],
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