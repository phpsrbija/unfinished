<?php

namespace ContactUs\Service;

use ContactUs\Filter\ContactUsFilter;
use ContactUs\Mapper\ContactUsMapper;
use MysqlUuid\Formats\Binary;
use Ramsey\Uuid\Uuid;
use Std\FilterException;
use Zend\Paginator\Paginator;

/**
 * Class ContactUsService
 *
 * @package ContactUs\Service
 * @author  Djordje Stojiljkovic <djordjestojilljkovic@gmail.com>
 */
class ContactUsService
{
    /**
     * @var ContactUsFilter $contactUsFilter
     */
    private $contactUsFilter;

    /**
     * @var ContactUsMapper $contactUsMapper
     */
    private $contactUsMapper;

    /**
     * @var Paginator $pagination
     */
    private $pagination;

    /**
     * ContactUsService constructor.
     *
     * @param ContactUsFilter $contactUsFilter
     * @param ContactUsMapper $contactUsMapper
     * @param Paginator       $pagination
     */
    public function __construct(
        ContactUsFilter $contactUsFilter,
        ContactUsMapper $contactUsMapper,
        Paginator       $pagination)
    {
        $this->contactUsFilter = $contactUsFilter;
        $this->contactUsMapper = $contactUsMapper;
        $this->pagination      = $pagination;
    }

    /**
     * @param int $page
     * @param int $limit
     *
     * @return Paginator
     */
    public function getPagination($page = 1, $limit = 10)
    {
        $this->pagination->setCurrentPageNumber($page);
        $this->pagination->setItemCountPerPage($limit);

        return $this->pagination;
    }

    /**
     * Return all records from db.
     *
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function getAll()
    {
        return $this->contactUsMapper->select();
    }

    /**
     * @param mixed $contactId
     *
     * @return array|\ArrayObject|null
     */
    public function getById($contactId)
    {
        return $this->contactUsMapper->select(['contact_id' => $contactId])->current();
    }

    /**
     * @param string $email
     *
     * @return array|\ArrayObject|null
     */
    public function getByEmail($email)
    {
        return $this->contactUsMapper->select(['email' => (string) $email])->current();
    }

    /**
     * @param  array $data
     *
     * @return int
     */
    public function create(array $data)
    {
        $data = $this->filterData($data);
        $data['contact_id']   = Uuid::uuid1()->toString();
        $data['contact_uuid'] = (new \MysqlUuid\Uuid($data['contact_id']))->toFormat(new Binary());

        return $this->contactUsMapper->insert($data);
    }

    /**
     * @param  array $data
     * @param  mixed $contactId
     *
     * @return int
     *
     * @throws \Exception
     */
    public function update($data, $contactId)
    {
        if (empty($this->getById($contactId))) {
            $ex = new \Exception('Contact message object not found. Contact Message ID: ' . $contactId);
            throw $ex;
        }

        return $this->contactUsMapper->update(
            $this->filterData($data), ['contact_id' => $contactId]
        );
    }

    /**
     * @param  mixed $contactId
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function delete($contactId)
    {
        if (empty($this->getById($contactId))) {
            $ex = new \Exception('Contact Message with ID: ' .$contactId. ' not found');
            throw $ex;
        }

        return (bool) $this->contactUsMapper->delete(['contact_id' => $contactId]);
    }

    /**
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function getForSelect()
    {
        return $this->contactUsMapper->select();
    }

    /**
     * @param  array $data
     *
     * @return array
     *
     * @throws FilterException
     */
    private function filterData($data)
    {
        $filter = $this->contactUsFilter->getInputFilter();
        $filter->setData($data);

        if (!$filter->isValid()) {
            $ex = new FilterException($filter->getMessages());
            throw $ex;
        }

        return $filter->getValues();
    }
}