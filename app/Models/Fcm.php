<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fcm extends Model
{
//    use \App\Models\CommonModelFunctions;
//    use CommonFunctions;
    protected $table = 'fcm_token';
    protected $dateFormat = 'U';
    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int',
    ];

        protected $fillable = [
        'user_id',
        'fcm_token',
    ];
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
