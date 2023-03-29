<!DOCTYPE html>
<html lang="en" class="mt-front">

<head>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
          type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <link rel="stylesheet" href="{{ asset('assets/front/scss/main.css') }}" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/front/slick/slick.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/front/slick/slick-theme.css') }}"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('assets/front/build/css/intlTelInput.css') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css"/>
    <!-- custom font style -->
    <link rel="stylesheet" href="{{ asset('assets/front/fonts/san-francisco/san-francisco-style.css') }}"
          type="text/css">
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.css"
          integrity="sha512-Woz+DqWYJ51bpVk5Fv0yES/edIMXjj3Ynda+KWTIkGoynAMHrqTcDUQltbipuiaD5ymEo9520lyoVOo9jCQOCA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>{!! __(config('settings.company_name')) !!}</title>
    <link rel="icon" href="{!! asset('assets/front/img/favcon.png') !!}" type="image/gif">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.css"
          integrity="sha512-UzcnE2gVMx7OCuXHLNVyoElL8v2QGAOidIn6PIy0d8ciWuqMBsgpB4QfKcuj8RbHrljngft9T8remhtF992RlQ=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-213174370-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-213174370-1');
    </script>

    @stack('stylesheet-page-level')
    @stack('stylesheet-end')

</head>

<script>
    var locale = "{{ app()->getLocale() }}";
    window.Laravel = {!! json_encode([
    'csrfToken' => csrf_token(),
    'baseUrl' => url('/') . '/' . config('app.locale') . '/' /*url(config('app.locale')).'/'*/,
    'apiUrl' => url('/') . '/' . config('app.locale') . '/api/' /*url(config('app.locale')).'/'*/,
    'base' => env('APP_URL'),
    'locale' => config('app.locale'),
    'user_id' => isset($userData) ? $userData['id'] : '',
    'user_notification_setting' => isset($userData) ? $userData->settings : '',
    'user_token' => $userData['token'] ?? '',
    'websocketEndpoint' => env('PUSHER_APP_PATH'),
    'websocketPort' => env('PUSHER_APP_PORT',7010),
    'websocketKey' => env('PUSHER_APP_KEY'),
    'websocketCluster' => env('PUSHER_APP_CLUSTER'),
    'is_user' => isset($userData) ? $userData->isUser() : false,
    'is_logged_in' => isset($userData),
    'session_id' => session()->getId(),
    'image_path' =>"{{ asset('') }}",
    'translations' => cache('translations'),
    'languages' =>cache('LANGUAGES'),
]) !!};
</script>

<body class="{!! $languages[$locale]['is_rtl'] ? 'rtl' : 'ltr' !!}">

