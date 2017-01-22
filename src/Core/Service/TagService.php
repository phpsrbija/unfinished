<?php
declare(strict_types = 1);

namespace Core\Service;

use Ramsey\Uuid\Uuid;
use MysqlUuid\Uuid as MysqlUuid;
use MysqlUuid\Formats\Binary;
use Core\Mapper\TagsMapper;
use Core\Filter\TagFilter;
use Core\Exception\FilterException;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;

/**
 * Class TagService.
 *
 * @package Core\Service
 */
class TagService
{
    /**
     * @var TagsMapper
     */
    private $tagsMapper;

    private $tagFilter;

    /**
     * TagService constructor.
     *
     * @param tagsMapper $tagsMapper mapper for tags
     */
    public function __construct(TagsMapper $tagsMapper, TagFilter $tagFilter)
    {
        $this->tagsMapper = $tagsMapper;
        $this->tagFilter  = $tagFilter;
    }

    /**
     * Return pagination object to paginate results on view
     *
     * @param  int $page  Current page set to pagination to display
     * @param  int $limit Limit set to pagination
     * @return Paginator
     */
    public function getPagination($page, $limit)
    {
        $select           = $this->tagsMapper->getPaginationSelect();
        $paginatorAdapter = new DbSelect($select, $this->tagsMapper->getAdapter());
        $paginator        = new Paginator($paginatorAdapter);

        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($limit);

        return $paginator;
    }

    /**
     * Return one tag for given UUID
     *
     * @param  string $tagId UUID from DB
     * @return array|\ArrayObject|null
     */
    public function getTag($tagId)
    {
        return $this->tagsMapper->get($tagId);
    }

    /**
     * Create new tag.
     *
     * @param $data
     * @throws FilterException
     */
    public function createTag($data)
    {
        $filter = $this->tagFilter->getInputFilter()->setData($data);

        if(!$filter->isValid()){
            throw new FilterException($filter->getMessages());
        }

        $data             = $filter->getValues();
        $data['tag_id']   = Uuid::uuid1()->toString();
        $data['tag_uuid'] = (new MysqlUuid($data['tag_id']))->toFormat(new Binary);

        $this->tagsMapper->insert($data);
    }

    /**
     * Update existing tag.
     *
     * @param $data
     * @param $tagId
     * @throws FilterException
     * @throws \Exception
     */
    public function updateTag($data, $tagId)
    {
        if(!$this->getTag($tagId)){
            throw new \Exception('Tag dos not exist.');
        }

        $filter = $this->tagFilter->getInputFilter()->setData($data);

        if(!$filter->isValid()){
            throw new FilterException($filter->getMessages());
        }

        $data = $filter->getValues();
        $this->tagsMapper->update($data, ['tag_id' => $tagId]);
    }

    /**
     * Delete tag by given UUID
     *
     * @param  string $tagId UUID from DB
     * @return bool
     */
    public function delete($tagId)
    {
        return (bool)$this->tagsMapper->delete(['tag_id' => $tagId]);
    }

    /**
     * Returnall tags typically to populate select box
     *
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function getAll()
    {
        return $this->tagsMapper->select();
    }
}
