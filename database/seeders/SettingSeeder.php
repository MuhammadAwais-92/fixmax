<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
                "privacy_policy" => "privacy-policy",
                "terms_and_conditions" => "terms-and-conditions",
                "contact_us" => "contact-us",
                "mission_and_vision" => "mission-and-vision",
                "about_us" => "about-us",
                "address" => "Office street, office, UAE",
                "latitude" => "31.469693",
                "longitude" => "74.27284610000004",
                "email_header" => "",
                "company_name" => "Padel Stadium",
                "date-format" => "d M, Y",
                "contact_number" => "(+966) 123 456 789",
                "email" => "info@development.com",
                "facebook_url" => "https://www.facebook.com/",
                "instagram_url" => "https://www.instagram.com/",
                "twitter_url" => "https://www.twitter.com/",
                "ios_app" => "https://www.apple.com/app-store/",
                "android_app" => "https://play.google.com/store/apps",
                "value_added_tax" => "3",
              ]
        );
    }
}
