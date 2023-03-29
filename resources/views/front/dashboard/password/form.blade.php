@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <main class="change-password spacing-y">
        <div class="container">
            <div class="row">
                @include('front.dashboard.common.left-sidebar')
                <div class="col-xl-9 col-lg-8 col-md-6">
                    <div class="change-password-box">
                        <form id="changePasswordForm" method="post"
                              action="{!! route('front.dashboard.update.password') !!}">
                            @csrf
                            <div class="common-input">
                                <label class="input-label">{{__('Current Password')}}</label>
                                <div class="password-input-box">
                                    <input type="password" name="current_password" minlength="6"
                                           class="password-input pass" placeholder="☀☀☀☀☀☀" required>
                                    <i class="fa fa-eye-slash view-password"></i>
                                </div>
                                @include('front.common.alert', ['input' => 'current_password'])
                            </div>
                            <div class="common-input">
                                <label class="input-label">{{__('New Password')}}</label>
                                <div class="password-input-box">
                                    <input type="password" name="password" minlength="6" id="pw"
                                           class="password-input pass" placeholder="☀☀☀☀☀☀" required>
                                    <i class="fa fa-eye-slash view-password"></i>
                                </div>
                                @include('front.common.alert', ['input' => 'password'])

                            </div>
                            <div class="common-input">
                                <label class="input-label">{{__('Confirm New Password')}}</label>
                                <div class="password-input-box">
                                    <input type="password" name="password_confirmation" minlength="6" equalTo="#pw"
                                           class="password-input pass" placeholder="☀☀☀☀☀☀" required>
                                    <i class="fa fa-eye-slash view-password"></i>
                                </div>

                            </div>
                            <div class="d-flex flex-wrap">
                                <div class="w-50 pr-05">
                                    <a href="{{route('front.dashboard.index')}}"
                                       class="secondary-btn border-btn mw-100">
                                        {{__('Cancel')}}
                                    </a>
                                </div>
                                <div class="w-50 pl-05">
                                    <button class="secondary-btn mw-100">
                                        {{__('Update')}}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        $('#changePasswordForm').validate();
        $.validator.messages.equalTo = function (param, input) {
            return '{{ __('The password confirmation does not match.') }}';
        }

        $('.view-password').on('click', function () {
            let input = $(this).parent().find(".pass");
            input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
            let inputShow = $(this).parent().find(".view-password");
            inputShow.attr('class', input.attr('type') === 'password' ? 'fa fa-eye-slash view-password' : 'fa fa-eye view-password');
        });
    </script>
@endpush
