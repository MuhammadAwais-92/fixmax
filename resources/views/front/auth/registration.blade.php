@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <section class="login-sec">
        <div class="login-inner">
            <div class="custom-container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="login-form mx-auto">
                            <div class="custom-heading-all-us">
                                <p class="ps-heading mx-auto">{{__('Registration')}}
                                </p>
                            </div>
                            <form action="">
                                <div class="login-form-inner">
                                    <div class="form-btn-sec">
                                        <a href="{{route('front.auth.register.form', ['type'=>'user','platform' => request()->platform, 'id' => request()->id, 'email' => request()->email, 'full_name' => request()->full_name])}}"
                                           class="btn btn-secondary w-100 auth-btn-sec mb-2">{{__('User')}}</a>
                                        <a href="{{route('front.auth.register.form', ['type'=>'supplier','platform' => request()->platform, 'id' => request()->id, 'email' => request()->email, 'full_name' => request()->full_name])}}"
                                           class="btn btn-primary w-100 auth-btn-dark">{{__('Stadium Owner')}}</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection


