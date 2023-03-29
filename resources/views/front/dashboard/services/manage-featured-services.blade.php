@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <main class="supplier-profile spacing-y">
        <div class="container">
            <div class="row">
                @include('front.dashboard.common.left-sidebar')
                <div class="col-xl-9 col-lg-8">
                    <div class="services-main-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div
                                    class="d-flex flex-wrap justify-content-center justify-content-sm-between align-content-center mb-3">
                                    <div
                                        class="visit-fee-block d-flex flex-wrap align-items-center justify-content-between mb-3 mb-sm-0">
                                    </div>
                                </div>
                            </div>
                            @forelse ($services as $service)
                                <div class="col-md-4 col-lg-6 col-xl-4 col-sm-6 col-6-ctm ">
                                    <div class="services-card feature-services">
                                        <div class="img-block">
                                            @if( str_contains($service->default_image, '.mp4') || str_contains($service->default_image, '.mov'))
                                                <video width="242" height="140" controls muted>
                                                    <source src="{{$service->default_image}}" class="img-fluid"
                                                            type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            @else

                                                <img
                                                    src="{!! imageUrl(url($service->default_image), 361, 191, 100, 1) !!}"
                                                    alt="services-img"
                                                    class="img-fluid services-img">
                                            @endif
                                        </div>
                                        @if ($service->discount)
                                            <div class="discount">
                                                {{ $service->discount }}% {{__('OFF')}}
                                            </div>
                                        @endif
                                        <div class="feature-box">
                                            <img src="{{ asset('assets/front/img/feature-icon.svg') }}"
                                                 alt="feature-icon" class="img-fluid feature-icon">
                                        </div>
                                        <div class="desc-block">
                                            <div class="cate-block d-flex align-items-center justify-content-center">

                                                <a href="{{ route('front.dashboard.service.edit', $service->id) }}">
                                                    <button class="edit-del-btn">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </a>

                                                <span class="seprater"></span>
                                                <button class="deleteService edit-del-btn" data-id="{{ $service->id }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                            <div class="d-flex align-content-center justify-content-between">
                                                <div class="star-rating-area">
                                                    <div class="rating-static clearfix"
                                                         rel="{{ round(getStarRating($service->average_rating), 1) }}">
                                                        <label class="full" title="{{__('Awesome - 5 stars')}}"></label>
                                                        <label class="half" title="{{__('Pretty good - 4.5 stars')}}"></label>
                                                        <label class="full" title="{{__('Pretty good - 4 stars')}}"></label>
                                                        <label class="half" title="{{__('Meh - 3.5 stars')}}"></label>
                                                        <label class="full" title="{{__('Meh - 3 stars')}}"></label>
                                                        <label class="half" title="{{__('Kinda bad - 2.5 stars')}}"></label>
                                                        <label class="full" title="{{__('Kinda bad - 2 stars')}}"></label>
                                                        <label class="half" title="{{__('Meh - 1.5 stars')}}"></label>
                                                        <label class="full" title="{{__('Sucks big time - 1 star')}}"></label>
                                                        <label class="half" title="{{__('Sucks big time - 0.5 stars')}}"></label>
                                                    </div>
                                                    <div class="ratilike ng-binding">
                                                        ({{number_format($service->average_rating,1)}})
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="title-row d-flex justify-content-between align-items-center flex-wrap">
                                                <div class="title text-truncate">
                                                    {{ translate($service->name) }}
                                                </div>
                                            </div>
                                            @if ($service->discount > 0)
                                                <div class="price-sec d-flex">
                                                    <span
                                                        class="text-truncate">{{__('AED')}}{{ $service->discountedMinPrice }} -
                                                        {{__('AED')}} {{ $service->dicountedMaxPrice }}</span>
                                                    <strike class="text-truncate">{{__('AED')}}{{ $service->min_price }}
                                                        -
                                                        {{__('AED')}} {{ $service->max_price }}</strike>
                                                </div>
                                            @else
                                                <div class="price-sec d-flex">
                                                    <span class="text-truncate">{{__('AED')}}{{ $service->min_price }} -
                                                        {{__('AED')}}{{ $service->max_price }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-danger w-100" role="alert">
                                        {{ __('No Service Found') }}
                                    </div>
                                </div>
                            @endforelse
                            {{ $services->links('front.common.pagination', ['paginator' => $services]) }}
                        </div>
                    </div>
                </div>
            </div>
    </main>
    <div class="modal fade feature-packages-modal response-modal" id="subscription-modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="packages-box">
                    <div class="headline-box">
                        {{__('Package Subscription')}}
                    </div>
                    <div class="innner-sec">
                        <p class="primary-text-p mb-2">
                            {{__('Your subscription has expired. Kindly renew your subscription package.')}}'
                        </p>
                        <div class="ctm-btnz-block renew-btnz d-flex justify-content-between align-items-center mw-100">
                            <a href="{{ route('front.dashboard.services.index') }}"
                               class="secondary-btn border-btn mr-1 mw-100">
                                {{__('Renew Later')}}
                            </a>
                            <a href="{{ route('front.dashboard.packages.index') }}" class="secondary-btn ml-1 mw-100">
                                {{__('Renew Now')}}
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(".deleteService").on('click', function (e) {
            let id = $(this).attr('data-id');
            $(".deleteService").attr('disabled', 'disabled');
            swal({
                    title: "{{ __('Do you want to delete this service?') }}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#022C44",
                    cancelButtonColor: "#022C44",
                    confirmButtonText: "{{ __('Yes') }}",
                    cancelButtonText: "{{ __('Cancel') }}",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {

                        $.ajax({

                            url: window.Laravel.baseUrl + "dashboard/service-delete/" + id,
                            success: function (data) {
                                toastr.success("{{ __('success') }}",
                                    "{{ __('Service removed successfully') }}")
                                location.reload();
                            }
                        })

                    } else {
                        $(".deleteService").attr('disabled', false);
                        swal.close()
                    }
                });
        });
    </script>
@endpush
