<?php

namespace Category\Filter;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class CategoryFilter implements InputFilterAwareInterface
{
    protected $inputFilter;

    public function getInputFilter()
    {
        if(!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(
                [
                'name'       => 'name',
                'required'   => true,
                'filters'    => [['name' => 'StringTrim']],
                'validators' => [
                    ['name' => 'NotEmpty'],
                    ['name' => 'StringLength', 'options' => ['min' => 2, 'max' => 500]],
                ],
                ]
            );

            $inputFilter->add(
                [
                'name'       => 'slug',
                'required'   => true,
                'filters'    => [['name' => 'StringTrim', 'options' => ['charlist' => '/']]],
                'validators' => [
                    ['name' => 'NotEmpty'],
                    ['name' => 'StringLength', 'options' => ['min' => 2, 'max' => 100]],
                ],
                ]
            );

            $inputFilter->add(
                [
                'name'       => 'title',
                'required'   => false,
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
                'required'   => false,
                'filters'    => [['name' => 'StringTrim']],
                'validators' => [
                    ['name' => 'NotEmpty'],
                    ['name' => 'StringLength', 'options' => ['min' => 2, 'max' => 1000]],
                ],
                ]
            );

            $inputFilter->add(
                [
                'name'     => 'is_in_homepage',
                'required' => false,
                'filters'  => [['name' => 'Boolean']],
                ]
            );

            $inputFilter->add(
                [
                'name'     => 'is_in_category_list',
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
        throw new \Exception("Not used");
    }
}
