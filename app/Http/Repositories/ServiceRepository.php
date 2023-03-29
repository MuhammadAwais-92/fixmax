<?php


namespace App\Http\Repositories;

use App\Http\Repositories\BaseRepository\Repository;
use App\Models\Service;
use App\Models\UserFeaturedSubscription;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Libraries\DataTable;
use App\Http\Repositories\ServiceImagesRepository;
use App\Jobs\FeaturedSubscriptionExpiry;
use App\Jobs\ServiceDiscountExpiry;
use App\Models\Cart;
use Carbon\Carbon;
use Facade\Ignition\QueryRecorder\Query;

class ServiceRepository extends Repository
{
    protected $serviceImagesRepository;
    public function __construct()
    {
        $this->setModel(new Service());
        $this->serviceImagesRepository = new ServiceImagesRepository;
    }
    public function all($type = '')
    {
        $query = $this->getQuery();
        if ($type) {
            $query = $query->where('user_id', auth()->user()->id)->where('is_featured', '1');
        } else {
            $query = $query->where('user_id', auth()->user()->id);
        }
        if ($this->getPaginate() > 0) {
            $services = $query->select($this->getSelect())->with($this->getRelations())->latest()->paginate($this->getPaginate());
        } else {
            $services = $query->select($this->getSelect())->with($this->getRelations())->latest()->get();
        }
        return $services;
    }
    public function servicefilter($params)
    {

        $query = $this->getQuery();
        $query->where('is_active', 1);
        if (isset($params['categoriesWhereHas'])) {
            $query->whereHas('category');
        }

        if (isset($params['idCardVerified'])) {
            $id_card_verify = $params['idCardVerified'];
            $query->whereHas('supplier', function ($q) use ($id_card_verify) {
                $q->where('is_id_card_verified', $id_card_verify)->whereHas('subscription', function ($q) {
                    $q->where('is_expired', 0);
                });
            });
        }


        if (isset($params['supplier_id'])) {
            $store_id = $params['supplier_id'];
            $query->where('user_id', $store_id);
        }
        if (isset($params['min_price'])) {
            $min_price = $params['min_price'];
            $query->where('min_price', '>=', $min_price);
        }
        if (isset($params['max_price'])) {
            $max_price = $params['max_price'];
            $query->where('max_price', '<=', $max_price);
        }
        if (isset($params['category_id'])) {
            $category_id = $params['category_id'];
            $query->whereHas('category', function ($q) use ($category_id) {
                $q->where('parent_id', $category_id);
            });
        }
        if (isset($params['subCategory'])) {
            $subCategory = $params['subCategory'];
            $query->where('category_id', $subCategory);
        }
        if (isset($params['service']) &&  $params['service'] == 'featured') {
            $query->where('is_featured', '1');
        }
        if (isset($params['service']) &&  $params['service'] == 'offer') {
            $query->where('service_type', 'offer');
        }
        if (isset($params['area_id']) && $params['area_id'] !== '') {

            $ss_data = $params['area_id'];
            $query->whereHas('supplier', function ($q) use ($ss_data) {
                $q->whereHas('coveredAreas', function ($q) use ($ss_data) {
                    $q->where('city_id',  $ss_data);
                });
            });
        }

        // if (isset($params['latitude']) && isset($params['longitude'])) {
        //     $lat = $params['latitude'];
        //     $long = $params['longitude'];
        //     $distance = config("settings.nearby_radius", 20); //km
        //     $haversine = '( 6367 * acos( cos( radians(' . $lat . ') ) * cos( radians( latitude ) ) *cos( radians( longitude ) - radians(' . $long . ') ) + sin( radians(' . $lat . ') )* sin( radians( latitude ) ) ) )';
        //     $query->select('*')->selectRaw("{$haversine} AS distance")->whereRaw("{$haversine} < ?", [$distance]);
        //     //            $query->selectRaw(" *,{$haversine} AS distance")->orderBy('distance');
        // }

        // if (isset($params['near_to_far'])) {
        //     $query->orderBy('distance');
        // }

        if (isset($params['popular'])) {
            $query->orderBy('average_rating', 'desc');
        }

        // $selectStore = function ($query) {
        //     $query->select(['id', 'user_type', 'supplier_name', 'city_id', 'is_id_card_verified', 'address', 'latitude', 'longitude']);
        // };

        // $relations['supplier'] = $selectStore;
        // $this->setRelations($relations);

        if (isset($params['keyword']) && $params['keyword'] != '') {
            //            $query->whereRaw('LOWER(`name`) LIKE ? ', ['%' . strtolower($params['keyword']) . '%']);
            $query->whereRaw('LOWER(`name`) LIKE ? ', ['%' . strtolower($params['keyword']) . '%'])->orWhere(function ($q) use ($params) {
                $q->where('name->en', $params['keyword'])->orWhere('name->ar', $params['keyword'])->orWhere('name->en', strtolower($params['keyword']))->orWhere('name->en', strtoupper($params['keyword']));
            });
        }

        if ($this->getPaginate() > 0) {
            if (isset($params['near_to_far'])) {
                $services = $query->with($this->getRelations())->latest()->paginate($this->getPaginate());
            } else {
                if(isset($params['service']) &&  $params['service'] == 'featured')
                {
                    $services = $query->select($this->getSelect())->with($this->getRelations())->latest()->paginate($this->getPaginate(),['*'],'featured')->withQueryString();

                }
                elseif(isset($params['service']) &&  $params['service'] == 'offer')
                {
                    $services = $query->select($this->getSelect())->with($this->getRelations())->latest()->paginate($this->getPaginate(),['*'],'offers')->withQueryString();

                }
                else 
                {
                    $services = $query->select($this->getSelect())->with($this->getRelations())->latest()->paginate($this->getPaginate(),['*'],'services')->withQueryString();

                }
            }
        } else {
            $services = $query->select($this->getSelect())->with($this->getRelations())->latest()->get();
        }
        return $services;
    }
    public function detail($slug)
    {
        $query = $this->getModel()->query();
        if (!is_null($slug)) {
            $query->where('slug', $slug);
        }
        $service = $query->select($this->getSelect())->with($this->getRelations())->first();
        return $service;
    }
    public function get($id)
    {
        $query = $this->getModel()->query();
        if (!is_null($id)) {
            $query->where('id', $id);
        }
        $service = $query->select($this->getSelect())->with($this->getRelations())->first();
        return $service;
    }
    public function allAdminServices()
    {
        $columns = [
            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'slug', 'dt' => 'slug'],
            ['db' => 'service_type', 'dt' => 'service_type'],
            ['db' => 'average_rating', 'dt' => 'average_rating'],
            ['db' => 'discount', 'dt' => 'discount'],
            //            ['db' => 'deleted_at', 'dt' => 'deleted_at'],
            ['db' => 'min_price', 'dt' => 'min_price'],
            ['db' => 'max_price', 'dt' => 'max_price'],
            ['db' => 'user_id', 'dt' => 'user_id'],
            ['db' => 'category_id', 'dt' => 'category_id'],
            ['db' => 'is_active', 'dt' => 'is_active'],
            ['db' => 'name', 'dt' => 'name'],

        ];
        DataTable::init(new Service(), $columns);
        $title = request('datatable.query.name', '');
        $min = request('datatable.query.min', '');
        $max = request('datatable.query.max', '');
        $slug = request('datatable.query.slug', '');
        $supplier_name = request('datatable.query.supplier_name', '');
        $category_id = request('datatable.query.category_id', '');
        if ($slug != '') {
            DataTable::where('slug', 'LIKE', '%' . addslashes($slug) . '%');
        }
        
