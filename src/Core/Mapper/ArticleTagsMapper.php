<?php

declare(strict_types = 1);

namespace Core\Mapper;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\TableGateway\AbstractTableGateway;

class ArticleTagsMapper extends AbstractTableGateway implements AdapterAwareInterface
{
    protected $table = 'article_tags';

    public function setDbAdapter(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }
}
