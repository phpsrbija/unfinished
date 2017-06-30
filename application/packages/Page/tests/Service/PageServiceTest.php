<?php
declare(strict_types = 1);
namespace Page\Test\Service;

class PageServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testGetPaginationShouldReturnPaginationInstance()
    {
        $pageFilter = $this->getMockBuilder(\Page\Filter\PageFilter::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageMapper = $this->getMockBuilder(\Page\Mapper\PageMapper::class)
            ->disableOriginalConstructor()
            ->getMock();
        $paginator = $this->getMockBuilder(\Zend\Paginator\Paginator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $upload = $this->getMockBuilder(\UploadHelper\Upload::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageService = new \Page\Service\PageService($pageFilter, $pageMapper, $paginator, $upload);

        static::assertInstanceOf(\Zend\Paginator\Paginator::class, $pageService->getPagination());
    }

    public function testGetPageShouldReturnNull()
    {
        $pageFilter = $this->getMockBuilder(\Page\Filter\PageFilter::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageMapper = $this->getMockBuilder(\Page\Mapper\PageMapper::class)
            ->setMethods(['select', 'current'])
            ->disableOriginalConstructor()
            ->getMock();
        $pageMapper->expects(static::once())
            ->method('select')
            ->willReturnSelf();
        $pageMapper->expects(static::once())
            ->method('current')
            ->willReturn(null);
        $paginator = $this->getMockBuilder(\Zend\Paginator\Paginator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $upload = $this->getMockBuilder(\UploadHelper\Upload::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageService = new \Page\Service\PageService($pageFilter, $pageMapper, $paginator, $upload);

        static::assertInternalType('null', $pageService->getPage(1));
    }

    public function testGetPageBySlugShouldReturnNull()
    {
        $pageFilter = $this->getMockBuilder(\Page\Filter\PageFilter::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageMapper = $this->getMockBuilder(\Page\Mapper\PageMapper::class)
            ->setMethods(['getActivePage', 'current'])
            ->disableOriginalConstructor()
            ->getMock();
        $pageMapper->expects(static::once())
            ->method('getActivePage')
            ->willReturnSelf();
        $pageMapper->expects(static::once())
            ->method('current')
            ->willReturn(null);
        $paginator = $this->getMockBuilder(\Zend\Paginator\Paginator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $upload = $this->getMockBuilder(\UploadHelper\Upload::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageService = new \Page\Service\PageService($pageFilter, $pageMapper, $paginator, $upload);

        static::assertInternalType('null', $pageService->getPageBySlug('test'));
    }

    public function testGetHomepageShouldReturnNull()
    {
        $pageFilter = $this->getMockBuilder(\Page\Filter\PageFilter::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageMapper = $this->getMockBuilder(\Page\Mapper\PageMapper::class)
            ->setMethods(['select', 'current'])
            ->disableOriginalConstructor()
            ->getMock();
        $pageMapper->expects(static::once())
            ->method('select')
            ->willReturnSelf();
        $pageMapper->expects(static::once())
            ->method('current')
            ->willReturn(null);
        $paginator = $this->getMockBuilder(\Zend\Paginator\Paginator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $upload = $this->getMockBuilder(\UploadHelper\Upload::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageService = new \Page\Service\PageService($pageFilter, $pageMapper, $paginator, $upload);

        static::assertInternalType('null', $pageService->getHomepage());
    }

    public function testCreatePageShouldReturnTrue()
    {
        $pageData = [
            'is_homepage' => 1
        ];
        $pageFilter = $this->getMockBuilder(\Page\Filter\PageFilter::class)
            ->setMethods(['getInputFilter', 'setData', 'isValid', 'getValues'])
            ->disableOriginalConstructor()
            ->getMock();
        $pageFilter->expects(static::once())
            ->method('getInputFilter')
            ->willReturnSelf();
        $pageFilter->expects(static::once())
            ->method('isValid')
            ->willReturn(true);
        $pageFilter->expects(static::once())
            ->method('getValues')
            ->willReturn($pageData);
        $pageFilter->expects(static::once())
            ->method('setData')
            ->willReturnSelf();
        $pageMapper = $this->getMockBuilder(\Page\Mapper\PageMapper::class)
            ->setMethods(['update', 'insert'])
            ->disableOriginalConstructor()
            ->getMock();
        $pageMapper->expects(static::once())
            ->method('insert')
            ->willReturn(true);
        $paginator = $this->getMockBuilder(\Zend\Paginator\Paginator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $upload = $this->getMockBuilder(\UploadHelper\Upload::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageService = new \Page\Service\PageService($pageFilter, $pageMapper, $paginator, $upload);

        static::assertSame(true, $pageService->createPage($pageData));
    }

    /**
     * @expectedExceptionMessage test error
     * @expectedException \Std\FilterException
     */
    public function testCreatePageShouldThrowFilterException()
    {
        $pageData = [
            'is_homepage' => 1
        ];

        $pageFilter = $this->getMockBuilder(\Page\Filter\PageFilter::class)
            ->setMethods(['getInputFilter', 'setData', 'isValid', 'getMessages'])
            ->disableOriginalConstructor()
            ->getMock();
        $pageFilter->expects(static::once())
            ->method('getInputFilter')
            ->willReturnSelf();
        $pageFilter->expects(static::once())
            ->method('isValid')
            ->willReturn(false);
        $pageFilter->expects(static::once())
            ->method('getMessages')
            ->willReturn(['test error']);
        $pageFilter->expects(static::once())
            ->method('setData')
            ->willReturnSelf();
        $pageMapper = $this->getMockBuilder(\Page\Mapper\PageMapper::class)
            ->setMethods(['update', 'insert'])
            ->disableOriginalConstructor()
            ->getMock();
        $paginator = $this->getMockBuilder(\Zend\Paginator\Paginator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $upload = $this->getMockBuilder(\UploadHelper\Upload::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageService = new \Page\Service\PageService($pageFilter, $pageMapper, $paginator, $upload);

        static::assertSame(true, $pageService->createPage($pageData));
    }

    /**
     * @expectedExceptionMessage Page object not found. Page ID:1
     * @expectedException \Exception
     */
    public function testUpdatePageShouldThrowException()
    {
        $pageData = [
            'is_homepage' => 1
        ];
        $pageFilter = $this->getMockBuilder(\Page\Filter\PageFilter::class)
            ->setMethods(['select'])
            ->disableOriginalConstructor()
            ->getMock();
        $pageMapper = $this->getMockBuilder(\Page\Mapper\PageMapper::class)
            ->setMethods(['select', 'current'])
            ->disableOriginalConstructor()
            ->getMock();
        $pageMapper->expects(static::once())
            ->method('select')
            ->willReturnSelf();
        $pageMapper->expects(static::once())
            ->method('current')
            ->willReturn(null);
        $paginator = $this->getMockBuilder(\Zend\Paginator\Paginator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $upload = $this->getMockBuilder(\UploadHelper\Upload::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageService = new \Page\Service\PageService($pageFilter, $pageMapper, $paginator, $upload);

        $pageService->updatePage($pageData, 1);
    }

    /**
     * @expectedExceptionMessage test error
     * @expectedException \Std\FilterException
     */
    public function testUpdatePageShouldThrowFilterException()
    {
        $pageData = [
            'is_homepage' => 1
        ];
        $pageFilter = $this->getMockBuilder(\Page\Filter\PageFilter::class)
            ->setMethods(['getInputFilter', 'setData', 'isValid', 'getMessages'])
            ->disableOriginalConstructor()
            ->getMock();
        $pageFilter->expects(static::once())
            ->method('getInputFilter')
            ->willReturnSelf();
        $pageFilter->expects(static::once())
            ->method('setData')
            ->willReturnSelf();
        $pageFilter->expects(static::once())
            ->method('isValid')
            ->willReturn(false);
        $pageFilter->expects(static::once())
            ->method('getMessages')
            ->willReturn(['test error']);
        $pageMapper = $this->getMockBuilder(\Page\Mapper\PageMapper::class)
            ->setMethods(['select', 'current'])
            ->disableOriginalConstructor()
            ->getMock();
        $pageMapper->expects(static::once())
            ->method('select')
            ->willReturnSelf();
        $pageMapper->expects(static::once())
            ->method('current')
            ->willReturn(new \Page\Entity\Page());
        $paginator = $this->getMockBuilder(\Zend\Paginator\Paginator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $upload = $this->getMockBuilder(\UploadHelper\Upload::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageService = new \Page\Service\PageService($pageFilter, $pageMapper, $paginator, $upload);

        $pageService->updatePage($pageData, 1);
    }

    public function testUpdatePageShouldReturnTrue()
    {
        $pageData = [
            'is_homepage' => 1
        ];
        $pageFilter = $this->getMockBuilder(\Page\Filter\PageFilter::class)
            ->setMethods(['getInputFilter', 'setData', 'isValid', 'getValues', 'select'])
            ->disableOriginalConstructor()
            ->getMock();
        $pageFilter->expects(static::once())
            ->method('getInputFilter')
            ->willReturnSelf();
        $pageFilter->expects(static::once())
            ->method('isValid')
            ->willReturn(true);
        $pageFilter->expects(static::once())
            ->method('getValues')
            ->willReturn($pageData);
        $pageFilter->expects(static::once())
            ->method('setData')
            ->willReturnSelf();
        $pageMapper = $this->getMockBuilder(\Page\Mapper\PageMapper::class)
            ->setMethods(['update', 'select', 'current'])
            ->disableOriginalConstructor()
            ->getMock();
        $pageMapper->expects(static::exactly(2))
            ->method('update')
            ->willReturn(true);
        $pageMapper->expects(static::once())
            ->method('select')
            ->willReturnSelf();
        $pageMapper->expects(static::once())
            ->method('current')
            ->willReturn(new \Page\Entity\Page());
        $paginator = $this->getMockBuilder(\Zend\Paginator\Paginator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $upload = $this->getMockBuilder(\UploadHelper\Upload::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageService = new \Page\Service\PageService($pageFilter, $pageMapper, $paginator, $upload);

        static::assertSame(true, $pageService->updatePage($pageData, 1));
    }

    public function testUpdatePageShouldReturnTrueAndDeleteImageViaUploader()
    {
        $pageData = [
            'is_homepage' => 1,
            'main_img' => 'test_path'
        ];
        $pageFilter = $this->getMockBuilder(\Page\Filter\PageFilter::class)
            ->setMethods(['getInputFilter', 'setData', 'isValid', 'getValues', 'select'])
            ->disableOriginalConstructor()
            ->getMock();
        $pageFilter->expects(static::once())
            ->method('getInputFilter')
            ->willReturnSelf();
        $pageFilter->expects(static::once())
            ->method('isValid')
            ->willReturn(true);
        $pageFilter->expects(static::once())
            ->method('getValues')
            ->willReturn($pageData);
        $pageFilter->expects(static::once())
            ->method('setData')
            ->willReturnSelf();
        $pageMapper = $this->getMockBuilder(\Page\Mapper\PageMapper::class)
            ->setMethods(['update', 'select', 'current'])
            ->disableOriginalConstructor()
            ->getMock();
        $pageMapper->expects(static::exactly(2))
            ->method('update')
            ->willReturn(true);
        $pageMapper->expects(static::once())
            ->method('select')
            ->willReturnSelf();
        $pageMapper->expects(static::once())
            ->method('current')
            ->willReturn(new \Page\Entity\Page());
        $paginator = $this->getMockBuilder(\Zend\Paginator\Paginator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $upload = $this->getMockBuilder(\UploadHelper\Upload::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageService = new \Page\Service\PageService($pageFilter, $pageMapper, $paginator, $upload);

        static::assertSame(true, $pageService->updatePage($pageData, 1));
    }

    public function testDeletePageShouldReturnTrue()
    {
        $pageFilter = $this->getMockBuilder(\Page\Filter\PageFilter::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageMapper = $this->getMockBuilder(\Page\Mapper\PageMapper::class)
            ->setMethods(['select', 'current', 'delete'])
            ->disableOriginalConstructor()
            ->getMock();
        $pageMapper->expects(static::once())
            ->method('select')
            ->willReturnSelf();
        $pageMapper->expects(static::once())
            ->method('current')
            ->willReturn(new \Page\Entity\Page());
        $pageMapper->expects(static::once())
            ->method('delete')
            ->willReturn(true);
        $paginator = $this->getMockBuilder(\Zend\Paginator\Paginator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $upload = $this->getMockBuilder(\UploadHelper\Upload::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageService = new \Page\Service\PageService($pageFilter, $pageMapper, $paginator, $upload);

        static::assertSame(true, $pageService->delete(1));
    }

    /**
     * @expectedExceptionMessage Page not found
     * @expectedException \Exception
     */
    public function testDeletePageShouldThrowException()
    {
        $pageFilter = $this->getMockBuilder(\Page\Filter\PageFilter::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageMapper = $this->getMockBuilder(\Page\Mapper\PageMapper::class)
            ->setMethods(['select', 'current'])
            ->disableOriginalConstructor()
            ->getMock();
        $pageMapper->expects(static::once())
            ->method('select')
            ->willReturnSelf();
        $pageMapper->expects(static::once())
            ->method('current')
            ->willReturn(null);
        $paginator = $this->getMockBuilder(\Zend\Paginator\Paginator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $upload = $this->getMockBuilder(\UploadHelper\Upload::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageService = new \Page\Service\PageService($pageFilter, $pageMapper, $paginator, $upload);

        $pageService->delete(1);
    }
}
