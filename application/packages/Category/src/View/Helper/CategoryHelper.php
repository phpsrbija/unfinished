<?php

declare(strict_types=1);

namespace Category\View\Helper;

use Category\Service\CategoryService;
use Zend\View\Helper\AbstractHelper;

class CategoryHelper extends AbstractHelper
{
    /** @var CategoryService */
    private $categoryService;

    /** @var array */
    private $homepageCategories;

    /**
     * CategoryHelper constructor.
     *
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /** @return $this */
    public function __invoke()
    {
        return $this;
    }

    /** @return \Zend\Db\ResultSet\ResultSet */
    public function forSelect()
    {
        return $this->categoryService->getAll();
    }

    /**
     * We need to return X categories with Y posts in every category sorted by
     * magic for homepage. magic = most viewed, most comments, most appropriate
     * for the user etc. etc. for now return just latest.
     */
    public function forHomepage()
    {
        if (!$this->homepageCategories) {
            $this->homepageCategories = $this->categoryService->getCategoriesWithPosts(true);
        }

        return $this->homepageCategories;
    }
}
