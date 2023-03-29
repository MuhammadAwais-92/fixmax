<?php

namespace App\Http\Controllers\Front\Dashboard;

use App\Http\Repositories\UserRepository;
use App\Http\Repositories\ReviewRepository;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    protected $reviewRepository;
    public function __construct(ReviewRepository $reviewRepository){
        parent::__construct();
        $this->reviewRepository = $reviewRepository;
        $this->reviewRepository->setFromWeb(true);
        $this->breadcrumbs[route('front.index')] = ['title' => __('Home')];
    }
    public function index()
    {
        $this->breadcrumbTitle = __('Rating & Reviews');
        $this->breadcrumbs['javascript: {};'] = ['title' => __("Rating & Reviews")];
        $this->reviewRepository->setPaginate(4);
        $this->reviewRepository->setRelations([
            'user:id,user_name,image'
        ]);
        $reviews = $this->reviewRepository->all(0,auth()->id(),0, 0,true);
        return view('front.dashboard.review.index',['reviews'=>$reviews]);
    }

}
