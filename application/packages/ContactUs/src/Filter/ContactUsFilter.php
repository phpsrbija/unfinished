<?php

namespace ContactUs\Filter;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * Class ContactUsFilter
 *
 * @package ContactUs\Filter
 * @author  Djordje Stojiljkovic <djordjestojilljkovic@gmail.com>
 */
class ContactUsFilter implements InputFilterAwareInterface
{
    /**
     * @var \Zend\InputFilter\InputFilter $inputFilter
     */
    protected $inputFilter;

    /**
     * @return InputFilter
     */
    public function getInputFilter()
    {
        $inputFilter = new InputFilter();

        $inputFilter
            ->add([
                'name'       => 'name',
                'required'   => true,
                'filters'    => [['name' => 'StringTrim']],
                'validators' => [
                    ['name'  => 'NotEmpty'],
                    ['name'  => 'StringLength', 'options' => ['min' => 1, 'max' => 255]],
                ],
            ])
            ->add([
                'name'       => 'email',
                'required'   => true,
                'filters'    => [['name' => 'StringTrim']],
                'validators' => [
                    ['name'  => 'NotEmpty'],
                    ['name'  => 'EmailAddress'],
                    ['name'  => 'StringLength', 'options' => ['min' => 2, 'max' => 100]],
                ]
            ])
            ->add([
                'name'       => 'phone',
                'required'   => false,
                'filters'    => [['name' => 'StringTrim']],
                'validators' => [
                    // TODO: PhoneNumber match cases.
                ]
            ])
            ->add([
                'name'       => 'subject',
                'required'   => true,
                'filters'    => [['name' => 'StringTrim']],
                'validators' => [
                    ['name'  => 'NotEmpty'],
                    ['name'  => 'StringLength', 'options' => ['min' => 5]]
                ]
            ])
            ->add([
                'name'       => 'body',
                'required'   => true,
                'filters'    => [['name' => 'StringTrim']],
                'validators' => [
                    ['name'  => 'NotEmpty'],
                    ['name'  => 'StringLength', 'options' => ['min' => 5]]
                ]
            ])
        ;

        return $inputFilter;
    }

    /**
     * @param  InputFilterInterface $inputFilter
     *
     * @return void
     *
     * @throws \Exception
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        $ex = new \Exception('Not used');
        throw $ex;
    }
}