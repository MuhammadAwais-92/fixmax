@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')


    <main class="login-sec spacing-y">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="login-text">
                        <div class="title">{{ __('Reset Password') }}</div>
                        <div class="title-des">{{ __('Please enter code sent at') }} <span>{{ $email }}</span>
                            {{ __('and choose a password') }}</div>
                    </div>
                    <form id="resetForm" method="post" action="{!! route('front.auth.password.reset.submit') !!}">
                        @csrf
                        <div class="common-input">
                            <label class="input-label">{{ __('Code') }}</label>
                            <input type="text" name="verification_code" placeholder="1234" required>
                            @include('front.common.alert', ['input' => 'verification_code'])
                        </div>
                        <input type="email" hidden required name="email" value="{{ $email }}"
                               placeholder="{{ __('e.g johndoe@example.com') }}">
                        <div class="common-input">
                            <label class="input-label">{{ __('New Password') }}</label>
                            <div class="password-input-box">
                                <input type="password" class="password-input pass" name="password" minlength="6"
                                       maxlength="32" id="pw"
                                       placeholder="&#9728;&#9728;&#9728;&#9728;&#9728;&#9728;" required>
                                <i class="fa fa-eye-slash view-password"></i>
                            </div>
                            @include('front.common.alert', ['input' => 'password'])
                        </div>
                        <div class="common-input">
                            <label class="input-label">{{ __('Confirm New Password') }}</label>
                            <div class="password-input-box">
                                <input type="password" class="password-input pass" name="password_confirmation"
                                       maxlength="32" equalTo="#pw" id="pwc"
                                       placeholder="&#9728;&#9728;&#9728;&#9728;&#9728;&#9728;">
                                <i class="fa fa-eye-slash view-password"></i>
                            </div>
                        </div>
                        <button class="login-btn w-100">{{ __('Submit') }}</button>
                    </form>
                    <div class="float-right">
                        <p class="forgot-password">{{ __("Didn't receive the code?") }}
                            <button
                                class="resend-b verify-btn-resend">{{ __('Resend') }}</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>


@endsection

@push('scripts')
    <script>
        $('#resetForm').validate();
        $.validator.messages.equalTo = function (param, input) {
            return '{{ __('The password confirmation does not match.') }}';
        }
        $(document).ready(function () {
            $('.verify-btn-resend').on('click', function () {
                let email = "{!! session()->get('email') !!}"
                $.ajax({
                    url: window.Laravel.baseUrl + "forgot-password-resend",
                    type: 'post',
                    data: {
                        'email': email,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (res) {
                        toastr.success('{{ __('Code send successfully') }}');
                    }
                })
            })

            $('.view-password').on('click', function () {
                let input = $(this).parent().find(".pass");
                input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
                let inputShow = $(this).parent().find(".view-password");
                inputShow.attr('class', input.attr('type') === 'password' ?
                    'fa fa-eye-slash view-password' : 'fa fa-eye view-password');
            });
        })
    </script>
@endpush
