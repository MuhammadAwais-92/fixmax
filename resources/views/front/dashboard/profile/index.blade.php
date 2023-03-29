@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <main class="supplier-profile spacing-y">
        <div class="container">
            <div class="row">
                @include('front.dashboard.common.left-sidebar')
                <div class="col-xl-9 col-lg-8">
                    <div class="supplier-profile-content">
                        <div class="d-flex justify-content-end mb-3">
                            <a href="{{ route('front.dashboard.edit.profile') }}" class="secondary-btn btn-17">
                                {{ __('Edit profile') }}
                            </a>
                        </div>
                        @if ($user->isUser())
                            <div class="sup-profile-box">
                                <div class="per-info-block d-flex flex-wrap justify-content-between align-items-center">
                                    <div class="title-rating-block">
                                        <h3 class="head-title">
                                            {{ __('Personal Info') }}
                                        </h3>
                                    </div>
                                    <button class="chose-img-btn mx-25">
                                        <img src="{{ imageUrl($user->image_url, 100, 100, 100, 1) }}"
                                             alt="sup-profile-img" class="img-fluid sup-profile-img">
                                        <span class="cam-icon">
                                            <i class="fas fa-camera"></i>
                                        </span>
                                    </button>
                                </div>
                                <div class="sup-title-value-row d-flex">
                                    <div class="sup-title">
                                        {{ __('Name') }}
                                    </div>
                                    <div class="sup-vlaue">
                                        <p>{{ $user->user_name }}</p>
                                    </div>
                                </div>
                                <div class="sup-title-value-row d-flex">
                                    <div class="sup-title">
                                        {{__('Email Address')}}
                                    </div>
                                    <div class="sup-vlaue">
                                        <a href="mailto: {{ $user->email }}">
                                            {{ $user->email }}
                                        </a>
                                    </div>
                                </div>
                                <div class="sup-title-value-row d-flex">
                                    <div class="sup-title">
                                        {{ __('Phone No') }}
                                    </div>
                                    <div class="sup-vlaue">
                                        <a dir="ltr" href="tel:{{ $user->phone }}">
                                            {{ $user->phone }}
                                        </a>
                                    </div>
                                </div>
                                <div class="sup-title-value-row d-flex">
                                    <div class="sup-title">
                                        {{ __('Address') }}
                                    </div>
                                    <div class="sup-vlaue">
                                        <a target="_blank"
                                           href="https://www.google.com/maps/dir//{!! @$user->latitude !!},{!! @$user->longitude !!}/@ {!! @$user->latitude !!},{!! @$user->longitude !!},12z">{{ $user->address }}</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($user->isSupplier())
                            <div class="sup-profile-box">
                                <div class="per-info-block d-flex flex-wrap justify-content-between align-items-center">
                                    <div class="title-rating-block">
                                        <div class="d-flex">
                                            <div class="star-rating-area">
                                                <div class="rating-static clearfix"
                                                     rel="{{ round(getStarRating($user->rating), 1) }}">
                                                    <label class="full" title="{{__('Awesome - 5 stars')}}"></label>
                                                    <label class="half"
                                                           title="{{__('Pretty good - 4.5 stars')}}"></label>
                                                    <label class="full" title="{{__('Pretty good - 4 stars')}}"></label>
                                                    <label class="half" title="{{__('Meh - 3.5 stars')}}"></label>
                                                    <label class="full" title="{{__('Meh - 3 stars')}}"></label>
                                                    <label class="half" title="{{__('Kinda bad - 2.5 stars')}}"></label>
                                                    <label class="full" title="{{__('Kinda bad - 2 stars')}}"></label>
                                                    <label class="half" title="{{__('Meh - 1.5 stars')}}"></label>
                                                    <label class="full"
                                                           title="{{__('Sucks big time - 1 star')}}"></label>
                                                    <label class="half"
                                                           title="{{__('Sucks big time - 0.5 stars')}}"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <h3 class="head-title">
                                            {{ __('Personal Info') }}
                                        </h3>
                                    </div>
                                    <button class="chose-img-btn mx-25">
                                        <img src="{{ imageUrl($user->image_url, 100, 100, 100, 1) }}"
                                             alt="sup-profile-img" class="img-fluid sup-profile-img">
                                        <span class="cam-icon">
                                            <i class="fas fa-camera"></i>
                                        </span>
                                    </button>
                                </div>
                                <div class="sup-title-value-row d-flex">
                                    <div class="sup-title">
                                        {{ __('Name') }}
                                    </div>
                                    <div class="sup-vlaue">
                                        <p>{{ translate($user->supplier_name) }}</p>
                                    </div>
                                </div>
                                <div class="sup-title-value-row d-flex">
                                    <div class="sup-title">
                                        {{ __('Address') }}
                                    </div>
                                    <div class="sup-vlaue">
                                        <a target="_blank"
                                           href="https://www.google.com/maps/dir//{!! @$user->latitude !!},{!! @$user->longitude !!}/@ {!! @$user->latitude !!},{!! @$user->longitude !!},12z">{{ $user->address }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="sup-profile-box">
                                <div class="sup-title-value-row pt-0">
                                    <h3 class="head-title">
                                        {{ __('Contact Info') }}
                                    </h3>
                                </div>
                                <div class="sup-title-value-row d-flex">
                                    <div class="sup-title">
                                        {{ __('Email Address') }}
                                    </div>
                                    <div class="sup-vlaue">
                                        <a href="mailto: {{ $user->email }}">
                                            {{ $user->email }}
                                        </a>
                                    </div>
                                </div>
                                <div class="sup-title-value-row d-flex">
                                    <div class="sup-title">
                                        {{__('Phone No') }}
                                    </div>
                                    <div class="sup-vlaue">
                                        <a dir="ltr" href="tel:{{ $user->phone }}">
                                            {{ $user->phone }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="sup-profile-box">
                                <div class="sup-title-value-row pt-0">
                                    <h3 class="head-title">
                                        {{ __('Service Area') }}
                                    </h3>
                                </div>
                                <div class="sup-title-value-row d-flex">
                                    <div class="sup-title">
                                        {{ translate($user->city->name) }}
                                    </div>
                                    <div class="sup-vlaue">
                                        <div class="areas">
                                            @foreach ($coveredAreas as $area)
                                                @if ($area->area)
                                                    <p class="d-flex">
                                                        <span
                                                            class="font-light">{{ translate($area->area->name) }}</span><span
                                                            class="mx-05">-</span><span>{{ $area->estimated_time }}mins</span>
                                                    </p>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="sup-title-value-row d-flex">
                                    <div class="sup-title">
                                        {{ __('Visit Fee') }}
                                    </div>
                                    <div class="sup-vlaue">
                                        {{ $user->visit_fee }} {{ __('AED') }}
                                    </div>
                                </div>
                            </div>
                            <div class="sup-profile-box">
                                <div class="sup-title-value-row pt-0">
                                    <h3 class="head-title">
                                        {{ __('Document') }}
                                    </h3>
                                </div>
                                <div class="sup-title-value-row d-flex">
                                    <div class="sup-title">
                                        {{ __('Trade License') }}
                                    </div>
                                    <div class="sup-vlaue">
                                        <div class="trade-img-box">
                                            <a href="{!! url($user->trade_license_image_url)!!}"
                                               data-lightbox="image-1">
                                                <img
                                                    src="{{ imageUrl($user->trade_license_image_url, 215, 215, 100, 1) }}"
                                                    alt="trad-img" class="img-fluid trad-img">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
