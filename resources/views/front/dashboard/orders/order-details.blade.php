@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <main class="order-details spacing-y">
        <div class="container">
            <div class="row">
                @include('front.dashboard.common.left-sidebar')
                <div class="col-xl-9 col-lg-8">
                    <div class="order-detail-content">
                        <!-- order details -->
                        <div class="order-title-row d-flex justify-content-between align-items-start flex-wrap">
                            <div class="order-title-block mw-55 mw-lg-100">
                                <h3 class="title">
                                    {{__('Order#')}} {{ $order->order_number }}
                                </h3>
                                <div class="order-place-date d-flex flex-wrap">
                                    <span>{{__('Order Placement Time:')}}</span> <span class="date"
                                                                                       dir="ltr">{{ date('d/m/Y H:i', $order->updated_at) }}</span>
                                </div>
                                <div class="order-place-date d-flex flex-wrap">
                                    <span>{{__('Scheduled Time:')}}</span> <span class="date"
                                                                                 dir="ltr">{{ date('d/m/Y', $order->date) }}
                                        {{ date('H:i', strtotime($order->time)) }}</span>
                                </div>
                                <div class="order-status d-flex flex-wrap">
                                    @if ($order->status == 'confirmed')
                                        <span>{{__('Status:')}}</span><span
                                            class="status-val pend">{{__('Pending')}}</span>
                                    @elseif ($order->status == 'cancelled')
                                        <span>{{__('Status:')}}</span><span
                                            class="status-val cancl">{{ __($order->status) }}</span>
                                    @elseif ($order->status == 'in-progress')
                                        <span>{{__('Status:')}}</span><span
                                            class="status-val acept">{{__('In-progress')}}</span>
                                    @elseif ($order->status == 'completed')
                                        <span>{{__('Status:')}}</span><span
                                            class="status-val compl">{{ __($order->status) }}</span>
                                    @else
                                        <span>{{__('Status:')}}</span><span
                                            class="status-val pend">{{ __($order->status) }}</span>
                                    @endif
                                </div>
                            </div>
                            @if ($order->isConfirmed())
                                @if ($userData->isUser())
                                    <div class="d-flex align-items-end flex-column mt-3 mt-xl-0 user-order-dt-block">
                                        <button id="cancel" data-toggle="modal" data-target="#order-cancel-modal"
                                                class="secondary-btn w-100">
                                            {{__('Cancel Order')}} ({{__('Time Left:')}} <span id="time"></span>)
                                        </button>
                                        <div class="visit-fee d-flex flex-wrap">
                                            <span class="prc">{{__('Total Amount:')}}</span><span
                                                class="prc px-0">{{__('AED')}}
                                                {{ $order->total_amount }}</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="d-flex align-items-end flex-column mt-3 mt-xl-0 user-order-dt-block">
                                        <button data-toggle="modal" data-target="#order-cancel-modal"
                                                class="secondary-btn w-100">
                                            {{__('Cancel Order')}}
                                        </button>
                                        <button data-toggle="modal" data-target="#order-in-progress-modal"
                                                class="secondary-btn w-100 mt-1">
                                            {{__('In Progress')}}
                                        </button>
                                        <div class="visit-fee d-flex flex-wrap mt-1">
                                            <span class="prc mt-0">{{__('Total Amount:')}}</span><span
                                                class="prc px-0 mt-0">{{__('AED')}}
                                                {{ $order->total_amount }}</span>
                                        </div>
                                    </div>
                                @endif
                            @endif
                            @if ($order->isInProgress())
                                @if ($userData->isSupplier())
                                    <div class="d-flex align-items-end flex-column mt-3 mt-xl-0 user-order-dt-block">
                                        <button id="cancel" data-toggle="modal" data-target="#order-complete-modal"
                                                class="secondary-btn w-100">
                                            {{__('Mark As Complete')}}
                                        </button>
                                        <div class="visit-fee d-flex flex-wrap">
                                            <span class="prc">{{__('Total Amount:')}}</span><span
                                                class="prc px-0">{{__("AED")}} {{ $order->total_amount }}</span>
                                        </div>
                                    </div>
                                @endif
                            @endif
                            @if ($order->isCompleted())
                                <div class="order-price-block d-flex flex-column align-items-end">
                                    <div class="dropdown invoice-dd">
                                        <button class="secondary-btn d-flex align-items-center" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                            <span class="mx-05">{{__('Invoice')}}</span> </span> <svg id="dd-icon-1" xmlns="http://www.w3.org/2000/svg" width="9" height="5" viewBox="0 0 9 5">
                                                <path id="DropdownIcon" d="M9.688-7.171a.289.289,0,0,0-.09-.2L9.146-7.8a.318.318,0,0,0-.207-.086.318.318,0,0,0-.207.086L5.187-4.422,1.643-7.8a.318.318,0,0,0-.207-.086.3.3,0,0,0-.207.086l-.451.43a.289.289,0,0,0-.09.2.289.289,0,0,0,.09.2l4.2,4a.318.318,0,0,0,.207.086.318.318,0,0,0,.207-.086l4.2-4A.289.289,0,0,0,9.688-7.171Z" transform="translate(-0.688 7.884)" fill="#fff"/>
                                              </svg>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="">
                                            <a class="dropdown-item" onclick="generatePDF()"
                                               href="javascript:void(0)">{{__('View Invoice')}}</a>
                                            <a class="dropdown-item" onclick="sendInvoice()"
                                               href="javascript:void(0)">{{__('Send Invoice')}}</a>
                                        </div>
                                    </div>
                                    <div class="order-price d-flex flex-wrap">
                                        <span>{{__('Total Amount:')}}</span><span class="pl-05">{{__('AED')}}
                                            {{ $order->total_amount }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <!-- issue image -->
                        <div class="issue-block">
                            <h4 class="title">
                                {{__('Issue Image')}}
                            </h4>
                            @foreach ($order->issue_images as $image)
                                <div class="img-block">
                                    <img src="{!! imageUrl(url($image), 185, 124, 100, 1) !!}" alt="issue-img"
                                         class="img-fluid issue-img">
                                </div>
                            @endforeach
                            <div class="desc-block mb-1">
                                <h5 class="title-sm">
                                    {{__('Comments')}}
                                </h5>
                                <p class="p-text">
                                    {{ $order->order_notes }}
                                </p>
                            </div>
                            <div class="desc-block">
                                <h5 class="title-sm">
                                    {{__('Selected Option')}}
                                </h5>
                                @if ($order->issue_type == 'know')
                                    <p class="p-text">
                                        {{__('I know the issue')}}
                                    </p>
                                @else
                                    <p class="p-text">
                                        {{__('I do not know the issue')}}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <!-- payement method -->
                        <div class="payment-block py-bb">
                            <h3 class="my-title">
                                {{__('Payment Method')}}
                            </h3>
                            <h5 class="my-sm-title">
                                {{__('Paypal')}}
                            </h5>
                        </div>
                        <!-- address block -->
                        <div class="address-block py-bb">
                            <h3 class="my-title">
                                {{__('Address')}}
                            </h3>
                            <h5 class="my-sm-title">
                                {{ $order->address['address_name'] }}
                            </h5>
                            <p class="primary-text-p">
                                {{ $order->address['address'] }}
                            </p>
                            <p class="primary-text-p mb-0" dir="ltr">
                                {{ $order->address['user_phone'] }}
                            </p>

                        </div>
                    @if ($userData->isUser())
                        <!-- supplier -->
                            <div class="user-info-block py-bb service-block">
                                <div class="d-flex align-content-center flex-wrap mb-1">
                                    <h3 class="my-title mb-1">
                                        {{__('Supplier')}}
                                    </h3>
                                    @if (Auth::user()->isUser() && $order->status == 'completed' && $order->rateSupplier->isNotEmpty())
                                        <a href="#" class="rate-link d-block" data-toggle="modal"
                                           data-target="#rate-supplier-modal">
                                            {{__('Rate Supplier')}}
                                        </a>
                                    @endif
                                </div>
                                <div class="user-info-row d-flex flex-wrap">
                                    <div class="sup-img-block">
                                        <img src="{!! imageUrl(url($order->supplier->image_url), 75, 75, 100, 1) !!}"
                                             alt="user-img" class="img-fluid user-img">
                                    </div>
                                    <div class="user-desc desc-block">
                                        <div class="d-flex">
                                            <div class="star-rating-area">
                                                <div class="rating-static clearfix"
                                                     rel="{{ round(getStarRating($order->supplier->rating), 1) }}">
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
                                                <div class="ratilike ng-binding">
                                                    ({{ number_format($order->supplier->rating, 1) }})
                                                </div>
                                            </div>
                                        </div>
                                        <div class="user-name">
                                            {{ translate($order->supplier->supplier_name) }}
                                        </div>
                                        <p class="user-no">
                                            {!! $order->supplier->category ? translate($order->supplier->category->name) : 'N/A' !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                    @else
                        <!-- user information -->
                            <div class="user-info-block py-bb">
                                <h3 class="my-title mb-1">
                                    {{__('User Information')}}
                                </h3>
                                <div class="user-info-row d-flex flex-wrap">
                                    <div class="info-img-block">
                                        <img src="{!! imageUrl(url($order->user->image_url), 75, 75, 100, 1) !!}"
                                             alt="user-img" class="img-fluid user-img">
                                    </div>
                                    <div class="user-desc">
                                        <div class="user-name">
                                            {{ $order->user->user_name }}
                                        </div>
                                        <p class="user-no" dir="ltr">
                                            {{ $order->user->phone }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                    @endif
                    <!-- services details -->
                        <div class="service-block py-bb">
                            <div class="d-flex align-content-center flex-wrap mb-1">
                                <h3 class="my-title mb-1">
                                    {{__('Service Details')}}
                                </h3>
                                @if (Auth::user()->isUser() && $order->status == 'completed' && $order->rateService->isNotEmpty())
                                    <a href="#" class="rate-link d-block" data-toggle="modal"
                                       data-target="#rate-service-modal">
                                        {{__('Rate Service')}}
                                    </a>
                                @endif
                            </div>
                            <div class="services-row d-flex flex-wrap">
                                <div class="img-block">
                                    @if (str_contains($order->image, '.mp4') || str_contains($order->image, '.mov'))
                                        <video width="123" height="65" controls muted>
                                            <source src="{{ $order->image }}" class="img-fluid" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @else
                                        <img src="{!! imageUrl(url($order->image), 123, 65, 100, 1) !!}" alt="user-img"
                                             class="img-fluid user-img">
                                    @endif
                                </div>
                                <div class="desc-block">
                                    <div class="d-flex">
                                        <div class="star-rating-area">
                                            <div class="rating-static clearfix"
                                                 rel="{{ round(getStarRating($order->serviceRating->average_rating), 1) }}">
                                                <label class="full" title="{{__('Awesome - 5 stars')}}"></label>
                                                <label class="half" title="{{__('Pretty good - 4.5 stars')}}"></label>
                                                <label class="full" title="{{__('Pretty good - 4 stars')}}"></label>
                                                <label class="half" title="{{__('Meh - 3.5 stars')}}"></label>
                                                <label class="full" title="{{__('Meh - 3 stars')}}"></label>
                                                <label class="half" title="{{__('Kinda bad - 2.5 stars')}}"></label>
                                                <label class="full" title="{{__('Kinda bad - 2 stars')}}"></label>
                                                <label class="half" title="{{__('Meh - 1.5 stars')}}"></label>
                                                <label class="full" title="{{__('Sucks big time - 1 star')}}"></label>
                                                <label class="half"
                                                       title="{{__('Sucks big time - 0.5 stars')}}"></label>
                                            </div>
                                            <div class="ratilike ng-binding">
                                                ({{ number_format($order->serviceRating->average_rating, 1) }})
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-p">
                                        {!! translate($order->service_name) !!}
                                    </div>
                                    <h4 class="serv-price d-flex">
                                        <span>{{__('AED')}} {!! $order->min_price !!}</span> -
                                        <span>{{__('AED')}} {!! $order->max_price !!}</span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <!-- Select Equipments -->
                        @if ($order->orderItems->isNotEmpty())
                            <div class="service-block py-bb">
                                <h3 class="my-title mb-1">
                                    {{__('Selected Equipment(s)')}}
                                </h3>
                                @foreach ($order->orderItems as $item)
                                    <div class="services-row d-flex flex-wrap">
                                        <div class="img-block">
                                            <img src="{!! imageUrl(url($item->image), 123, 65, 100, 1) !!}"
                                                 alt="user-img" class="img-fluid user-img">
                                        </div>
                                        <div class="desc-block">
                                            <h4 class="serv-price d-flex">
                                                <span>{{__('AED')}}{{ $item->price }}</span>
                                            </h4>
                                            <div class="text-p mb-0">
                                                {!! translate($item->name) !!}<p
                                                    class="px-05 d-flex align-items-center">(<span
                                                        class="pr-05">{{__('Qty:')}}</span><span>{{ $item->quantity }}</span>)
                                                </p>
                                            </div>
                                            <div class="text-p mb-0">
                                                {!! $item->make !!} - {!! $item->equipment_model !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div class="order-summary-block py-bb">
                            <h3 class="my-title">
                                {{__('Order Summary')}}
                            </h3>
                            <div class="summary-box">
                                {{-- <div class="title-value-row d-flex flex-wrap justify-content-between align-items-center">
                    <div class="title">Subtotal</div>
                    <div class="value">
                      AED {{ $order->subTotal }}
                    </div>
                  </div> --}}
                                @if ($order->subtotal)
                                    <div
                                        class="title-value-row d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="title">{{__('Equipment Charges')}}</div>
                                        <div class="value">
                                            {{__('AED')}} {{ $order->subtotal }}
                                        </div>
                                    </div>
                                @endif
                                <div
                                    class="title-value-row d-flex flex-wrap justify-content-between align-items-center">
                                    <div class="title">{{__('Visit Fee:')}}</div>
                                    <div class="value">
                                        {{__('AED')}} {{ $order->visit_fee }}
                                    </div>
                                </div>
                                @if ($order->discount > 0)
                                    <div
                                        class="title-value-row d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="title">{{__('Coupon Discount')}}</div>
                                        <div class="value">
                                            - {{__('AED')}} {{ $order->discount }}
                                        </div>
                                    </div>
                                @endif
                                <div
                                    class="title-value-row d-flex flex-wrap justify-content-between align-items-center">
                                    <div class="title">{{__('Service Charges')}}</div>
                                    <div class="value">
                                        {{__('AED')}} {{ $order->quoated_price }}
                                    </div>
                                </div>
                                <div
                                    class="title-value-row d-flex flex-wrap justify-content-between align-items-center">
                                    <div class="title">{{__('VAT')}}</div>
                                    <div class="value">
                                        {{__('AED')}} {{ $order->vat }}
                                    </div>
                                </div>
                                @if ($userData->isSupplier() && $order->status == 'completed')
                                    <div
                                        class="title-value-row d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="title">{{__('Platform Commission')}}</div>
                                        <div class="value">
                                            {{__('AED')}} {{ $order->platform_commission }}
                                        </div>
                                    </div>
                                @endif
                                <div
                                    class="title-value-row total-row d-flex flex-wrap justify-content-between align-items-center">
                                    <div class="title">{{__('Total')}}</div>
                                    <div class="value">
                                        {{__('AED')}} {{ $order->total_amount }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Rate Supplier Modal -->
    @if ($order->rateSupplier->isNotEmpty())
        <div class="modal fade feature-packages-modal order-cancel-mdl rating-modal" id="rate-supplier-modal"
             tabindex="-1"
             role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="packages-box">
                        <div class="headline-box">
                            {{__('Rate Supplier')}}
                        </div>
                        <div class="innner-sec">
                            <form action="{{ route('api.auth.reviews.save') }}" id="reviewForm">
                                <div class="modal-desc px-1">
                                    <p class="primary-text-p">
                                        {{__('Leave a Review for')}}
                                        <span> {{ translate($order->supplier->supplier_name) }}</span>
                                    </p>
                                    <div class="sup-img-desc-row d-flex flex-wrap">
                                        <div class="supp-img-block">
                                            <img
                                                src="{!! imageUrl(url($order->supplier->image_url), 75, 75, 100, 1) !!}"
                                                alt="sup-img" class="img-fluid sup-img">
                                        </div>
                                        <div class="sup-desc-block d-flex flex-column justify-content-between">
                                            <div class="titles-block">
                                                <h4 class="title">
                                                    {{ translate($order->supplier->supplier_name) }}
                                                </h4>
                                                <p class="p-text">
                                                    {!! $order->supplier->category ? translate($order->supplier->category->name) : 'N/A' !!}
                                                </p>
                                            </div>
                                            <input type="hidden" name="id" value="{{ $order->rateSupplier[0]->id }}">
                                            <div class="ratting-starts-block">
                                                <div class="d-flex align-items-center">
                                                    <fieldset class="rate">
                                                        <input type="radio" id="rating-5" name="rating" value="5"/>
                                                        <label for="rating-5" title="5 stars"></label>
                                                        <input type="radio" id="rating-4.5" name="rating" value="4.5"/>
                                                        <label class="half" for="rating-4.5"
                                                               title="4.5 stars"></label>
                                                        <input type="radio" id="rating-4" name="rating" value="4"/>
                                                        <label for="rating-4" title="4 stars"></label>
                                                        <input type="radio" id="rating-3.5" name="rating" value="3.5"/>
                                                        <label class="half" for="rating-3.5"
                                                               title="3.5 stars"></label>
                                                        <input type="radio" id="rating-3" name="rating" value="3"/>
                                                        <label for="rating-3" title="3 stars"></label>
                                                        <input type="radio" id="rating-2.5" name="rating"
                                                               value="3.5"/><label class="half" for="rating-2.5"
                                                                                   title="2.5 stars"></label>
                                                        <input type="radio" id="rating-2" name="rating"
                                                               value="2"/><label
                                                            for="rating-2" title="2 stars"></label>
                                                        <input type="radio" id="rating-1.5" name="rating"
                                                               value="2.5"/><label class="half" for="rating-1.5"
                                                                                   title="1.5 stars"></label>
                                                        <input type="radio" id="rating-1" name="rating"
                                                               value="1"/><label
                                                            for="rating-1" title="1 star"></label>
                                                        <input type="radio" id="rating-0.5" name="rating"
                                                               value="0.5"/><label class="half" for="rating-0.5"
                                                                                   title="0.5 star"></label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="common-input mb-2">
                                        <label class="input-label">
                                            {{__('Describe your experience (Optional)')}}
                                        </label>
                                        <textarea class="ctm-textarea" rows="6" name="review"
                                                  placeholder="{{ __('Enter your comment here...') }}"></textarea>
                                    </div>
                                </div>
                                <div class="d-flex flex-wrap">
                                    <div class="px-1 w-50">
                                        <button data-dismiss="modal" data-target="#rate-supplier-modal"
                                                class="secondary-btn border-btn mw-100">
                                            {{__('Cancel')}}
                                        </button>
                                    </div>
                                    <div class="px-1 w-50">
                                        <button class="secondary-btn mw-100">
                                            {{__('Submit')}}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Rate Service Modal -->
    @if ($order->rateService->isNotEmpty())
        <div class="modal fade feature-packages-modal order-cancel-mdl rating-modal" id="rate-service-modal"
             tabindex="-1"
             role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="packages-box">
                        <div class="headline-box">
                            {{__('Rate Service')}}
                        </div>
                        <div class="innner-sec">
                            <form action="{{ route('api.auth.reviews.save') }}" id="reviewServiceForm">
                                <div class="modal-desc px-1">
                                    <p class="primary-text-p">
                                        {{__('Leave a Review for')}}
                                        <span> {!! translate($order->service_name) !!}</span>
                                    </p>
                                    <div class="sup-img-desc-row d-flex flex-wrap">
                                        <div class="service-img-block">
                                            <img src="{!! imageUrl(url($order->image), 123, 65, 100, 1) !!}"
                                                 alt="sup-img" class="img-fluid sup-img">
                                        </div>
                                        <div class="sup-desc-block d-flex flex-column justify-content-between">
                                            <div class="titles-block">
                                                <p class="p-text">
                                                    {{__('How would you rate the service?')}}
                                                </p>
                                            </div>
                                            <input type="hidden" name="id" value="{{ $order->rateService[0]->id }}">
                                            <div class="ratting-starts-block">
                                                <div class="d-flex align-items-center">
                                                    <fieldset class="rate">
                                                        <input type="radio" id="s-rating-5" name="rating" value="5"/>
                                                        <label for="s-rating-5" title="5 stars"></label>
                                                        <input type="radio" id="s-rating-4.5" name="rating"
                                                               value="4.5"/>
                                                        <label class="half" for="s-rating-4.5"
                                                               title="4.5 stars"></label>
                                                        <input type="radio" id="s-rating-4" name="rating" value="4"/>
                                                        <label for="s-rating-4" title="4 stars"></label>
                                                        <input type="radio" id="s-rating-3.5" name="rating"
                                                               value="3.5"/>
                                                        <label class="half" for="s-rating-3.5"
                                                               title="3.5 stars"></label>
                                                        <input type="radio" id="s-rating-3" name="rating" value="3"/>
                                                        <label for="s-rating-3" title="3 stars"></label>
                                                        <input type="radio" id="s-rating-2.5" name="rating"
                                                               value="3.5"/><label class="half" for="s-rating-2.5"
                                                                                   title="2.5 stars"></label>
                                                        <input type="radio" id="s-rating-2" name="rating"
                                                               value="2"/><label
                                                            for="s-rating-2" title="2 stars"></label>
                                                        <input type="radio" id="s-rating-1.5" name="rating"
                                                               value="2.5"/><label class="half" for="s-rating-1.5"
                                                                                   title="1.5 stars"></label>
                                                        <input type="radio" id="s-rating-1" name="rating"
                                                               value="1"/><label
                                                            for="s-rating-1" title="1 star"></label>
                                                        <input type="radio" id="s-rating-0.5" name="rating"
                                                               value="0.5"/><label class="half" for="s-rating-0.5"
                                                                                   title="0.5 star"></label>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="common-input mb-2">
                                        <label class="input-label">
                                            {{__('Describe your experience (Optional)')}}
                                        </label>
                                        <textarea class="ctm-textarea" rows="6" name="review"
                                                  placeholder="{{ __('Enter your comment here...') }}"></textarea>
                                    </div>
                                </div>
                                <div class="d-flex flex-wrap">
                                    <div class="px-1 w-50">
                                        <button data-dismiss="modal" data-target="#rate-service-modal"
                                                class="secondary-btn border-btn mw-100">
                                            {{__('Cancel')}}
                                        </button>
                                    </div>
                                    <div class="px-1 w-50">
                                        <button class="secondary-btn mw-100">
                                            {{__('Submit')}}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="modal fade feature-packages-modal order-cancel-mdl" id="order-cancel-modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="packages-box">
                    <div class="headline-box">
                        {{__('Order Cancellation')}}
                    </div>
                    <form action="{!! route('front.dashboard.order.cancel', $order->id) !!}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $order->id }}">
                        <input type="hidden" name="status" id="status" value="cancelled">
                        <div class="innner-sec">
                            <p class="primary-text-p px-1 mb-2">
                                {{__('Are you sure you want to cancel your current Order')}}
                                <span>(Order#{{ $order->order_number }})?</span>
                            </p>
                            <div class="d-flex flex-wrap">
                                <div class="px-1 w-50">
                                    <button class="secondary-btn border-btn mw-100" type="button" class="close"
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
    <div class="modal fade feature-packages-modal order-cancel-mdl" id="order-in-progress-modal" tabindex="-1"
         role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="packages-box">
                    <div class="headline-box">
                        {{__('Order In Progress')}}
                    </div>
                    <form action="{!! route('front.dashboard.order.in-progress', $order->id) !!}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $order->id }}">
                        <input type="hidden" name="status" id="status" value="in-progress">
                        <div class="innner-sec">
                            <p class="primary-text-p px-1 mb-2">
                                {{__('Are you sure you want to make your current Order In Progress')}}
                                <span>(Order#{{ $order->order_number }})?</span>
                            </p>
                            <div class="d-flex flex-wrap">
                                <div class="px-1 w-50">
                                    <button class="secondary-btn border-btn mw-100" type="button" class="close"
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
    <div class="modal fade feature-packages-modal order-cancel-mdl" id="order-complete-modal" tabindex="-1"
         role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="packages-box">
                    <div class="headline-box">
                        {{__('Order In Progress')}}
                    </div>
                    <form action="{!! route('front.dashboard.order.complete', $order->id) !!}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $order->id }}">
                        <input type="hidden" name="status" id="status" value="completed">
                        <div class="innner-sec">
                            <p class="primary-text-p px-1 mb-2">
                                {{__('Are you sure you want to complete current Order')}}
                                <span>({{__('Order#')}}{{ $order->order_number }})?</span>
                            </p>
                            <div class="d-flex flex-wrap">
                                <div class="px-1 w-50">
                                    <button class="secondary-btn border-btn mw-100" type="button" class="close"
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
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('#reviewForm').validate({
                ignore: '',
                rules: {
                    rating: {
                        required: true
                    },
                },
                errorPlacement: function (error, element) {
                    //Custom position: first name
                    if (element.attr("name") == "rating") {
                        error.insertAfter(element.parent().parent().parent());
                    } else {
                        error.insertAfter(element.parent());
                    }
                },
            });
            $(`#reviewForm`).submit(function (e) {
                $(`input[name='rating']`).val();
                if ($(this).valid()) {
                    if ('' == window.Laravel.user_token) {
                        e.preventDefault();
                        window.location.href = "{{ route('front.auth.login') }}";
                    }
                    e.preventDefault();
                    console.log($(this).serialize(), window.Laravel.user_token);
                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: $(this).serialize(),
                        headers: {
                            Authorization: window.Laravel.user_token,
                        },
                        success: function (data) {
                            if (data.success == true) {
                                toastr.success(data.message);
                                window.location.reload();
                            } else {
                                toastr.error(data.message);
                            }
                        }
                    });
                }
            });

            $('#reviewServiceForm').validate({
                ignore: '',
                rules: {
                    rating: {
                        required: true
                    },
                },
                errorPlacement: function (error, element) {
                    //Custom position: first name
                    if (element.attr("name") == "rating") {
                        error.insertAfter(element.parent().parent().parent());
                    } else {
                        error.insertAfter(element.parent());
                    }
                },
            });
            $(`#reviewServiceForm`).submit(function (e) {
                $(`input[name='rating']`).val();
                if ($(this).valid()) {
                    if ('' == window.Laravel.user_token) {
                        e.preventDefault();
                        window.location.href = "{{ route('front.auth.login') }}";
                    }
                    e.preventDefault();
                    console.log($(this).serialize(), window.Laravel.user_token);
                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: $(this).serialize(),
                        headers: {
                            Authorization: window.Laravel.user_token,
                        },
                        success: function (data) {
                            if (data.success == true) {
                                toastr.success(data.message);
                                window.location.reload();
                            } else {
                                toastr.error(data.message);
                            }
                        }
                    });
                }
            });
        });
    </script>
    <script>
        // Set the date we're counting down to
        var time = '<?php echo date('F d,Y H:i:s', strtotime('+' . config('settings.cancel_duration') . 'minutes', $order->updated_at)); ?>';
        // times='<?php echo date('F d,Y h:i:s', $order->created_at); ?>';


        var countDownDate = new Date(time).getTime();

        // Update the count down every 1 second
        var x = setInterval(function () {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Output the result in an element with id="demo"
            document.getElementById("time").innerHTML =
                minutes + ":" + seconds;

            // If the count down is over, write some text
            if (distance < 0) {
                clearInterval(x);
                $('#cancel').hide();
            }
        }, 1000);

        function generatePDF() {
            let id = '{{ $order->id }}';
            console.log(id)
            $.ajax({
                url: window.Laravel.apiUrl + 'print/invoice/' + id,
                headers: {
                    'Authorization': window.Laravel.user_token
                },
                beforeSend: function () {
                    $(".link-loader").show();
                },
                success: function (data) {
                    console.log("this is the response from generate pdf", data);
                    if (data.success == true) {
                        var url = window.Laravel.base + data.data;
                        window.open(url, '_blank');
                    } else {
                        toastr.error(data.data);
                    }
                },
                complete: function () {
                    $(".link-loader").hide();
                },
            });
        }

        function sendInvoice() {
            let id = "{{ $order->id }}";
            $.ajax({
                url: window.Laravel.apiUrl + 'send/invoice/' + id,
                headers: {
                    'Authorization': window.Laravel.user_token
                },
                beforeSend: function () {
                    $(".link-loader").show();
                },
                success: function (data) {
                    console.log("this is the response from generate pdf", data);
                    if (data.success == true) {
                        toastr.success(data.message);
                    } else {
                        toastr.error(data.message);
                    }
                },
                complete: function () {
                    $(".link-loader").hide();
                },
            });
        }
    </script>
@endpush
