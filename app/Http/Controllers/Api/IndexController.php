<?php

namespace App\Http\Controllers\Api;

use App\Http\Dtos\AdminDto;
use App\Http\Libraries\Uploader;
use App\Http\Repositories\AdminRepository;
use App\Http\Requests\AdminRequest;
use App\Http\Controllers\Controller;
use App\Http\Repositories\ArticleRepository;
use App\Http\Repositories\CityRepository;
use App\Http\Repositories\FaqRepository;
use App\Http\Dtos\SendEmailDto;
use App\Http\Middleware\Language;
use App\Http\Repositories\CouponRepository;
use App\Jobs\ContactUs;
use App\Http\Repositories\GalleryRepository;
use App\Http\Repositories\InfoPagesRepository;
use App\Http\Repositories\ProjectRepository;
use App\Http\Repositories\ServiceRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\CouponRequest;
use App\Http\Requests\ImageRequest;
use App\Http\Requests\ProjectRequest;
use App\Models\City;
use App\Models\Equipment;
use App\Models\Language as ModelsLanguage;
use App\Models\UserArea;
use Exception;
use Illuminate\Http\Request;
use App\Models\Language as Lang;

class IndexController extends Controller
{
    protected CityRepository $cityRepository;
    protected InfoPagesRepository $pagesRepository;
    protected ArticleRepository $articleRepository;
    protected FaqRepository $faqRepository;
    protected GalleryRepository $galleryRepository;
    protected UserRepository $userRepository;
    protected ProjectRepository $projectRepository;
    protected ServiceRepository $serviceRepository;
    protected CouponRepository $couponRepository;





