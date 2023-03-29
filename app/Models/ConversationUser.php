<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ConversationUser extends Model
{

    protected $table = 'conversation_user';
    public $timestamps = false;
    protected $dateFormat = 'U';

    protected $hidden = ['pivot'];
    protected $casts = [
        'conversation_id' => 'int',
        'user_id' => 'int'
    ];
    protected $fillable = [
        'conversation_id',
        'user_id',
    ];

}
