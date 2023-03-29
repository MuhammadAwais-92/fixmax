@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <main class="subscription-packages spacing-y">
        <div class="container">
            <div class="row">
                @include('front.dashboard.common.left-sidebar')
                <div class="col-xl-9 col-lg-8">
                    <div class="packages-main">
                        <div class="row">

                            <div class="col-md-12">
                                <h4 class="expiry-title d-flex flex-wrap">
                                    <span>{{__('Your package will expire on')}}</span> <strong
                                        dir="ltr">{{date('d F Y',auth()->user()->expiry_date)}}</strong>
                                </h4>
                            </div>
                            @forelse($packages as $package)
                                <div class="col-xl-4 col-lg-6 col-md-4">
                                    <form method="post" action="{{ route('front.dashboard.subscription.payment') }}">
                                        @csrf
                                        <input type="hidden" value="{{ $package->id }}" name="package_id">
                                        <div
                                            class="subscription-card    @if ($subscriptionId == $package->id) subscribed-pack @endif">
                                            <div class="header-block mx-auto">
                                                <p class="pack-type text-truncate">
                                                    {{ translate($package->name) }}
                                                </p>
                                                <h3 class="pack-price text-truncate">
                                                    {{ getPrice($package->price, $currency) }}
                                                </h3>
                                                <div class="pack-time text-truncate">
                                                    {{ $package->duration }} {{ $package->duration_type }}
                                                    {{ __('Package') }}
                                                </div>
                                            </div>
                                            <div class="desc-block">
                                                <p class="p-text">
                                                    {!! translate($package->description) !!}
                                                </p>
                                            </div>
                                            @if ($subscriptionId == $package->id)
                                                <button class="secondary-btn mw-100">
                                                    {{__('Subscribed')}}
                                                </button>
                                            @else
                                                <button class="secondary-btn mw-100">
                                                    {{__('Buy Now')}}
                                                </button>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            @empty
                            @endforelse

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
@endsection
