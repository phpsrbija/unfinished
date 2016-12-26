<?php
declare(strict_types = 1);
namespace Core\Mapper;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\TableGateway\AbstractTableGateway;

/**
 * Class TagsMapper.
 *
 * @package Core\Mapper
 */
class TagsMapper extends AbstractTableGateway implements AdapterAwareInterface
{
    /**
     * @var string
     */
    protected $table = 'tags';

    /**
     * Db adapter setter method,
     *
     * @param  Adapter $adapter db adapter
     * @return void
     */
    public function setDbAdapter(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function get($id)
    {
        return $this->select(['tag_id' => $id])->current();
    }

    public function getPaginationSelect()
    {
        $select = $this->getSql()->select()->order(['name' => 'asc']);

        return $select;
    }
}
