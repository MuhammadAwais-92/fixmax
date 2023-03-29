<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute کو قبول کرنا ضروری ہے۔',
    'accepted_if' => ':attribute کو قبول کرنا ضروری ہے جب :other ہے :value۔',
    'active_url' => ':attribute ایک درست URL نہیں ہے۔',
    'after' => ':attribute:date کے بعد کی تاریخ ہونی چاہیے۔',
    'after_or_equal' => ':attribute:date کے بعد یا اس کے مساوی تاریخ ہونی چاہیے۔',
    'alpha' => ':attribute میں صرف حروف ہونا چاہیے۔',
    'alpha_dash' => ':attribute میں صرف حروف نمبر ڈیشز اور انڈر سکور شامل ہونے چاہئیں۔',
    'alpha_num' => ':attribute میں صرف حروف اور اعداد ہونے چاہئیں۔',
    'before' => ':attribute:date سے پہلے کی تاریخ ہونی چاہیے۔',
    'before_or_equal' => ':attribute کو :date سے پہلے یا اس کے برابر کی تاریخ ہونی چاہیے۔',
    'between' => [
        'numeric' => ':attribute کو :min اور :max کے درمیان ہونا چاہیے۔',
        'file' => ':attribute:min اور :max kilobytes کے درمیان ہونا چاہیے۔',
        'string' => ':attribute کو :min اور :max حروف کے درمیان ہونا چاہیے۔',
        'array' => ':attribute میں :min اور :max اشیاء کے درمیان ہونا ضروری ہے۔',
    ],
    'boolean' => ':attribute فیلڈ کو صحیح یا غلط ہونا چاہیے۔',
    'confirmed' => ':attribute کی تصدیق مماثل نہیں ہے۔',
    'current_password' => 'پاس ورڈ غلط ہے۔',
    'date' => ':attribute ایک درست تاریخ نہیں ہے۔',
    'date_equals' => ':attribute کو :date کے برابر تاریخ ہونی چاہیے۔',
    'date_format' => ':attribute فارمیٹ :فارمیٹ سے میل نہیں کھاتا۔',
    'declined' => ':attribute کو مسترد کرنا ضروری ہے۔',
    'declined_if' => ':attribute کو رد کر دیا جانا چاہیے جب :other ہے :value۔',
    'different' => ':attribute اور :other مختلف ہونا چاہیے۔',
    'digits' => ':attribute کا ہونا ضروری ہے :digits digits۔',
    'digits_between' => ':attribute کو :min اور :max ہندسوں کے درمیان ہونا چاہیے۔',
    'dimensions' => ':attribute میں تصویر کے غلط طول و عرض ہیں۔',
    'distinct' => ':attribute فیلڈ میں ڈپلیکیٹ ویلیو ہے۔',
    'email' => ':attribute ایک درست ای میل پتہ ہونا چاہیے۔',
    'ends_with' => ':attribute کا اختتام مندرجہ ذیل میں سے کسی ایک کے ساتھ ہونا چاہیے: :values۔',
    'exists' => 'منتخب کردہ :attribute غلط ہے۔',
    'file' => ':attribute ایک فائل ہونی چاہیے۔',
    'filled' => ':attribute فیلڈ میں ایک قدر ہونی چاہیے۔',
    'gt' => [
        'numeric' => ':attribute کو :value سے بڑا ہونا چاہیے۔',
        'file' => ':attribute کو :value kilobytes سے بڑا ہونا چاہیے۔',
        'string' => ':attribute کو :value حروف سے بڑا ہونا چاہیے۔',
        'array' => ':attribute میں :value آئٹمز سے زیادہ ہونا ضروری ہے۔',
    ],
    'gte' => [
        'numeric' => ':attribute کو :value سے بڑا یا اس کے برابر ہونا چاہیے۔',
        'file' => ':attribute کو :value kilobytes سے بڑا یا اس کے برابر ہونا چاہیے۔',
        'string' => ':attribute کو :value حروف سے بڑا یا اس کے برابر ہونا چاہیے۔',
        'array' => ':attribute میں :value آئٹمز یا اس سے زیادہ ہونا ضروری ہے۔',
    ],
    'image' => ':attribute ایک تصویر ہونی چاہیے۔',
    'in' => 'منتخب کردہ :attribute غلط ہے۔',
    'in_array' => ':attribute فیلڈ :other میں موجود نہیں ہے۔',
    'integer' => ':attribute ایک عدد عدد ہونا چاہیے۔',
    'ip' => ':attribute ایک درست IP پتہ ہونا چاہیے۔',
    'ipv4' => ':attribute ایک درست IPv4 پتہ ہونا چاہیے۔',
    'ipv6' => ':attribute ایک درست IPv6 پتہ ہونا چاہیے۔',
    'json' => ':attribute ایک درست JSON سٹرنگ ہونی چاہیے۔',
    'lt' => [
        'numeric' => ':attribute کو :value سے کم ہونا چاہیے۔',
        'file' => ':attribute کو :value kilobytes سے کم ہونا چاہیے۔',
        'string' => ':attribute کو :value حروف سے کم ہونا چاہیے۔',
        'array' => ':attribute میں :value آئٹمز سے کم ہونا ضروری ہے۔',
    ],
    'lte' => [
        'numeric' => ':attribute کو :value سے کم یا اس کے برابر ہونا چاہیے۔',
        'file' => ':attribute کو :value kilobytes سے کم یا اس کے برابر ہونا چاہیے۔',
        'string' => ':attribute کو :value حروف سے کم یا برابر ہونا چاہیے۔',
        'array' => ':attribute میں :value آئٹمز سے زیادہ نہیں ہونا چاہیے۔',
    ],
    'max' => [
        'numeric' => ':attribute کو :max سے زیادہ نہیں ہونا چاہیے۔',
        'file' => ':attribute کو :max kilobytes سے زیادہ نہیں ہونا چاہیے۔',
        'string' => ':attribute کو :max حروف سے زیادہ نہیں ہونا چاہیے۔',
        'array' => ':attribute میں :max سے زیادہ اشیاء نہیں ہونی چاہئیں۔',
    ],
    'mimes' => ':attribute ٹائپ: :values کی فائل ہونی چاہیے۔',
    'mimetypes' => ':attribute ٹائپ: :values کی فائل ہونی چاہیے۔',
    'min' => [
        'numeric' => ':attribute کم از کم :min ہونا چاہیے۔',
        'file' => ':attribute کم از کم :min kilobytes ہونا چاہیے۔',
        'string' => ':attribute کم از کم :min حروف کا ہونا چاہیے۔',
        'array' => ':attribute میں کم از کم :min اشیاء ہونی چاہئیں۔',
    ],
    'multiple_of' => ':attribute کو :value کا کثیر ہونا چاہیے۔',
    'not_in' => 'منتخب کردہ :attribute غلط ہے۔',
    'not_regex' => ':attribute فارمیٹ غلط ہے۔',
    'numeric' => ':attribute کو ایک عدد ہونا چاہیے۔',
    'password' => 'پاس ورڈ غلط ہے۔',
    'present' => ':attribute فیلڈ کا موجود ہونا ضروری ہے۔',
    'prohibited' => ':attribute فیلڈ ممنوع ہے۔',
    'prohibited_if' => ':attribute فیلڈ ممنوع ہے جب :other ہے :value۔',
    'prohibited_unless' => ':attribute فیلڈ ممنوع ہے جب تک کہ :other :values میں نہ ہو۔',
    'prohibits' => ':attribute فیلڈ منع کرتا ہے :other کو موجود ہونے سے۔',
    'regex' => ':attribute فارمیٹ غلط ہے۔',
    'required' => ':attribute فیلڈ درکار ہے۔',
    'required_if' => ':attribute فیلڈ کی ضرورت ہوتی ہے جب :other ہے :value۔',
    'required_unless' => ':attribute فیلڈ کی ضرورت ہے جب تک کہ :other :values میں نہ ہو۔',
    'required_with' => ':attribute فیلڈ کی ضرورت ہوتی ہے جب :values موجود ہو۔',
    'required_with_all' => ':attribute فیلڈ کی ضرورت ہوتی ہے جب :values موجود ہوں۔',
    'required_without' => ':attribute فیلڈ کی ضرورت ہوتی ہے جب :values موجود نہ ہو۔',
    'required_without_all' => ':attribute فیلڈ کی ضرورت ہے جب :values میں سے کوئی بھی موجود نہ ہو۔',
    'same' => ':attribute اور :other کو مماثل ہونا چاہیے۔',
    'size' => [
        'numeric' => ':attribute کو :size ہونا چاہیے۔',
        'file' => ':attribute کا ہونا ضروری ہے :size kilobytes۔',
        'string' => ':attribute کا ہونا ضروری ہے :size حروف۔',
        'array' => ':attribute میں :size آئٹمز کا ہونا ضروری ہے۔',
    ],
    'starts_with' => ':attribute کو درج ذیل میں سے کسی ایک سے شروع ہونا چاہیے: :values۔',
    'string' => ':attribute ایک تار ہونا چاہیے۔',
    'timezone' => ':attribute ایک درست ٹائم زون ہونا چاہیے۔',
    'unique' => ':attribute پہلے ہی لیا جا چکا ہے۔',
    'uploaded' => ':attribute اپ لوڈ کرنے میں ناکام۔',
    'url' => ':attribute ایک درست URL ہونا چاہیے۔',
    'uuid' => ':attribute ایک درست UUID ہونا چاہیے۔',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'en' => 'انگریزی',
        'ar' => 'عربی',
        'description.en' => 'انگریزی میں تفصیل',
        'description.ar' => 'عربی میں تفصیل',
        'email' => 'ای میل',
        'password' => 'پاس ورڈ',
        'address_name' => 'پتہ',
        'user_phone' => 'Phone',
        'supplier_name[en]' => 'سپلائر کے نام',
        'supplier_name[ar]' => 'سپلائر کے نام',
        'password_confirmation' => 'پاسورڈ کی تو ثیق',
        'token' => 'ٹوکن',
        'subscription_type' => 'سبسکرپشن کی قسم',
        'package_id' => 'پیکج',
        'phone' => 'فون',
        'amount' => 'رقم',
        'current_password' => 'Current Password',
        'client_id' => 'کلائنٹ کی اسناد',
        'secret_id' => 'خفیہ اسناد',
        'supplier_name' => 'سپلائر کے نام',
        'address' => 'پتہ',
        'trade_license_image' => 'تجارتی لائسنس',
        'supplier_name.en' => 'سپلائر کے نام',
        'supplier_name.ar' => 'سپلائر کے نام',
        'user_name' => 'صارف کا نام',
        'terms_conditions' => 'Terms Conditions',
        'description' => 'تفصیل',
        'estimated_time' => 'متوقع وقت',
        'verification_code' => 'تصدیقی کوڈ',
        'city' => 'شہر',
        'Role' => 'کردار',
        'visit_fee' => 'وزٹ فیس',
        'google_id' => 'گوگل آئی ڈی',
        'expiry_date' => 'خاتمے کی تاریخ',
        'images' => 'امیجز',
        'date' => 'تاریخ',
        'city_id' => 'City',
        'area_id' => 'رقبہ',
        'subCategory' => 'ذیلی زمرہ',
        'my_range' => 'میری رینج',
        'issue_type' => 'مسئلہ کی قسم',
        'duration_type' => 'دورانیہ کی قسم',
        'service_images' => 'سروس امیجز',
        'quoated_price' => 'بتائے گئے نرخ',
        'status' => 'حالت',
        'imageUrl' => "تصویر",
        'category_id' => "قسم",
        'category' => "قسم",
        'min_price' => "کم از کم قیمت",
        'max_price' => "زیادہ سے زیادہ قیمت",
        'rating' => "درجہ بندی",
        'duration' => "دورانیہ",
        'review' => "جائزہ لیں",
        'project_images' => "پروجیکٹ امیجز",
        'image' => "تصویر",
        'user_type' => "صارف کی قسم",
        'service_id' => "سروس",
        'user_id' => "صارف",
        'name.en' => 'انگریزی میں نام',
        'name[en]' => 'انگریزی میں نام',
        'name[ar]' => 'عربی میں نام',
        'latitude' => 'طول',
        'featured_subscription' => 'نمایاں سبسکرپشن',
        'equipment[]' => 'سامان',
        'order_id' => 'ترتیب',
        'name' => 'نام',
        'equipment_model' => 'آلات کا ماڈل',
        'price' => 'قیمت',
        'make' => 'بنائیں',
        'longitude' => 'طول البلد',
        'covered_areas' => 'احاطہ شدہ علاقے',
        'code' => 'کوڈ',
        'keyword' => 'کلیدی لفظ',
        'sort' => 'ترتیب دیں',
        'message_text' => 'پیغام کا متن',
        'subject' => 'مضمون',
        'paymentID' => 'ادائیگی کی شناخت',
        'selected_address' => 'منتخب کردہ پتہ',
        'payment_method' => 'ادائیگی کا طریقہ',
        'name.ar' => 'عربی میں نام',
        'question.en' => 'انگریزی میں سوال',
        'question.ar' => 'عربی میں سوال',
        'answer.en' => 'انگریزی میں جواب دیں۔',
        'answer.ar' => 'عربی میں جواب دیں۔',
        'content' => 'مواد',
        'content.en' => "انگریزی میں مواد",
        'content.ar' => "عربی میں مواد",
    ],

];
