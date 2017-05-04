<?php

namespace Category\View\Helper;

use Category\Service\CategoryService;
use Zend\View\Helper\AbstractHelper;

class CategoryHelper extends AbstractHelper
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function __invoke()
    {
        return $this;
    }

    public function forSelect()
    {
        return $this->categoryService->getAll();
    }
}