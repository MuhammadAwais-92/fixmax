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
                            <ul class="nav nav-pills mb-2" id="pills-tab" role="tablist">
                                <li class="nav-item custom-tab">
                                    <a class="nav-link  @if ($status == 'all') active @endif"
                                       href="{{ route('front.dashboard.orders.index') }}">{{__('All')}}</a>
                                </li>
                                <li class="nav-item custom-tab">
                                    <a class="nav-link @if ($status == 'confirmed') active @endif"
                                       href="{{ route('front.dashboard.orders.index', 'confirmed') }}">{{__('Pending')}}</a>
                                </li>
                                <li class="nav-item custom-tab">
                                    <a class="nav-link @if ($status == 'in-progress') active @endif"
                                       href="{{ route('front.dashboard.orders.index', 'in-progress') }}">{{__('In Progress')}}</a>
                                </li>
                                <li class="nav-item custom-tab">
                                    <a class="nav-link  @if ($status == 'completed') active @endif"
                                       href="{{ route('front.dashboard.orders.index', 'completed') }}">{{__('Completed')}}</a>
                                </li>
                                <li class="nav-item custom-tab">
                                    <a class="nav-link @if ($status == 'cancelled') active @endif"
                                       href="{{ route('front.dashboard.orders.index', 'cancelled') }}">{{__('Cancelled')}}</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="orders-list">
                                    @forelse ($orders as $order)
                                        <a href="{{ route('front.dashboard.order.detail', $order->id) }}">
                                            <div class="order-list-card">
                                                <div class="orderlist-desc">
                                                    <div
                                                        class="d-flex justify-content-between align-items-center flex-wrap">
                                                        <div class="order-desc">
                                                            <div class="order-name ">
                                                                {{__('Order#')}} {{ $order->order_number }}


                                                            </div>
                                                            <div class="order-time d-flex flex-wrap">
                                                                <span class="title">{{__('Scheduled Time:')}}</span>
                                                                <span
                                                                    class="order-date-time"
                                                                    dir="ltr">{{ date('d/m/Y', $order->date) }}
                                                                    {{ date('H:i', strtotime($order->time)) }}</span>
                                                            </div>
                                                            <div class="status d-flex flex-wrap">
                                                                @if ($order->status == 'confirmed')
                                                                    <span>{{__('Status:')}}</span> <span
                                                                        class="status-value pend">{{__('Pending')}}</span>
                                                                @elseif($order->status == 'in-progress')
                                                                    <span>{{__('Status:')}}</span> <span
                                                                        class="status-value acept">{{ __($order->status) }}</span>
                                                                @elseif($order->status == 'cancelled')
                                                                    <span>{{__('Status:')}}</span> <span
                                                                        class="status-value cancl">{{ __($order->status) }}</span>
                                                                @elseif($order->status == 'completed')
                                                                    <span>{{__('Status:')}}</span> <span
                                                                        class="status-value compl">{{ __($order->status) }}</span>
                                                                @else
                                                                    <span>{{__('Status:')}}</span> <span
                                                                        class="status-value pend">{{ __($order->status) }}</span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        @if ($order->isConfirmed())
                                                            @if ($userData->isUser())
                                                                {{-- <div
                                                                class="d-flex align-items-end flex-column mt-3 mt-xl-0 user-order-dt-block">
                                                                <button id="cancel" data-toggle="modal"
                                                                    data-target="#order-cancel-modal"
                                                                    class="secondary-btn w-100">
                                                                    Cancel Order (Time Left: <span
                                                                        class="time">{{ date('F d,Y H:i:s', strtotime('+' . config('settings.cancel_duration') . 'minutes', $order->updated_at)) }}</span>)
                                                                </button>

                                                            </div> --}}
                                                                <div
                                                                    class="user-visit-price-block visit-price d-flex flex-wrap justify-content-end "
                                                                    style="display: none !important;">
                                                                    <span class="title">{{__('Time Left:')}}</span>
                                                                    <p><span
                                                                            class="time">{{ date('F d,Y H:i:s', strtotime('+' . config('settings.cancel_duration') . 'minutes', $order->updated_at)) }}</span>
                                                                    </p>
                                                                    <button type="button" id="cancel"
                                                                            data-toggle="modal"
                                                                            data-target="#order-cancel-modal"
                                                                            class="secondary-btn">
                                                                        {{__('Cancel Order')}}
                                                                    </button>
                                                                </div>
                                                            @endif
                                                        @endif

                                                    </div>


                                                </div>
                                                <div class="order-list-img-block">
                                                    <div
                                                        class="d-flex flex-wrap justify-content-between align-items-start">
                                                        <div class="order-img-left d-flex order-img-price-row">
                                                            <div class="img-block">
                                                                @if (str_contains($order->image, '.mp4') || str_contains($order->image, '.mov'))
                                                                    <video width="123" height="65" controls muted>
                                                                        <source src="{{ $order->image }}"
                                                                                class="img-fluid" type="video/mp4">
                                                                        Your browser does not support the video tag.
                                                                    </video>
                                                                @else
                                                                    <img
                                                                        src="{!! imageUrl(url($order->image), 123, 65, 100, 1) !!}"
                                                                        alt="order-list-img"
                                                                        class="img-fluid">
                                                                @endif

                                                            </div>
                                                            <div class="text-desc-block">
                                                                <p class="service-name">
                                                                    {{ translate($order->service_name) }}
                                                                </p>
                                                                <h3 class="visit-price d-flex gap-05">
                                                                    <span class="title px-0">{{__('Visit Fee')}}</span> <strong>{{__('AED')}}
                                                                        {{ $order->visit_fee }}</strong>
                                                                </h3>
                                                            </div>
                                                        </div>
                                                        <div class="visit-price mb-05 d-flex gap-05">
                                                            <span class="title px-0">{{__('Total Amount')}}</span>
                                                            <strong>{{__('AED')}}{{ $order->total_amount }}</strong>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </a>


                                        <div class="modal fade feature-packages-modal order-cancel-mdl"
                                             id="order-cancel-modal" tabindex="-1" role="dialog"
                                             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="packages-box">
                                                        <div class="headline-box">
                                                            {{__('Order Cancellation')}}
                                                        </div>
                                                        <form
                                                            action="{!! route('front.dashboard.order.cancel', $order->id) !!}"
                                                            method="post">
                                                            @csrf
                                                            <input type="hidden" name="id"
                                                                   value="{{ $order->id }}">
                                                            <input type="hidden" name="status" id="status"
                                                                   value="cancelled">
                                                            <div class="innner-sec">
                                                                <p class="primary-text-p px-1 mb-2">
                                                                    {{__('Are you sure you want to cancel your current Order')}}
                                                                    <span>({{__('Order#')}}{{ $order->order_number }})?</span>
                                                                </p>
                                                                <div class="d-flex flex-wrap">
                                                                    <div class="px-1 w-50">
                                                                        <button class="secondary-btn border-btn mw-100"
                                                                                type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                            {{__('No')}}
                                                                        </button>
                                                                    </div>
                                                                    <div class="px-1 w-50">
                                                                        <button class="secondary-btn mw-100">
                                                                            {{__('Yes')}}
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    @empty
                                        <div class="alert alert-danger w-100" role="alert">
                                            {{ __('No Orders Found') }}
                                        </div>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    {{ $orders->links('front.common.pagination', ['paginator' => $orders]) }}
                </div>
            </div>
        </div>
        </div>
    </main>
@endsection
@push('scripts')
    <script>
        $(`.time`).each(function (i, v) {
            let time = $(v).html();


            var countDownDate = new Date(time).getTime();

            // Update the count down every 1 second
            var x = setInterval(function () {

                // Get today's date and time
                var now = new Date().getTime();

                // Find the distance between now and the count down date
                var distance = countDownDate - now;
                console.log("🚀 ~ file: manage-orders.blade.php ~ line 139 ~ x ~ distance", distance)

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Output the result in an element with id="demo"
                $(v).html(minutes + ":" + seconds);

                // If the count down is over, write some text
                if (distance < 0) {
                    clearInterval(x);
                    $(v).parent().prev().parent().hide();
                    // $(v).parent().next().hide();
                    // $(v).parent().hide();

                    // $(v).parent().prev().hide();
                } else {
                    $(v).parent().prev().parent().show();
                }
            }, 1000);
        });
    </script>
@endpush
