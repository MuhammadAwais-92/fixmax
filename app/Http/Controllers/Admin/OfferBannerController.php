<?php

namespace App\Http\Controllers\Admin;
use App\Http\Dtos\OfferUpdateDto;

use App\Http\Requests\PageRequest;
use App\Http\Controllers\Controller;
use App\Http\Repositories\OfferBannerRepository;
use App\Models\Page;
use Illuminate\Http\Request;

class OfferBannerController extends Controller {
    protected $offerBannerRepository;
    public function __construct(OfferBannerRepository $offerBannerRepository) {
        parent::__construct('adminData', 'admin');
        $this->offerBannerRepository = $offerBannerRepository;
        $this->breadcrumbTitle = 'Offer Banner';
        $this->breadcrumbs[route('admin.dashboard.index')] = ['icon' => 'fa fa-fw fa-home','title' => 'Dashboard'];
    }
    public function index()
    {
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage Offer Banner'];
        return view('admin.offers.index');
    }
    public function all(){
        $pages = $this->offerBannerRepository->allPages();
        return response($pages);
    }
    public function edit($id) {
        $heading = (($id > 0) ? 'Edit Offer':'Add Offer');
        $this->breadcrumbs[route('admin.dashboard.offers.index')] = ['icon' => 'fa fa-fw fa-building', 'title' => 'Manage Offer Banner'];
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => $heading];
        return view('admin.offers.edit', [
            'method' => 'PUT',
            'pageId' => $id,
            'action' => route('admin.dashboard.offers.update', $id),
            'heading' => $heading,
            'page' => $this->offerBannerRepository->get($id)
        ]);
    }

    public function update(PageRequest $request, $id) {
        try {
            $offerDto = OfferUpdateDto::fromRequest($request);
            $this->offerBannerRepository->save($offerDto);
            if ($id == 0){
                return redirect(route('admin.dashboard.offers.index'))->with('status', 'Offer added successfully.');

            }
            return redirect(route('admin.dashboard.offers.index'))->with('status', 'Offer updated successfully.');
        }
        catch (\Exception $e){
            return response(['err'=>$e->getMessage()]);
        }
    }

    public function destroy($id) {
        try {
            $this->offerBannerRepository->destroyPage($id);
            return response(['msg' => 'Page deleted']);
        }
        catch (\Exception $e){
            return response(['err'=>$e->getMessage()]);
        }
    }

}
