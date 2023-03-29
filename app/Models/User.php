<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Facades\JWTAuth;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $dateFormat = 'U';
    public static $snakeAttributes = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'city_id',
        'category_id',
        'expiry_date',
        'user_name',
        'email',
        'password',
        'phone',
        'image',
        'id_card_images',
        'is_verified',
        'is_active',
        'is_id_card_verified',
        'verification_code',
        'address',
        'latitude',
        'longitude',
        'user_type',
        'trade_license_image',
        'supplier_name',
        'visit_fee',
        'about',
        'rating',
        'client_id',
        'secret_id',
        'amount_on_hold',
        'available_balance',
        'total_earning',
        'settings',
        'fcm_token',
        'facebook_id',
        'google_id',
        'total_commission',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
        'is_id_card_verified' => 'boolean',
        'supplier_name' => 'array',
        'about' => 'array',
        'id_card_images' => 'array',
        'rating' => 'float',
    ];

    protected $appends = [
        'image_url',
        'trade_license_image_url',
        'id_card_images_url',
    ];


    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function coveredAreas()
    {
        return $this->belongsToMany(City::class, 'user_areas');
    }
    public function usersAreas()
    {
        return $this->hasMany(City::class, 'user_areas');
    }
    public function services()
    {
        return $this->hasMany(Service::class);
    }
    public function subscriptions()
    {
        return $this->hasOne(UserSubscription::class);
    }
    public function subscription()
    {
        return $this->hasOne(UserSubscription::class)->latest();
    }
    public function addresses()
    {
        return $this->hasMany(Addresses::class);
    }
    public function defaultAddress()
    {
        return $this->hasMany(Addresses::class)->where('default_address',1)->first();
    }
    public function getSelectedAddressAndTime($supplier, $area_id)
    {

        $coveredArea = UserArea::where('user_id', $supplier->id)->where('city_id', $area_id)->first();
        if($coveredArea)
        {
            $supplier->estimated_time = $coveredArea->estimated_time;
            $supplier->selected_area = $coveredArea->area->name;
        }
      
        return $supplier;
    }
    public function getTime($supplier)
    {
        $estimated_time='';
        $coveredArea = UserArea::where('user_id', $this->id)->where('city_id', session()->get('area_id'))->first();
        if($coveredArea)
        {
            $estimated_time = $coveredArea->estimated_time;
        }

        return $estimated_time;
    }
    public function isUser()
    {
        return $this->user_type == 'user';
    }

    public function isSupplier()
    {
        return $this->user_type == 'supplier';
    }
    public function supplierFeaturedSubscription()
    {
        return $this->hasMany(UserFeaturedSubscription::class, 'user_id')->where('is_expired', 0)->where('service_id', 0);
    }

    public function getUserActiveFeaturedPackages()
    {
        return UserFeaturedSubscription::where('user_id', '=', $this->id)->where('is_expired', 0)->where('service_id', 0)->get();
    }
    public function UserFeaturedSubscriptionCount($id)
    {
        return $this->supplierFeaturedSubscription()->whereJsonContains('package->id', $id)->count();
    }
    public function isVerified()
    {
        return $this->is_verified;
    }
    public function isApproved()
    {
        return $this->is_id_card_verified;
    }
    public function isActive()
    {
        return $this->is_active;
    }
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function getFormattedModel($generateNewToken = false, $updateSession = false): User
    {
        $user = $this;
        unset($user->password);
        unset($user->created_at);
        unset($user->updated_at);
        unset($user->deleted_at);
        if ($user->isUser()) {
            unset($user->supplier_name);
            unset($user->expiry_date);
            unset($user->id_card_images);
            unset($user->is_id_card_verified);
            unset($user->about);
            unset($user->rating);
            unset($user->client_id);
            unset($user->secret_id);
            unset($user->amount_on_hold);
            unset($user->available_balance);
            unset($user->total_earning);;
        } else {
            unset($user->user_name);
            $user->is_subscribed = $user->isSubscribed();
            $user->has_subscriptions = $user->hasSubscriptions();
            $user->has_covered_area = !$user->coveredAreas()->get()->isEmpty();
            $user->city_name = $user->city->name;
        }
        if ($generateNewToken) {
            $JWTToken = JWTAuth::fromUser($user);
            $user->token = 'Bearer ' . $JWTToken;
            //            $JWTToken = JWTAuth::fromUser(auth()->user());
            //            $data = $data->merge([
            //                'token' =>  'Bearer ' .$JWTToken,
            //            ]);
            //            $this->token = $data->get('token');
        }
        if ($updateSession) {
            session()->put('USER_DATA', $user);
            //            session()->put('USER_DATA', $this);
        }
        return $user;
    }

    public function checkIfActive()
    {
        $message = __('Your account has been suspended. Please contact the admin.');
        if ($this->isVerified() && !$this->isActive()) {
            auth()->logout();
            throw new Exception($message);
        }
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'supplier_id')->where('is_reviewed', true);
    }
    public function pendingReviews()
    {
        return $this->hasMany(Review::class, 'supplier_id')->where('is_reviewed', false);
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getImageUrlAttribute()
    {
        if (empty($this->attributes['image'])) {
            return url('images/default-image.jpg');
        }
        return url($this->attributes['image']);
    }
    public function getTradeLicenseImageUrlAttribute()
    {
        if (empty($this->attributes['trade_license_image'])) {
            return url('images/default-image.jpg');
        }
        return url($this->attributes['trade_license_image']);
    }
    public function getIdCardImagesUrlAttribute()
    {
        $images = null;
        if (is_array($this->id_card_images)) {
            $images = collect($this->id_card_images)->map(function ($image) {
                return url($image);
            });
        }
        return $images;
    }

    public function isSubscribed()
    {
        $subscription = $this->subscription()->first();
        if ($subscription) {
            if (!$subscription->is_expired) {
                return true;
            }
        }
        return false;
    }

    public function hasSubscriptions()
    {
        $subscription = $this->subscription()->first();
        if ($subscription) {
            return true;
        } else {
            return false;
        }
    }
}
