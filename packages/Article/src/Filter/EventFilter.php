<?php

declare(strict_types=1);

namespace Article\Filter;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class EventFilter implements InputFilterAwareInterface
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
                    'name'     => 'sub_title',
                    'required' => false,
                    'filters'  => [['name' => 'StringTrim']],
                ]
            );

            $inputFilter->add(
                [
                    'name'     => 'place_name',
                    'required' => true,
                    'filters'  => [['name' => 'StringTrim']],
                ]
            );

            $inputFilter->add(
                [
                    'name'     => 'event_url',
                    'required' => false,
                    'filters'  => [['name' => 'StringTrim']],
                ]
            );

            $inputFilter->add(
                [
                    'name'       => 'body',
                    'required'   => true,
                    'filters'    => [['name' => 'StringTrim']],
                    'validators' => [
                        ['name' => 'NotEmpty'],
                        ['name' => 'StringLength', 'options' => ['min' => 2]],
                    ],
                ]
            );

            $inputFilter->add(
                [
                    'name'       => 'start_at',
                    'required'   => true,
                    'filters'    => [['name' => 'StringTrim']],
                    'validators' => [
                        ['name' => 'NotEmpty'],
                        ['name' => 'Date', 'options' => ['format' => 'Y-m-d H:i:s']],
                    ],
                ]
            );

            $inputFilter->add(
                [
                    'name'       => 'end_at',
                    'required'   => true,
                    'filters'    => [['name' => 'StringTrim']],
                    'validators' => [
                        ['name' => 'NotEmpty'],
                        ['name' => 'Date', 'options' => ['format' => 'Y-m-d H:i:s']],
                    ],
                ]
            );

            $inputFilter->add(
                [
                    'name'       => 'longitude',
                    'required'   => true,
                    'filters'    => [['name' => 'StringTrim']],
                    'validators' => [['name' => 'NotEmpty']],
                ]
            );

            $inputFilter->add(
                [
                    'name'       => 'latitude',
                    'required'   => true,
                    'filters'    => [['name' => 'StringTrim']],
                    'validators' => [['name' => 'NotEmpty']],
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
