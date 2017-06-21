<?php

namespace Page\Service;

use Core\Exception\FilterException;
use Page\Mapper\PageMapper;
use Page\Filter\PageFilter;
use UploadHelper\Upload;
use Ramsey\Uuid\Uuid;
use MysqlUuid\Uuid as MysqlUuid;
use MysqlUuid\Formats\Binary;
use Zend\Paginator\Paginator;

class PageService
{
    private $pageFilter;
    private $pageMapper;
    private $pagination;
    private $upload;

    public function __construct(PageFilter $pageFilter, PageMapper $pageMapper, Paginator $pagination, Upload $upload)
    {
        $this->pageFilter = $pageFilter;
        $this->pageMapper = $pageMapper;
        $this->pagination = $pagination;
        $this->upload     = $upload;
    }

    public function getPagination($page = 1, $limit = 10)
    {
        $this->pagination->setCurrentPageNumber($page);
        $this->pagination->setItemCountPerPage($limit);

        return $this->pagination;
    }

    /**
     * @param $pageId
     * @return \Page\Entity\Page|null
     */
    public function getPage($pageId)
    {
        return $this->pageMapper->select(['page_id' => $pageId])->current();
    }

    /**
     * @param $urlSlug
     * @return \Page\Entity\Page|null
     */
    public function getPageBySlug($urlSlug)
    {
        return $this->pageMapper->getActivePage($urlSlug)->current();
    }

    /**
     * @return \Page\Entity\Page|null
     */
    public function getHomepage()
    {
        return $this->pageMapper->select(['is_homepage' => true])->current();
    }

    /**
     * @param array $data
     * @return int
     * @throws FilterException
     */
    public function createPage($data)
    {
        $filter = $this->pageFilter->getInputFilter()->setData($data);

        if(!$filter->isValid()){
            throw new FilterException($filter->getMessages());
        }

        $data            = $filter->getValues()
            + ['main_img' => $this->upload->uploadImage($data, 'main_img')];
        $data['page_id'] = Uuid::uuid1()->toString();
        $data['page_uuid']
                         = (new MysqlUuid($data['page_id']))->toFormat(new Binary);

        if($data['is_homepage']){
            $this->pageMapper->update(['is_homepage' => false]);
        }

        return $this->pageMapper->insert($data);
    }

    public function updatePage($data, $pageId)
    {
        if(!($page = $this->getPage($pageId))){
            throw new \Exception('Page object not found. Page ID:' . $pageId);
        }

        $filter = $this->pageFilter->getInputFilter()->setData($data);

        if(!$filter->isValid()){
            throw new FilterException($filter->getMessages());
        }

        $data = $filter->getValues()
            + ['main_img' => $this->upload->uploadImage($data, 'main_img')];

        // We don't want to force user to re-upload image on edit
        if(!$data['main_img']){
            unset($data['main_img']);
        }
        else{
            $this->upload->deleteFile($page->getMainImg());
        }

        if($data['is_homepage']){
            $this->pageMapper->update(['is_homepage' => false]);
        }

        return $this->pageMapper->update($data, ['page_id' => $pageId]);
    }

    public function delete($pageId)
    {
        if(!($page = $this->getPage($pageId))){
            throw new \Exception('Page not found');
        }

        $this->upload->deleteFile($page->getMainImg());

        return (bool)$this->pageMapper->delete(['page_id' => $pageId]);
    }
}
