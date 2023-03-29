<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Admin\OfferBannerController;
use App\Http\Dtos\AdminDto;
use App\Http\Libraries\Uploader;
use App\Http\Repositories\AdminRepository;
use App\Http\Repositories\InfoPagesRepository;
use App\Http\Dtos\SendEmailDto;
use App\Http\Repositories\ArticleRepository;
use App\Http\Repositories\GalleryRepository;
use App\Http\Repositories\FaqRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Repositories\ServiceRepository;
use App\Http\Repositories\ProjectRepository;
use App\Http\Repositories\CityRepository;
use App\Http\Requests\AdminRequest;
use App\Http\Controllers\Controller;
use App\Http\Repositories\CartRepository;
use App\Http\Repositories\CategoryRepository;
use App\Http\Repositories\CouponRepository;
use App\Http\Repositories\EquipmentRepository;
use App\Http\Repositories\OfferBannerRepository;
use App\Http\Repositories\ReviewRepository;
use App\Http\Requests\CouponRequest;
use App\Http\Requests\CoveredAreaRequest;
use App\Http\Requests\ImageRequest;
use App\Http\Requests\UserRequest;
use App\Jobs\ContactUs;
use App\Models\City;
use App\Models\Equipment;
use App\Models\Review;
use App\Models\UserArea;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

class IndexController extends Controller
{
    protected $reviewRepository, $cartRepository, $equipmentRepository,$couponRepository,$offerRepository, $serviceRepository, $categoryRepository, $pagesRepository, $userRepository, $articleRepository, $galleryRepository, $faqRepository, $projectRepository;
    public function __construct(ReviewRepository $reviewRepository,OfferBannerRepository $offerRepository,CouponRepository $couponRepository, CartRepository $cartRepository, EquipmentRepository $equipmentRepository, CategoryRepository $categoryRepository, CityRepository $cityRepository, ServiceRepository $serviceRepository, UserRepository $userRepository, InfoPagesRepository $pagesRepository, GalleryRepository $galleryRepository, ArticleRepository $articleRepository, FaqRepository $faqRepository, ProjectRepository $projectRepository)
    {
        parent::__construct();
        $this->pagesRepository = $pagesRepository;
        $this->pagesRepository->setFromWeb(true);
        $this->articleRepository = $articleRepository;
        $this->articleRepository->setFromWeb(true);
        $this->faqRepository = $faqRepository;
        $this->faqRepository->setFromWeb(true);
        $this->galleryRepository = $galleryRepository;
        $this->galleryRepository->setFromWeb(true);
        $this->userRepository = $userRepository;
        $this->userRepository->setFromWeb(true);
        $this->serviceRepository = $serviceRepository;
        $this->serviceRepository->setFromWeb(true);
        $this->projectRepository = $projectRepository;
        $this->projectRepository->setFromWeb(true);
        $this->cityRepository = $cityRepository;
        $this->cityRepository->setFromWeb(true);
        $this->categoryRepository = $categoryRepository;
        $this->categoryRepository->setFromWeb(true);
        $this->equipmentRepository = $equipmentRepository;
        $this->equipmentRepository->setFromWeb(true);
        $this->cartRepository = $cartRepository;
        $this->cartRepository->setFromWeb(true);
        $this->reviewRepository = $reviewRepository;
        $this->reviewRepository->setFromWeb(true);
        $this->couponRepository = $couponRepository;
        $this->couponRepository->setFromWeb(true);
        $this->offerRepository = $offerRepository;
        $this->offerRepository->setFromWeb(true);
    }

    public function index(Request $request)
    {
        $this->categoryRepository->setPaginate(5);
        $categories = $this->categoryRepository->all(true);
        $ss_data = session()->get('area_id');
        $this->userRepository->setPaginate(8);
        $this->userRepository->setRelations([
            'category:id,name'
        ]);
        $request->merge(['area_id' => $ss_data, 'popular' => true]);
        $suppliers = $this->userRepository->supplierfilter(1, $request);
        if ($ss_data !== null) {
            foreach ($suppliers as $supplier) {
                $supplier->getSelectedAddressAndTime($supplier, $ss_data);
            }
        }
        $this->serviceRepository->setPaginate(0);
        $this->serviceRepository->setRelations([
            'supplier:id,supplier_name',
        ]);
        $ss_data = session()->get('area_id');
        $request->merge(['categoriesWhereHas' => 1, 'idCardVerified' => 1, 'area_id' => $ss_data, 'popular' => true]);
        $services = $this->serviceRepository->servicefilter($request->all());
        foreach ($services as $service) {
            $service->getFormattedModel();
        }
        $aboutUs = $this->pagesRepository->getslug(config('settings.about_us'));
        $vision = $this->pagesRepository->getslug(config('settings.our_vision'));
        $mission = $this->pagesRepository->getslug(config('settings.our_mission'));
        $offers = $this->offerRepository->all();
        return view('front.home.index', [
            'categories' => $categories,
            'suppliers'   => $suppliers,
            'services'   => $services,
            'aboutUs' => $aboutUs,
            'vision'   => $vision,
            'mission'   => $mission,
            'offers' => $offers
        ]);
    }