<div id="main-app">
    @if (Route::current()->getName() != 'front.404')
        @include('front.common.header')
    @endif

    @yield('content')
    {{-- <div class="modal fade feature-packages-modal order-cancel-mdl not_show" id="userData" tabindex="-1"
         role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="packages-box">
                    <div class="headline-box">
                        Select Your Area
                    </div>
                    <div class="innner-sec">
                        <form action="{{ route('front.save.userData') }}" method="post" id="userData">
                            @csrf
                            <div class="modal-desc px-1">
                                <div class="common-input">
                                    <label class="input-label">City</label>
                                    <div class="password-input-box">
                                        <select class="js-example-basic-single" required id="city_id"
                                                name="city_id">
                                            <option selected="true" disabled="disabled" value="">
                                                {{ __('Select City') }}
                                            </option>
                                            @forelse($cities as $city)
                                                <option value="{{ $city->id }}"
                                                    {{ old('city_id', session()->get('city_id')) == $city->id ? 'selected' : '' }}>
                                                    {{ translate($city->name) }}</option>
                                            @empty
                                                <option selected="true" disabled="disabled" value="">
                                                    {{ __('No City have been created') }}</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div>
                                        @error('city_id')
                                        <label id="city_id-error" class="text-danger"
                                               for="city_id">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>
                                <div class="common-input">
                                    <label class="input-label">Area</label>
                                    <div class="password-input-box">
                                        <select class="js-example-basic-single" required id="area_id"
                                                name="area_id">
                                            <option selected disabled value="">{{ __('Select Area') }}
                                            </option>
                                        </select>
                                    </div>
                                    <div>
                                        @error('area_id')
                                        <label id="area_id-error" class="text-danger"
                                               for="city_id">{{ $message }}</label>
                                        @enderror
                                    </div>
                                </div>
                                <div class="common-input">
                                    <label class="input-label">{{__('Address')}} <span
                                            class="text-danger">*</span></label>
                                    <div class="input-address-mt">
                                        <input type="text" name="address" id="address"
                                               value="{{old('address', session()->get('address'))}}"
                                               class="address" placeholder="{{ __('e.g Al-Ain') }}" readonly
                                               data-target="#register-map-model" data-toggle="modal"
                                               data-latitude="latitude"
                                               data-longitude="longitude" data-address="address" required>
                                        <button class="address-icon" data-target="#register-map-model"
                                                data-toggle="modal"
                                                data-latitude="latitude" data-longitude="longitude"
                                                data-address="address"><i
                                                class="fas fa-map-marker-alt"></i></button>
                                        <input type="hidden" name="latitude" id="latitude" class="latitude"
                                               value="{{old('address', session()->get('latitude'))}}">
                                        <input type="hidden" name="longitude" id="longitude" class="longitude"
                                               value="{{old('address', session()->get('longitude'))}}">
                                    </div>
                                    @include('front.common.alert', ['input' => 'address'])
                                </div>
                                <button id="userDataForm" class="login-btn w-100">
                                    {{__('Submit')}}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @include('front.common.map-modal')
                @if (session()->has('user_data'))
                    <button data-dismiss="modal" class="close-btn">
                        <svg id="RemoveIcon" xmlns="http://www.w3.org/2000/svg" width="32.729" height="32.729"
                             viewBox="0 0 32.729 32.729">
                            <path id="RemoveIcon-2" data-name="RemoveIcon"
                                  d="M18.321,23.321a.971.971,0,0,1-.964.964H13.5v3.857a.971.971,0,0,1-.964.964H10.607a.971.971,0,0,1-.964-.964V24.286H5.786a.971.971,0,0,1-.964-.964V21.393a.971.971,0,0,1,.964-.964H9.643V16.571a.971.971,0,0,1,.964-.964h1.929a.971.971,0,0,1,.964.964v3.857h3.857a.971.971,0,0,1,.964.964Zm4.821-.964A11.571,11.571,0,1,0,11.571,33.929,11.574,11.574,0,0,0,23.143,22.357Z"
                                  transform="translate(-7.627 8.738) rotate(-45)" fill="#022c44"/>
                        </svg>
                    </button>
                @endif
            </div>
        </div>

    </div> --}}

    @if (Route::current()->getName() != 'front.404')
        @include('front.common.footer')
    @endif

</div>

<script src="{{ asset('assets/front/js/jquery.min.js') }}"></script>
<script src="{{asset('js/app.js')}}"></script>
<script>
    function getval(sel) {
        let url = `${window.Laravel.baseUrl}save-user-data`;
       let area_id=sel.value;
       $.ajax({
            url: url, // if you say $(this) here it will refer to the ajax call not $('.company2')
            data: {
                id: area_id,
            },
            type: 'GET',
            dataType: "json",

            success: function(result) {
                location.reload();
    
            }
        });
    }
