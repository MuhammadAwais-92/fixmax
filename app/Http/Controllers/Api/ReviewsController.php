<?php

namespace App\Http\Controllers\Api;

use App\Http\Dtos\ReviewSaveDto;
use App\Http\Repositories\ReviewRepository;
use App\Http\Requests\ReviewRequest;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class ReviewsController extends Controller
{
    protected $reviewRepository;
    protected $userRepository;
    public function __construct(ReviewRepository $reviewRepository){
        parent::__construct();
        $this->reviewRepository = $reviewRepository;
        $this->breadcrumbs[route('front.dashboard.index')] = ['title' => __('Home')];
    }
    public function save(ReviewRequest $request)
    {
        DB::beginTransaction();
        try {
            $review = $this->reviewRepository->get($request->get('id'));
            if (is_null($review)){
                throw new Exception(__('Review does not exist.'));
            }
            if ($review->user_id != auth()->id()){
                throw new Exception(__('You are not allowed to save this review'));
            }
            if ($review->is_reviewed){
                throw new Exception(__('This review has already been made, please refresh'));
            }
            // $service=Service::find($review->service_id);
            // if(!$service)
            // {
            //     throw new Exception(__('Service has been deleted, You cant give reviews'));
            // }
            $reviewCollection = collect([
                'id' => $request->get('id'),
                'user_id' => $review->user_id,
                'order_id' => $review->order_id,
                'supplier_id' => $review->supplier_id,
                'service_id' => $review->service_id,
                'rating' => $request->get('rating'),
                'review' => $request->get('review'),
                'is_reviewed' => true,
            ]);
            $reviewSaveDto = ReviewSaveDto::fromCollection($reviewCollection);
            $review = $this->reviewRepository->save($reviewSaveDto);
            if ($review) {
                DB::commit();
                return responseBuilder()->success(__('Review added successfully.'), ['review'=>$review]);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return responseBuilder()->error($e->getMessage());
        }

    }

    public function index(Request $request){
        try {
            $this->reviewRepository->setRelations([
                'user:id,user_name,image',
                'service'
            ]);
            $this->reviewRepository->setPaginate($request->get('per_page', 4));
            $reviews = $this->reviewRepository->all(
                $request->get('user_id', 0),
                $request->get('supplier_id', 0),
                $request->get('service_id', 0),
                $request->get('order_id', 0),
                $request->get('is_reviewed', true),
            );
            return responseBuilder()->success(__('reviews'), $reviews);
        } catch (\Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }

    }

}
