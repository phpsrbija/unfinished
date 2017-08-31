<?php

namespace ContactUs\Mapper;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

/**
 * Class ContactUsMapper
 *
 * @package ContactUs\Mapper
 * @author  Djordje Stojiljkovic <djordjestojilljkovic@gmail.com>
 */
class ContactUsMapper extends AbstractTableGateway implements AdapterAwareInterface
{
    /**
     * Table name.
     *
     * @var string $table
     */
    protected $table = 'contact_us';

    /**
     * ContactUsMapper constructor.
     *
     * @param Adapter             $adapter
     * @param HydratingResultSet  $resultSet
     */
    public function __construct(Adapter $adapter, HydratingResultSet $resultSet)
    {
        $this->resultSetPrototype = $resultSet;
        $this->adapter = $adapter;
        $this->initialize();
    }

    /**
     * @param  Adapter $adapter
     *
     * @return void
     *
     * @throws \Exception
     */
    public function setDbAdapter(Adapter $adapter)
    {
        $ex = new \Exception('Set DB adapter in constructor.', 400);
        throw $ex;
    }

    /**
     * @return \Zend\Db\Sql\Select
     */
    public function getPaginationSelect()
    {
        return $this->getSql()->select()->order([
            'created_at'  => 'desc',
        ]);
    }
}