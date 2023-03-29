<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\FaqRepository;
use App\Http\Requests\FaqRequest;
use App\Http\Requests\FromValidation;


class FaqsController extends Controller
{
    protected FaqRepository $faqRepository;

    public function __construct(FaqRepository $faqRepository)
    {
        parent::__construct('adminData', 'admin');
        $this->faqRepository = $faqRepository;
        $this->breadcrumbTitle = "Faqs";
        $this->breadcrumbs[route('admin.dashboard.index')] = ['icon' => 'fa fa-fw fa-home', 'title' => 'Dashboard'];
    }

    public function index()
    {
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => 'Manage FAQs'];
        return view('admin.faqs.index');
    }

    public function view($id)
    {
        $heading = (($id > 0) ? 'View Store' : 'Add Store');
        $this->breadcrumbs[route('admin.dashboard.articles.index')] = ['icon' => 'fa fa-fw fa-building', 'title' => 'Manage FAQs'];
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => $heading];
        return view('admin.articles.view', [
            'method' => 'PUT',
            'storeId' => $id,
            'action' => route('admin.dashboard.articles.update', $id),
            'heading' => $heading,
            'user' => $this->faqRepository->getViewParams($id),
        ]);
    }

    public function all()
    {
        $columns = [
            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'question', 'dt' => 'question'],
            ['db' => 'answer', 'dt' => 'answer'],
        ];
        $articles = $this->faqRepository->getDataTable($columns);
        return response($articles);

    }

    public function edit($id)
    {
        $heading = (($id > 0) ? 'Edit Faqs' : 'Add Faqs');
        $this->breadcrumbs[route('admin.dashboard.faqs.index')] = ['icon' => 'fa fa-fw fa-building', 'title' => 'Manage Article'];
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => $heading];
        return view('admin.faqs.edit', [
            'heading' => $heading,
            'action' => route('admin.dashboard.faqs.update', $id),
            'faq' => $this->faqRepository->getViewParams($id),
            'faqId' => $id,
        ]);
    }

    public function update(FaqRequest $request, $id)
    {
        $faq = $this->faqRepository->save($request, $id);
        if ($faq) {
            $status = 'Faq Updated Successfully.';
            if ($id == 0) {
                $status = 'Faq Added Successfully.';
            }
            return redirect()->route('admin.dashboard.faqs.index')->with('status', $status);
        }
        return redirect()->back()->withErrors('something went wrong');
    }

    public function show($id)
    {
        dd("show");
    }

    public function destroy($id)
    {

        $data = $this->faqRepository->destroy($id);
        if (!$data) {
            return response(['err' => 'Unable to delete'], 400);
        }
        return response(['msg' => 'Successfully deleted']);
    }
}
