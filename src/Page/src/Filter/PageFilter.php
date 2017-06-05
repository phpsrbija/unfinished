<?php

namespace Page\Filter;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class PageFilter implements InputFilterAwareInterface
{
    protected $inputFilter;

    public function getInputFilter()
    {
        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name'       => 'title',
            'required'   => true,
            'filters'    => [['name' => 'StringTrim']],
            'validators' => [
                ['name' => 'NotEmpty'],
                ['name' => 'StringLength', 'options' => ['min' => 2, 'max' => 100]],
            ],
        ]);

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
            'name'       => 'body',
            'required'   => true,
            'filters'    => [['name' => 'StringTrim']],
            'validators' => [
                ['name' => 'NotEmpty'],
                ['name' => 'StringLength', 'options' => ['min' => 2, 'max' => 100000]],
            ],
        ]);

        $inputFilter->add([
            'name'       => 'description',
            'required'   => true,
            'filters'    => [['name' => 'StringTrim']],
            'validators' => [
                ['name' => 'NotEmpty'],
                ['name' => 'StringLength', 'options' => ['min' => 2, 'max' => 50000]],
            ],
        ]);

        $inputFilter->add([
            'name'     => 'has_layout',
            'required' => false,
            'filters'  => [['name' => 'Boolean']],
        ]);

        $inputFilter->add([
            'name'     => 'is_homepage',
            'required' => false,
            'filters'  => [['name' => 'Boolean']],
        ]);

        $inputFilter->add([
            'name'     => 'is_active',
            'required' => false,
            'filters'  => [['name' => 'Boolean']],
        ]);

        $inputFilter->add([
            'name'     => 'is_wysiwyg_editor',
            'required' => false,
            'filters'  => [['name' => 'Boolean']],
        ]);

        return $inputFilter;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
}