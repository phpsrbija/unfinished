<?php
declare(strict_types = 1);

namespace TmpFakeIt\Mapper;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\TableGateway\AbstractTableGateway;

/**
 * Class TmpCounterMapper.
 *
 * @package TmpFakeIt\Action
 */
class TmpCounterMapper extends AbstractTableGateway implements AdapterAwareInterface
{
    /**
     * @var string
     */
    protected $table = 'tmp_counter';

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

    public function getByIp($ip)
    {
        return $this->select(['ip' => $ip]);
    }

    public function insertRec($data)
    {
        return $this->insert($data);
    }

}
