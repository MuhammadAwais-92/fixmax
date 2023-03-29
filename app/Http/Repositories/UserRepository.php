<?php


namespace App\Http\Repositories;

use App\Http\Dtos\SendEmailDto;
use App\Http\Dtos\UserDto;
use App\Http\Dtos\UserRegisterDto;
use App\Http\Libraries\DataTable;
use App\Http\Repositories\BaseRepository\Repository;
use App\Jobs\SendMail;
use App\Models\Fcm;
use App\Models\Review;
use App\Models\User;
use App\Traits\EMails;
use Carbon\Carbon;
use ErrorException;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\DataTransferObject\DataTransferObject;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;


class UserRepository extends Repository
{

    public function __construct()
    {
        $this->setModel(new User());
    }

    /**
     * @throws Exception
     */
    public function save($params)
    {
        DB::beginTransaction();
        try {
            $data = $params->except('id', 'image', 'trade_license_image', 'id_card_images', 'password', 'package_id', 'google_id', 'facebook_id')->toArray();
            if (!is_null($params->password)) {
                $data['password'] = bcrypt($params->password);
            }
            if (!is_null($params->image)) {
                $data['image'] = $params->image;
            }
            if (!is_null($params->trade_license_image)) {
                $data['trade_license_image'] = $params->trade_license_image;
            }
            if (isset($params->google_id) && !is_null($params->google_id)) {
                $data['google_id'] = $params->google_id;
            }
            if (isset($params->google_id) && !is_null($params->facebook_id)) {
                $data['facebook_id'] = $params->facebook_id;
            }
            if (!is_null($params->id_card_images)) {
                if ($params->id > 0) {
                    $user = $this->get($params->id);
                    if ($user->id_card_images != $params->id_card_images) {
                        $data['is_id_card_verified'] = false;
                    }
                }
                $data['id_card_images'] = $params->id_card_images;
            }
            $user = $this->getModel()->updateOrCreate(['id' => $params->id], $data);
            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function sendEmailVerification($type = 'verification', $email = null)
    {
        try {
            if (is_null($email)) {
                $user = $this->getUser();
            } else {
                $user = $this->get(0, $email);
                if (is_null($user)) {
                    throw new Exception(__('Email does not exist'));
                }
            }
            $code = rand(1000, 9999);
            $data = collect([
                'receiver_name' => $user->isSupplier() ? $user->supplier_name['en'] : $user->user_name,
                'receiver_email' => $user->email,
                'subject' => ($type == 'verification' ? __('Email verification code') : __('Password Reset Code')) . ' ' . $code,
                'view' => $type == 'verification' ? 'emails.user.email_verification' : 'emails.user.forgot_password',
                'sender_email' => config('settings.email'),
                'sender_name' => config('settings.company_name'),
                'code' => $code,
                'link' => $type == 'verification' ? route('front.auth.verification', ['code' => $code]) : route('front.auth.show.reset.form', ['code' => $code]),
                //                'data'           => [
                //                    'verification_code' => $code,
                //                    'receiver_name'     => $user->getFullNameAttribute(),
                //                    'link'              => $type == 'verification' ? route('front.auth.verification',['code' => $code]) : route('front.auth.show.reset.form',['code' => $code]),
                //                ],
            ]);

            $user->update(['verification_code' => $code]);

            $sendEmailDto = SendEmailDto::fromCollection($data);
            SendMail::dispatch($sendEmailDto);

            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function emailVerification($code)
    {
        $user = $this->getUser();
        if ($user->is_verified == '1') {
            throw new Exception(__('Email Already verified'));
        }

        if ($user->verification_code == $code) {
            $user->update(['verification_code' => '', 'is_verified' => 1]);
            if ($this->getFromWeb()) {
                $user->getFormattedModel(true, true);
                return $user;
            }
            $user->getFormattedModel(true, false);
            return $user;
        }
        throw new Exception(__('Verification code does not match'));
    }
    public function supplierfilter($storeId = null, $request = null)
    {

        $query = $this->getModel()->query();
        $query->where('is_id_card_verified', 1);
        $query->where('is_active', 1);
        $query->where('user_type', 'supplier');
        $query->whereHas('subscription', function ($q) {
            $q->where('is_expired', 0);
        });
        $query->whereHas('category');
        $query->has('services');


        if ($storeId == 0) {
            $query->where('type', 'supplier')->orderBy('created_at', 'desc');
        } else {
            if (!is_null($request)) {

                $lat = $request->get('latitude');
                $long = $request->get('longitude');

                $distance = config("settings.nearby_radius", 20); //km

                if ($request->has('area_id') && $request->area_id !== null) {
                    $ss_data = $request->get('area_id');
                    $query->whereHas('coveredAreas', function ($q) use ($ss_data) {
                        $q->where('city_id',  $ss_data);
                    });
                    // $distance = config("settings.nearby_radius", 20); //km
                    // if ($request->sort != "near_to_far") {
                    //     if (array_key_exists('latitude', $ss_data) && array_key_exists('longitude', $ss_data)) {
                    //         $lat = $ss_data['latitude'];
                    //         $long = $ss_data['longitude'];
                    //         if ($lat != "" && $long != "") {
                    //             $haversine = '( 6367 * acos( cos( radians(' . $lat . ') )* cos( radians( latitude ) ) *cos( radians( longitude ) - radians(' . $long . ') ) + sin( radians(' . $lat . ') )* sin( radians( latitude ) ) ) )';
                    //             $query->select('*')->selectRaw("{$haversine} AS distance")->whereRaw("{$haversine} < ?", [$distance]);
                    //         }
                    //     }
                    // }
                }

                if ($request->sort != "near_to_far" && $request->sort != "latest" && $lat != "" && $long != "") {
                    $haversine = '( 6367 * acos( cos( radians(' . $lat . ') )* cos( radians( latitude ) ) *cos( radians( longitude ) - radians(' . $long . ') ) + sin( radians(' . $lat . ') )* sin( radians( latitude ) ) ) )';
                    $query->select('*')->selectRaw("{$haversine} AS distance")->whereRaw("{$haversine} < ?", [$distance]);
                }

                if ($request->has('popular')) {
                    $query->orderBy('rating', 'desc');
                }
                if ($request->has('category_id') && $request->category_id != '') {
                    $query->where('category_id', $request->category_id);
                }
                if ($request->has('subCategory') && $request->subCategory != '') {

                    $query->whereHas('services', function ($q) use ($request) {
                        $q->where('category_id', $request->subCategory);
                    });
                }

                if ($request->has('keyword') && $request->keyword != '') {
                    $query->where('supplier_name', 'like', '%' . $request->keyword . '%');
                }

                // if ($request->has('supplier') && $request->supplier != '') {
                //     $query->where('type', $request->supplier);
                // } else {
                //     $query->where('type', '!=', 'user');
                // }

                // if ($request->has('rating') && $request->rating != '') {
                //     $query->whereBetween('rating', [(int)$request->rating, (int)$request->rating + 0.99]);
                // }



                // if ($request->has('category') && $request->category !== '') {
                //     $category = $request->category;
                //     $query->whereHas('products', function ($q) use ($category) {
                //         $q->whereHas('categories', function ($query) use ($category) {
                //             $query->where('category_id', $category);
                //         });
                //     });
                // }

                // if ($request->has('product_type') && $request->product_type !== '') {
                //     $product_type = $request->product_type;
                //     $query->whereHas('products', function ($q) use ($product_type) {
                //         $q->where(['product_type' => $product_type, 'approval_status' => 'approved'])->wherehas('categories');
                //     });
                // }

                if ($request->has('sort') && $request->sort != '') {

                    if ($request->sort == "latest") {
                        $query->orderBy('created_at', 'desc');
                    }

                    if ($request->sort == "rating") {
                        $query->orderBy('rating', 'DESC');
                    }
                    if ($lat != "" && $long != "") {
                        if ($request->sort == "near_to_far") {
                            $haversine = '( 6367 * acos( cos( radians(' . $lat . ') )* cos( radians( latitude ) ) *cos( radians( longitude ) - radians(' . $long . ') ) + sin( radians(' . $lat . ') )* sin( radians( latitude ) ) ) )';
                            $query->selectRaw(" *,{$haversine} AS distance")->orderBy('distance');
                        }
                    }
                    // if ($request->has('user_data') && $request->user_data !== null) {
                    //     if (array_key_exists('latitude', $ss_data) && array_key_exists('longitude', $ss_data)) {
                    //         $latitude = $ss_data['latitude'];
                    //         $longitude = $ss_data['longitude'];
                    //         if ($latitude != "" && $longitude != "") {
                    //             if ($request->sort == "near_to_far") {
                    //                 $haversine = '( 6367 * acos( cos( radians(' . $latitude . ') )* cos( radians( latitude ) ) *cos( radians( longitude ) - radians(' . $longitude . ') ) + sin( radians(' . $latitude . ') )* sin( radians( latitude ) ) ) )';
                    //                 $query->selectRaw(" *,{$haversine} AS distance")->orderBy('distance');
                    //             }
                    //         }
                    //     }
                    // }
                }
            }
        }
        if ($request->display_type == 'list') {
            $data = $query->with($this->getRelations())->latest()->paginate($this->getPaginate())->withQueryString();
        } else {
            $data = $query->with($this->getRelations())->latest()->paginate($this->getPaginate());
        }
        return $data;
    }

    public function setUserSettings()
    {
        $user = $this->getUser();
        if ($user->settings) {
            $settings = 0;
        } else if (!$user->settings) {
            $settings = 1;
        }
        $user->update(['settings' => $settings]);
        return $settings;
    }
    public function typeUsers($type = 'supplier', $keyword = null)
    {
        $user = $this->getModel()->where('user_type', $type)->select($this->getSelect())->with($this->getRelations());
        if (isset($keyword) && $keyword != NULL) {
            $user = $user->where('supplier_name', 'like', '%' .  Str::lower($keyword) . '%');
        }
        $user = $user->paginate($this->getPaginate())->withQueryString();
        return $user;
    }
    public function get($id = 0, $email = null)
    {
        $user = new User();
        if ($id > 0) {
            $user = $this->getModel()->select($this->getSelect())->with($this->getRelations())->find($id);
        }
        if (!is_null($email)) {
            $user = $this->getModel()->where('email', $email)->first();
        }
        if (!is_null($user)) {
            // if (is_null($user->supplier_name)) {
            //     $user->supplier_name = ['en' => '', 'ar' => ''];
            // }

            foreach (cache('LANGUAGES') as $lang) {

                if (is_null($user->supplier_name)) {
                    $user->supplier_name = [];
                    $user->supplier_name += [$lang['short_code'] => ''];
                } else {
                    if (!array_key_exists($lang['short_code'], $user->supplier_name)) {

                        $user->supplier_name += [$lang['short_code'] => ''];
                    }
                }
            }


            // if (is_null($user->about)) {
            //     $user->about = ['en' => '', 'ar' => ''];
            // }
        }
        return $user;
    }

    public function resetPassword($code, $email, $password)
    {
        $user = $this->getModel()->where([
            'verification_code' => $code,
            'email' => $email
        ])->first();
        if ($user !== null) {
            $user->update(['password' => bcrypt($password)]);
            return true;
        } else {
            throw new Exception(__('Invalid code'));
        }
    }

    public function adminDataTable($columns, $type = 'user')
    {

        DataTable::init(new User(), $columns);
        DataTable::where('user_type', '=', $type);
        $email = \request('datatable.query.email', '');
        $emailStatus = \request('datatable.query.emailStatus', '');
        $trashedItems = \request('datatable.query.trashedItems', NULL);
        $createdAt = \request('datatable.query.createdAt', '');
        $updatedAt = \request('datatable.query.updatedAt', '');
        $deletedAt = \request('datatable.query.deletedAt', '');
        $rating = \request('datatable.query.rating', '');
        $title = \request('datatable.query.name', '');
        $activeStatus = \request('datatable.query.activeStatus', '');
        $cityId = \request('datatable.query.city_id', '');

        if ($cityId != "") {
            DataTable::where('city_id', '=', $cityId);
        }
        if ($emailStatus != "") {
            DataTable::where('is_verified', '=', $emailStatus);
        }
        if ($activeStatus != "") {
            DataTable::where('is_active', '=', $activeStatus);
        }
        if ($rating != "") {
            DataTable::orderBy('rating', $rating);
        }
        if (!empty($title)) {
            if ($type == 'supplier') {
                //                DataTable::where('supplier_name', 'LIKE', '%' . addslashes($title) . '%');
                DataTable::where('supplier_name', 'LIKE', '%' . $title . '%');
            }
            if ($type == 'user') {
                DataTable::where('user_name', 'LIKE', '%' . $title . '%');
            }
        }
        if (!empty($trashedItems)) {
            DataTable::getOnlyTrashed();
        }

        if ($email != '') {
            DataTable::where('email', 'like', '%' . addslashes($email) . '%');
        }

        if ($createdAt != '') {
            $createdAt = Carbon::createFromFormat('m/d/Y', $createdAt);
            $cBetween = [$createdAt->hour(0)->minute(0)->second(0)->timestamp, $createdAt->hour(23)->minute(59)->second(59)->timestamp];
            DataTable::whereBetween('created_at', $cBetween);
        }
        if ($updatedAt != '') {
            $updatedAt = Carbon::createFromFormat('m/d/Y', $updatedAt);
            $uBetween = [$updatedAt->hour(0)->minute(0)->second(0)->timestamp, $updatedAt->hour(23)->minute(59)->second(59)->timestamp];
            DataTable::whereBetween('updated_at', $uBetween);
        }

        if ($type == 'supplier') {
            DataTable::whereHas('city');
            DataTable::with('city');
        }
        $user = DataTable::get();
        $dateFormat = config('settings.date-format');
        $start = 1;
        if ($user['meta']['start'] > 0 && $user['meta']['page'] > 1) {
            $start = $user['meta']['start'] + 1;
            //            $start = $order['meta']['start'];
        }
        $count = $start;

        if (sizeof($user['data']) > 0) {
            foreach ($user['data'] as $key => $data) {
                $user['data'][$key]['id'] = $count++;
                if ($type == 'user') {
                    $user['data'][$key]['name'] = $data['user_name'];
                    $user['data'][$key]['is_verified'] = $data['is_verified'] ? 'Yes' : 'No';
                    $user['data'][$key]['is_active'] = $data['is_active'] ? 'Yes' : 'No';
                    $user['data'][$key]['actions'] = '<a href="' . route('admin.dashboard.users.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' .
                        '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.dashboard.users.destroy', $data['id']) . '" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>';
                }
                if ($type == "supplier") {
                    $user['data'][$key]['name'] = $data['supplier_name']['en'];
                    $user['data'][$key]['rating'] = getStarRating($data['rating']);
                    $user['data'][$key]['city'] = '';
                    if (!empty($data['city']['name'])) {
                        $user['data'][$key]['city'] = $data['city']['name']['en'];
                    }
                    $user['data'][$key]['is_id_card_verified'] = $data['is_id_card_verified'] ? 'Yes' : 'No';
                    $user['data'][$key]['actions'] = '<a href="' . route('admin.dashboard.suppliers.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' .
                        '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.dashboard.suppliers.destroy', $data['id']) . '" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>' .
                        '<a href="' . route('admin.dashboard.suppliers.reviews', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Reviews"><i class="fa fa-fw fa-comments"></i></a>'
                        //                            '<a href="' . route('admin.withdraws.index', ['store_id' => $data['id']]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Withdraw request"><i class="fa fa-fw fa-money"></i></a>'
                        . ($data['is_id_card_verified'] == 1 ? '' : '<a href="' . route('admin.dashboard.id.card.verify', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Verify id card"><i class="fa fa-check-square"></i></a>');
                }
                //                $user['data'][$key]['created_at'] = Carbon::createFromTimestamp($data['created_at'])->format($dateFormat);
                //                $user['data'][$key]['updated_at'] = Carbon::createFromTimestamp($data['updated_at'])->format($dateFormat);
            }
        }

        return $user;
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            $user = $this->get($id);
            if ($user) {
                if ($user->delete()) {
                    $user->update(['email' => '']);
                    //            if ($user->isStore()) {
                    //                $user->products()->delete();
                    //            }
                    if (!is_null($user->getOriginal('image'))) {
                        deleteImage($user->getOriginal('image'));
                    }
                    if (!is_null($user->getOriginal('id_card_images'))) {
                        foreach ($user->id_card_images as $image) {
                            deleteImage($image);
                        }
                    }
                    DB::commit();
                    return true;
                } else {
                    throw new Exception('Unable to delete user');
                }
            } else {
                     throw new Exception('Unable to delete user');
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
    public function reviews($id)
    {
        $user = $this->get($id);
        return $user->reviews()->get();
    }
    public function Reviewsdestroy($id)
    {
        DB::beginTransaction();
        try {
            $query = $this->getModel()->query();
            $reviews = Review::find($id);
            $supplier_id = $reviews->supplier_id;
            if ($reviews->delete()) {

                //re calculate average rating
                $rev = Review::where('supplier_id', $supplier_id)->where('is_reviewed', true)->avg('rating');
                $query->where('id', $supplier_id)->update([
                    'rating' => $rev
                ]);

                DB::commit();
                return true;
            } else {
                throw new Exception('Unable to delete Reviews');
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
    public function changeUserPassword($params)
    {
        $user = $this->getUser();
        if (Hash::check($params->current_password, $user->password)) {
            $user->update(['password' => bcrypt($params->password)]);
            $user = $user->getFormattedModel(true, true);
            return $user;
        }
        throw new Exception(__('Incorrect current password'));
    }

    public function verifyIdCard($id)
    {
        $user = $this->get($id);
        $user->update(['is_id_card_verified' => 1]);
        return $user;
    }
    public function logout($userId, $token)
    {
        DB::beginTransaction();
        try {
            $user = $this->get($userId);
            $user->update(['fcm_token' => null]);
            Fcm::where('user_id', $user->id)->where('fcm_token', $token)->delete();
            JWTAuth::invalidate(JWTAuth::getToken());
            DB::commit();
            return $user;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
