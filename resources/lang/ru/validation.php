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

    'accepted' => ':attribute должен быть принят.',
    'accepted_if' => ':attribute должен быть принят, когда :other равно :value.',
    'active_url' => ':attribute не является допустимым URL.',
    'after' => ':attribute не является допустимым URL.',
    'after_or_equal' => ':attribute должен быть датой после :date или равным ей.',
    'alpha' => ':attribute должен содержать только буквы.',
    'alpha_dash' => ':attribute должен содержать только буквы, цифры, дефисы и символы подчеркивания.',
    'alpha_num' => 'The :attribute must only contain letters and numbers.',
    'array' => ':attribute должен быть массивом.',
    'before' => 'The :attribute must be a date before :date.',
    'before_or_equal' => ':attribute должен быть датой до :date.',
    'between' => [
        'numeric' => ':attribute должен быть между :min и :max.',
        'file' => ':attribute должен быть между :min и :max килобайтами.',
        'string' => ':attribute должен находиться между символами :min и :max.',
        'array' => ':attribute должен иметь элементы от :min до :max.',
    ],
    'boolean' => 'Поле :attribute должно быть истинным или ложным.',
    'confirmed' => 'Подтверждение :attribute не совпадает.',
    'current_password' => 'Пароль неверен.',
    'date' => ':attribute не является действительной датой.',
    'date_equals' => ':attribute должен быть датой, равной :date.',
    'date_format' => ':attribute не соответствует формату :format.',
    'declined' => ':attribute должен быть отклонен.',
    'declined_if' => ':attribute должен быть отклонен, если :other равно :value.',
    'different' => ':attribute и :other должны быть разными.',
    'digits' => ':attribute должен быть :digits цифры.',
    'digits_between' => ':attribute должен быть между цифрами :min и :max.',
    'dimensions' => ':attribute имеет недопустимые размеры изображения.',
    'distinct' => 'Поле :attribute имеет повторяющееся значение.',
    'email' => ':attribute должен быть действительным адресом электронной почты.',
    'ends_with' => ':attribute должен заканчиваться одним из следующих: :values.',
    'exists' => 'Выбранный :attribute недействителен.',
    'file' => ':attribute должен быть файлом.',
    'filled' => 'Поле :attribute должно иметь значение.',
    'gt' => [
        'numeric' => ':attribute должен быть больше :value.',
        'file' => ':attribute должен быть больше :value килобайт.',
        'string' => ':attribute должен быть больше символов :value.',
        'array' => ':attribute должен иметь более :value элементов.',
    ],
    'gte' => [
        'numeric' => ':attribute должен быть больше или равен :value.',
        'file' => ':attribute должен быть больше или равен :value килобайтам.',
        'string' => ':attribute должен быть больше или равен :value символов.',
        'array' => ':attribute должен иметь элементы :value или более.',
    ],
    'image' => ':attribute должен быть изображением.',
    'in' => 'Выбранный :attribute недействителен.',
    'in_array' => 'Поле :attribute не существует в :other.',
    'integer' => ':attribute должен быть целым числом.',
    'ip' => ':attribute должен быть действительным IP-адресом.',
    'ipv4' => ':attribute должен быть действительным адресом IPv4.',
    'ipv6' => ':attribute должен быть действительным адресом IPv6.',
    'json' => ':attribute должен быть допустимой строкой JSON.',
    'lt' => [
        'numeric' => ':attribute должен быть меньше :value.',
        'file' => 'Размер :attribute должен быть меньше :value килобайт.',
        'string' => ':attribute должен быть меньше символов :value.',
        'array' => 'Элемент :attribute должен содержать меньше элементов :value.',
    ],
    'lte' => [
        'numeric' => ':attribute должен быть меньше или равен :value.',
        'file' => ':attribute должен быть меньше или равен :value килобайтам.',
        'string' => ':attribute должен быть меньше или равен :value символов.',
        'array' => ':attribute не должен содержать более :value элементов.',
    ],
    'max' => [
        'numeric' => ':attribute не должен быть больше :max.',
        'file' => ':attribute не должен превышать :max килобайт.',
        'string' => ':attribute не должен превышать :max символов.',
        'array' => ':attribute не должен содержать более :max элементов.',
    ],
    'mimes' => ':attribute должен быть файлом типа :values.',
    'mimetypes' => ':attribute должен быть файлом типа :values.',
    'min' => [
        'numeric' => ':attribute должен быть как минимум :min.',
        'file' => 'Размер :attribute должен быть не менее :min килобайт.',
        'string' => ':attribute должен содержать не менее :min символов.',
        'array' => ':attribute должен иметь как минимум :min элементов.',
    ],
    'multiple_of' => ':attribute должен быть кратен :value.',
    'not_in' => 'Выбранный :attribute недействителен.',
    'not_regex' => 'Недопустимый формат :attribute.',
    'numeric' => ':attribute должен быть числом.',
    'password' => 'Пароль неверен.',
    'present' => 'Поле :attribute должно присутствовать.',
    'prohibited' => 'Поле :attribute запрещено.',
    'prohibited_if' => 'Поле :attribute запрещено, когда :other равно :value.',
    'prohibited_unless' => 'Поле :attribute запрещено, если только :other не находится в :values.',
    'prohibits' => 'Поле :attribute запрещает присутствие :other.',
    'regex' => 'Недопустимый формат :attribute.',
    'required' => 'Поле :attribute является обязательным.',
    'required_if' => 'Поле :attribute является обязательным, если :other равно :value.',
    'required_unless' => 'Поле :attribute является обязательным, если только :other не находится в :values.',
    'required_with' => 'Поле :attribute обязательно, когда присутствует :values.',
    'required_with_all' => 'Поле :attribute обязательно, когда присутствуют :values.',
    'required_without' => 'Поле :attribute является обязательным, если :values ​​отсутствует.',
    'required_without_all' => 'Поле :attribute является обязательным, если ни одно из значений :value не присутствует.',
    'same' => ':attribute и :other должны совпадать.',
    'size' => [
        'numeric' => ':attribute должен быть :size.',
        'file' => ':attribute должен быть :size килобайт.',
        'string' => ':attribute должен состоять из символов :size.',
        'array' => ':attribute должен содержать элементы :size.',
    ],
    'starts_with' => ':attribute должен начинаться с одного из следующих: :values.',
    'string' => ':attribute должен быть строкой.',
    'timezone' => ':attribute должен быть действительным часовым поясом.',
    'unique' => ':attribute  уже занят.',
    'uploaded' => 'Не удалось загрузить :attribute.',
    'url' => ':attribute должен быть допустимым URL.',
    'uuid' => ':attribute должен быть допустимым UUID.',

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
        'en' => 'Английский',
        'ar' => 'арабский',
        'description.en' => 'Описание на английском',
        'description.ar' => 'Описание на арабском',
        'email' => 'Эл. адрес',
        'password' => 'Пароль',
        'address_name' => 'Адрес',
        'user_phone' => 'Телефон',
        'supplier_name[en]' => 'наименование поставщика',
        'supplier_name[ar]' => 'наименование поставщика',
        'password_confirmation' => 'Подтверждение пароля',
        'token' => 'Токен',
        'subscription_type' => 'Тип подписки',
        'package_id' => 'Упаковка',
        'phone' => 'Телефон',
        'amount' => 'Количество',
        'current_password' => 'текущий пароль',
        'client_id' => 'Учетные данные клиента',
        'secret_id' => 'Секретные учетные данные',
        'supplier_name' => 'наименование поставщика',
        'address' => 'Адрес',
        'trade_license_image' => 'Торговая лицензия',
        'supplier_name.en' => 'наименование поставщика',
        'supplier_name.ar' => 'наименование поставщика',
        'user_name' => 'Имя пользователя',
        'terms_conditions' => 'Условия',
        'description' => 'Описание',
        'estimated_time' => 'Расчетное время',
        'verification_code' => 'Код верификации',
        'city' => 'Город',
        'Role' => 'Роль',
        'visit_fee' => 'Плата за посещение',
        'google_id' => 'Идентификатор Google',
        'expiry_date' => 'Дата истечения срока',
        'images' => 'Images',
        'date' => 'Свидание',
        'city_id' => 'City',
        'area_id' => 'Область',
        'subCategory' => 'Подкатегория',
        'my_range' => 'Мой диапазон',
        'issue_type' => 'Тип проблемы',
        'duration_type' => 'Тип продолжительности',
        'service_images' => 'Сервисные образы',
        'quoated_price' => 'Котировальная цена',
        'status' => 'Статус',
        'imageUrl' => "Изображение",
        'category_id' => "Категория",
        'category' => "Категория",
        'min_price' => "Минимальная цена",
        'max_price' => "Максимальная цена",
        'rating' => "Рейтинг",
        'duration' => "Продолжительность",
        'review' => "Обзор",
        'project_images' => "Изображения проекта",
        'image' => "Изображение",
        'user_type' => "Тип пользователя",
        'service_id' => "обслуживание",
        'user_id' => "Пользователь",
        'name.en' => 'Имя на английском языке',
        'name[en]' => 'Имя на английском языке',
        'name[ar]' => 'Имя на арабском языке',
        'latitude' => 'Широта',
        'featured_subscription' => 'Избранная подписка',
        'equipment[]' => 'Оборудование',
        'order_id' => 'Заказ',
        'name' => 'Имя',
        'equipment_model' => 'Модель оборудования',
        'price' => 'Цена',
        'make' => 'Делать',
        'longitude' => 'Долгота',
        'covered_areas' => 'Крытые площади',
        'code' => 'Код',
        'keyword' => 'ключевое слово',
        'sort' => 'Сортировать',
        'message_text' => 'Текст сообщения',
        'subject' => 'Предмет',
        'paymentID' => 'Идентификатор платежа',
        'selected_address' => 'Выбранный адрес',
        'payment_method' => 'Метод оплаты',
        'name.ar' => 'Имя на арабском языке',
        'question.en' => 'Вопрос на английском языке',
        'question.ar' => 'Вопрос на арабском языке',
        'answer.en' => 'Ответь на английском',
        'answer.ar' => 'Ответ на арабском',
        'content' => 'Содержание',
        'content.en' => "Содержание на английском языке",
        'content.ar' => "Содержание на арабском языке",
    ],

];
