<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\GalleryRepository;
use App\Http\Requests\GalleryRequest;
use App\Http\Requests\FromValidation;


class GalleriesController extends Controller
{
    protected GalleryRepository $galleryReposiroty;

    public function __construct(GalleryRepository $galleryRepository)
    {
        parent::__construct('adminData', 'admin');
        $this->galleryRepository = $galleryRepository;
        $this->breadcrumbTitle = "Gallery";
        $this->breadcrumbs[route('admin.dashboard.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
    }

    public function index()
    {
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage Galleries'];
        return view('admin.galleries.index');
    }

    public function view($id)
    {
        $heading = (($id > 0) ? 'View Store' : 'Add Store');
        $this->breadcrumbs[route('admin.dashboard.articles.index')] = ['icon' => 'fa fa-fw fa-building', 'title' => 'Manage Articles'];
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => $heading];
        return view('admin.articles.view', [
            'method' => 'PUT',
            'storeId' => $id,
            'action' => route('admin.dashboard.articles.update', $id),
            'heading' => $heading,
            'user' => $this->galleryRepository->getViewParams($id),
        ]);
    }

    public function all()
    {
        $columns = [
            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'image', 'dt' => 'image'],
        ];
        $galleries = $this->galleryRepository->getDataTable($columns);
        return response($galleries);

    }

    public function edit($id)
    {
        $heading = (($id > 0) ? 'Edit Image' : 'Add Image');
        $this->breadcrumbs[route('admin.dashboard.galleries.index')] = ['icon' => 'fa fa-fw fa-building', 'title' => 'Manage Article'];
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => $heading];
        return view('admin.galleries.edit', [
            'heading' => $heading,
            'action' => route('admin.dashboard.galleries.update', $id),
            'gallery' => $this->galleryRepository->getViewParams($id),
            'galleryId' => $id,
        ]);
    }

    public function update(GalleryRequest $request, $id)
    {
        $gallery = $this->galleryRepository->save($request, $id);
        if ($gallery) {
            $status = 'Gallery Updated Successfully.';
            if ($id == 0) {
                $status = 'Gallery Added Successfully.';
            }
            return redirect()->route('admin.dashboard.galleries.index')->with('status', $status);
        }
        return redirect()->back()->withErrors('something went wrong');
    }

    public function show($id)
    {
        dd("show");
    }

    public function destroy($id)
    {

        $data = $this->galleryRepository->destroy($id);
        if (!$data) {
            return response(['err' => 'Unable to delete'], 400);
        }
        return response(['msg' => 'Successfully deleted']);
    }
}