    public function __construct()
    {
        parent::__construct();
        $this->cityRepository = new CityRepository();
        $this->pagesRepository = new InfoPagesRepository();
        $this->articleRepository = new ArticleRepository();
        $this->faqRepository = new FaqRepository();
        $this->galleryRepository = new GalleryRepository();
        $this->userRepository = new UserRepository();
        $this->projectRepository = new ProjectRepository();
        $this->serviceRepository = new ServiceRepository();
        $this->couponRepository = new CouponRepository();
        
    }
    public function uploadImage(ImageRequest $request)
    {
        try {
            $path = 'front/media';
            $input = 'image';
            if ($request->filled('path')) {
                $path = $request->path;
            }
            if ($request->filled('input')) {
                $input = $request->input;
            }
            if ($request->hasFile($input)) {
                $image = uploadImage($request->file($input), $path, $input);
            } else {
                throw new Exception(__('Something went wrong'));
            }
            return responseBuilder()->success(__('Image Uploaded'), $image);
        } catch (Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }
    public function notificationCount(){
        
        $data['noti_count'] = $this->notificationRepository->count();
 


        return responseBuilder()->success(__('notificationCount'),$data); 
    }
    public function userArea(Request $request)
    {
        $request->validate([
            'city_id'   => 'required',
            'area_id'   => 'required',
            'address'   => 'required',
            'longitude' => 'required',
            'latitude'  => 'required',
        ]);
        $city = City::where('id', $request->area_id)->where('parent_id', $request->city_id)->first();

        $polygon_lat = [];
        $polygon_lng = [];

        $count_polygon = count($city->polygon);
        foreach ($city->polygon as $item) {
            array_push($polygon_lat, $item['lat']);
            array_push($polygon_lng, $item['lng']);
        }


        if (Check_is_in_polygon($count_polygon - 1, $polygon_lng, $polygon_lat, $request->longitude, $request->latitude)) {
            // session()->put('area_id', $request->area_id);
            // session()->put('city_id', $request->city_id);
            // session()->put('address', $request->address);
            // session()->put('longitude', $request->longitude);
            // session()->put('latitude', $request->latitude);
            return responseBuilder()->success( __('Save Successfully'));
        } else {
            return  responseBuilder()->error( __('Address is not found in the selected area'));
        }
        return redirect()->back();
    }
    public function getAreas(Request $request, $id)
    {
        $areas = $this->cityRepository->areas($id);
        return responseBuilder()->success('Areas', $areas);
    }
    public function removeImage(Request $request)
    {
        deleteImage($request->image);
        return responseBuilder()->success(__('Image Delete Successfully'));
    }
   public function services(Request $request)
   {
    try {
        $ss_data = $request->get('area_id');
  
        $this->serviceRepository->setPaginate(6);
        $this->serviceRepository->setRelations([
            'supplier:id,supplier_name',
        ]);
        $request->merge(['categoriesWhereHas'=>1,'idCardVerified' => 1,'area_id' => $ss_data]);
        $services = $this->serviceRepository->servicefilter($request->all());
        foreach ($services as $service) {
            $service->getFormattedModel();
        }
        return responseBuilder()->success(__('Services'),  $services);
    } catch (Exception $e) {
        return responseBuilder()->error($e->getMessage());
    }
   }
   public function serviceDetail(Request $request,$slug)
   {
    try {
        $userId = 0;
        if (auth()->check() && auth()->user()->isUser()){
            $userId = auth()->id();
        }
        $this->serviceRepository->setRelations([
            'supplier.category',
            'supplier.coveredareas',
            'images:id,file_path,file_default,file_type,service_id',
            'pendingReviews'=>function($q) use($userId){
                $q->select(['id','user_id','service_id','rating','review','is_reviewed'])->where('user_id', $userId);
            },
        ]);
        $service=$this->serviceRepository->detail($slug);
        $service->getFormattedModel();
        if($request->get('area_id'))
        $service->estimated_time=UserArea::where('user_id',$service->supplier->id)->where('city_id',$request->get('area_id'))->first()->estimated_time;
        return responseBuilder()->success(__('Service Detail'), ['detail' => $service]);
    } catch (Exception $e) {
        return responseBuilder()->error($e->getMessage());
    }
   }
    public function pages($slug)
    {
        try {
            $this->pagesRepository->setPaginate(16);
            $pageData = $this->pagesRepository->getslug($slug);
            return responseBuilder()->success(__('Pages'), ['Info Pages' => $pageData]);
        } catch (Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }
    public function missionandvision()
    {
        try {
            
            $missionData = $this->pagesRepository->getslug('our-mission');
            $visionData = $this->pagesRepository->getslug('our-vision');
              $data['missionData']=$missionData;
              $data['visionData']=$visionData;
            return responseBuilder()->success(__('Pages'),  $data);
        } catch (Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }
    public function articleDetail($slug)
    {
        try {
            $article = $this->articleRepository->get($slug);
            return responseBuilder()->success(__('Article'), ['detail' => $article]);
        } catch (Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }
    public function gallery()
    {
        try {
            $this->galleryRepository->setPaginate(9);
            $images = $this->galleryRepository->all();
            return responseBuilder()->success(__('Gallery'), $images);
        } catch (Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }
    public function faqs()
    {
        try {
            $faqs = $this->faqRepository->all();
            return responseBuilder()->success(__('Faqs'),  $faqs);
        } catch (Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }
    public function contactEmail(Request $request)
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

            return responseBuilder()->success(__('Contact Email Sent Successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with('err', $e->getMessage())->withInput();
        }
    }
    public function suppliers(Request $request)
    {
        try {
            
            $ss_data = $request->get('area_id');

   
            // $city = City::where('id', $ss_data['area_id'])->where('parent_id', $ss_data['city_id'])->first();
            // $polygon_lat = [];
            // $polygon_lng = [];
            // $count_polygon = count($city->polygon);
            // foreach ($city->polygon as $item) {
            //     array_push($polygon_lat, $item['lat']);
            //     array_push($polygon_lng, $item['lng']);
            // }
    
            // if (!Check_is_in_polygon($count_polygon - 1, $polygon_lng, $polygon_lat, $ss_data['longitude'],$ss_data['latitude'])) {
      
            //     return responseBuilder()->error(__('Address not found'));
            // } 
          
            $this->userRepository->setPaginate(8);
            $this->userRepository->setRelations([
                'category:id,name'
            ]);
            $suppliers = $this->userRepository->supplierfilter(1, $request);
      
            if ($ss_data !== null) {
                foreach ($suppliers as $supplier) {
                    $supplier->getSelectedAddressAndTime($supplier, $ss_data);
                }
            }
            return responseBuilder()->success(__('Suppliers'),  $suppliers);
        } catch (Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }
    public function supplierDetail(Request $request,$id)
    {
        try {
            $ss_data = $request->get('area_id');
            $userId = 0;
            if (auth()->check() && auth()->user()->isUser()){
                $userId = auth()->id();
            }
            $this->userRepository->setRelations([
                'category:id,name',
                'pendingReviews'=>function($q) use($userId){
                    $q->select(['id','user_id','service_id','supplier_id','rating','review','is_reviewed'])->where('user_id', $userId);
                },
            ]);
            $supplier=$this->userRepository->get($id);
            if($ss_data!==null)
            {
                $supplier=$supplier->getSelectedAddressAndTime($supplier,$ss_data);
            }
            $this->projectRepository->setPaginate(8);
            $projects=$this->projectRepository->supplierProjects($supplier->id);
            return responseBuilder()->success(__('Supplier Detail'), ['suppliers' => $supplier,'projects' => $projects]);
        } catch (Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
       
    }
    public function supplierPortfolio(Request $request)
    {
        try {
            $this->projectRepository->setPaginate(8);
            $portfolio=$this->projectRepository->supplierProjects($request->supplier_id);
            return responseBuilder()->success(__('portfolio'), $portfolio );
        } catch (Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }
    public function projectDetail($id)
    {
        try {
            $this->projectRepository->setRelations([
                'images:id,file_path,file_default,file_type,project_id',
            ]);
            $project = $this->projectRepository->get($id);
            return responseBuilder()->success(__('project'), ['project' => $project] );
        } catch (Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }
    public function getEquipments($id)
    {
        try {
          
            $equipments = Equipment::where('service_id',$id)->get();
            return responseBuilder()->success(__('equipments'),  $equipments);
        } catch (Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }

    public function articles()
    {
        try {
            $this->articleRepository->setPaginate(16);
            $articles = $this->articleRepository->all();
            return responseBuilder()->success(__('Articles'),  $articles);
        } catch (Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }
    public function multiImageUpload(ImageRequest $request)
    {
        try {
            $imageArray = [];
            $path = 'front/media';
            if ($request->has('path')) {
                $path = $request->path;
            }
            if ($request->hasFile('images')) {
                $data = $request->allFiles();
                foreach ($data['images'] as $key => $img) {
                    $image = uploadImage($img, $path);
                    $imageArray[$key] = $image;
                }
            }
            return responseBuilder()->success(__('Images Uploaded'), $imageArray);
        } catch (Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }
    public function setUserSettings()
    {
        $userRepository = new UserRepository();
       $settings = $userRepository->setUserSettings();
        return responseBuilder()->success(__("Settings updated successfully."),['settings'=>$settings]);
    }
    public function getLangauges()
    {
        $languages = Lang::get()->toArray();
        return responseBuilder()->success(__("Settings updated successfully."),['langugaes'=>$languages]);
    }
    public function couponValidate(CouponRequest $request)
    {
        try {

            $data = $this->couponRepository->addUserCoupon($request->get('code'));
            if ($data == "expired") {
                return responseBuilder()->error(__('Coupon is Expired.'));
            }
            if ($data == "finished") {
                return responseBuilder()->error(__('Coupon is Expired Or Finished.'));
            }
            return responseBuilder()->success(__('Coupon is Successfully Added.'));
        } catch (\Exception $e) {
            return responseBuilder()->error($e->getMessage());
            return responseBuilder()->error('Something Went Wrong.');
        }
    }
}
