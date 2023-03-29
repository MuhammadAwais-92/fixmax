<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $dateFormat = 'U';
    protected $fillable = ['conversation_id', 'mime_type', 'message', 'sender_id', 'file','deleted_by','user1_deleted','user2_deleted'];
    protected $appends = ['date'];
    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int',
        'user1_deleted' => 'int',
        'user2_deleted' => 'int',
    ];
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function getFileAttribute()
    {
        if (empty($this->attributes['file']))
        {
            return '';
        }
        return url($this->attributes['file']);
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
