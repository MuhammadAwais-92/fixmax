<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $dateFormat = 'U';
    protected $fillable = ['id','service_id','user2_deleted','user1_deleted'];
    protected $appends = ['date'];
    public function conversationUsers()
    {
        return $this->belongsToMany(User::class);
    }

    public function users(){
        return $this->hasMany(ConversationUser::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }

    public function service()
    {
        return $this->belongsTo(Service::class)->withTrashed();
    }
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->getTimestamp();
    }
    public function getDateAttribute()
    {
        return unixTODateformateForHuman2($this->attributes['created_at']);
    }
}