        if (!empty($category_id)) {
            DataTable::whereHas('category', function ($query) use ($category_id) {
                $query->where('parent_id', $category_id);
            });
        }

        if (!empty($title)) {
            DataTable::where('name', 'LIKE', '%' . $title . '%');
        }
     
        if (!empty($min)) {
            DataTable::where('min_price', '>=', $min);
        }
        if (!empty($max)) {
            DataTable::where('max_price', '<=', $max);
        }
        DataTable::with('supplier');
        DataTable::whereHas('supplier');
        DataTable::with('category');
        DataTable::with('category.parent');
        if (!empty($supplier_name)) {
            DataTable::wherehas('supplier', function ($q) use ($supplier_name) {
                $q->where('supplier_name', 'LIKE', '%' . $supplier_name . '%');
            });
        }

        $services = DataTable::get();
     
        $start = 1;
        if ($services['meta']['start'] > 0 && $services['meta']['page'] > 1) {
            $start = $services['meta']['start'] + 1;
        }
        $count = $start;

        if (sizeof($services['data']) > 0) {
            foreach ($services['data'] as $key => $data) {
                
                $services['data'][$key]['id'] = $count++;
                $services['data'][$key]['en_name'] = $data['name']['en'];
                $services['data'][$key]['ar_name'] = $data['name']['ar'];
                $services['data'][$key]['min_price'] = $data['min_price'];
                $services['data'][$key]['max_price'] = $data['max_price'];
                $services['data'][$key]['discount'] = $data['discount'] ? $data['discount'] : '0';
                $services['data'][$key]['average_rating'] = $data['average_rating'];
                $services['data'][$key]['supplier_name']  = $services['data'][$key]['supplier']['supplier_name']['en'];
                $services['data'][$key]['category']  = $services['data'][$key]['category']['parent']['name']['en'];
                $services['data'][$key]['Activate'] = $data['is_active'] == '1' ? 'Active' : 'In-Active';
                if($data['is_active'] == '1')
                {
                    $services['data'][$key]['actions'] = '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill deactivate-record-button href="javascript:{};" data-url="' . route('admin.dashboard.service.off', $data['id'])  . '" title="Delete"><i class="fa fa-times"></i></a>';
                }
              else{
                $services['data'][$key]['actions'] = '<a class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill activate-record-button" href="javascript:{};" data-url="' . route('admin.dashboard.service.on', $data['id']) . '" title="Accept"> <i class="fa fa-check"></i></a>';
              }
            }
        }
        return $services;
    }
    public function activate($id)
    {
        try {
            $service = $this->get($id);
            $service->is_active = '1';
            $service->save();
            return true;
        } catch (\Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }
    public function deActivate($id)
    {
        try {
            $service = $this->get($id);
            $service->is_active = '0';
            $service->save();
            return true;
        } catch (\Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }
    public function destroy($id)
    {
        $service = $this->get($id);
        $service->equipments()->delete();
        $service::destroy($id);
        $cart = Cart::where('service_id', $service->id)->get();
        if($cart->isNotEmpty())
        {
            foreach ($cart as $cart) {
                $cart->equipments()->delete();
                $cart->delete();
            }
        }
        return $service;
    }
    public function save($params)
    {
        DB::beginTransaction();
        try {
            $data = $params->except('service_images', 'featured_subscription')->toArray();
            if ($data['id'] == 0) {
                $data['slug'] = $this->getModel()->checkSlug($data['name']['en']);
            } else {
                unset($data['slug']);
            }
            $service = $this->getModel()->updateOrCreate(['id' => $params->id], $data);
            if ($service->discount > 0) {
                $days = Carbon::now()->diffInDays(unixTODateformate($service->expiry_date));
                ServiceDiscountExpiry::dispatch($service->id)->delay(now()->addDays($days)->endOfDay());
            }
            if ($params->featured_subscription && $params->featured_subscription != '') {
                $id = $params->featured_subscription;
                $subscription = UserFeaturedSubscription::findOrFail($id);
                $duration_type = $subscription->package['duration_type'];
                $duration = $subscription->package['duration'];

                if ($subscription) {
                    $subscription->update([
                        'service_id' => $service->id,
                    ]);

                    $expiry_date = unixConversion($duration_type, $duration, now()->unix());
                    $days = Carbon::now()->diffInDays(Carbon::parse($expiry_date));

                    FeaturedSubscriptionExpiry::dispatch($subscription->id)->delay(now()->addDays($days)->endOfDay());

                    $service->update([
                        'is_featured' => 1,
                        'featured_expiry_date' => $expiry_date
                    ]);
                }
            }
            if ($params->id && $params->id != 0) {
                $serviceImages = $service->images()->get();
                if (count($serviceImages) > 0) {
                    foreach ($serviceImages as $image) {
                        $image->delete();
                    }
                }
            }
            foreach ($params->service_images as $image) {
                $this->serviceImagesRepository->save($image, $service->id);
            }
            $cart = Cart::where('service_id', $service->id)->get();
            if($cart->isNotEmpty())
            {
                foreach ($cart as $cart) {
                    $cart->equipments()->delete();
                    $cart->delete();
                }
            }
         

            DB::commit();
            return $service;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
