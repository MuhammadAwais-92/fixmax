<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Order extends Model
{


    protected $dateFormat = 'U';
    public static $snakeAttributes = false;
    protected $casts = [
        'user_id' => 'int',
        'created_at' => 'int',
        'updated_at' => 'int',
        'address'=>'array',
        'issue_images' => 'array',
        'service_name' => 'array',

    ];
    protected $appends = ['full_name','issue_images_url','service_image'];
    protected $fillable = [
        'user_id',
        'service_id',
        'supplier_id',
        'full_name',
        'first_name',
        'last_name',
        'order_notes',
        'status',
        'min_price',
        'max_price',
        'subtotal',
        'total_amount',
        'service_name',
        'platform_commission',
        'amount_paid',
        'quoated_price',
        'address',
        'quotation_invoice',
        'order_number',
        'image',
        'visit_fee',
        'date',
        'time',
        'invoice',
        'issue_images',
        'vat_1',
        'vat_2',
        'discount',
        'vat_percentage_1',
        'vat_percentage_2',
        'issue_type',
        'is_quoated',
        'is_visited',


    ];
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->getTimestamp();
    }
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }
    public function service()
    {
        return $this->belongsTO(Service::class, 'service_id');
    }
    public function serviceRating()
    {
        return $this->belongsTO(Service::class, 'service_id')->withTrashed();
    }
    public function rateSupplier()
    {
        return $this->hasMany(Review::class)->where('is_reviewed', false);
    }
    public function rateService()
    {
        return $this->hasMany(Review::class)->where('is_reviewed', false);
    }
    public function orderTransactions()
    {
        return $this->hasMany(\App\Models\OrderTransaction::class);
    }
    public function orderItems()
    {
        return $this->hasMany(\App\Models\OrderItem::class);
    }
    public function orderItemsBought()
    {
        return $this->hasMany(\App\Models\OrderItem::class)->where('qty_1','!=',false);
    }
    public function orderItemsToBeBought()
    {
        return $this->hasMany(\App\Models\OrderItem::class)->where('qty_2','!=',false);
    }
    protected function getImageAttribute() {
        if (!empty($this->attributes['image'])){
            return url($this->attributes['image']);
        }
        return url('images/productDetail.jpg');
    }
    protected function getServiceImageAttribute() {
        if (!empty($this->attributes['image'])){
            return $this->attributes['image'];
        }
        return url('images/productDetail.jpg');
    }
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
    public function getAddressAttribute($value)
    {
        return json_decode($value,true);
    }
    public function isPending(){
        return $this->status == 'pending';
    }
    public function isAccepted(){
        return $this->status == 'accepted';
    }
    public function isCompleted(){
        return $this->status == 'completed';
    }
    public function isCancelled(){
        return $this->status == 'cancelled';
    }
    public function isRejected(){
        return $this->status == 'rejected';
    }
    public function isVisited(){
        return $this->status == 'visited';
    }
    public function isQuoted(){
        return $this->status == 'quoted';
    }
    public function isConfirmed(){
        return $this->status == 'confirmed';
    }
    public function isInProgress(){
        return $this->status == 'in-progress';
    }
    public function getIssueImagesUrlAttribute()
    {
        $images = null;
        if (is_array($this->issue_images)) {
            $images = collect($this->issue_images)->map(function ($image) {
                return url($image);
            });
        }
        return $images;
    }

}
