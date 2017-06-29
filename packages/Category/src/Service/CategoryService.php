<?php
declare(strict_types = 1);
namespace Category\Service;

use Ramsey\Uuid\Uuid;
use MysqlUuid\Uuid as MysqlUuid;
use MysqlUuid\Formats\Binary;
use Category\Mapper\CategoryMapper;
use Category\Filter\CategoryFilter;
use Std\FilterException;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;
use UploadHelper\Upload;

/**
 * Class CategoryService.
 *
 * @package Category\Service
 */
class CategoryService
{
    private $categoryMapper;
    private $categoryFilter;
    private $upload;

    /**
     * CategoryService constructor.
     *
     * @param CategoryMapper $categoryMapper
     * @param CategoryFilter $categoryFilter
     * @param Upload $upload
     */
    public function __construct(CategoryMapper $categoryMapper, CategoryFilter $categoryFilter, Upload $upload)
    {
        $this->categoryMapper = $categoryMapper;
        $this->categoryFilter = $categoryFilter;
        $this->upload = $upload;
    }

    /**
     * Return pagination object to paginate results on view
     *
     * @param  int $page Current page set to pagination to display
     * @param  int $limit Limit set to pagination
     * @return Paginator
     */
    public function getPagination($page, $limit)
    {
        $select = $this->categoryMapper->getPaginationSelect();
        $paginatorAdapter = new DbSelect($select, $this->categoryMapper->getAdapter());
        $paginator = new Paginator($paginatorAdapter);

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
     * Return one category for given URL Slug
     *
     * @param  String $urlSlug
     * @return array|\ArrayObject|null
     */
    public function getCategoryBySlug($urlSlug)
    {
        return $this->categoryMapper->select(['slug' => $urlSlug])->current();
    }

    /**
     * Create new category.
     *
     * @param  $data
     * @throws FilterException
     */
    public function createCategory($data)
    {
        $filter = $this->categoryFilter->getInputFilter()->setData($data);

        if (!$filter->isValid()) {
            throw new FilterException($filter->getMessages());
        }

        $values                     = $filter->getValues();
        $values['category_id']      = Uuid::uuid1()->toString();
        $values['category_uuid']    = (new MysqlUuid($values['category_id']))->toFormat(new Binary);
        $values['main_img']         = $this->upload->uploadImage($data, 'main_img');

        $this->categoryMapper->insert($values);
    }

    /**
     * Update existing category.
     *
     * @param  $data
     * @param  $categoryId
     * @throws FilterException
     * @throws \Exception
     */
    public function updateCategory($data, $categoryId)
    {
        if (!($oldCategory = $this->getCategory($categoryId))) {
            throw new \Exception('CategoryId dos not exist.');
        }

        $filter = $this->categoryFilter->getInputFilter()->setData($data);

        if (!$filter->isValid()) {
            throw new FilterException($filter->getMessages());
        }

        $values = $filter->getValues() + [
                'main_img' => $this->upload->uploadImage($data, 'main_img')
            ];

        // We don't want to force user to re-upload image on edit
        if (!$values['main_img']) {
            unset($values['main_img']);
        } else {
            $this->upload->deleteFile($oldCategory->main_img);
        }

        $this->categoryMapper->update($values, ['category_id' => $categoryId]);
    }

    /**
     * Delete category by given UUID
     *
     * @param  string $categoryId UUID from DB
     * @return bool
     */
    public function delete($categoryId)
    {
        $category = $this->getCategory($categoryId);

        $this->upload->deleteFile($category->main_img);

        return (bool)$this->categoryMapper->delete(['category_id' => $categoryId]);
    }

    /**
     * Returnall categoriess typically to populate select box
     *
     * @return \Zend\Db\ResultSet\ResultSet
     */
    public function getAll($type = null)
    {
        if($type){
            return $this->categoryMapper->select(['type' => $type]);
        }

        return $this->categoryMapper->select();
    }

    /**
     * Return categories with posts(articles)
     *
     * @param  null $inHomepage
     * @param  null $inCategoryList
     * @return mixed
     */
    public function getCategoriesWithPosts($inHomepage = null, $inCategoryList = null)
    {
        $categories = $this->categoryMapper->getWeb(7, null, $inHomepage, $inCategoryList)->toArray();

        foreach ($categories as $ctn => $category) {
            $select = $this->categoryMapper->getCategoryPostsSelect($category['category_id'], 4);
            $posts  = $this->categoryMapper->selectWith($select)->toArray();
            $categories[$ctn]['posts'] = $posts;
        }

        return $categories;
    }

    /**
     * Return categories posts/articles
     *
     * @param  null $inCategoryList
     * @return null|\Zend\Db\ResultSet\ResultSetInterface
     */
    public function getCategories($inCategoryList = null)
    {
        return $this->categoryMapper->getWeb(null, ['name' => 'asc'], null, $inCategoryList);
    }

    /**
     * Get posts - articles with type == Posts
     *
     * @param  $category
     * @param  int $page
     * @return Paginator
     */
    public function getCategoryPostsPagination($category, $page = 1): Paginator
    {
        $categoryid = isset($category->category_id) ? $category->category_id : null;
        $select     = $this->categoryMapper->getCategoryPostsSelect($categoryid, 12);
        $paginatorAdapter   = new DbSelect($select, $this->categoryMapper->getAdapter());
        $paginator          = new Paginator($paginatorAdapter);

        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(12);

        return $paginator;
    }
}
