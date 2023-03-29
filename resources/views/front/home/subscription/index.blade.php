@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')


    <main class="login-sec spacing-y">
        <div class="container">
            <div class="packages-main">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="login-text">
                            <div class="title">{{ __('Choose Subscription Package') }}</div>
                            <div class="title-des">{{ __('Choose Subscription Package') }}</div>
                        </div>
                    </div>
                    @forelse($packages as $package)
                        <div class="col-xl-4 col-lg-6 col-md-4">
                            <form method="post" action="{{ route('front.dashboard.subscription.payment') }}">
                                @csrf
                                <input type="hidden" value="{{ $package->id }}" name="package_id">
                                <div
                                    class="subscription-card  @if ($subscriptionId == $package->id) subscribed-pack @endif">
                                    <div class="header-block mx-auto">
                                        <p class="pack-type text-truncate">
                                            {{ translate($package->name) }}
                                        </p>
                                        <h3 class="pack-price text-truncate">
                                            {{ getPrice($package->price, $currency) }}
                                        </h3>
                                        <div class="pack-time text-truncate">
                                            {{ $package->duration }} {{ $package->duration_type }} {{ __('Package') }}
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
                        @include('front.common.alert-empty', [
                            'message' => __('No Package found.'),
                        ])
                    @endforelse
                    {{ $packages->links('front.common.pagination', ['paginator' => $packages]) }}

                </div>
            </div>
        </div>
    </main>
    <div class="modal fade feature-packages-modal response-modal" id="subscription-modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="packages-box">
                    <div class="innner-sec">
                        <p class="primary-text-p mb-2 pl-1">
                            {{__('Thank you for registering. we are verifying your information and we wil contact you soon regarding your registration process.')}}'
                        </p>
                        <div class="ctm-btnz-block renew-btnz d-flex justify-content-between align-items-center mw-100">
                            <a href="{{ route('front.index') }}" class="secondary-btn ml-1 mw-100">
                                {{__('Back to Homepage')}}
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        approved = '<?php echo !$userData->isApproved(); ?>';
        issubscribed = '<?php echo $userData->isSubscribed(); ?>';
        if (approved && issubscribed) {
            $(window).on('load', function () {
                $('#subscription-modal').modal('show');
            });
        }
    </script>
@endpush
