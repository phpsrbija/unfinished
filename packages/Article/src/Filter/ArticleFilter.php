<?php

namespace Article\Filter;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class ArticleFilter implements InputFilterAwareInterface
{
    protected $inputFilter;

    public function getInputFilter()
    {
        if(!$this->inputFilter) {
            $inputFilter = new InputFilter();

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
                'name'       => 'published_at',
                'required'   => true,
                'filters'    => [['name' => 'StringTrim']],
                'validators' => [['name' => 'NotEmpty'], ['name' => 'Date', 'options' => ['format' => 'Y-m-d H:i:s']]]
                ]
            );

            $inputFilter->add(
                [
                'name'     => 'category_id',
                'required' => true
                ]
            );

            $inputFilter->add(
                [
                'name'     => 'admin_user_id',
                'required' => true
                ]
            );

            $inputFilter->add(
                [
                'name'     => 'status',
                'required' => false,
                'filters'  => [['name' => 'Boolean']],
                ]
            );

            $inputFilter->add(
                [
                'name'     => 'is_wysiwyg_editor',
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
