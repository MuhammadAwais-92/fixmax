<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\CategoryRepository;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Exception;


class SubCategoryController extends Controller
{
    public CategoryRepository $categoryRepository;

    public function __construct()
    {
        parent::__construct('adminData', 'admin');
        $this->breadcrumbTitle = 'Sub Categories';
        $this->breadcrumbs[route('admin.dashboard.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
        $this->categoryRepository = new CategoryRepository();
    }

  

    public function edit($parentId,$id)
    {
        $Category = $this->categoryRepository->get($parentId);
        $this->breadcrumbTitle = $Category->name['en'];
        $heading = (($id > 0) ? 'Edit Subcategory' : 'Add Subcategory');
        $this->breadcrumbs[route('admin.dashboard.categories.index')] = ['icon' => 'fa fa-fw fa-building', 'title' => 'Manage Categories'];
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => $heading];
        return view('admin.sub-categories.edit', [
            'categoryId' => $id,
            'category' => $this->categoryRepository->get($id),
            'action' => route('admin.dashboard.categories.sub-categories.update',[$parentId,$id]),
            'parent' => $parentId
        ]);
    }


    public function update(CategoryRequest $request,$parentId, $id)
    {
        try {
            $data = $request->except('_method','_token');
            $subCategory = $this->categoryRepository->save($data, $id);
            if ($id == 0) {
                return redirect(route('admin.dashboard.categories.index'))->with('status', 'Subcategory is Added Successfully.');
            } else {
                return redirect(route('admin.dashboard.categories.index'))->with('status', 'Subcategory is Updated Successfully.');
            }
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }

    }

    public function destroy($id)
    {
        $this->categoryRepository->destroy($id);
        return response(['msg' => 'City is Deleted Successfully.']);
    }
}
