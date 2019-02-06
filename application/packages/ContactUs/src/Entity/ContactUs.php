<?php

namespace ContactUs\Entity;

/**
 * Class ContactUs
 *
 * @package ContactUs\Entity
 * @author  Djordje Stojiljkovic <djordjestojilljkovic@gmail.com>
 */
class ContactUs
{
    private $contact_uuid;
    private $contact_id;
    private $name;
    private $email;
    private $phone;
    private $subject;
    private $body;
    private $created_at;

    /**
     * @return mixed
     */
    public function getContactUuid()
    {
        return $this->contact_id;
    }

    /**
     * @param $uuid
     *
     * @return \ContactUs\Entity\ContactUs
     */
    public function setContactUuid($uuid)
    {
        $this->contact_id = $uuid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContactId()
    {
        return $this->contact_id;
    }

    /**
     * @param $id
     *
     * @return \ContactUs\Entity\ContactUs
     */
    public function setContactId($id)
    {
        $this->contact_id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     *
     * @return \ContactUs\Entity\ContactUs
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $email
     *
     * @return \ContactUs\Entity\ContactUs
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param $phone
     *
     * @return \ContactUs\Entity\ContactUs
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param $subject
     *
     * @return \ContactUs\Entity\ContactUs
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param $body
     *
     * @return \ContactUs\Entity\ContactUs
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param string $createdAt
     *
     * @return \ContactUs\Entity\ContactUs
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }

    /**
     * Hydration of object.
     *
     * @param array $data
     */
    public function exchangeArray($data = [])
    {
        // Fetch entity properties.
        $properties = array_keys(
            get_object_vars($this)
        );

        foreach ($properties as $property) {
            $this->{$property} = isset($data[$property]) ? $data[$property] : null;
        }
    }

    /**
     * Dehydrate/Extract object to array.
     *
     * @return array
     */
    public function getArrayCopy()
    {
        return [
            'contact_uuid'  => (binary) $this->contact_uuid,
            'contact_id'    => (string) $this->contact_id,
            'name'          => (string) $this->name,
            'email'         => (string) $this->email,
            'phone'         =>          $this->phone,
            'subject'       => (string) $this->subject,
            'body'          => (string) $this->body,
            'created_at'    => (string) $this->created_at
        ];
    }
}