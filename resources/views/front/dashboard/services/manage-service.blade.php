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
                                    @if ($userData->isSupplier() && auth()->user()->isApproved())
                                        @if ($userData->isSupplier() &&  !auth()->user()->isSubscribed())
                                            <button class="secondary-btn add-project-btn" data-toggle="modal"
                                                    data-target="#subscription-modal">
                                                <svg id="AddIcon" xmlns="http://www.w3.org/2000/svg" width="23.143"
                                                     height="23.143" viewBox="0 0 23.143 23.143">
                                                    <path id="AddIcon-2" data-name="AddIcon"
                                                          d="M18.321,23.321a.971.971,0,0,1-.964.964H13.5v3.857a.971.971,0,0,1-.964.964H10.607a.971.971,0,0,1-.964-.964V24.286H5.786a.971.971,0,0,1-.964-.964V21.393a.971.971,0,0,1,.964-.964H9.643V16.571a.971.971,0,0,1,.964-.964h1.929a.971.971,0,0,1,.964.964v3.857h3.857a.971.971,0,0,1,.964.964Zm4.821-.964A11.571,11.571,0,1,0,11.571,33.929,11.574,11.574,0,0,0,23.143,22.357Z"
                                                          transform="translate(0 -10.786)" fill="#022c44"></path>
                                                </svg>
                                                {{__('Add Service')}}
                                            </button>
                                        @else
                                            <a href="{{ route('front.dashboard.service.create') }}"
                                               class="secondary-btn add-project-btn">
                                                <svg id="AddIcon" xmlns="http://www.w3.org/2000/svg" width="23.143"
                                                     height="23.143" viewBox="0 0 23.143 23.143">
                                                    <path id="AddIcon-2" data-name="AddIcon"
                                                          d="M18.321,23.321a.971.971,0,0,1-.964.964H13.5v3.857a.971.971,0,0,1-.964.964H10.607a.971.971,0,0,1-.964-.964V24.286H5.786a.971.971,0,0,1-.964-.964V21.393a.971.971,0,0,1,.964-.964H9.643V16.571a.971.971,0,0,1,.964-.964h1.929a.971.971,0,0,1,.964.964v3.857h3.857a.971.971,0,0,1,.964.964Zm4.821-.964A11.571,11.571,0,1,0,11.571,33.929,11.574,11.574,0,0,0,23.143,22.357Z"
                                                          transform="translate(0 -10.786)" fill="#022c44"></path>
                                                </svg>
                                                {{__('Add Service')}}
                                            </a>
                                        @endif
                                    @else
                                        <div class="">
                                            <span class="help-block">
                                                <small
                                                    class="text-danger  gothic-normel">{{ __('Your Account is not verified by the admin. You can not add any service until your ID is verified by the admin.') }}</small>
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @forelse ($services as $service)
                                <div class="col-md-4 col-lg-6 col-xl-4 col-sm-6 col-6-ctm ">
                                    <div class="services-card feature-services">
                                        <div class="img-block">
                                            @if( str_contains($service->default_image, '.mp4') || str_contains($service->default_image, '.mov'))
                                                <video width="262" height="140" controls muted>
                                                    <source src="{{$service->default_image}}" class="img-fluid"
                                                            type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            @else

                                                <img
                                                    src="{!! imageUrl(url($service->default_image), 263, 188, 95, 1) !!}"
                                                    alt="services-img"
                                                    class="img-fluid services-img">
                                            @endif


                                        </div>
                                        @if ($service->discount)
                                            <div class="discount">
                                                {{ $service->discount }}% {{__('OFF')}}
                                            </div>
                                        @endif
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
                                                        <label class="half"
                                                               title="{{__('Pretty good - 4.5 stars')}}"></label>
                                                        <label class="full"
                                                               title="{{__('Pretty good - 4 stars')}}"></label>
                                                        <label class="half" title="{{__('Meh - 3.5 stars')}}"></label>
                                                        <label class="full" title="{{__('Meh - 3 stars')}}"></label>
                                                        <label class="half"
                                                               title="{{__('Kinda bad - 2.5 stars')}}"></label>
                                                        <label class="full"
                                                               title="{{__('Kinda bad - 2 stars')}}"></label>
                                                        <label class="half" title="{{__('Meh - 1.5 stars')}}"></label>
                                                        <label class="full"
                                                               title="{{__('Sucks big time - 1 star')}}"></label>
                                                        <label class="half"
                                                               title="{{__('Sucks big time - 0.5 stars')}}"></label>
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
                                                        class="text-truncate">{{__('AED')}}{{ round($service->discountedMinPrice,2) }} -
                                                        {{__('AED')}}{{ round($service->dicountedMaxPrice,2) }}</span>
                                                    <strike
                                                        class="text-truncate">{{__('AED')}}{{ round($service->min_price,2) }}
                                                        -
                                                        {{__('AED')}}{{ round($service->max_price,2) }}</strike>
                                                </div>
                                            @else
                                                <div class="price-sec d-flex">
                                                    <span class="text-truncate">AED{{ round($service->min_price,2) }} -
                                                        {{__('AED')}}{{ round($service->max_price,2) }}</span>
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
                            {{__('Your subscription has expired. Kindly renew your subscription package.')}}
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
