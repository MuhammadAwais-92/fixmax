<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 18 Dec 2018 05:28:00 +0000.
 */

namespace App\Models;

//use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Notification
 *
 * @property int $id
 * @property int $user1_id
 * @property int $user2_id
 * @property int $sender_id
 * @property string $title
 * @property string $description
 * @property int $extras
 * @property string $action
 * @property bool $is_seen
 * @property int $created_at
 * @property int $updated_at
 * @property string $deleted_at
 *
 * @property \App\Models\User $user
 *
 * @package App\Models
 */
class Notification extends Model
{

    use \Illuminate\Database\Eloquent\SoftDeletes;
    
    protected $dateFormat = 'U';
    public static $snakeAttributes = false;
    protected $table = 'notifications';
    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int',
        'extras' => 'array',
        'title' =>'array',
        'description'=>'array'
    ];

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'extras->quotation_id',
        'extras->order_id',
        'extras->service_id',
        'extras->service_name',
        'extras->image',
        'extras->notification_id',
        'extras->conversation_id',
        'extras->supplier_id',
        'extras->app_logo',
        'extras->service_slug',
        'action',
        'title->en',
        'title->ar',
        'title->ru',
        'title->ur',
        'title->hi',
        'description->en',
        'description->ar',
        'description->ru',
        'description->ur',
        'description->hi',
    ];
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->getTimestamp();
    }
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

}
