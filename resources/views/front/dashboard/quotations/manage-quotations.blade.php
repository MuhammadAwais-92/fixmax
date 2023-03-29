@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <main class="manage-orders spacing-y">
        <div class="container">
            <div class="row">
                @include('front.dashboard.common.left-sidebar')
                <div class="col-xl-9 col-lg-8">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-pills mb-2">
                                <li class="nav-item custom-tab">
                                    <a class="nav-link  @if ($status == 'all') active @endif"
                                       href="{{ route('front.dashboard.quotations.index') }}">{{__('All')}}</a>
                                </li>
                                <li class="nav-item custom-tab">
                                    <a class="nav-link @if ($status == 'pending') active @endif"
                                       href="{{ route('front.dashboard.quotations.index', 'pending') }}">{{__('pending')}}</a>
                                </li>
                                <li class="nav-item custom-tab">
                                    <a class="nav-link  @if ($status == 'visited') active @endif"
                                       href="{{ route('front.dashboard.quotations.index', 'visited') }}">{{__('visited')}}</a>
                                </li>
                                <li class="nav-item custom-tab">
                                    <a class="nav-link @if ($status == 'quoted') active @endif"
                                       href="{{ route('front.dashboard.quotations.index', 'quoted') }}">{{__('quoted')}}</a>
                                </li>
                                <li class="nav-item custom-tab">
                                    <a class="nav-link @if ($status == 'confirmed') active @endif"
                                       href="{{ route('front.dashboard.quotations.index', 'confirmed') }}">{{__('accepted')}}</a>
                                </li>
                                <li class="nav-item custom-tab">
                                    <a class="nav-link @if ($status == 'rejected') active @endif"
                                       href="{{ route('front.dashboard.quotations.index', 'rejected') }}">{{__('Cancelled')}}</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                @forelse ($quotations as $quotation)
                                    <a href="{{ route('front.dashboard.quotation.detail', $quotation->id) }}">
                                        <div class="tab-pane fade show active" id="all" role="tabpanel"
                                             aria-labelledby="all-tab">
                                            <div class="orders-list">
                                                <div class="order-list-card">
                                                    <div class="orderlist-desc">
                                                        <div class="d-flex justify-content-between flex-wrap mb-05">
                                                            <div class="order-name mb-0">
                                                                Quotation ID#{{ $quotation->order_number }}
                                                            </div>
                                                            @if (!$quotation->quoated_price)
                                                                <div class="visit-price d-flex flex-wrap">
                                                                    <span class="title">{{__('Visit Fee')}}</span>
                                                                    <strong>{{__('AED')}}{{ $quotation->visit_fee }}</strong>
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <div class="order-time d-flex flex-wrap">
                                                            <span class="title">{{__('Scheduled Time:')}}</span> <span
                                                                class="order-date-time"
                                                                dir="ltr">{{ date('d/m/Y', $quotation->date) }}
                                                                {{ date("H:i", strtotime($quotation->time)) }}</span>
                                                        </div>
                                                        <div class="status d-flex flex-wrap">
                                                            @if ($quotation->status == 'rejected')
                                                                <span>{{__('Status:')}}</span> <span
                                                                    class="status-value cancl">{{__('Cancelled')}}</span>
                                                            @elseif($quotation->status == 'confirmed')
                                                                <span>{{__('Status:')}}</span> <span
                                                                    class="status-value acept">{{__('Accepted')}}</span>
                                                            @elseif($quotation->status == 'quoted')
                                                                <span>{{__('Status:')}}</span> <span
                                                                    class="status-value quote">{{__('Quoted')}}</span>
                                                            @elseif($quotation->status == 'visited')
                                                                <span>{{__('Status:')}}</span> <span
                                                                    class="status-value visit">{{__('Visited')}}</span>
                                                            @else
                                                                <span>{{__('Status:')}}</span> <span
                                                                    class="status-value pend">{{ __($quotation->status) }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="order-list-img-block">
                                                        <div
                                                            class="d-flex order-img-price-row flex-wrap justify-content-between align-items-start">
                                                            <div class="left-col d-flex flex-wrap">
                                                                <div class="img-block">
                                                                    @if (str_contains($quotation->image, '.mp4') || str_contains($quotation->image, '.mov'))
                                                                        <video width="123" height="65" controls muted>
                                                                            <source src="{{ $quotation->image }}"
                                                                                    class="img-fluid" type="video/mp4">
                                                                            Your browser does not support the video tag.
                                                                        </video>
                                                                    @else
                                                                        <img
                                                                            src="{!! imageUrl(url($quotation->image), 123, 65, 100, 1) !!}"
                                                                            alt="user-img"
                                                                            class="img-fluid user-img">
                                                                    @endif

                                                                </div>
                                                                <div class="text-desc-block">
                                                                    <p class="service-name">
                                                                        {{ translate($quotation->service_name) }}
                                                                    </p>
                                                                    <h3 class="price">
                                                                        {{__('AED')}}
                                                                        {{ $quotation->min_price }}- {{__('AED')}}
                                                                        {{ $quotation->max_price }}
                                                                    </h3>
                                                                </div>
                                                            </div>
                                                            @if ($quotation->quoated_price)
                                                                <div class="visit-price d-flex flex-wrap">
                                                                    <span
                                                                        class="title">{{__('Quoted Service Price')}}</span>
                                                                    <strong> {{__('AED')}}{{ $quotation->quoated_price }}</strong>
                                                                </div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>

                                @empty
                                    <div class="alert alert-danger w-100" role="alert">
                                        {{ __('No Quotation Found') }}
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        {{ $quotations->links('front.common.pagination', ['paginator' => $quotations]) }}
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="modal fade feature-packages-modal order-cancel-mdl" id="checkout-alert-modal" tabindex="-1"
         role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="packages-box">
                    <div class="innner-sec px-3 py-2">
                        <p class="primary-text-p px-1">
                            {{ __('Your request has been submitted. Service provider will send their employee to check the issue and quote the amount accordingly.') }}
                            <br>
                            {{ __('If you purchase anything from the supplier outside the application, the platform will not take any responsibility!') }}
                        </p>
                        <div class="px-1 mt-2">
                            <a type="button" data-dismiss="modal" class="secondary-btn mw-100">
                                {{__('ok')}}
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
        $(document).ready(function () {
            check = '<?php echo isset(session()->all()['status']); ?>';
            if (check) {
                $(window).on('load', function () {
                    $('#checkout-alert-modal').modal('show');
                });
            }
        });
    </script>
@endpush
