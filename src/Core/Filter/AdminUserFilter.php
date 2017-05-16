<?php

namespace Core\Filter;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Db\Adapter\Adapter;

class AdminUserFilter implements InputFilterAwareInterface
{
    protected $inputFilter;
    protected $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function getInputFilter()
    {
        if(!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add([
                'name'       => 'first_name',
                'required'   => true,
                'filters'    => [['name' => 'StringTrim']],
                'validators' => [
                    ['name' => 'NotEmpty'],
                    ['name' => 'StringLength', 'options' => ['min' => 2, 'max' => 255]]
                ],
            ]);

            $inputFilter->add([
                'name'       => 'last_name',
                'required'   => true,
                'filters'    => [['name' => 'StringTrim']],
                'validators' => [
                    ['name' => 'NotEmpty'],
                    ['name' => 'StringLength', 'options' => ['min' => 2, 'max' => 255]]
                ],
            ]);

            $inputFilter->add([
                'name'       => 'email',
                'required'   => true,
                'filters'    => [['name' => 'StringTrim']],
                'validators' => [
                    ['name' => 'NotEmpty'],
                    ['name' => 'EmailAddress'],
                    ['name' => 'dbnorecordexists', 'options' => ['adapter' => $this->adapter, 'table' => 'admin_users', 'field' => 'email']],

                ],
            ]);

            $inputFilter->add([
                'name'     => 'introduction',
                'required' => false,
                'filters'  => [['name' => 'StringTrim']]
            ]);

            $inputFilter->add([
                'name'       => 'password',
                'required'   => true,
                'validators' => [
                    ['name' => 'NotEmpty'],
                    ['name' => 'StringLength', 'options' => ['min' => 7, 'max' => 255]]
                ],
            ]);

            $inputFilter->add([
                'name'       => 'confirm_password',
                'required'   => true,
                'validators' => [
                    ['name' => 'NotEmpty'],
                    ['name' => 'Identical', 'options' => ['token' => 'password']],
                ],
            ]);

            $inputFilter->add([
                'name'       => 'status',
                'required'   => true,
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