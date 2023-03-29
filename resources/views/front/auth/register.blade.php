@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <main class="login-sec spacing-y">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="login-text">
                        <div class="title">{{__('Register')}}</div>
                        <div class="title-des">{{__('Fill the form below to proceed forward')}}</div>
                    </div>

                    <div class="common-input">
                        <input type="hidden" id='user_type' name='type_user' value="{{ old('user_type') }}">
                        <label class="input-label">{{__('Choose Role')}}</label>
                        <div class="select-role-mt">
                            <div class="role-checkbox d-flex align-items-center justify-content-between">
                                <p>{{__('User')}}</p>
                                <div class="role-radio">
                                    <label class="custom-radio">
                                        <input class="user" value="" type="radio" checked="checked" name="Role">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="role-checkbox d-flex align-items-center justify-content-between">
                                <p>{{__('Supplier')}}</p>
                                <div class="role-radio">
                                    <label class="custom-radio">
                                        <input class="supplier" type="radio" name="Role">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="user">
                        <form action="{{ route('front.auth.register.submit') }}" id="registerForm" method="post">
                            @csrf
                            <div id="user">
                                <input hidden type="text" name="user_type" value="{{ old('user_type', 'user') }}">
                                @if (request()->get('platform') == 'google')
                                    <input type="hidden" name="google_id" value="{{ request()->get('id') }}">
                                @elseif(request()->get('platform') == 'facebook')
                                    <input type="hidden" name="facebook_id" value="{{ request()->get('id') }}">
                                @endif

                                <div class="common-input">
                                    <label class="input-label">{{__('Full Name')}} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="user_name"
                                           value="{{ old('user_name', request()->get('user_name')) }}"
                                           placeholder="{{ __('John Doe') }}" required>
                                    @include('front.common.alert', ['input' => 'user_name'])
                                </div>
                                <div class="common-input">
                                    <label class="input-label">{{__('Email')}} <span
                                            class="text-danger">*</span></label>
                                    <input type="email" name="email" value="{{ old('email', request()->get('email')) }}"
                                           placeholder="{{ __('example@mail.com') }}" required>
                                    @include('front.common.alert', ['input' => 'email'])
                                </div>

                                <div class="common-input">
                                    <label class="input-label">{{__('Phone Number')}} <span class="text-danger">*</span></label>
                                    <div class="d-flex phone-number-input">
                                        <input name="phone" id="phone" value="{{ old('phone') }}" type="tel"
                                               autocomplete="off" data-intl-tel-input-id="0" minlength="11"
                                               maxlength="14"
                                               required>
                                        @include('front.common.alert', ['input' => 'phone'])
                                    </div>
                                    <div class="phone_number"></div>
                                </div>
                                <div class="common-input">
                                    <label class="input-label">{{__('Address')}} <span
                                            class="text-danger">*</span></label>
                                    <div class="input-address-mt">
                                        <input type="text" name="address" id="address" value="{{ old('address') }}"
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
                                               value="{{ old('latitude') }}">
                                        <input type="hidden" name="longitude" id="longitude" class="longitude"
                                               value="{{ old('longitude') }}">
                                    </div>
                                    @include('front.common.alert', ['input' => 'address'])
                                    @include('front.common.alert', ['input' => 'latitude'])
                                </div>

                                <div class="common-input">
                                    <label class="input-label">{{__('Password')}} <span
                                            class="text-danger">*</span></label>
                                    <div class="password-input-box">
                                        <input type="password" minlength="6" id="pw_user" name="password"
                                               class="password-input pass"
                                               placeholder="&#9728;&#9728;&#9728;&#9728;&#9728;&#9728;">
                                        <i class="fa fa-eye-slash view-password"></i>
                                    </div>
                                    @include('front.common.alert', ['input' => 'password'])
                                </div>
                                <div class="common-input">
                                    <label class="input-label">{{__('Confirm Password')}} <span
                                            class="text-danger">*</span></label>
                                    <div class="password-input-box">
                                        <input type="password" minlength="6" equalTo="#pw_user" id="pc_user"
                                               name="password_confirmation"
                                               class="password-input pass"
                                               placeholder="&#9728;&#9728;&#9728;&#9728;&#9728;&#9728;">
                                        <i class="fa fa-eye-slash view-password"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="remember-me">
                                <label class="custom-check">
                                    <input type="checkbox" checked="checked" name="terms_conditions" required>
                                    <span class="checkmark rounded"></span>
                                </label>
                                <div class="prvc">{{__('By Signing up, i agree to')}} <a target="_blank"
                                                                                         href="{{ route('front.pages', [config('settings.terms_and_conditions')]) }}">{{__('Term & Conditions')}} </a> {{__('and')}}
                                    <a target="_blank"
                                       href="{{ route('front.pages', [config('settings.privacy_policy')]) }}">{{__('Privacy Policy')}}</a>.
                                </div>
                            </div>
                            <button class="login-btn w-100">{{__('Register')}}</button>
                        </form>

                    </div>

                    <div id="supplier">
                        <form action="{{ route('front.auth.register.submit') }}" id="supplierRegisterForm"
                              method="post">
                            @csrf
                            <input hidden type="text" id="user_type_supplier" name="user_type"
                                   value="{{ old('user_type', 'supplier') }}">
                            <input hidden type="text" name="is_id_card_verified"
                                   value="{{ old('is_id_card_verified', null) }}">

                            @if (request()->get('platform') == 'google')
                                <input type="hidden" name="google_id" value="{{ request()->get('id') }}">
                            @elseif(request()->get('platform') == 'facebook')
                                <input type="hidden" name="facebook_id" value="{{ request()->get('id') }}">
                            @endif

                            <div class="common-input">
                                <label class="input-label">{{__('Category')}} <span class="text-danger">*</span></label>
                                <select class="js-example-basic-single" name="category" required>
                                    <option value="" readonly="" selected>{{__('Select Category')}}</option>
                                    @forelse($categories as $category)
                                        <option value="{{ $category->id }}"
                                                @if (old('category') == $category->id) selected @endif>
                                            {{ translate($category->name) }}</option>
                                    @empty
                                        <option value="" disabled selected>{{ __('Select category') }}</option>
                                    @endforelse
                                </select>
                                <div id="catId"></div>
                                @include('front.common.alert', ['input' => 'category'])

                            </div>
                            @if(request()->get('user_name'))
                                <div class="common-input">
                                    <label class="input-label">{{__('Company Name')}} <span class="text-danger">*</span></label>
                                    <input type="text" name="supplier_name[en]"
                                           value="{{ old('supplier_name.en',request()->get('user_name')) }}"
                                           placeholder="{{ __('John Doe') }}" required>
                                    <input type="text" hidden name="supplier_name[ar]" value=""
                                           placeholder="{{ __('John Doe') }}" required>
                                    @include('front.common.alert', ['input' => 'supplier_name.en'])
                                </div>
                            @else
                                <div class="common-input">
                                    <label class="input-label">{{__('Company Name')}} <span class="text-danger">*</span></label>
                                    <input type="text" name="supplier_name[en]" value="{{ old('supplier_name.en') }}"
                                           placeholder="{{ __('John Doe') }}" required>
                                    <input type="text" hidden name="supplier_name[ar]" value=""
                                           placeholder="{{ __('John Doe') }}" required>
                                    @include('front.common.alert', ['input' => 'supplier_name.en'])
                                </div>
                            @endif
                            <div class="common-input">
                                <label class="input-label">{{__('Email')}} <span class="text-danger">*</span></label>
                                <input type="email" name="email" value="{{ old('email', request()->get('email')) }}"
                                       placeholder="{{ __('example@mail.com') }}" required>
                                @include('front.common.alert', ['input' => 'email'])
                            </div>
                            <div class="common-input">
                                <label class="input-label">{{__('Phone Number')}} <span
                                        class="text-danger">*</span></label>
                                <div class="d-flex phone-number-input">
                                    <input name="phone" id="supplier-phone" value="{{ old('phone') }}" type="tel"
                                           autocomplete="off" data-intl-tel-input-id="0" minlength="11" maxlength="14"
                                           required>
                                    @include('front.common.alert', ['input' => 'phone'])
                                </div>
                                <div class="phone_number"></div>
                            </div>

                            <div class="common-input">
                                <label class="input-label">{{__('Password')}} <span class="text-danger">*</span></label>
                                <div class="password-input-box">
                                    <input type="password" minlength="6" id="pw" name="password"
                                           class="password-input pass"
                                           placeholder="&#9728;&#9728;&#9728;&#9728;&#9728;&#9728;">
                                    <i class="fa fa-eye-slash view-password"></i>
                                </div>
                                @include('front.common.alert', ['input' => 'password'])
                            </div>
                            <div class="common-input">
                                <label class="input-label">{{__('Confirm Password')}} <span class="text-danger">*</span></label>
                                <div class="password-input-box">
                                    <input type="password" minlength="6" equalTo="#pw" id="pc"
                                           name="password_confirmation"
                                           class="password-input pass"
                                           placeholder="&#9728;&#9728;&#9728;&#9728;&#9728;&#9728;">
                                    <i class="fa fa-eye-slash view-password"></i>
                                </div>
                            </div>
                            <div class="common-input">
                                <label class="input-label">{{__('Address')}} <span class="text-danger">*</span></label>
                                <div class="input-address-mt">
                                    <input type="text" name="address" id="address" value="{{ old('address') }}"
                                           class="address" placeholder="{{ __('e.g Al-Ain') }}" readonly
                                           data-target="#register-map-model" data-toggle="modal"
                                           data-latitude="latitude"
                                           data-longitude="longitude" data-address="address" required>
                                    <button class="address-icon" data-target="#register-map-model" data-toggle="modal"
                                            data-latitude="latitude" data-longitude="longitude" data-address="address">
                                        <i
                                            class="fas fa-map-marker-alt"></i></button>
                                    <input type="hidden" name="latitude" id="latitude" class="latitude"
                                           value="{{ old('latitude') }}">
                                    <input type="hidden" name="longitude" id="longitude" class="longitude"
                                           value="{{ old('longitude') }}">
                                </div>
                                @include('front.common.alert', ['input' => 'address'])
                                @include('front.common.alert', ['input' => 'latitude'])
                            </div>
                            <div class="common-input">
                                <label class="input-label">{{__('Select City')}} <span
                                        class="text-danger">*</span></label>
                                <select class="js-example-basic-single" name="city" required>
                                    <option value="">{{__('e.g Ajman')}}</option>
                                    @forelse($cities as $city)
                                        <option value="{{ $city->id }}"
                                                @if (old('city') == $city->id) selected @endif>
                                            {{ translate($city->name) }}
                                        </option>
                                    @empty
                                        <option value="" disabled selected>{{ __('Select city') }}</option>
                                    @endforelse

                                </select>
                                <div id="city"></div>
                                @include('front.common.alert', ['input' => 'city'])

                            </div>

                            <div class="common-input mb-1">
                                {{-- <label class="input-label">Attach Your Display Picture</label> --}}
                                @include('front.common.image-upload', [
                                    'imageTitle' => __('Attach Your Display Picture'),
                                    'inputName' => 'image',
                                    'isRequired' => 1,
                                    'recommend_size' => '100 x 100',
                                    'allowVideo' => 0,
                                    'imageNumber' => 1,
                                    'allowDelete' => 1,
                                    'displayImageSrc' => old('image') ? imageUrl(old('image'), 100, 100, 95, 1) : '',
                                    'value' => old('image', ''),
                                ])
                                <div id="img"></div>

                            </div>
                            <div class="common-input mb-1">
                                {{-- <label class="input-label">Attach Your Trade License</label> --}}
                                @include('front.common.image-upload', [
                                    'imageTitle' => __('Attach Your Trade License'),
                                    'inputName' => 'trade_license_image',
                                    'recommend_size' => '113 x 85',
                                    'isRequired' => 1,
                                    'allowVideo' => 0,
                                    'imageNumber' => 2,
                                    'allowDelete' => 1,
                                    'displayImageSrc' => old('trade_license_image')
                                        ? imageUrl(old('trade_license_image'), 113, 85, 95, 1)
                                        : '',
                                    'value' => old('trade_license_image', ''),
                                ])
                                <div id="tl_img"></div>
                            </div>


                            <div class="remember-me">
                                <label class="custom-check">
                                    <input type="checkbox" checked="checked" name="terms_conditions" required>
                                    <span class="checkmark rounded"></span>
                                </label>
                                <div class="prvc">{{_('By Signing up, i agree to')}} <a target="_blank"
                                                                                        href="{{route('front.pages',[config('settings.terms_and_conditions')])}}">{{__('Term & Conditions')}} </a>
                                    {{__('and')}}
                                    <a target="_blank"
                                       href="{{route('front.pages',[config('settings.privacy_policy')])}}">{{__('Privacy Policy')}}</a>.
                                </div>
                            </div>
                            <button class="login-btn w-100">{{__('Register')}}</button>
                        </form>
                    </div>
                    <div class="forgot-password float-right">
                        {{__('Already have an account?')}}'
                        <a href="{{ route('front.auth.login') }}"
                           class="forgot-password register-p">{{__('Login Here')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('front.common.map-modal')
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {

            if ($(`#user_type`).val() == 'supplier') {
                $("#user").hide();
                $("#supplier").show();
                $(`.supplier`).attr('checked', 'checked');


            } else if ($(`#user_type`).val() == 'user') {
                $("#supplier").hide();
                $("#user").show();
                $(`.user`).attr('checked', 'checked');
            } else {


                $("#supplier").hide();

                $(".supplier").click(function () {

                    $("#user").hide();
                    $("#supplier").show();


                });

                $(".user").click(function () {
                    $("#supplier").hide();
                    $("#user").show();
                });
            }
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#registerForm').validate({
                ignore: '',
                rules: {
                    'email': {
                        required: true,
                        email: true,
                    },
                    'phone': {
                        required: true,
                        tel: true,
                    }
                },
                errorPlacement: function (error, element) {
                    // console.log(element.attr('name'));
                    if (element.attr("name") == "terms_conditions") {
                        error.insertAfter(element.parent().siblings());
                    } else if (element.attr("name") === "phone") {
                        $(".phone_number").html(error);
                    } else {
                        error.insertAfter(element);
                    }
                },
            });

            $.validator.messages.equalTo = function (param, input) {
                return '{{ __('The password confirmation does not match.') }}';
            }
        });
    </script>
    <script>
        $(document).ready(function () {

            $('#supplierRegisterForm').validate({
                ignore: '',
                rules: {
                    'email': {
                        required: true,
                        email: true,
                    },
                    'supplier_name[en]': {
                        required: true,
                    },
                    'supplier_name[ar]': {
                        required: false,
                    },
                    'category': {
                        required: true,
                    },
                    'city': {
                        required: true,
                    },
                    'phone': {
                        required: true,
                        tel: true,
                    }
                },

                errorPlacement: function (error, element) {
                    console.log(element.attr("name"));
                    if (element.attr("name") == "terms_conditions") {
                        error.insertAfter(element.parent().siblings());

                    } else if (element.attr("name") === "category") {
                        $("#catId").html(error);
                    } else if (element.attr("name") === "phone") {
                        $(".phone_number").html(error);
                    } else if (element.attr("name") === "city") {
                        $("#city").html(error);
                    } else if (element.attr("name") === "image") {
                        $("#img").html(error);
                    } else if (element.attr("name") === "trade_license_image") {
                        $("#tl_img").html(error);
                    } else {
                        error.insertAfter(element);
                    }
                },

            });
            $.validator.messages.equalTo = function (param, input) {
                return '{{ __('The password confirmation does not match.') }}';
            }


        });
    </script>
    <script>

    </script>
    <script>
        $('.view-password').on('click', function () {
            let input = $(this).parent().find(".pass");
            input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
            let inputShow = $(this).parent().find(".view-password");
            inputShow.attr('class', input.attr('type') === 'password' ? 'fa fa-eye-slash view-password' :
                'fa fa-eye view-password');
        });
    </script>
    <script>
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function () {
            $('.js-example-basic-single').select2();
        });
    </script>
@endpush
