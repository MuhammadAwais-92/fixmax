<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repositories\CategoryRepository;

class CategoriesController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        parent::__construct();
        $this->categoryRepository = $categoryRepository;
    }

    public function categories()
    {
        $this->categoryRepository->setPaginate(0);
        $this->categoryRepository->setSelect([
            'id',
            'name',
            'image'
        ]);
        $categories =  $this->categoryRepository->all(true);
        return responseBuilder()->success(__('Categories'), ['categories' => $categories]);
    }
    
    public function subCategories($id)
    {
        $this->categoryRepository->setPaginate(0);
        $this->categoryRepository->setRelations(['subCategories']);
        $this->categoryRepository->setSelect([
            'id',
            'name',
            'image'
        ]);
        $categories=$this->categoryRepository->get($id);
        return responseBuilder()->success(__('Sub Categories'), ['categories' => $categories]);
    }
    public function getSubCategories($id)
    {
        $subcategories = $this->categoryRepository->subcategories($id);
        return responseBuilder()->success('subcategories', $subcategories);
    }
}
