<?php
declare(strict_types = 1);
namespace Menu\Test\Service;

use Zend\Stdlib\ArrayObject;

class MenuServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testGetNestedAllShouldReturnArray()
    {
        $menuFilter = $this->getMockBuilder(\Menu\Filter\MenuFilter::class)
            ->disableOriginalConstructor()
            ->getMock();
        $menuMapper = $this->getMockBuilder(\Menu\Mapper\MenuMapper::class)
            ->setMethods(['selectAll', 'toArray'])
            ->disableOriginalConstructor()
            ->getMock();
        $menuMapper->expects(static::once())
            ->method('selectAll')
            ->willReturnSelf();
        $menuMapper->expects(static::once())
            ->method('toArray')
            ->willReturn([]);
        $categoryService = $this->getMockBuilder(\Category\Service\CategoryService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageService = $this->getMockBuilder(\Page\Service\PageService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $menuService = new \Menu\Service\MenuService($menuMapper, $menuFilter, $categoryService, $pageService);

        static::assertInternalType('array', $menuService->getNestedAll());
    }

    public function testGetShouldReturnArray()
    {
        $menuFilter = $this->getMockBuilder(\Menu\Filter\MenuFilter::class)
            ->disableOriginalConstructor()
            ->getMock();
        $menuMapper = $this->getMockBuilder(\Menu\Mapper\MenuMapper::class)
            ->setMethods(['get'])
            ->disableOriginalConstructor()
            ->getMock();
        $menuMapper->expects(static::once())
            ->method('get')
            ->willReturn([]);
        $categoryService = $this->getMockBuilder(\Category\Service\CategoryService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageService = $this->getMockBuilder(\Page\Service\PageService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $menuService = new \Menu\Service\MenuService($menuMapper, $menuFilter, $categoryService, $pageService);

        static::assertInternalType('array', $menuService->get(1));
    }

    public function testAddMenuItemWithPageIdShouldReturnTrue()
    {
        $menuFilter = $this->getMockBuilder(\Menu\Filter\MenuFilter::class)
            ->setMethods(['getInputFilter', 'setData', 'isValid', 'getValues'])
            ->disableOriginalConstructor()
            ->getMock();
        $menuFilter->expects(static::once())
            ->method('getInputFilter')
            ->willReturnSelf();
        $menuFilter->expects(static::once())
            ->method('setData')
            ->willReturnSelf();
        $menuFilter->expects(static::once())
            ->method('isValid')
            ->willReturn(true);
        $menuFilter->expects(static::once())
            ->method('getValues')
            ->willReturn(['page_id' => 1, 'category_id' => false, 'href' => false]);
        $menuMapper = $this->getMockBuilder(\Menu\Mapper\MenuMapper::class)
            ->setMethods(['insertMenuItem', 'get'])
            ->disableOriginalConstructor()
            ->getMock();
        $menuMapper->expects(static::once())
            ->method('insertMenuItem')
            ->willReturn(true);
        $categoryService = $this->getMockBuilder(\Category\Service\CategoryService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageService = $this->getMockBuilder(\Page\Service\PageService::class)
            ->setMethods(['getPage'])
            ->disableOriginalConstructor()
            ->getMock();
        $pageService->expects(static::once())
            ->method('getPage')
            ->willReturn(new \Page\Entity\Page());
        $menuService = new \Menu\Service\MenuService($menuMapper, $menuFilter, $categoryService, $pageService);

        static::assertSame(true, $menuService->addMenuItem(['page_id' => 1, 'category_id' => false, 'href' => false]));
    }

    public function testAddMenuItemWithCategoryIdShouldReturnTrue()
    {
        $menuFilter = $this->getMockBuilder(\Menu\Filter\MenuFilter::class)
            ->setMethods(['getInputFilter', 'setData', 'isValid', 'getValues'])
            ->disableOriginalConstructor()
            ->getMock();
        $menuFilter->expects(static::once())
            ->method('getInputFilter')
            ->willReturnSelf();
        $menuFilter->expects(static::once())
            ->method('setData')
            ->willReturnSelf();
        $menuFilter->expects(static::once())
            ->method('isValid')
            ->willReturn(true);
        $menuFilter->expects(static::once())
            ->method('getValues')
            ->willReturn(['page_id' => false, 'category_id' => 1, 'href' => false]);
        $menuMapper = $this->getMockBuilder(\Menu\Mapper\MenuMapper::class)
            ->setMethods(['insertMenuItem', 'get'])
            ->disableOriginalConstructor()
            ->getMock();
        $menuMapper->expects(static::once())
            ->method('insertMenuItem')
            ->willReturn(true);
        $categoryService = $this->getMockBuilder(\Category\Service\CategoryService::class)
            ->setMethods(['getCategory'])
            ->disableOriginalConstructor()
            ->getMock();
        $categoryService->expects(static::once())
            ->method('getCategory')
            ->willReturn(new ArrayObject(['category_uuid' => 'test']));
        $pageService = $this->getMockBuilder(\Page\Service\PageService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $menuService = new \Menu\Service\MenuService($menuMapper, $menuFilter, $categoryService, $pageService);

        static::assertSame(true, $menuService->addMenuItem(['page_id' => 1, 'category_id' => false, 'href' => false]));
    }

    /**
     * @expectedExceptionMessage test error
     * @expectedException \Std\FilterException
     */
    public function testAddMenuItemWithCategoryIdShouldThrowFilterException()
    {
        $menuFilter = $this->getMockBuilder(\Menu\Filter\MenuFilter::class)
            ->setMethods(['getInputFilter', 'setData', 'isValid', 'getMessages'])
            ->disableOriginalConstructor()
            ->getMock();
        $menuFilter->expects(static::once())
            ->method('getInputFilter')
            ->willReturnSelf();
        $menuFilter->expects(static::once())
            ->method('setData')
            ->willReturnSelf();
        $menuFilter->expects(static::once())
            ->method('isValid')
            ->willReturn(false);
        $menuFilter->expects(static::once())
            ->method('getMessages')
            ->willReturn(['test error']);
        $menuMapper = $this->getMockBuilder(\Menu\Mapper\MenuMapper::class)
            ->setMethods(['get'])
            ->disableOriginalConstructor()
            ->getMock();
        $categoryService = $this->getMockBuilder(\Category\Service\CategoryService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageService = $this->getMockBuilder(\Page\Service\PageService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $menuService = new \Menu\Service\MenuService($menuMapper, $menuFilter, $categoryService, $pageService);

        static::assertSame(true, $menuService->addMenuItem(['page_id' => 1, 'category_id' => false, 'href' => false]));
    }

    /**
     * @expectedExceptionMessage You need to set only one link. Post, Category or Href.
     * @expectedException \Exception
     */
    public function testAddMenuItemWithCategoryIdShouldThrowException()
    {
        $menuFilter = $this->getMockBuilder(\Menu\Filter\MenuFilter::class)
            ->setMethods(['getInputFilter', 'setData', 'isValid'])
            ->disableOriginalConstructor()
            ->getMock();
        $menuFilter->expects(static::once())
            ->method('getInputFilter')
            ->willReturnSelf();
        $menuFilter->expects(static::once())
            ->method('setData')
            ->willReturnSelf();
        $menuFilter->expects(static::once())
            ->method('isValid')
            ->willReturn(true);
        $menuMapper = $this->getMockBuilder(\Menu\Mapper\MenuMapper::class)
            ->setMethods(['get'])
            ->disableOriginalConstructor()
            ->getMock();
        $categoryService = $this->getMockBuilder(\Category\Service\CategoryService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageService = $this->getMockBuilder(\Page\Service\PageService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $menuService = new \Menu\Service\MenuService($menuMapper, $menuFilter, $categoryService, $pageService);

        static::assertSame(true, $menuService->addMenuItem(['page_id' => 1, 'category_id' => 1, 'href' => 1]));
    }

    public function testAddMenuItemWithHrefShouldReturnTrue()
    {
        $menuFilter = $this->getMockBuilder(\Menu\Filter\MenuFilter::class)
            ->setMethods(['getInputFilter', 'setData', 'isValid', 'getValues'])
            ->disableOriginalConstructor()
            ->getMock();
        $menuFilter->expects(static::once())
            ->method('getInputFilter')
            ->willReturnSelf();
        $menuFilter->expects(static::once())
            ->method('setData')
            ->willReturnSelf();
        $menuFilter->expects(static::once())
            ->method('isValid')
            ->willReturn(true);
        $menuFilter->expects(static::once())
            ->method('getValues')
            ->willReturn(['page_id' => false, 'category_id' => false, 'href' => 'test']);
        $menuMapper = $this->getMockBuilder(\Menu\Mapper\MenuMapper::class)
            ->setMethods(['insertMenuItem', 'get'])
            ->disableOriginalConstructor()
            ->getMock();
        $menuMapper->expects(static::once())
            ->method('insertMenuItem')
            ->willReturn(true);
        $categoryService = $this->getMockBuilder(\Category\Service\CategoryService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageService = $this->getMockBuilder(\Page\Service\PageService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $menuService = new \Menu\Service\MenuService($menuMapper, $menuFilter, $categoryService, $pageService);

        static::assertSame(true, $menuService->addMenuItem(['page_id' => false, 'category_id' => false, 'href' => 'test']));
    }

    public function testUpdateMenuItemShouldReturnTrue()
    {
        $menuFilter = $this->getMockBuilder(\Menu\Filter\MenuFilter::class)
            ->setMethods(['getInputFilter', 'setData', 'isValid', 'getValues'])
            ->disableOriginalConstructor()
            ->getMock();
        $menuFilter->expects(static::once())
            ->method('getInputFilter')
            ->willReturnSelf();
        $menuFilter->expects(static::once())
            ->method('setData')
            ->willReturnSelf();
        $menuFilter->expects(static::once())
            ->method('isValid')
            ->willReturn(true);
        $menuFilter->expects(static::once())
            ->method('getValues')
            ->willReturn(['page_id' => false, 'category_id' => false, 'href' => 'test']);
        $menuMapper = $this->getMockBuilder(\Menu\Mapper\MenuMapper::class)
            ->setMethods(['updateMenuItem'])
            ->disableOriginalConstructor()
            ->getMock();
        $menuMapper->expects(static::once())
            ->method('updateMenuItem')
            ->willReturn(true);
        $categoryService = $this->getMockBuilder(\Category\Service\CategoryService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageService = $this->getMockBuilder(\Page\Service\PageService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $menuService = new \Menu\Service\MenuService($menuMapper, $menuFilter, $categoryService, $pageService);

        static::assertSame(true, $menuService->updateMenuItem(['page_id' => false, 'category_id' => false, 'href' => 'test'], 1));
    }

    public function testDeleteShouldReturnTrue()
    {
        $menuFilter = $this->getMockBuilder(\Menu\Filter\MenuFilter::class)
            ->disableOriginalConstructor()
            ->getMock();
        $menuMapper = $this->getMockBuilder(\Menu\Mapper\MenuMapper::class)
            ->setMethods(['select', 'delete'])
            ->disableOriginalConstructor()
            ->getMock();
        $menuMapper->expects(static::once())
            ->method('select')
            ->willReturn(new \Zend\Db\ResultSet\ResultSet());
        $menuMapper->expects(static::once())
            ->method('delete')
            ->willReturn(true);
        $categoryService = $this->getMockBuilder(\Category\Service\CategoryService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageService = $this->getMockBuilder(\Page\Service\PageService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $menuService = new \Menu\Service\MenuService($menuMapper, $menuFilter, $categoryService, $pageService);

        static::assertSame(true, $menuService->delete(1));
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage This Menu Item has child items
     */
    public function testDeleteShouldThrowException()
    {
        $resultSet = $this->getMockBuilder(\Zend\Db\ResultSet\ResultSet::class)
            ->setMethods(['count'])
            ->getMockForAbstractClass();
        $resultSet->expects(static::once())
            ->method('count')
            ->willReturn(1);
        $menuFilter = $this->getMockBuilder(\Menu\Filter\MenuFilter::class)
            ->disableOriginalConstructor()
            ->getMock();
        $menuMapper = $this->getMockBuilder(\Menu\Mapper\MenuMapper::class)
            ->setMethods(['select'])
            ->disableOriginalConstructor()
            ->getMock();
        $menuMapper->expects(static::once())
            ->method('select')
            ->willReturn($resultSet);
        $categoryService = $this->getMockBuilder(\Category\Service\CategoryService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageService = $this->getMockBuilder(\Page\Service\PageService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $menuService = new \Menu\Service\MenuService($menuMapper, $menuFilter, $categoryService, $pageService);

        static::assertSame(true, $menuService->delete(1));
    }

    public function testGetForSelectShouldReturnResultSet()
    {
        $menuFilter = $this->getMockBuilder(\Menu\Filter\MenuFilter::class)
            ->disableOriginalConstructor()
            ->getMock();
        $menuMapper = $this->getMockBuilder(\Menu\Mapper\MenuMapper::class)
            ->setMethods(['forSelect'])
            ->disableOriginalConstructor()
            ->getMock();
        $menuMapper->expects(static::once())
            ->method('forSelect')
            ->willReturn(new \Zend\Db\ResultSet\ResultSet());

        $categoryService = $this->getMockBuilder(\Category\Service\CategoryService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageService = $this->getMockBuilder(\Page\Service\PageService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $menuService = new \Menu\Service\MenuService($menuMapper, $menuFilter, $categoryService, $pageService);

        static::assertInstanceOf(\Zend\Db\ResultSet\ResultSet::class, $menuService->getForSelect());
    }

    public function testUpdateMenuOrderShouldReturnTrueWhenNoOrderReceived()
    {
        $menuFilter = $this->getMockBuilder(\Menu\Filter\MenuFilter::class)
            ->disableOriginalConstructor()
            ->getMock();
        $menuMapper = $this->getMockBuilder(\Menu\Mapper\MenuMapper::class)
            ->disableOriginalConstructor()
            ->getMock();
        $categoryService = $this->getMockBuilder(\Category\Service\CategoryService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageService = $this->getMockBuilder(\Page\Service\PageService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $menuService = new \Menu\Service\MenuService($menuMapper, $menuFilter, $categoryService, $pageService);

        static::assertSame(true, $menuService->updateMenuOrder(false));
    }

    /**
     * @expectedExceptionMessage test error
     * @expectedException \Exception
     */
    public function testUpdateMenuOrderShouldRethrowException()
    {
        $menuFilter = $this->getMockBuilder(\Menu\Filter\MenuFilter::class)
            ->disableOriginalConstructor()
            ->getMock();
        $menuMapper = $this->getMockBuilder(\Menu\Mapper\MenuMapper::class)
            ->setMethods(['getAdapter'])
            ->disableOriginalConstructor()
            ->getMock();
        $menuMapper->expects(static::exactly(2))
            ->method('getAdapter')
            ->willThrowException(new \Exception('test error'));
        $categoryService = $this->getMockBuilder(\Category\Service\CategoryService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageService = $this->getMockBuilder(\Page\Service\PageService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $menuService = new \Menu\Service\MenuService($menuMapper, $menuFilter, $categoryService, $pageService);

        static::assertSame(true, $menuService->updateMenuOrder(true));
    }

    public function testUpdateMenuOrderShouldReturnTrue()
    {
        $child = new \stdClass();
        $child->id = 1;
        $parent = new \stdClass();
        $parent->children = [$child];
        $parent->id = 2;

        $menuFilter = $this->getMockBuilder(\Menu\Filter\MenuFilter::class)
            ->disableOriginalConstructor()
            ->getMock();
        $menuMapper = $this->getMockBuilder(\Menu\Mapper\MenuMapper::class)
            ->setMethods(['getAdapter', 'getDriver', 'getConnection', 'beginTransaction', 'commit', 'update'])
            ->disableOriginalConstructor()
            ->getMock();
        $menuMapper->expects(static::exactly(2))
            ->method('getDriver')
            ->willReturnSelf();
        $menuMapper->expects(static::exactly(2))
            ->method('getConnection')
            ->willReturnSelf();
        $menuMapper->expects(static::exactly(2))
            ->method('getAdapter')
            ->willReturnSelf();
        $menuMapper->expects(static::exactly(1))
            ->method('beginTransaction')
            ->willReturnSelf();
        $menuMapper->expects(static::exactly(1))
            ->method('commit')
            ->willReturnSelf();
        $menuMapper->expects(static::exactly(2))
            ->method('update')
            ->willReturnSelf();
        $categoryService = $this->getMockBuilder(\Category\Service\CategoryService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pageService = $this->getMockBuilder(\Page\Service\PageService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $menuService = new \Menu\Service\MenuService($menuMapper, $menuFilter, $categoryService, $pageService);

        static::assertSame(true, $menuService->updateMenuOrder([$parent]));
    }
}
