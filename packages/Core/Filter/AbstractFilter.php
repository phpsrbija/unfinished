<?php

namespace Core\Filter;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

abstract class AbstractFilter implements InputFilterAwareInterface
{
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    /**
     * @param array $msgs All messages
     * @return string All messages concatenated in one string
     */
    public function getMessages(array $msgs)
    {
        $allMsgs = '';
        array_walk_recursive(
            $msgs, function ($value) use (&$allMsgs) {
                $allMsgs .= "- " . $value . "<br/>";
            }
        );

        return $allMsgs;
    }
}
