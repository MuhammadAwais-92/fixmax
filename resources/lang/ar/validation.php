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


    'accepted' => 'يجب الموافقة على attribute:',
    'accepted_if' => 'يجب الموافقة على attribute: عندما: other يكون: value:',
    'active_url' => ':attribute رابط غير صحيح',
    'after' => ':attribute يجب ان تكون تاريخ بعد :date.',
    'after_or_equal' => ' :attribute يجب ان تكون تاريخ بعد :date.',
    'alpha' => ':attribute يجب ان تحتوي على حروف فقط',
    'alpha_dash' => ':attribute يجب ان تحتوي على حروف وأرقام وداشز  ',
    'alpha_num' => ':attribute يجب ان تحتوي على حروف وأرقام',
    'array' => 'يجب أن يكون attribute: مصفوفة',
    'before' => ' :attribute يجب ان تكون تاريخ قبل :date.',
    'before_or_equal' => ' :attribute يجب ان تكون تاريخ نفس او قبل :date.',
    'between' => [
        'numeric' => ' :attribute يجب ان تكون بين :min و max:',
        'file' => ':attribute يجب ان تكون بين :min و max:كيلو بايت',
        'string' => ':attribute يجب ان تكون بين :min و max:حروف',
        'array' => ':attribute يجب ان تكون بين :min و max: عناصر',
    ],
    'boolean' => ':attribute يجب ان تكون صح او خطاء',
    'confirmed' => ':attribute تأكيد السمة غير مطابق.',
    'date' => ':attribute ليست تاريخًا صالحًا.',
    'current_password' => 'كلمة السر غير صحيحة',
    'date_equals' => 'يجب أن يكون attribute: مثل تاريخ: date:',
    'date_format' => ':attribute  لا تطابق التنسيق : :format.',
    'declined' => 'يجب رفض attribute:',
    'declined_if' => 'يجب رفض attribute: عندما: other: يكون: value:',
    'different' => 'يجب أن يكون :attribute و  :other مختلفين.',
    'digits' => 'يجب أن تكون ا:attribute  أرقامًا.',
    'digits_between' => 'يجب أن تكون:attribute  بين :min و :max أرقام.',
    'dimensions' => ':attribute  لها أبعاد صورة غير صالحة.',
    'distinct' => 'يحتوي حقل :attribute  على قيمة مكررة.',
    'email' => 'يجب أن تكون :attribute  عنوان بريد إلكتروني صالحًا.',
    'ends_with' => 'يجب أن ينتهي attribute: بواحدة من الخيارات التالية values:',
    'exists' => 'ال attribute: المحدد غير صحيح',
    'file' => 'يجب أن تكون :attribute : ملفًا.',
    'filled' => 'يجب أن يحتوي حقل :attribute  على قيمة.',
    'gt' => [
        'numeric' => 'يجب أن يكون attribute: أكبر من value:',
        'file' => 'يجب أن يكون attribute: أكبر من value:',
        'string' => 'يجب أن يكون attribute: أكبر من:value رمز',
        'array' => 'يجب أن يحتوي attribute: على أكثر من value: عناصر',
    ],
    'gte' => [
        'numeric' => 'يجب أن تكون قيمة attribute: أكبر أو تساوي value:',
        'file' => 'يجب أن تكون قيمة attribute: أكبر أو تساوي value: كيلو بايت',
        'string' => 'يجب أن تكون قيمة attribute: أكبر أو تساوي value: رمز',
        'array' => 'يجب أن تكون قيمة attribute: أكبر أو تساوي value: رمز',
    ],
    'image' => 'يجب أن تكون :attribute  صورة.',
    'in' => ':attribute  المحددة: غير صالحة.',
    'in_array' => 'حقل :attribute : غير موجود في: :other.',
    'integer' => 'يجب أن تكون :attribute  عددًا صحيحًا.',
    'ip' => 'يجب أن تكون :attribute : عنوان IP صالحًا.',
    'json' => 'يجب أن تكون :attribute : سلسلة JSON صالحة.',
    'ipv4' => 'يجب أن يكون attribute: عنوان IPv4: صحيح',
    'ipv6' => 'يجب أن يكون attribute: عنوان IPv6: صحيح',
    'lt' => [
        'numeric' => 'يجب أن يكون attribute: من سلسلة جافا سكريبت المستهدف',
        'file' => 'يجب أن يكون attribute: من سلسلة جافا سكريبت المستهدف',
        'string' => 'يجب أن يكون attribute: أقل من: value رمز',
        'array' => 'يجب أن يحتوي attribute: على أقل من: value: عناصر',
    ],
    'lte' => [
        'numeric' => 'يجب أن يكون attribute: أقل أو يساوي: value:',
        'file' => 'يجب أن يكون attribute: أقل أو يساوي value: كيلو بايت',
        'string' => 'يجب أن يكون attribute: أقل أو يساوي value: كيلو بايت',
        'array' => 'يجب ألّا يحتوي attribute: على أكثر من value: عناصر',
    ],
    'max' => [
        'numeric' => 'لا يجوز أن تكون :attribute  أكبر من: max.',
        'file' => 'لا يجوز أن تكون :attribute : أكبر من  :max كيلوبايت.',
        'string' => 'لا يجوز أن تكون :attribute  max: الحد الأقصى من الأحرف.',
        'array' => 'لا يجوز أن تحتوي :attribute  على أكثر من: max items.',
    ],

    'mimes' => 'يجب أن تكون:attribute  ملفًا من jpeg و jpg و png القيم.',
    'mimetypes' => 'يجب أن تكون:attribute  ملفًا من jpeg و jpg و png القيم.',
    'min' => [
        'numeric' => 'يجب أن تكون :attribute  على الأقل :min.',
        'file' => 'يجب ألا تقل :attribute  عن :min كيلوبايت.',
        'string' => 'يجب ألا تقل :attribute  عن :min حرفًا.',
        'array' => 'يجب أن تحتوي:attribute  على الأقل على: min من العناصر.',
    ],
    'multiple_of' => 'يجب أن يكون :attribute عدة: value',
    'not_in' => ':attribute  المحددة: غير صالحة.',
    'not_regex' => 'صيغة attribute: غير صحيحة',
    'numeric' => 'يجب أن تكون :attribute  رقمًا.',
    'password' => 'كلمة السر غير صحيحة',
    'present' => 'يجب أن يكون حقل :attribute  موجودًا.',
    'prohibited' => 'يجب أن تكون خانة :attribute موجودة',
    'prohibited_if' => 'يجب أن تكون خانة attribute: موجودة',
    'prohibited_unless' => 'تكون خانة :attribute محظورة ما لم يكن: other في: values',
    'prohibits' => 'تكون خانة :attribute محظورة ما لم يكن: other في: values',
    'regex' => 'تنسيق :attribute : غير صالح.',
    'required' => ':attribute الحقل مطلوب',
    'required_if' => 'يكون حقل :attribute  مطلوبًا عندما: :other هو: value.',
    'required_unless' => 'حقل :attribute  مطلوب إلا إذا كان :other في: قيم.',
    'required_with' => 'يكون حقل :attribute  مطلوبًا عندما تكون: :value موجودة.',
    'required_with_all' => 'يكون حقل :attribute  مطلوبًا عندما تكون: :value موجودة.',
    'required_without' => 'يكون حقل :attribute  مطلوبًا عندما: :value غير موجودة.',
    'required_without_all' => 'يكون حقل :attribute  مطلوبًا في حالة عدم وجود أي من: :value.',
    'same' => 'يجب أن يتطابق :attribute : و: :other.',
    'size' => [
        'numeric' => 'يجب أن تكون :attribute : :size.',
        'file' => 'يجب أن تكون :attribute : :size كيلوبايت.',
        'string' => 'يجب أن تكون :attribute : أحرف الحجم.',
        'array' => 'يجب أن تحتوي :attribute : على عناصر الحجم.',
    ],
    'starts_with' => 'يجب أن يبدأ :attribute بواحدة من التالية:values',
    'string' => 'يجب أن تكون :attribute : سلسلة.',
    'timezone' => 'يجب أن تكون :attribute : منطقة صالحة.',
    'unique' => 'تم استخدام :attribute  بالفعل.',
    'uploaded' => 'فشل تحميل :attribute :.',
    'url' => 'تنسيق :attribute : غير صالح.',
    'uuid' => 'يجب أن يكون :attribute معرف فريد عالمياً صحيح',


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention 'attribute.rule" to name the lines. This makes it quick to
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
        'en' => 'إنجليزي',
        'ar' => 'عربي',
        'description.en' => 'الوصف باللغة الإنجليزية',
        'description.ar' => 'المحتوى باللغة العربية',
        'email' => 'البريد الإلكتروني',
        'password' => 'كلمة المرور',
        'address_name' => 'العنوان',
        'user_phone' => 'هاتف',
        'supplier_name[en]' => 'اسم المورد',
        'supplier_name[ar]' => 'اسم المورد',
        'password_confirmation' => 'تأكيد كلمة المرور',
        'token' => 'رمز',
        'subscription_type' => 'نوع الاشتراك',
        'package_id' => 'طَرد',
        'phone' => 'هاتف',
        'amount' => 'مقدار',
        'current_password' => 'كلمة المرور الحالية',
        'client_id' => 'اعتماد العميل',
        'secret_id' => 'الاعتماد السري',
        'supplier_name' => 'اسم المورد',
        'address' => 'العنوان',
        'trade_license_image' => 'الرخصة التجارية',
        'supplier_name.en' => 'اسم المورد',
        'supplier_name.ar' => 'اسم المورد',
        'user_name' => 'اسم االمستخدم',
        'terms_conditions' => 'الشروط والأحكام',
        'description' => 'وصف',
        'estimated_time' => 'الوقت المقدر',
        'verification_code' => 'رمز التحقق',
        'city' => 'مدينة',
        'Role' => 'دور',
        'visit_fee' => 'رسوم الزيارة',
        'google_id' => 'معرف جوجل',
        'expiry_date' => 'تاريخ انتهاء الصلاحية',
        'images' => 'الصور',
        'date' => 'تاريخ',
        'city_id' => 'مدينة',
        'area_id' => 'منطقة',
        'subCategory' => 'تصنيف فرعي',
        'my_range' => 'المدى الخاص بي',
        'issue_type' => 'نوع القضية',
        'duration_type' => 'نوع المدة',
        'service_images' => 'صور الخدمة',
        'quoated_price' => 'سعر مقتبس',
        'status' => 'حالة',
        'imageUrl' => "صورة",
        'category_id' => "فئة",
        'category' => "فئة",
        'min_price' => "سعر دقيقة",
        'max_price' => "أقصى سعر",
        'rating' => "تقييم",
        'duration' => "مدة",
        'review' => "إعادة النظر",
        'project_images' => "صور المشروع",
        'image' => "صورة",
        'user_type' => "نوع المستخدم",
        'service_id' => "خدمة",
        'user_id' => "المستخدم",
        'name.en' => 'الاسم بالانجليزية',
        'name[en]' => 'الاسم بالانجليزية',
        'name[ar]' => 'الاسم بالعربي',
        'latitude' => 'خط العرض',
        'featured_subscription' => 'اشتراك مميز',
        'equipment[]' => 'معدات',
        'order_id' => 'ترتيب',
        'name' => 'اسم',
        'equipment_model' => 'نموذج المعدات',
        'price' => 'سعر',
        'make' => 'يجعلون',
        'longitude' => 'خط الطول',
        'covered_areas' => 'المناطق المغطاة',
        'code' => 'رمز',
        'keyword' => 'كلمة رئيسية',
        'sort' => 'فرز',
        'message_text' => 'رسالة نصية',
        'subject' => 'موضوعات',
        'paymentID' => 'معرف الدفع',
        'selected_address' => 'العنوان المحدد',
        'payment_method' => 'طريقة الدفع او السداد',
        'name.ar' => 'الاسم بالعربي',
        'question.en' => 'السؤال باللغة الإنجليزية',
        'question.ar' => 'السؤال بالعربية',
        'answer.en' => 'الإجابة باللغة الإنجليزية',
        'answer.ar' => 'الجواب بالعربية',
        'content' => 'محتوى',
        'content.en' => "المحتوى باللغة الإنجليزية",
        'content.ar' => "المحتوى باللغة العربية",
    ],

];
