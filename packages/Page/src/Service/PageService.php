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
    private $pageMapper;
    private $pageFilter;
    private $pagination;
    private $upload;

    public function __construct(PageFilter $pageFilter, PageMapper $pageMapper, Paginator $pagination, Upload $upload)
    {
        $this->pageMapper = $pageMapper;
        $this->pageFilter = $pageFilter;
        $this->pagination = $pagination;
        $this->upload     = $upload;
    }

    public function getPagination($page = 1, $limit = 10)
    {
        $this->pagination->setCurrentPageNumber($page);
        $this->pagination->setItemCountPerPage($limit);

        return $this->pagination;
    }

    public function getPage($pageId)
    {
        return $this->pageMapper->select(['page_id' => $pageId])->current();
    }

    public function getHomepage()
    {
        return $this->pageMapper->select(['is_homepage' => true])->current();
    }

    public function createPage($data)
    {
        $filter = $this->pageFilter->getInputFilter()->setData($data);

        if(!$filter->isValid()){
            throw new FilterException($filter->getMessages());
        }

        $data              = $filter->getValues() + ['main_img' => $this->upload->uploadImage($data, 'main_img')];
        $data['page_id']   = Uuid::uuid1()->toString();
        $data['page_uuid'] = (new MysqlUuid($data['page_id']))->toFormat(new Binary);

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

        $data = $filter->getValues() + ['main_img' => $this->upload->uploadImage($data, 'main_img'),];

        // We don't want to force user to re-upload image on edit
        if(!$data['main_img']){
            unset($data['main_img']);
        }

        if($data['is_homepage']){
            $this->pageMapper->update(['is_homepage' => false]);
        }

        return $this->pageMapper->update($data, ['page_id' => $pageId]);
    }

    public function delete($pageId)
    {
        return (bool)$this->pageMapper->delete(['page_id' => $pageId]);
    }
}