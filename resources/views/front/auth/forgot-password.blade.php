@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')

    <main class="login-sec spacing-y">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="login-text">
                        <div class="title">{{ __('Forgot Password') }}</div>
                        <div class="title-des">{{ __('Enter your email address to recover password') }}</div>
                    </div>
                    <form id="forgotForm" method="post" action="{!! route('front.auth.forgot-password.submit') !!}">
                        @csrf
                        <div class="common-input">
                            <label class="input-label">{{ __('Email') }} </label>
                            <input type="email" name="email" placeholder="{{ __('e.g') }} {{__('johndoe@example.com')}}" required>
                        </div>
                        <button class="login-btn w-100">{{ __('Submit') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </main>



@endsection

@push('scripts')
    <script>
        $('#forgotForm').validate();
    </script>
@endpush
