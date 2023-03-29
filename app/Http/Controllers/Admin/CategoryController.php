<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\CategoryRepository;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Exception;


class CategoryController extends Controller
{
    public CategoryRepository $categoryRepository;

    public function __construct()
    {
        parent::__construct('adminData', 'admin');
        $this->breadcrumbTitle = 'Categories';
        $this->breadcrumbs[route('admin.dashboard.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
        $this->categoryRepository = new CategoryRepository();
    }

    public function index()
    {
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage Categories'];
        $this->categoryRepository->setSelect([
            'id',
            'name'
        ]);
        $categories = $this->categoryRepository->all(true);
        return view('admin.categories.index', ['categories' => $categories]);
    }

    public function edit($id)
    {
        $this->breadcrumbTitle = 'Categories';
        $heading = (($id > 0) ? 'Edit Category' : 'Add Category');
        $this->breadcrumbs[route('admin.dashboard.categories.index')] = ['icon' => 'fa fa-fw fa-building', 'title' => 'Manage Categories'];
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => $heading];
        $category = $this->categoryRepository->get($id);
        return view('admin.categories.edit', [
            'categoryId' => $id,
            'category' => $category,
            'action' => route('admin.dashboard.categories.update', [$id]),
        ]);
    }


    public function update(CategoryRequest $request, $id)
    {
        try {
            $data = $request->except('_method','_token');
            $category = $this->categoryRepository->save($data, $id);
            if ($id == 0) {
                return redirect(route('admin.dashboard.categories.index'))->with('status', 'category is Added Successfully.');
            } else {
                return redirect(route('admin.dashboard.categories.index'))->with('status', 'category is Updated Successfully.');
            }
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }

    }

    public function destroy($id)
    {
        $this->categoryRepository->destroy($id);
        return response(['msg' => 'Category is Deleted Successfully.']);
    }
}
