<?php

declare(strict_types=1);

namespace Article\Filter;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class VideoFilter implements InputFilterAwareInterface
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
                    'name'       => 'sub_title',
                    'required'   => false,
                    'filters'    => [['name' => 'StringTrim']],
                    'validators' => [
                        ['name' => 'NotEmpty'],
                        ['name' => 'StringLength', 'options' => ['min' => 2, 'max' => 500]],
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
                        ['name' => 'StringLength', 'options' => ['min' => 2]],
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
                        ['name' => 'StringLength', 'options' => ['min' => 2]],
                    ],
                ]
            );

            $inputFilter->add(
                [
                    'name'       => 'video_url',
                    'required'   => true,
                    'filters'    => [['name' => 'StringTrim']],
                    'validators' => [
                        ['name' => 'NotEmpty'],
                        ['name' => 'StringLength'],
                    ],
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
