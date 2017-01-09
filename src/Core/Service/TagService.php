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
     * Update or Insert tag.
     *
     * @param  Array $data Data from POST
     * @param  null $tagId UUID of tag if we want to edit or 0 to add new tag
     * @throws \Exception
     */
    public function save($data, $tagId = 0)
    {
        $filter = $this->tagFilter->getInputFilter()->setData($data);

        if(!$filter->isValid()){
            throw new FilterException($filter->getMessages());
        }

        $data = $filter->getValues();

        if($tagId){
            $this->tagsMapper->update($data, ['tag_id' => $tagId]);
        }
        else{
            $data['tag_id']   = Uuid::uuid1()->toString();
            $data['tag_uuid'] = (new MysqlUuid($data['tag_id']))->toFormat(new Binary);

            $this->tagsMapper->insert($data);
        }
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

    public function getAll()
    {
        return $this->tagsMapper->select();
    }
}
