<?php

declare(strict_types = 1);

namespace Article\Mapper;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\TableGateway\AbstractTableGateway;

class ArticleCategoriesMapper extends AbstractTableGateway implements AdapterAwareInterface
{
    protected $table = 'article_categories';

    public function setDbAdapter(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }
}
