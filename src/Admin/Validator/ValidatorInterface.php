<?php

namespace Admin\Validator;

/**
 * Interface ValidatorInterface.
 *
 * @proposal
 *
 * @package Admin\Validator
 */
interface ValidatorInterface
{
    /**
     * Perform data validation.
     *
     * @param array $postData post data to validate
     *
     * @return boolean
     */
    public function validate($postData);

    /**
     * Return error messages.
     *
     * @return \Zend\Stdlib\ArrayObject
     */
    public function getMessages();
}