</script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="{{ asset('assets/front/slick/slick.min.js') }}"></script>
<script src="{{ asset('assets/front/js/mytech.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('assets/front/js/jquery.validate.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script src="{{ asset('assets/front/build/js/intlTelInput.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"
        integrity="sha512-kZsqvmw94Y8hyhwtWZJvDtobwQ9pLhF1DuIvcqSuracbRn6WJs1Ih+04fpH/8d1CFKysp7XA1tR0Aa2jKLTQUg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script class="iti-load-utils" async="" src="{{ asset('assets/front/build/js/utils.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"
        integrity="sha512-k2GFCTbp9rQU412BStrcD/rlwv1PYec9SNrkbQlo6RZCf75l6KcC3UwDY8H5n5hl4v77IDtIPwOk9Dqjs/mMBQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true,
        'showImageNumberLabel': true,

    })
</script>
<script>
    $(document).ready(function () {
        $(document).on('click', '#userDataForm', function (e) {
            var area_val = $('select#area_id option:selected').val();
            var city_val = $('select#city_id option:selected').val();
            if (area_val == 0 && city_val != '') {
                e.preventDefault();
                toastr.error('error', "{{ __('Please select area') }}");
                return false;
            } else {
                {{-- toastr.error('error', "{{__('Please select city')}}"); --}}
            }
        });


        // $("#userData").validate({});
        $(document).on('click', '#show_model', function () {
            $('#userData').modal({
                backdrop: 'static',
                keyboard: false,
            });
            $("#userData").modal('show');
        });
        let area_id = @json(session()->get('area_id'));
        let selected_city_id = @json(session()->get('city_id'));
        $(document).on("change", "#city_id", function (e) {
            e.preventDefault();
            var city_id = $("#city_id option:selected").val();
            $('#area_id').empty();
            let url = window.Laravel.apiUrl + 'areas/' + city_id;
            $.ajax({
                type: "GET",
                url: url,
                dataType: 'json',
                success: function (response) {
                    if (locale === 'ar') {
                        var area_data = response.data.collection.map((ar) => {
                            let area = {
                                id: ar.id,
                                text: ar.name['ar']
                            }
                            return area;
                        });
                        $("#area_id").select2({
                            placeholder: "Select Delivery Areas",
                            data: area_data
                        });
                    } else {
                        var area_data = response.data.collection.map((ar) => {
                            let area = {
                                id: ar.id,
                                text: ar.name['en']
                            }
                            return area;
                        });
                        $("#area_id").select2({
                            placeholder: "Select Delivery Areas",
                            data: area_data
                        });
                    }

                    let sess_data = @json(session()->has('user_data'));
                    if (sess_data) {
                        if (selected_city_id === city_id) {
                            setTimeout(function () {
                                $('#area_id').val(area_id).trigger('change');
                            }, 100);
                        }
                    }
                }
            });
        });

        @if (session()->has('user_data'))
        $('#city_id').trigger('change');
        @endif

        @if (request()->routeIs('front.index'))
        let sess_data = @json(session()->has('user_data'));
        if (sess_data) {
            console.log('here in if');
            let area_id = @json(session()->get('area_id'));

            let ss_data = @json(session()->get('user_data'));
            localStorage.setItem("city_id", ss_data['city_id']);
            localStorage.setItem("area_id", ss_data['area_id']);
        } else {
            $('#userData').modal({
                backdrop: 'static',
                keyboard: false
            })
            $("#userData").modal('show');
        }
        @endif
    });
</script>
<script>
    var input = document.querySelector("#phone");
    window.intlTelInput(input, {
        //   allowDropdown: false,
        autoHideDialCode: false,
        autoPlaceholder: "off",
        dropdownContainer: document.body,
        //   excludeCountries: ["us"],
        formatOnDisplay: false,
        geoIpLookup: function (callback) {
            $.get("http://ipinfo.io", function () {
            }, "jsonp").always(function (resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
            });
        },
        //   hiddenInput: "full_number",
        initialCountry: "ae",
        //   localizedCountries: { 'de': 'Deutschland' },
        nationalMode: false,
        //   onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
        //   placeholderNumberType: "MOBILE",
        preferredCountries: ['ae', 'sa'],
        separateDialCode: false,
        utilsScript: "{{ asset('assets/front/build/js/utils.js') }}",
    });
</script>
<script>
    var input = document.querySelector(".new-phone");
    window.intlTelInput(input, {
        //   allowDropdown: false,
        autoHideDialCode: false,
        autoPlaceholder: "off",
        dropdownContainer: document.body,
        //   excludeCountries: ["us"],
        formatOnDisplay: false,
        geoIpLookup: function (callback) {
            $.get("http://ipinfo.io", function () {
            }, "jsonp").always(function (resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
            });
        },
        //   hiddenInput: "full_number",
        initialCountry: "ae",
        //   localizedCountries: { 'de': 'Deutschland' },
        nationalMode: false,
        //   onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
        //   placeholderNumberType: "MOBILE",
        preferredCountries: ['ae', 'sa'],
        separateDialCode: false,
        utilsScript: "{{ asset('assets/front/build/js/utils.js') }}",
    });
</script>
<script>
    var input = document.querySelector("#supplier-phone");
    window.intlTelInput(input, {
        //   allowDropdown: false,
        autoHideDialCode: false,
        autoPlaceholder: "off",
        dropdownContainer: document.body,
        //   excludeCountries: ["us"],
        formatOnDisplay: false,
        geoIpLookup: function (callback) {
            $.get("http://ipinfo.io", function () {
            }, "jsonp").always(function (resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
            });
        },
        //   hiddenInput: "full_number",
        initialCountry: "ae",
        //   localizedCountries: { 'de': 'Deutschland' },
        nationalMode: false,
        //   onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
        //   placeholderNumberType: "MOBILE",
        preferredCountries: ['ae', 'sa'],
        separateDialCode: false,
        utilsScript: "{{ asset('assets/front/build/js/utils.js') }}",
    });
</script>
<script>
    jQuery.extend(jQuery.validator.messages, {
        required: "{{ __('This field is required.') }}",
        email: "{{ __('Please enter a valid email address.') }}",
        url: "{{ __('Please enter a valid URL.') }}",
        date: "{{ __('Please enter a valid date.') }}",
        number: "{{ __('Please enter a valid number.') }}",
        digits: "{{ __('Please enter only digits.') }}",
        tel: "{{ __('Please enter only digits.') }}",
        equalTo: "{{ __('Please enter the same value again.') }}",
        accept: "{{ __('Please enter a value with a valid extension.') }}",
        maxlength: jQuery.validator.format(
            "{{ __('Please enter no more than') }} {0} {{ __('characters.') }}"),
        minlength: jQuery.validator.format(
            "{{ __('Please enter at least') }} {0} {{ __('characters.') }}"),
        max: jQuery.validator.format("{{ __('Please enter a value less than or equal to {0}.') }}"),
        min: jQuery.validator.format("{{ __('Please enter a value greater than or equal to {0}.') }}")
    });

    jQuery.validator.addMethod("tel", function (value, element) {
        return this.optional(element) || /^(?:\+)[0-9]/.test(value);
    }, "{{ __('Please enter international number starting with + sign.') }}")


    jQuery.validator.methods.email = function (value, element) {
        return this.optional(element) || /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/i.test(
            value);
    }

    jQuery.validator.setDefaults({
        errorPlacement: function (error, element) {
            error.insertAfter(element.parent());
        }
    });

    setTimeout(fade_out, 1000);

    function fade_out() {
        $(".pre-loader-common").fadeOut().empty();
    }
</script>

<script>
    var locale = "{{ app()->getLocale() }}";
    var currency = "{{ $currency }}";
    var isEnableRtl = "{{ $locale }}" == 'en' ? false : true;

    $(document).ready(function () {
        toastr.options = {
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut",
            "rtl": isEnableRtl,
            "closeButton": false
        }
        if ("{!! session()->has('status') !!}") {
            toastr.success('{{ __('success') }}', "{!! session()->get('status') !!}")

        }
        if ("{!! session()->has('err') !!}") {

            toastr.error('{{ __('alert') }}', "{!! session()->get('err') !!}")

        }
    });

</script>
<script>
    function imageUrl(path, width, height, quality, crop) {
        if (typeof (width) === 'undefined')
            width = null;
        if (typeof (height) === 'undefined')
            height = null;
        if (typeof (quality) === 'undefined')
            quality = null;
        if (typeof (crop) === 'undefined')
            crop = null;

        var basePath = window.Laravel.base;
        var url = null;
        if (!width && !height) {
            url = path;
        } else {
            // url = basePath + '/images/timthumb.php?src=' +basePath+ path; // IMAGE_LOCAL_PATH
            url = basePath + '/images/timthumb.php?src=' + path; // IMAGE_LIVE_PATH
            if (width !== null) {
                url += '&w=' + width;
            }
            if (height !== null && height > 0) {
                url += '&h=' + height;
            }
            if (crop !== null) {
                url += "&zc=" + crop;
            } else {
                url += "&zc=1";
            }
            if (quality !== null) {
                url += '&q=' + quality + '&s=1';
            } else {
                url += '&q=95&s=1';
            }
        }
        return url;
    }
// add class
$(document).ready(function(){

// jQuery methods go here...
$(".location-select").click(function(){
    $(".select2-dropdown--below").addClass("input-set");
 
});
});


</script>

@stack('scripts')

</body>

</html>