    public function error404()
    {
        $this->breadcrumbs[1] = ['url' => route('front.index'), 'title' => '404'];

        return view('front.home.404');
    }
    public function SaveArea(Request $request)
    {
        try {

            if ($request->area_id) {

                session()->put('area_id', $request->area_id);
            } else {
                session()->put('area_id', null);
            }

            return redirect()->back()->with('status', __(''));
        } catch (Exception $e) {
            return redirect(route('front.404'))->with('err', $e->getMessage());
        }
    }
    public function SaveUserData(Request $request)
    {

        if ($request->id) {

            session()->put('area_id', $request->id);
        } else {
            session()->put('area_id', null);
        }


        return true;

        // $request->validate([
        //     'city_id' => 'required',
        //     'area_id' => 'required',
        // ]);

        //     $data = [];
        //     $data['city_id'] = $request->city_id;
        //     $data['area_id'] = $request->area_id;
        //     session()->put('city_id', $request->city_id);
        //     session()->put('area_id', $request->area_id);
        //     session()->put('user_data', $data);
        //     return redirect()->route('front.index')->with(__('status'), __('Save Successfully'));


        // $request->validate([
        //     'city_id' => 'required',
        //     'area_id' => 'required',
        //     'address' => 'required',
        //     'longitude' => 'required',
        //     'latitude'  => 'required',
        // ]);
        // $city = City::where('id', $request->area_id)->where('parent_id', $request->city_id)->first();
        // $polygon_lat = [];
        // $polygon_lng = [];
        // $count_polygon = count($city->polygon);
        // foreach ($city->polygon as $item) {
        //     array_push($polygon_lat, $item['lat']);
        //     array_push($polygon_lng, $item['lng']);
        // }

        // if (Check_is_in_polygon($count_polygon - 1, $polygon_lng, $polygon_lat, $request->longitude, $request->latitude)) {
        //     $data = [];
        //     $data['city_id'] = $request->city_id;
        //     $data['address'] = $request->address;
        //     $data['latitude'] = $request->latitude;
        //     $data['longitude'] = $request->longitude;
        //     $data['area_id'] = $request->area_id;
        //     session()->put('city_id', $request->city_id);
        //     session()->put('address', $request->address);
        //     session()->put('latitude', $request->latitude);
        //     session()->put('longitude', $request->longitude);
        //     session()->put('area_id', $request->area_id);

        //     session()->put('user_data', $data);
        //     return redirect()->route('front.index')->with(__('status'), __('Save Successfully'));
        // } else {
        //     session()->forget('user_data');
        //     return redirect()->back()->with('err', __('Address is not found in the selected area'));
        // }
    }
    public function pages($slug)
    {
        try {
            if ($slug == "contact-us") {
                $this->breadcrumbs[url(route('front.index'))] = ['title' => __('home')];
                $this->breadcrumbTitle = __('Contact Us');
                $this->breadcrumbs['javascript: {};'] = ['title' => __('Contact Us')];
                return view('front.home.contact');
            }
            $pageData = $this->pagesRepository->getslug($slug);
            $this->breadcrumbs[url(route('front.index'))] = ['title' => __('home')];
            $this->breadcrumbTitle = __(translate($pageData->name));
            $this->breadcrumbs['javascript: {};'] = ['title' => translate($pageData->name)];


            if ($slug == config('settings.privacy_policy')) {
                return view('front.home.privacy-policy', ['page' => $pageData]);
            }

            if ($slug == config('settings.mission_vision')) {
                return view('front.home.terms-and-conditions', ['page' => $pageData]);
            }
            if ($slug == config('settings.terms_and_conditions')) {
                return view('front.home.terms-and-conditions', ['page' => $pageData]);
            }

            if ($slug == config('settings.about_us')) {
                $this->breadcrumbTitle = __('About Us');
                $this->breadcrumbs['javascript: {};'] = ['title' => __('About Us')];
                $vision = $this->pagesRepository->getslug(config('settings.our_vision'));
                $mission = $this->pagesRepository->getslug(config('settings.our_mission'));
                return view('front.home.about-us', ['page' => $pageData, 'vision' => $vision, 'mission' => $mission]);
            }
            return view('front.home.pages', ['page' => $pageData]);
        } catch (Exception $e) {
            return redirect(route('front.404'))->with('err', $e->getMessage());
        }
    }
    public function articles()
    {
        $this->breadcrumbs[url(route('front.index'))] = ['title' => __('home')];
        $this->breadcrumbTitle = __('Articles');
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Articles')];
        $this->articleRepository->setPaginate(4);
        $articles = $this->articleRepository->all();
        return view('front.home.article', ['articles' => $articles]);
    }
    public function couponValidate(CouponRequest $request)
    {
        try {

            $data = $this->couponRepository->addUserCoupon($request->get('code'));
            if ($data == "expired") {
                return redirect()->back()->with('err', __('Coupon is expired'));
            }

            if ($data == "finished") {
                return redirect()->back()->with('err', __('Coupon is Expired Or Finished.'));
            }

            return redirect()->back()->with('status', __('Coupon is applied successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with('err', 'Something Went Wrong.');
        }
    }

    public function articleDetail($slug)
    {
        $article = $this->articleRepository->get($slug);
        if (!is_null($article)) {
            $article_name = translate($article->name);
            $this->breadcrumbTitle = __('Article Detail');
            $this->breadcrumbs[] = ['url' => route('front.index'), 'title' => __('Home')];
            $this->breadcrumbs[] = ['url' => route('front.articles'), 'title' => __('Articles')];
            $this->breadcrumbs['javascript: {};'] = ['title' => __('Article Detail')];
            return view('front.home.article-detail', ['article' => $article]);
        }
        return redirect(route('front.404'))->with('err', __('No record found'));
    }
    public function faqs()
    {
        $this->breadcrumbs[url(route('front.index'))] = ['title' => __('home')];
        $this->breadcrumbTitle = __("FAQs");
        $this->breadcrumbs['javascript: {};'] = ['title' => __("FAQs")];
        $this->faqRepository->setPaginate(0);
        $faqs = $this->faqRepository->all();
        return view('front.home.faqs', ['faqs' => $faqs]);
    }
    public function gallery()
    {
        $this->breadcrumbs[url(route('front.index'))] = ['title' => __('home')];
        $this->breadcrumbTitle = __('Image Gallery');
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Image Gallery')];
        $this->galleryRepository->setPaginate(9);
        $images = $this->galleryRepository->all();
        return view('front.home.gallery', ['images' => $images]);
    }
    public function suppliers(Request $request)
    {
        $ss_data = session()->get('area_id');
        // if ($ss_data == null) {
        //     return redirect()->route('front.index')->with('err', __('Please Select Your Area First'));
        // }
        $this->breadcrumbs[url(route('front.index'))] = ['title' => __('home')];
        $this->breadcrumbTitle = __('Suppliers');
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Suppliers')];
        $categories = $this->categoryRepository->all(true);

        $this->userRepository->setPaginate(6);
        $this->userRepository->setRelations([
            'category:id,name'
        ]);
        $request->merge(['area_id' => $ss_data, 'popular' => true]);
        $suppliers = $this->userRepository->supplierfilter(1, $request);
        // dd($suppliers);
        if ($ss_data !== null) {
            foreach ($suppliers as $supplier) {
                $supplier->getSelectedAddressAndTime($supplier, $ss_data);
            }
        }
        if ($request->display_type == 'list') {
            return view('front.home.suppliers-list', ['suppliers' => $suppliers, 'categories' => $categories]);
        } else {
            return view('front.home.suppliers', ['suppliers' => $suppliers, 'categories' => $categories]);
        }
    }
    public function supplierDetail(Request $request, $id)
    {

        $ss_data = session()->get('area_id');
        // if ($ss_data == null) {
        //     return redirect()->route('front.index')->with('err', __('Please Select Your Area First'));
        // }
        $userId = 0;
        if (auth()->check() && auth()->user()->isUser()) {
            $userId = auth()->id();
        }
        $this->userRepository->setRelations([
            'category:id,name',
            'pendingReviews' => function ($q) use ($userId) {
                $q->select(['id', 'user_id', 'service_id', 'supplier_id', 'rating', 'review', 'is_reviewed'])->where('user_id', $userId);
            },
        ]);
        $supplier = $this->userRepository->get($id);
        $this->reviewRepository->setPaginate(4);
        $this->reviewRepository->setRelations([
            'user:id,user_name,image',
            'service'
        ]);
        $reviews = $this->reviewRepository->all(
            $request->get('user_id', 0),
            $request->get('supplier_id', $supplier->id),
            $request->get('service_id', 0),
            $request->get('order_id', 0),
            $request->get('is_reviewed', true),
        );
        $ss_data = session()->get('area_id');
        if ($ss_data !== null) {
            $supplier = $supplier->getSelectedAddressAndTime($supplier, $ss_data);
        }
        $this->breadcrumbTitle = __(translate($supplier->supplier_name));
        $this->breadcrumbs[] = ['url' => route('front.index'), 'title' => __('Home')];
        $this->breadcrumbs[] = ['url' => route('front.suppliers'), 'title' => __('Suppliers')];
        $this->breadcrumbs['javascript: {};'] = ['title' => __(translate($supplier->supplier_name))];
        $this->projectRepository->setPaginate(4);
        $projects = $this->projectRepository->supplierProjects($supplier->id);
        $reviewBars=Review::where('supplier_id',$supplier->id)->where('is_reviewed',true)->get();
        $rewBar=$this->reviewRepository->getBars($reviewBars);
        return view('front.home.supplier-detail', ['supplier' => $supplier, 'projects' => $projects, 'reviews' => $reviews,'rewBar'=>$rewBar]);
    }
    public function serviceDetail(Request $request, $slug)
    {
        $ss_data = session()->get('area_id');
        // if ($ss_data == null) {
        //     return redirect()->route('front.index')->with('err', __('Please Select Your Area First'));
        // }
        $userId = 0;
        if (auth()->check() && auth()->user()->isUser()) {
            $userId = auth()->id();
        }
        $this->serviceRepository->setRelations([
            'supplier.category',
            'images:id,file_path,file_default,file_type,service_id',
            'equipments' => function ($q) use ($userId) {
                $q->where('is_active', '1');
            },
            'pendingReviews' => function ($q) use ($userId) {
                $q->select(['id', 'user_id', 'service_id', 'rating', 'review', 'is_reviewed'])->where('user_id', $userId);
            },
        ]);
        $service = $this->serviceRepository->detail($slug);
        $this->reviewRepository->setPaginate(3);
        $this->reviewRepository->setRelations([
            'user:id,user_name,image',
            'service'
        ]);
        $reviews = $this->reviewRepository->all(
            $request->get('user_id', 0),
            $request->get('supplier_id', 0),
            $request->get('service_id', $service->id),
            $request->get('order_id', 0),
            $request->get('is_reviewed', true),
        );
        $userData = '';
        if (Auth::check() && Auth::user()->user_type == 'user') {
            $this->cartRepository->setRelations([
                'service',
                'service.images',
                'equipments'
            ]);
            $userData = $this->cartRepository->get($this->user->id, $service->id);
            if ($userData) {
                $userData->getFormattedModel();
            }
        }
        $this->breadcrumbTitle = __(translate($service->name));
        $this->breadcrumbs[] = ['url' => route('front.index'), 'title' => __('Home')];
        $this->breadcrumbs[] = ['url' => route('front.suppliers'), 'title' => __('Suppliers')];
        $this->breadcrumbs[] = ['url' => route('front.supplier-detail',$service->supplier->id), 'title' => __(translate($service->supplier->supplier_name))];
        $this->breadcrumbs[] = ['url' => route('front.services',['supplier_id' => $service->supplier->id]), 'title' => __('Services')];
        $this->breadcrumbs['javascript: {};'] = ['title' => __(translate($service->name))];
        $service->getFormattedModel();
        $reviewBars=Review::where('service_id',$service->id)->where('is_reviewed',true)->get();
        $rewBar=$this->reviewRepository->getBars($reviewBars);
        $ids = $service->supplier->coveredareas->pluck('id')->toArray();

        if (!in_array(session()->get('area_id'), $ids)) {
            session()->put('area_id', null);
        }
        return view('front.home.service-detail', ['service' => $service, 'cartData' => $userData, 'reviews' => $reviews,'rewBar'=> $rewBar]);
    }
    public function services(Request $request)
    {
         $ss_data = session()->get('area_id');
        // if ($ss_data == null) {
        //     return redirect()->route('front.index')->with('err', __('Please Select Your Area First'));
        // }
        $this->breadcrumbs[url(route('front.index'))] = ['title' => __('home')];
        $this->breadcrumbTitle = __('Services');
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Services')];

        $this->serviceRepository->setPaginate(6);
        $this->serviceRepository->setRelations([
            'supplier:id,supplier_name',
        ]);
         $ss_data = session()->get('area_id');
        $request->merge(['categoriesWhereHas' => 1, 'idCardVerified' => 1, 'area_id' => $ss_data, 'popular' => true]);
        $categories = $this->categoryRepository->all(true);
        $services = $this->serviceRepository->servicefilter($request->all());

        foreach ($services as $service) {
            $service->getFormattedModel();
        }
        if ($request->service == 'featured') {
            $this->breadcrumbs[url(route('front.index'))] = ['title' => __('home')];
            $this->breadcrumbTitle = __('Featured Services');
            $this->breadcrumbs['javascript: {};'] = ['title' => __('Featured Services')];
        }
        if ($request->service == 'offer') {
            $this->breadcrumbs[url(route('front.index'))] = ['title' => __('home')];
            $this->breadcrumbTitle = __('Offers');
            $this->breadcrumbs['javascript: {};'] = ['title' => __('Offers')];
        }
        $request = new \Illuminate\Http\Request();
        $request->merge(['categoriesWhereHas' => 1, 'idCardVerified' => 1, 'area_id' => $ss_data]);
        $suppliers = $this->userRepository->supplierfilter(1, $request);
        return view('front.home.services', ['services' => $services, 'categories' =>  $categories, 'suppliers' => $suppliers]);
    }
    public function projectDetail($id)
    {


        $this->projectRepository->setRelations([
            'images:id,file_path,file_default,file_type,project_id',
        ]);
        $project = $this->projectRepository->get($id);
        $this->breadcrumbTitle = __(translate($project->name));
        $this->breadcrumbs[] = ['url' => route('front.index'), 'title' => __('Home')];
        $this->breadcrumbs[] = ['url' => route('front.suppliers'), 'title' => __('Suppliers')];
        $this->breadcrumbs['javascript: {};'] = ['title' => __(translate($project->supplier->supplier_name))];
        return view('front.home.project-detail', ['project' => $project]);
    }
    public function contactEmail(UserRequest $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email',
                'subject' => 'required',
                'message_text' => 'required',
            ]);
            $data = $request->all();
            $data['receiver_email'] = config('settings.email');
            $data['receiver_name'] = config('settings.company_name');
            $data['sender_name'] = config('settings.company_name');
            $data['sender_email'] = $data['email'];

            //            $email = $this->sendMail($data, 'emails.user.contact_us', strtoupper($data['subject']), $data['receiver_email'], $data['sender_email']);


            $dataToSend = collect([
                'receiver_name' => config('settings.company_name'),
                'receiver_email' => config('settings.email'),
                'subject' => strtoupper($data['subject']),
                'view' => 'emails.user.contact_us',
                'sender_email' => $data['email'],
                'sender_name' => config('settings.company_name'),
                'code' => $data['message_text'],
                'link' => ''
            ]);

            $sendEmailDto = SendEmailDto::fromCollection($dataToSend);
            ContactUs::dispatch($sendEmailDto);

            return redirect()->back()->with('status', __('Contact Email Sent Successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with('err', $e->getMessage())->withInput();
        }
    }
    public function getEquipments(Request $request)
    {
        $id = $request->ids;
        $equipments = Equipment::whereIn('id', $id)->get();
        $data = '';
        $i = 0;
        foreach ($equipments as $equipment) {
            $data .= '<div class="col-sm-6 col-6-ctm px-0 cols">
        <div class="portfolio-add-card add-equipment">
            <div class="img-add-del-btn">
                <div class="img-block">
                    <img src="' . imageUrl(url($equipment->image_url), 246, 150, 100, 1) . '" alt="portfolio-img"
                        class="img-fluid portfolio-img">
                </div>
            </div>
            <input type="hidden" class="equipment-ids" id="' . $equipment->id . '" value="' . $equipment->id . '" name="equipment[' . $i . '][equipment_id]" required>
            <h3 class="price text-truncate">
                AED' . $equipment->price . '
            </h3>
            <h3 class="title text-truncate">
            ' . translate($equipment->name) . '
            </h3>
            <h3 class="title text-truncate">
               ' . $equipment->equipment_model . ' - ' . $equipment->make . '
            </h3>
            <input type="number" class="ctm-input quantity quant-input mt-1" min="1" value="1" name="equipment[' . $i . '][quantity]">
            <button class="close-btn">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>';
            $i++;
        }


        return response(['status_code' => '200', 'data' =>  $data]);
    }
}
