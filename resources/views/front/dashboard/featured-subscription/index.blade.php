@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <main class="subscription-packages spacing-y">
        <div class="container">
            <div class="row">
                @include('front.dashboard.common.left-sidebar')

                <div class="col-xl-9 col-lg-8">
                    <ul class="nav nav-pills mb-5" id="pills-tab" role="tablist">
                        <li class="nav-item custom-tab">
                            <a class="nav-link active" data-toggle="pill" href="#all-packages" role="tab"
                               aria-controls="all"
                               aria-selected="true">{{__('All Packages')}}</a>
                        </li>
                        <li class="nav-item custom-tab">
                            <a class="nav-link" data-toggle="pill" href="#purchased-packages" role="tab"
                               aria-controls="pending" aria-selected="false">{{__('Purchased Packages')}}</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="all-packages" role="tabpanel"
                             aria-labelledby="all-packages-tab">
                            <div class="packages-main">
                                <div class="row">
                                    @forelse ($packages as $package)
                                        <div class="col-xl-4 col-lg-6 col-md-4">
                                            <form method="post"
                                                  action="{{ route('front.dashboard.subscription.payment') }}">
                                                @csrf
                                                <input type="hidden" value="{{ $package->id }}" name="package_id">
                                                <input type="hidden" value="{{ $package->subscription_type }}"
                                                       name="subscription_type">
                                                <div class="subscription-card feature-card">
                                                    <div class="header-block mx-auto">
                                                        <h3 class="pack-price text-truncate">
                                                            {{ translate($package->name) }}
                                                        </h3>
                                                    </div>
                                                    <div class="desc-block">
                                                        <p class="p-text">
                                                            {{__('Feature 1 Product for')}}
                                                            {{ $package->duration }} {{ $package->duration_type }}
                                                        </p>
                                                        <h3 class="price text-truncate">
                                                            {{ getPrice($package->price, $currency) }}
                                                        </h3>
                                                        <p class="p-text">

                                                            {!! translate($package->description) !!}
                                                        </p>
                                                    </div>
                                                    <button class="secondary-btn mw-100">
                                                        {{__('Buy Now')}}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <div class="alert alert-danger w-100" role="alert">
                                                {{ __('No Package Found') }}
                                            </div>
                                        </div>
                                    @endforelse
                                    {{ $packages->links('front.common.pagination', ['paginator' => $packages]) }}

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="purchased-packages" role="tabpanel"
                             aria-labelledby="purchased-packages-tab">
                            <div class="packages-main">
                                <div class="row">
                                    @forelse ($purchasedPackages as $package)
                                        <div class="col-xl-4 col-lg-6 col-md-4">
                                            {{-- <form method="post"
                                                action="{{ route('front.dashboard.subscription.payment') }}">
                                                @csrf
                                                <input type="hidden" value="{{ $package->package['id'] }}" name="package_id">
                                                <input type="hidden" value="{{ $package->package['subscription_type'] }}"
                                                    name="subscription_type"> --}}
                                            <div class="subscription-card feature-card purchase-pack">
                                                <div class="header-block mx-auto">
                                                    <h3 class="pack-price text-truncate">
                                                        {{ translate($package->package['name']) }}
                                                    </h3>
                                                </div>
                                                <div class="desc-block">
                                                    <p class="p-text">
                                                        {{__('Feature')}} 1 {{__('Products for')}}
                                                        {{ $package->package['duration'] }} {{ $package->package['duration_type'] }}
                                                    </p>
                                                    <p class="perchase-count d-flex justify-content-center">
                                                        <span class="title">{{__('Purchase Count')}}:</span>
                                                        <span
                                                            class="val">{{ $package->purchase_count }}</span>
                                                    </p>

                                                    {{-- <p class="perchase-count d-flex justify-content-center">
                                                        <span class="title">Expiry:</span>
                                                        <span dir="ltr" class="val">{{date('d-m-Y',auth()->user()->expiry_date)}}</span>
                                                    </p> --}}

                                                    <h3 class="price text-truncate">
                                                        {{ getPrice($package->package['price'], $currency) }}
                                                    </h3>
                                                </div>
                                                <button class="secondary-btn mw-100">
                                                    {{__('Purchased')}}
                                                </button>
                                            </div>
                                            {{-- </form> --}}
                                        </div>
                                    @empty
                                        <div class="col-12">
                                            <div class="alert alert-danger w-100" role="alert">
                                                {{ __('No Package Found') }}
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
    </main>
@endsection
