<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $dateFormat = 'U';
    public static $snakeAttributes = false;

    protected $fillable = [
        "privacy_policy",
        "terms_and_conditions",
        "contact_us",
        "our_mission",
        "our_vision",
        "about_us",
        "user_data_delete",
        "address",
        "latitude",
        "longitude",
        "email_header",
        "company_name",
        "contact_number",
        "fax_number",
        "date-format",
        "email",
        "facebook_url",
        "instagram_url",
        "platform_commision",
        "platform_commision_percentage",
        "twitter_url",
        "android_app",
        "ios_app",
        "nearby_radius",
        "date-format",
        "value_added_tax",
        "aed_to_usd",
        "cancel_duration",
        "default_language"
    ];

    protected $casts=[
        'footer_text'=>'array',
    ];
}
