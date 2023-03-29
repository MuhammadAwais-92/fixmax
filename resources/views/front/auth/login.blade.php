@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')

    <main class="login-sec spacing-y">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="login-text">
                        <div class="title">{{ __('Welcome Back!') }}</div>
                        <div class="title-des">{{ __('Please login to your account') }}</div>
                    </div>

                    <form id="loginForm" method="post" action="{!! route('front.auth.login.submit') !!}">
                        @csrf
                        <div class="common-input">
                            <label class="input-label">{{ __('Email') }} <span class="text-danger">*</span></label>
                            <input type="text" name="email" placeholder="{{__('e.g')}} {{__('johndoe@example.com')}}" autocomplete="off"
                                   required>
                            @include('front.common.alert', ['input' => 'email'])
                        </div>
                        <div class="common-input">
                            <label class="input-label">{{ __('Password') }} <span class="text-danger">*</span></label>
                            <div class="password-input-box">
                                <input type="password" name="password" class="password-input pass"
                                       placeholder="&#9728;&#9728;&#9728;&#9728;&#9728;&#9728;" required>
                                <i class="fa fa-eye-slash view-password"></i>
                            </div>
                        </div>

                        <button class="login-btn w-100">{{ __('Login') }}</button>
                    </form>
                    <div class="float-right">
                        <a href="{{ route('front.auth.forgot-password') }}"
                           class="forgot-password">{{ __('Forgot your password?') }}</a>
                    </div>

                    <div class="line-or">
                        <span></span>
                        <p class="ortext">{{ __('OR') }}</p>
                    </div>
                    <a href="{{ route('front.auth.registration') }}" class="login-btn w-100">{{ __('Register') }}</a>
                    <a href="{!! route('front.auth.login.social', 'facebook') !!}" class="login-btn facebook-btn w-100"><i
                            class="fab  fa-facebook-f"></i>{{ __('Continue with Facebook') }}</a>
                    <a href="{!! route('front.auth.login.social', 'google') !!}" class="login-btn google-btn w-100"><i
                            class="fab   fa-google "></i>{{ __('Continue with Google') }}</a>
                </div>
            </div>
        </div>
    </main>


    @include('front.common.map-modal')
@endsection

@push('scripts')
    <script>
        $("#loginForm").validate({
            ignore: '',
            errorPlacement: function (error, element) {
                if (element.attr("name") == "password") {
                    $(".help-block").hide();
                    error.insertAfter(element.parent());

                } else {
                    error.insertAfter(element);
                }

            },

        });
        $('.view-password').on('click', function () {
            let input = $(this).parent().find(".pass");
            input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
            let inputShow = $(this).parent().find(".view-password");
            inputShow.attr('class', input.attr('type') === 'password' ? 'fa fa-eye-slash view-password' :
                'fa fa-eye view-password');
        });
    </script>
@endpush
