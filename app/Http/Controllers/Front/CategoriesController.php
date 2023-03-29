<?php

namespace App\Http\Controllers\Front;



use App\Http\Repositories\CategoryRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public $categoryRepository;
    public function __construct(CategoryRepository $categoryRepository)
    {
        parent::__construct();
        $this->categoryRepository = $categoryRepository;
        $this->categoryRepository->setFromWeb(true);
        $this->breadcrumbs[url(route('front.index'))] = ['title' => __('home')];
    }

    public function categories()
    {
        $this->breadcrumbTitle = __('Categories');
        $this->breadcrumbs['javascript:{};'] = [ 'title' => __('Categories')];
        $this->categoryRepository->setPaginate(8);
        $this->categoryRepository->setSelect([
            'id',
            'name',
            'image'
        ]);
        $categories=$this->categoryRepository->allCategories(true);
        return view('front.categories.categories', ['categories' => $categories]);
    }
    public function subCategories($id)
    {
        $this->breadcrumbTitle = __('Sub Categories');
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => __('Sub Categories')];
        $this->categoryRepository->setRelations(['subCategories']);
        $this->categoryRepository->setSelect([
            'id',
            'name',
            'image'
        ]);
        $categories=$this->categoryRepository->get($id);
        return view('front.categories.sub-categories', ['category' => $categories]);
    }

   
}
