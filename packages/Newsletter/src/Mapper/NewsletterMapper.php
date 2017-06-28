<?php

namespace Newsletter\Mapper;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\TableGateway\AbstractTableGateway;

class NewsletterMapper extends AbstractTableGateway implements AdapterAwareInterface
{
    protected $table = 'newsletter';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }

    public function setDbAdapter(Adapter $adapter)
    {
        throw new \Exception('Set Adapter in constructor.');
    }
}
