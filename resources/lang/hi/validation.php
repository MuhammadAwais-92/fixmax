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

    'accepted' => ':attribute को स्वीकार किया जाना चाहिए।',
    'accepted_if' => ':attribute तब स्वीकार की जानी चाहिए जब :other  है :value',
    'active_url' => ':attribute मान्य URL नहीं है।',
    'after' => ':attribute :date के बाद की तारीख होनी चाहिए।',
    'after_or_equal' => ':attribute :date के बाद या उसके बराबर की तारीख होनी चाहिए।',
    'alpha' => ':attribute में केवल अक्षर होने चाहिए।',
    'alpha_dash' => ':attribute में केवल अक्षर, संख्याएं, डैश और अंडरस्कोर होने चाहिए।',
    'alpha_num' => ':attribute में केवल अक्षर और संख्याएँ होनी चाहिए।',
    'array' => ':attribute एक सरणी होनी चाहिए।',
    'before' => ':attribute :date से पहले की तारीख होनी चाहिए।',
    'before_or_equal' => ':attribute :date से पहले या उसके बराबर की तारीख होनी चाहिए।',
    'between' => [
        'numeric' => ':attribute :min और :max के बीच होनी चाहिए।',
        'file' => ':attribute :min और :max किलोबाइट के बीच होनी चाहिए।',
        'string' => ':attribute :min और :max वर्णों के बीच होनी चाहिए।',
        'array' => ':attribute :min और :max आइटम के बीच होनी चाहिए।',
    ],
    'boolean' => ':attribute क्षेत्र सही या गलत होना चाहिए।',
    'confirmed' => ':attribute पुष्टि मेल नहीं खाती।',
    'current_password' => 'पासवर्ड गलत है.',
    'date' => ':attribute मान्य दिनांक नहीं है।',
    'date_equals' => ':attribute :date के बराबर एक तिथि होनी चाहिए।',
    'date_format' => ':attribute प्रारूप से मेल नहीं खाती :format।',
    'declined' => ':attribute को अस्वीकार किया जाना चाहिए।',
    'declined_if' => 'जब :other है :value हो तो :attribute को अस्वीकार कर दिया जाना चाहिए।',
    'different' => ':attribute और :other भिन्न होना चाहिए।',
    'digits' => ':attribute :digits अंक होनी चाहिए।',
    'digits_between' => ':attribute :min और :max अंकों के बीच होनी चाहिए।',
    'dimensions' => ':attribute में अमान्य छवि आयाम हैं।',
    'distinct' => ':attribute फ़ील्ड में एक डुप्लिकेट मान है।',
    'email' => ':attribute एक मान्य ईमेल पता होना चाहिए।',
    'ends_with' => ':attribute निम्न में से किसी एक के साथ समाप्त होनी following: :values।',
    'exists' => 'चयनित :attribute अमान्य है।',
    'file' => ':attribute एक फ़ाइल होनी चाहिए।',
    'filled' => ':attribute फ़ील्ड में एक मान होना चाहिए।',
    'gt' => [
        'numeric' => ':attribute :other से बड़ी होनी चाहिए।',
        'file' => ':attribute :other किलोबाइट से अधिक होनी चाहिए।',
        'string' => ':attribute :other वर्णों से अधिक होनी चाहिए।',
        'array' => ':attribute में :value आइटम से अधिक होना चाहिए।',
    ],
    'gte' => [
        'numeric' => ':attribute :value से अधिक या उसके बराबर होनी चाहिए।',
        'file' => ':attribute :value किलोबाइट से अधिक या उसके बराबर होनी चाहिए।',
        'string' => ':attribute :value वर्णों से अधिक या उसके बराबर होनी चाहिए।',
        'array' => ':attribute में :value आइटम या अधिक होना चाहिए।',
    ],
    'image' => ':attribute एक छवि होनी चाहिए।',
    'in' => 'चयनित :attribute अमान्य है।',
    'in_array' => ':attribute क्षेत्र :other में मौजूद नहीं है।',
    'integer' => ':attribute एक पूर्णांक होना चाहिए।',
    'ip' => ':attribute एक मान्य IP पता होना चाहिए।',
    'ipv4' => ':attribute एक मान्य IPv4 पता होना चाहिए।',
    'ipv6' => ':attribute एक मान्य IPv6 पता होना चाहिए।',
    'json' => ':attribute एक मान्य JSON स्ट्रिंग होनी चाहिए।',
    'lt' => [
        'numeric' => ':attribute :value से कम होनी चाहिए।',
        'file' => ':attribute :value किलोबाइट से कम होनी चाहिए।',
        'string' => ':attribute :value वर्णों से कम होनी चाहिए।',
        'array' => ':attribute में :value आइटम से कम होना चाहिए।',
    ],
    'lte' => [
        'numeric' => ':attribute :value से कम या उसके बराबर होनी चाहिए।',
        'file' => ':attribute :value किलोबाइट से कम या उसके बराबर होनी चाहिए।',
        'string' => ':attribute :value वर्णों से कम या उसके बराबर होनी चाहिए।',
        'array' => ':attribute में :value आइटम से अधिक नहीं होना चाहिए।',
    ],
    'max' => [
        'numeric' => ':attribute :value से अधिक नहीं होनी चाहिए।',
        'file' => ':attribute :value किलोबाइट से अधिक नहीं होनी चाहिए।',
        'string' => ':attribute :value वर्णों से अधिक नहीं होनी चाहिए।',
        'array' => 'विशेषता :attribute आइटम से अधिक नहीं होनी चाहिए।',
    ],
    'mimes' => ':attribute प्रकार की फ़ाइल होनी चाहिए:value',
    'mimetypes' => ':attribute प्रकार की फ़ाइल होनी चाहिए:value',
    'min' => [
        'numeric' => ':attribute कम से कम :min होनी चाहिए।',
        'file' => ':attribute कम से कम :min किलोबाइट होनी चाहिए।',
        'string' => ':attribute कम से कम :min वर्णों की होनी चाहिए।',
        'array' => ':attribute में कम से कम :min आइटम होने चाहिए।',
    ],
    'multiple_of' => ':attribute :value का गुणज होना चाहिए।',
    'not_in' => 'चयनित :attribute अमान्य है।',
    'not_regex' => ':attribute प्रारूप अमान्य है।',
    'numeric' => ':attribute एक संख्या होनी चाहिए।',
    'password' => 'पासवर्ड गलत है।',
    'present' => ':attribute फ़ील्ड मौजूद होना चाहिए।',
    'prohibited' => ':attribute फ़ील्ड निषिद्ध है।',
    'prohibited_if' => ':attribute फ़ील्ड निषिद्ध है जब :other है :value',
    'prohibited_unless' => ':attribute फ़ील्ड तब तक निषिद्ध है जब तक :other :values में न हो।',
    'prohibits' => ':attribute क्षेत्र :other को उपस्थित होने से रोकता है।',
    'regex' => ':attribute प्रारूप अमान्य है।',
    'required' => ':attribute फ़ील्ड आवश्यक है।',
    'required_if' => ':attribute फ़ील्ड आवश्यक है जब :other है :value.',
    'required_unless' => ':attribute फ़ील्ड तब तक आवश्यक है जब तक :other :values में न हो।',
    'required_with' => ':attribute फ़ील्ड आवश्यक है जब :values मौजूद हो।',
    'required_with_all' => ':attribute फ़ील्ड आवश्यक है जब :values मौजूद हों।',
    'required_without' => ':attribute फ़ील्ड आवश्यक है जब :values मौजूद नहीं है।',
    'required_without_all' => ':attribute फ़ील्ड की आवश्यकता तब होती है जब कोई भी :values मौजूद न हो।',
    'same' => ':attribute और :other का मिलान होना चाहिए।',
    'size' => [
        'numeric' => ':attribute :size होनी चाहिए।',
        'file' => ':attribute :size किलोबाइट होनी चाहिए।',
        'string' => ':attribute :size वर्ण होनी चाहिए।',
        'array' => ':attribute में :size के आइटम होने चाहिए।',
    ],
    'starts_with' => ':attribute निम्न में से किसी एक से शुरू होनी चाहिए: :values.',
    'string' => ':attribute एक स्ट्रिंग होनी चाहिए।',
    'timezone' => ':attribute एक मान्य समयक्षेत्र होना चाहिए।',
    'unique' => ':attribute पहले ही ली जा चुकी है।',
    'uploaded' => ':attribute अपलोड करने में विफल रही।',
    'url' => ':attribute एक मान्य URL होना चाहिए।',
    'uuid' => ':attribute एक मान्य UUID होना चाहिए।',

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
        'en' => 'अंग्रेज़ी',
        'ar' => 'अरबी',
        'description.en' => 'अंग्रेजी में विवरण',
        'description.ar' => 'अरबी में विवरण',
        'email' => 'ईमेल',
        'password' => 'पासवर्ड',
        'address_name' => 'पता',
        'user_phone' => 'फ़ोन',
        'supplier_name[en]' => 'आपूर्तिकर्ता का नाम',
        'supplier_name[ar]' => 'आपूर्तिकर्ता का नाम',
        'password_confirmation' => 'पासवर्ड पुष्टि',
        'token' => 'टोकन',
        'subscription_type' => 'सदस्यता प्रकार',
        'package_id' => 'पैकेट',
        'phone' => 'फ़ोन',
        'amount' => 'राशि',
        'current_password' => 'वर्तमान पासवर्ड',
        'client_id' => 'क्लाइंट क्रेडेंशियल',
        'secret_id' => 'गुप्त क्रेडेंशियल',
        'supplier_name' => 'आपूर्तिकर्ता का नाम',
        'address' => 'पता',
        'trade_license_image' => 'व्यापार लाइसेंस',
        'supplier_name.en' => 'आपूर्तिकर्ता का नाम',
        'supplier_name.ar' => 'आपूर्तिकर्ता का नाम',
        'user_name' => 'उपयोगकर्ता नाम',
        'terms_conditions' => 'नियम एवं शर्तें',
        'description' => 'विवरण',
        'estimated_time' => 'अनुमानित समय',
        'verification_code' => 'पुष्टि संख्या',
        'city' => 'शहर',
        'Role' => 'भूमिका',
        'visit_fee' => 'यात्रा शुल्क',
        'google_id' => 'गूगल आईडी',
        'expiry_date' => 'समाप्ति तिथि',
        'images' => 'इमेजिस',
        'date' => 'दिनांक',
        'city_id' => 'शहर',
        'area_id' => 'क्षेत्र',
        'subCategory' => 'उपश्रेणी',
        'my_range' => 'मेरी सीमा',
        'issue_type' => 'विषय वर्ग',
        'duration_type' => 'अवधि प्रकार',
        'service_images' => 'सेवा छवियां',
        'quoated_price' => 'तयशुदा मूल्य',
        'status' => 'दर्जा',
        'imageUrl' => "छवि",
        'category_id' => "श्रेणी",
        'category' => "श्रेणी",
        'min_price' => "न्यूनतम कीमत",
        'max_price' => "अधिकतम मूल्य",
        'rating' => "रेटिंग",
        'duration' => "अवधि",
        'review' => "समीक्षा",
        'project_images' => "परियोजना छवियां",
        'image' => "छवि",
        'user_type' => "उपयोगकर्ता का प्रकार",
        'service_id' => "सेवा",
        'user_id' => "उपयोगकर्ता",
        'name.en' => 'अंग्रेजी में नाम',
        'name[en]' => 'अंग्रेजी में नाम',
        'name[ar]' => 'अरबी में नाम',
        'latitude' => 'अक्षांश',
        'featured_subscription' => 'चुनिंदा सदस्यता',
        'equipment[]' => 'उपकरण',
        'order_id' => 'आदेश',
        'name' => 'नाम',
        'equipment_model' => 'उपकरण मॉडल',
        'price' => 'कीमत',
        'make' => 'बनाना',
        'longitude' => 'देशान्तर',
        'covered_areas' => 'आच्छादित क्षेत्र',
        'code' => 'कोड',
        'keyword' => 'कीवर्ड',
        'sort' => 'क्रम से लगाना',
        'message_text' => 'संदेश शब्द',
        'subject' => 'विषय',
        'paymentID' => 'भुगतान आईडी',
        'selected_address' => 'चयनित पता',
        'payment_method' => 'भुगतान का तरीका',
        'name.ar' => 'अरबी में नाम',
        'question.en' => 'अंग्रेजी में प्रश्न',
        'question.ar' => 'अरबी में प्रश्न',
        'answer.en' => 'अंग्रेज़ी में उत्तर दें',
        'answer.ar' => 'उत्तर अरबी में',
        'content' => 'विषय',
        'content.en' => "अंग्रेजी में सामग्री",
        'content.ar' => "अरबी में सामग्री",
    ],

];
