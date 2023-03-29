<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $dateFormat = 'U';
    public static $snakeAttributes = false;
    //    use HasFactory;
    protected $table = 'services';
    protected $appends = ['default_image','discounted_min_price','discounted_max_price','order_image'];

    protected $fillable = [
        'name',
        //        'name->en',
        //        'name->ar',
        'slug',
        'user_id',
        'category_id',
        'service_type',
        'discount',
        'min_price',
        'max_price',
        'expiry_date',
        'description',
        'average_rating',
        'created_at',
        'updated_at',
        'deleted_at',
        'is_featured',
        'featured_expiry_date',
    ];

    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int',
        'name' => 'array',
        'description' => 'array'
    ];
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->getTimestamp();
    }
    public function getDateFormat()
    {
        return 'U';
    }
    public function user()
    {
        return $this->belongsTO(User::class, 'user_id');
    }
    public function checkSlug($slug)
    {
        $slugName = str_replace(' ', '-', $slug);
        $countOfSameServiceName = $this->where('name', 'like', '%' . $slug . '%')->withTrashed()->count();
        if ($countOfSameServiceName > 0) {
            $product = $this->where('name', 'like', '%' . $slug . '%')->latest()->first();
            return $slugName . '-' . rand(2, 10000);
        } else {
            return $slugName;
        }
    }

    public function getOrderImageAttribute()
    {
        $default_image = $this->images()->where('service_id', $this->id)->where('file_default', 1)->get()->first();
        if (!is_null($default_image)) {
            return $default_image->file_path;
        }
        return url('assets/front/img/Placeholders/service.jpg');
    }
    public function getDefaultImageAttribute()
    {
        $default_image = $this->images()->where('service_id', $this->id)->where('file_default', 1)->get()->first();
        if (!is_null($default_image)) {
            return url($default_image->file_path);
        }
        return url('assets/front/img/Placeholders/service.jpg');
    }
    public function getDiscountedMinPriceAttribute()
    {
        $service = $this;
        $discountMinPrice = null; 
        if ($service->service_type == 'offer') {
            $discountedMinAmount = $this->min_price * ($this->discount / 100);
            $discountMinPrice = $this->min_price - $discountedMinAmount;
            $service->discountedMinPrice = $discountMinPrice;
        }
        return $discountMinPrice;
    }
    public function getDiscountedMaxPriceAttribute()
    {
        $service = $this;
        $discountMaxPrice = null; 
        if ($service->service_type == 'offer') {
            $discountedMaxAmount = $this->max_price * ($this->discount / 100);
            $discountMaxPrice = $this->max_price - $discountedMaxAmount;
        }
        return $discountMaxPrice;
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function pendingReviews()
    {
        return $this->hasMany(Review::class)->where('is_reviewed', false);
    }
    public function userFeaturedSubscriptions()
    {

        return $this->hasOne(UserFeaturedSubscription::class)->where('is_expired', 0);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function images()
    {
        return $this->hasMany(ServiceImage::class)->orderBy('file_default', 'desc');
    }

    public function supplier()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

 
    public function equipments()
    {
        return $this->hasMany(Equipment::class);
    }


 

    public function getFormattedModel(): Service
    {
        $service = $this;
        if ($service->service_type == 'offer') {
            $discountedMinAmount = $this->min_price * ($this->discount / 100);
            $discountMinPrice = $this->min_price - $discountedMinAmount;
            $discountedMaxAmount = $this->max_price * ($this->discount / 100);
            $discountMaxPrice = $this->max_price - $discountedMaxAmount;
            $service->discountedMinPrice = $discountMinPrice;
            $service->dicountedMaxPrice = $discountMaxPrice;
        }
        unset($service->created_at);
        unset($service->updated_at);
        unset($service->deleted_at);
        return $service;
    }
}
