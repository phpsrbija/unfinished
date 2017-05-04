<?php
declare(strict_types = 1);

namespace Category\Service;

use Ramsey\Uuid\Uuid;
use MysqlUuid\Uuid as MysqlUuid;
use MysqlUuid\Formats\Binary;
use Category\Mapper\CategoryMapper;
use Category\Filter\CategoryFilter;
use Core\Exception\FilterException;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;

/**
 * Class CategoryService.
 *
 * @package Category\Service
 */
class CategoryService
{
    private $categoryMapper;
    private $categoryFilter;

    /**
     * CategoryService constructor.
     */
    public function __construct(CategoryMapper $categoryMapper, CategoryFilter $categoryFilter)
    {
        $this->categoryMapper = $categoryMapper;
        $this->categoryFilter = $categoryFilter;
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
        $select           = $this->categoryMapper->getPaginationSelect();
        $paginatorAdapter = new DbSelect($select, $this->categoryMapper->getAdapter());
        $paginator        = new Paginator($paginatorAdapter);

        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage($limit);

        return $paginator;
    }

    /**
     * Return one category for given UUID
     *
     * @param  string $categoryId UUID from DB
     * @return array|\ArrayObject|null
     */
    public function getCategory($categoryId)
    {
        return $this->categoryMapper->get($categoryId);
    }

    /**
     * Create new category.
     *
     * @param $data
     * @throws FilterException
     */
    public function createCategory($data)
    {
        $filter = $this->categoryFilter->getInputFilter()->setData($data);

        if(!$filter->isValid()){
            throw new FilterException($filter->getMessages());
        }

        $data                  = $filter->getValues();
        $data['category_id']   = Uuid::uuid1()->toString();
        $data['category_uuid'] = (new MysqlUuid($data['category_id']))->toFormat(new Binary);

        $this->categoryMapper->insert($data);
    }

    /**
     * Update existing category.
     *
     * @param $data
     * @param $categoryId
     * @throws FilterException
     * @throws \Exception
     */
    public function updateCategory($data, $categoryId)
    {
        if(!$this->getCategory($categoryId)){
            throw new \Exception('CategoryId dos not exist.');
        }

        $filter = $this->categoryFilter->getInputFilter()->setData($data);

        if(!$filter->isValid()){
            throw new FilterException($filter->getMessages());
        }

        $data = $filter->getValues();
        $this->categoryMapper->update($data, ['category_id' => $categoryId]);
    }

    /**
     * Delete category by given UUID
     *
     * @param  string $categoryId UUID from DB
     * @return bool
     */
    public function delete($categoryId)
    {
        return (bool)$this->categoryMapper->delete(['category_id' => $categoryId]);
    }

    /**
     * Returnall categoriess typically to populate select box
     *
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function getAll()
    {
        return $this->categoryMapper->select();
    }
}
