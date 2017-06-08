<?php

namespace Menu\Filter;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Validator\Db\RecordExists;

class MenuFilter implements InputFilterAwareInterface
{
    protected $inputFilter;
    private $db;

    public function __construct(Adapter $db)
    {
        $this->db = $db;
    }

    public function getInputFilter()
    {
        if(!$this->inputFilter){
            $inputFilter = new InputFilter();

            $inputFilter->add([
                'name'       => 'title',
                'required'   => true,
                'filters'    => [['name' => 'StripTags'], ['name' => 'StringTrim']],
                'validators' => [
                    ['name' => 'NotEmpty'],
                    ['name' => 'StringLength', 'options' => ['max' => '255']],
                ],
            ]);

            $inputFilter->add([
                'name'     => 'href',
                'required' => false,
                'filters'  => [['name' => 'StripTags'], ['name' => 'StringTrim']]
            ]);

            $inputFilter->add([
                'name'       => 'article_id',
                'required'   => false,
                'filters'    => [['name' => 'Null']],
                'validators' => [
                    ['name' => RecordExists::class, 'options' => ['table' => 'articles', 'field' => 'article_id', 'adapter' => $this->db]]
                ]
            ]);

            $inputFilter->add([
                'name'       => 'category_id',
                'required'   => false,
                'filters'    => [['name' => 'Null']],
                'validators' => [
                    ['name' => RecordExists::class, 'options' => ['table' => 'category', 'field' => 'category_id', 'adapter' => $this->db]]
                ]
            ]);

            $inputFilter->add([
                'name'     => 'is_active',
                'required' => false,
                'filters'  => [['name' => 'Boolean']]
            ]);

            $inputFilter->add([
                'name'     => 'is_in_header',
                'required' => false,
                'filters'  => [['name' => 'Boolean']]
            ]);

            $inputFilter->add([
                'name'     => 'is_in_footer',
                'required' => false,
                'filters'  => [['name' => 'Boolean']]
            ]);

            $inputFilter->add([
                'name'     => 'is_in_side',
                'required' => false,
                'filters'  => [['name' => 'Boolean']]
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