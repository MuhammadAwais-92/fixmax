@section('content')
    @include('front.common.breadcrumb')
    <main class="manage-orders spacing-y">
        <div class="container">
            <div class="row">
                @include('front.dashboard.common.left-sidebar')
                <div class="col-xl-9 col-lg-8">
                    <div class="order-detail-content">
                        <!-- order details -->
                        <div class="order-title-row d-flex justify-content-between align-items-start flex-wrap">
                            <div class="order-title-block mw-55 mw-lg-100">
                                <h3 class="title">
                                    Quotation#{{ $quotation->order_number }}
                                </h3>
                                <div class="order-place-date d-flex flex-wrap">
                                    <span>Placement Time:</span> <span class="date"
                                        dir="ltr">{{ date('m/d/Y h:i A', $quotation->created_at) }}
                                    </span>
                                </div>
                                <div class="order-place-date d-flex flex-wrap">
                                    <span>Scheduled Time:</span> <span class="date"
                                        dir="ltr">{{ date('m/d/Y', $quotation->date) }}
                                        {{ $quotation->time }}</span>
                                </div>
                                <div class="order-status d-flex flex-wrap">
                                    @if ($quotation->status == 'rejected')
                                        <span>Status:</span><span class="status-val cancl">Cancelled</span>
                                    @elseif($quotation->status == 'confirmed')
                                        <span>Status:</span><span class="status-val acept">Accepted</span>
                                        @elseif($quotation->status == 'visited')
                                        <span>Status:</span><span class="status-val visit">Visited</span>
                                        @elseif($quotation->status == 'quoted')
                                        <span>Status:</span><span class="status-val quote">Quoted</span>
                                    @else
                                        <span>Status:</span><span
                                            class="status-val pend">{{ ucfirst($quotation->status) }}</span>
                                    @endif
                                </div>
                            </div>
                            @if ($quotation->isPending())
                                @if ($userData->isUser())
                                    <div class="d-flex align-items-end flex-column mt-3 mt-xl-0 user-order-dt-block">
                                        <div class="dropdown invoice-dd">
                                            <button class="secondary-btn d-flex align-items-center" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <span class="mx-05">Invoice</span> <img
                                                    src="{{ asset('assets/front/img/arrow-down.svg') }}" alt="arrow-down"
                                                    class="img-fluid arrow-down">
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="">
                                                <a class="dropdown-item" onclick="generatePDF()"
                                                    href="javascript:void(0)">View Invoice</a>
                                                <a class="dropdown-item" onclick="sendInvoice()"
                                                    href="javascript:void(0)">Send Invoice</a>
                                            </div>
                                        </div>
                                        <button id="reject" data-toggle="modal" data-target="#quotation-reject-modal"
                                            class="secondary-btn w-100 mt-1">
                                            Cancel Order (Time Left: <span id="time"></span>)
                                        </button>
                                        <div class="visit-fee d-flex flex-wrap">
                                            <span class="prc"></span><span class="prc px-0"><svg id="Icon"
                                                    xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 20 20">
                                                    <path id="Icon-2" data-name="Icon"
                                                        d="M13.375,3.375a10,10,0,1,0,10,10A10,10,0,0,0,13.375,3.375Zm.913,14.615H12.452V11.063h1.837Zm-.918-7.683a.96.96,0,1,1,1-.962A.964.964,0,0,1,13.37,10.308Z"
                                                        transform="translate(-3.375 -3.375)" fill="#022c44" />
                                                </svg>
                                                <span>Awaiting Supplier Response</span></span>

                                        </div>
                                    </div>
                                @else
                                    <div class="ctm-btnz-block d-flex flex-wrap mt-3 mt-xl-0 flex-cloumn mw-20">
                                        <div class="dropdown invoice-dd w-100">
                                            <button class="secondary-btn d-flex align-items-center" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <span class="mx-05">Invoice</span> <img
                                                    src="{{ asset('assets/front/img/arrow-down.svg') }}" alt="arrow-down"
                                                    class="img-fluid arrow-down">
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="">
                                                <a class="dropdown-item" onclick="generatePDF()"
                                                    href="javascript:void(0)">View Invoice</a>
                                                <a class="dropdown-item" onclick="sendInvoice()"
                                                    href="javascript:void(0)">Send Invoice</a>
                                            </div>
                                        </div>


                                            <button class="secondary-btn border-btn mw-100 my-1" data-toggle="modal"
                                                data-target="#quotation-reject-modal">
                                                Cancel
                                            </button>

                                            <span class="clock"
                                                data-countdown="{{ $quotation->created_at }}"></span>


                                            <button class="secondary-btn mw-100" data-toggle="modal"
                                                data-target="#visit-modal">
                                                Visit
                                            </button>

                                    </div>
                                @endif
                            @endif
                            @if ($quotation->isVisited())
                                @if ($userData->isUser())
                                    <div class="d-flex align-items-center justify-content-end mt-3 mt-xl-0 awaiting-title">
                                        <svg id="Icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 20 20">
                                            <path id="Icon-2" data-name="Icon"
                                                d="M13.375,3.375a10,10,0,1,0,10,10A10,10,0,0,0,13.375,3.375Zm.913,14.615H12.452V11.063h1.837Zm-.918-7.683a.96.96,0,1,1,1-.962A.964.964,0,0,1,13.37,10.308Z"
                                                transform="translate(-3.375 -3.375)" fill="#022c44" />
                                        </svg>
                                        <span>Awaiting Supplier Response</span>
                                    </div>
                                @else
                                    <div class="ctm-btnz-block d-flex flex-wrap mt-3 mt-xl-0">

                                        <div class="w-50 pl-05">
                                            <button class="secondary-btn mw-100" data-toggle="modal"
                                                data-target="#send-response-modal">
                                                Send Response
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            @endif
                            @if ($quotation->isQuoted())
                                @if ($userData->isUser())
                                    <div class="d-flex align-items-end flex-column mt-3 mt-xl-0">
                                        <a href="{{ route('front.dashboard.service.checkout', $quotation->id) }}"
                                            class="secondary-btn btn-17 w-100">
                                            Accept and Pay
                                        </a>
                                    </div>
                                @else
                                @endif
                            @endif
                        </div>
                        <!-- issue image -->
                        <div class="issue-block">
                            <h4 class="title">
                                Issue Image
                            </h4>
                            <div class="d-flex flex-wrap">
                            @foreach ($quotation->issue_images as $image)
                                <div class="issue-img-block mr-1">
                                    <img src="{!! imageUrl(url($image), 185, 124, 100, 1) !!}" alt="issue-img" class="img-fluid issue-img">
                                </div>
                            @endforeach
                            </div>
                            <div class="desc-block mb-1">
                                <h5 class="title-sm">
                                    Coments
                                </h5>
                                <p class="p-text">
                                    {{ $quotation->order_notes }}
                                </p>
                            </div>
                            <div class="desc-block">
                                <h5 class="title-sm">
                                    Selected Option
                                </h5>
                                @if ($quotation->issue_type == 'know')
                                    <p class="p-text">
                                        "I know the issue"
                                    </p>
                                @else
                                    <p class="p-text">
                                        "I do not know the issue"
                                    </p>
                                @endif
                            </div>
                        </div>
                        <!-- payement method -->
                        <div class="payment-block py-bb">
                            <h3 class="my-title">
                                Payment Method
                            </h3>
                            <h5 class="my-sm-title">
                                Paypal
                            </h5>
                        </div>
                        <!-- address block -->
                        <div class="address-block py-bb">
                            <h3 class="my-title">
                                Address
                            </h3>
                            <h5 class="my-sm-title">

                                {{ $quotation->address['address_name'] }}

                            </h5>
                            <p class="primary-text-p">
                                {{ $quotation->address['address'] }}

                            </p>
                            <p class="primary-text-p mb-0" dir="ltr">
                                {{ $quotation->address['user_phone'] }}

                            </p>

                        </div>
                        @if ($userData->isUser())
                            <!-- supplier -->
                            <div class="user-info-block py-bb service-block">
                                <h3 class="my-title mb-1">
                                    Supplier
                                </h3>
                                <div class="user-info-row d-flex flex-wrap">
                                    <div class="sup-img-block">
                                        <img src="{!! imageUrl(url($quotation->supplier->image_url), 75, 75, 100, 1) !!}" alt="user-img" class="img-fluid user-img">
                                    </div>
                                    <div class="user-desc desc-block">
                                        <div class="d-flex">
                                            <div class="star-rating-area">
                                                <div class="rating-static clearfix" rel="{{ round(getStarRating($quotation->supplier->rating), 1) }}">
                                                    <label class="full" title="Awesome - 5 stars"></label>
                                                    <label class="half" title="Pretty good - 4.5 stars"></label>
                                                    <label class="full" title="Pretty good - 4 stars"></label>
                                                    <label class="half" title="Meh - 3.5 stars"></label>
                                                    <label class="full" title="Meh - 3 stars"></label>
                                                    <label class="half" title="Kinda bad - 2.5 stars"></label>
                                                    <label class="full" title="Kinda bad - 2 stars"></label>
                                                    <label class="half" title="Meh - 1.5 stars"></label>
                                                    <label class="full" title="Sucks big time - 1 star"></label>
                                                    <label class="half"
                                                        title="Sucks big time - 0.5 stars"></label>
                                                </div>
                                                <div class="ratilike ng-binding">({{number_format($quotation->supplier->rating,1)}})</div>
                                            </div>
                                        </div>
                                        <div class="user-name">
                                            {{ translate($quotation->supplier->supplier_name) }}
                                        </div>
                                        <p class="user-no">
                                            {!! translate($quotation->supplier->category->name) !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- user information -->
                            <div class="user-info-block py-bb">
                                <h3 class="my-title mb-1">
                                    User Information
                                </h3>
                                <div class="user-info-row d-flex flex-wrap">
                                    <div class="info-img-block">
                                        <img src="{!! imageUrl(url($quotation->user->image_url), 75, 75, 100, 1) !!}" alt="user-img" class="img-fluid user-img">
                                    </div>
                                    <div class="user-desc">
                                        <div class="user-name">
                                            {{ $quotation->user->user_name }}
                                        </div>
                                        <p class="user-no" dir="ltr">
                                            {{ $quotation->user->phone }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <!-- services details -->
                        <div class="service-block py-bb">
                            <h3 class="my-title mb-1">
                                Service Details
                            </h3>
                            <div class="services-row d-flex flex-wrap">
                                <div class="img-block">
                                    @if (str_contains($quotation->image, '.mp4') || str_contains($quotation->image, '.mov'))
                                        <video width="123" height="65" controls muted>
                                            <source src="{{ $quotation->image }}" class="img-fluid"
                                                type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @else
                                        <img src="{!! imageUrl(url($quotation->image), 123, 65, 100, 1) !!}" alt="user-img" class="img-fluid user-img">
                                    @endif
                                </div>
                                <div class="desc-block">
                                    <div class="d-flex">
                                        <div class="star-rating-area">
                                            <div class="rating-static clearfix" rel="{{ round(getStarRating($quotation->serviceRating->average_rating), 1) }}">
                                                <label class="full" title="Awesome - 5 stars"></label>
                                                <label class="half" title="Pretty good - 4.5 stars"></label>
                                                <label class="full" title="Pretty good - 4 stars"></label>
                                                <label class="half" title="Meh - 3.5 stars"></label>
                                                <label class="full" title="Meh - 3 stars"></label>
                                                <label class="half" title="Kinda bad - 2.5 stars"></label>
                                                <label class="full" title="Kinda bad - 2 stars"></label>
                                                <label class="half" title="Meh - 1.5 stars"></label>
                                                <label class="full" title="Sucks big time - 1 star"></label>
                                                <label class="half" title="Sucks big time - 0.5 stars"></label>
                                            </div>
                                            <div class="ratilike ng-binding">({{number_format($quotation->serviceRating->average_rating,1)}})</div>
                                        </div>
                                    </div>
                                    <div class="text-p">
                                        {!! translate($quotation->service_name) !!}
                                    </div>
                                    <h4 class="serv-price d-flex">
                                        <span>AED {!! $quotation->min_price !!}</span> - <span>AED {!! $quotation->max_price !!}</span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <!-- Select Equipments -->

                        @if ($quotation->issue_type == 'know' || ($quotation->quoated_price !== null && $quotation->issue_type == 'not know'))
                            <div class="service-block py-bb">
                                @if ($quotation->quoated_price)
                                    <h3 class="my-title mb-0">
                                        Quotation Response
                                    </h3>
                                    <div class="visit-fee d-flex flex-wrap mb-14">
                                        <span class="px-0">Service Price:</span><span class="prc mx-05">AED
                                            {{ $quotation->quoated_price }}</span>
                                    </div>
                                @endif
                                @if ($quotation->orderItems->isNotEmpty())

                                    <h3 class="my-title mb-1">
                                        Selected Equipment(s)
                                    </h3>


                                    @foreach ($quotation->orderItems as $item)
                                        <div class="services-row d-flex flex-wrap">
                                            <div class="img-block">
                                                <img src="{!! imageUrl(url($item->image), 123, 65, 100, 1) !!}" alt="user-img"
                                                    class="img-fluid user-img">
                                            </div>
                                            <div class="desc-block">

                                                <div class="d-flex flex-wrap align-items-center gap-3x">
                                                <h4 class="serv-price d-flex">
                                                    <span>AED{{ $item->price }}</span>
                                                </h4>
                                                <div class="text-p mb-0">
                                                    <p class="px-05">
                                                        (<span
                                                            class="pr-05">Qty:</span><span>{{ $item->quantity }}</span>)
                                                    </p>
                                                </div>
                                                </div>
                                                <div class="text-p">
                                                    <p>{!! translate($item->name) !!}</p>
                                                </div>
                                                <div class="text-p mb-0">
                                                    {!! $item->make !!} - {!! $item->equipment_model !!}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    @endif
                                @endif
                            </div>
                            @if ($quotation->status == 'confirmed')
                                    <div class="order-summary-block py-bb">
                                        <h3 class="my-title">
                                            Order Summary
                                        </h3>
                                        <div class="summary-box">

                                            <div
                                                class="title-value-row d-flex flex-wrap justify-content-between align-items-center">
                                                <div class="title">Equipment Charges</div>
                                                <div class="value">
                                                    AED {{ $quotation->subtotal }}
                                                </div>
                                            </div>


                                            <div
                                                class="title-value-row d-flex flex-wrap justify-content-between align-items-center">
                                                <div class="title">Service Charges</div>
                                                <div class="value">
                                                    AED {{ $quotation->quoated_price }}
                                                </div>
                                            </div>
                                            <div
                                                class="title-value-row d-flex flex-wrap justify-content-between align-items-center">
                                                <div class="title">VAT</div>
                                                <div class="value">
                                                    AED {{ $quotation->vat_2 }}
                                                </div>
                                            </div>
                                            <div
                                                class="title-value-row total-row d-flex flex-wrap justify-content-between align-items-center">
                                                <div class="title">Total</div>
                                                <div class="value">
                                                    AED {{ $quotation->total_amount - $quotation->amount_paid }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="order-summary-block py-bb">
                                        <h3 class="my-title">
                                            Order Summary
                                        </h3>
                                        <div class="summary-box">
                                            @if ($quotation->issue_type == 'know')
                                                <div
                                                    class="title-value-row d-flex flex-wrap justify-content-between align-items-center">
                                                    <div class="title">Equipment Charges</div>
                                                    <div class="value">
                                                        AED {{ $quotation->subtotal }}
                                                    </div>
                                                </div>
                                            @endif
                                            <div
                                                class="title-value-row d-flex flex-wrap justify-content-between align-items-center">
                                                <div class="title">Visit Fee</div>
                                                <div class="value">
                                                    AED {{ $quotation->visit_fee }}
                                                </div>
                                            </div>

                                            <div
                                                class="title-value-row d-flex flex-wrap justify-content-between align-items-center">
                                                <div class="title">VAT</div>
                                                <div class="value">
                                                    AED {{ $quotation->vat_1 }}
                                                </div>
                                            </div>
                                            <div
                                                class="title-value-row total-row d-flex flex-wrap justify-content-between align-items-center">
                                                <div class="title">Total</div>
                                                <div class="value">
                                                    AED {{ $quotation->total_amount }}
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
    <div class="modal fade feature-packages-modal order-cancel-mdl" id="quotation-reject-modal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="packages-box">
                    <div class="headline-box">
                        Quotation Cancellation
                    </div>
                    <form action="{!! route('front.dashboard.quotation.reject', $quotation->id) !!}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $quotation->id }}">
                        <input type="hidden" name="status" id="status" value="rejected">
                        <div class="innner-sec">
                            <p class="primary-text-p px-1 mb-2">
                                Are you sure you want to cancel your current Order
                                <span>(Order#{{ $quotation->order_number }})?</span>
                            </p>
                            <div class="d-flex flex-wrap">
                                <div class="px-1 w-50">
                                    <button class="secondary-btn border-btn mw-100" type="button" class="close"
                                        data-dismiss="modal" aria-label="Close">
                                        No
                                    </button>
                                </div>
                                <div class="px-1 w-50">
                                    <button class="secondary-btn mw-100">
                                        Yes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="modal fade feature-packages-modal select-equipment-modal" id="quotation-reject-modal" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="packages-box">
                    <form action="{!! route('front.dashboard.quotation.reject', $quotation->id) !!}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $quotation->id }}">
                        <input type="hidden" name="status" id="status" value="rejected">
                        <div class="modal-content custom-dec-modal-all-pad">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                {{ __('Are you sure you want to reject your current quotation') }} (<span
                                    class="id-tittlee">{{ __('ID:') }} {{ $quotation->order_number }}</span>)?
                            </div>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" aria-label="Close"
                                    class="btn btn-primary">{{ __('No') }}</button>
                                <button type="submit" class="btn btn-secondary">{{ __('Yes') }}</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div> --}}
    <div class="modal fade feature-packages-modal order-cancel-mdl" id="visit-modal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="packages-box">
                    <div class="headline-box">
                        Quotation Visitation
                    </div>
                    <form action="{!! route('front.dashboard.quotation.visit', $quotation->id) !!}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $quotation->id }}">
                        <input type="hidden" name="status" id="status" value="visited">
                        <div class="innner-sec">
                            <p class="primary-text-p px-1 mb-2">
                                Are you sure you want to visited your current Order
                                <span>(Order#{{ $quotation->order_number }})?</span>
                            </p>
                            <div class="d-flex flex-wrap">
                                <div class="px-1 w-50">
                                    <button class="secondary-btn border-btn mw-100" type="button" class="close"
                                        data-dismiss="modal" aria-label="Close">
                                        No
                                    </button>
                                </div>
                                <div class="px-1 w-50">
                                    <button class="secondary-btn mw-100">
                                        Yes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="modal fade feature-packages-modal select-equipment-modal" id="visit-modal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="packages-box">
                    <form action="{!! route('front.dashboard.quotation.visit', $quotation->id) !!}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $quotation->id }}">
                        <input type="hidden" name="status" id="status" value="visited">
                        <div class="modal-content custom-dec-modal-all-pad">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                {{ __('Are you sure you want to visited your current quotation') }} (<span
                                    class="id-tittlee">{{ __('ID:') }} {{ $quotation->order_number }}</span>)?
                            </div>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" aria-label="Close"
                                    class="btn btn-primary">{{ __('No') }}</button>
                                <button type="submit" class="btn btn-secondary">{{ __('Yes') }}</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div> --}}
    <!-- select equipment Modal -->
    <div class="modal fade feature-packages-modal select-equipment-modal" id="select-equipment-modal" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="packages-box">
                    <div class="headline-box">
                        Select Equipment(s)
                    </div>
                    <div class="innner-sec">
                        <div class="container">
                            <form id="equipment-form">
                                <div class="equipment-card-sec">
                                    <div class="row">
                                        @if ($quotation->service)
                                            @forelse ($quotation->service->equipments as $equipment)
                                                <div class="col-sm-6 col-6-ctm px-1">
                                                    <div class="portfolio-add-card">
                                                        <div class="check-box">
                                                            <label class="custom-check">
                                                                <input type="checkbox" value="{{ $equipment->id }}"
                                                                    class="equipment-check" name="equipment[]">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </div>
                                                        <div class="img-add-del-btn">
                                                            <div class="img-block">
                                                                <img src="{!! imageUrl(url($equipment->image_url), 246, 150, 100, 1) !!}" alt="portfolio-img"
                                                                    class="img-fluid portfolio-img">
                                                            </div>
                                                        </div>
                                                        <h3 class="price text-truncate">
                                                            AED{{ $equipment->price }}
                                                        </h3>
                                                        <h3 class="title text-truncate">
                                                            {{ translate($equipment->name) }}
                                                        </h3>
                                                        <h3 class="title text-truncate">
                                                            {{ $equipment->equipment_model }} - {{ $equipment->make }}
                                                        </h3>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="alert alert-danger w-100" role="alert">
                                                    No Equipment Found
                                                </div>
                                            @endforelse
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 px-sm-1 px-2">
                                        <button class="login-btn w-100">
                                            Select
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Send Response 2 Modal -->
    <div class="modal fade feature-packages-modal response-modal" id="send-response-modal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="packages-box">
                    <div class="headline-box">
                        Send Response
                    </div>
                    <div class="innner-sec">
                        <form action="{!! route('front.dashboard.quotation.quote') !!}" id="quotation-form" method="POST">
                            @csrf
                            <div class="price-title-row d-flex flex-wrap align-items-center">
                                <span>Service Price Range:</span> <strong>AED{!! $quotation->min_price !!} -
                                    AED{!! $quotation->max_price !!}</strong>
                            </div>
                            <div class="common-input">
                                <label class="input-label">Price <span class="text-danger">*</span></label>
                                <input type="text" minlength="1" min="1" name="quoated_price"
                                    value="{{ old('quoated_price', request()->get('quoated_price')) }}"
                                    placeholder="AED100" required>
                                @include('front.common.alert', ['input' => 'quoated_price'])
                            </div>
                            <input type="hidden" name="id" value="{{ $quotation->id }}">
                            <input type="hidden" name="status" id="status" value="quoted">
                            <input type="hidden" name="issue_type" value="{!! $quotation->issue_type !!}">
                            <input type="hidden" name="min_price" value="{!! $quotation->min_price !!}">
                            <input type="hidden" name="max_price" value="{!! $quotation->max_price !!}">
                            <div class="add-equipment-block xy">
                                <div class="equip-link-row d-flex justify-content-between align-items-center flex-wrap">
                                    <h4 class="title">
                                        Selected Equipment
                                    </h4>
                                    <span class="link-s">
                                        (<a data-toggle="modal" data-target="#select-equipment-modal" href="#"
                                            class="add-eq-link">Add Equipment </a>)
                                    </span>
                                </div>
                            </div>
                            <div class="primary-text-p mb-25 xy">
                                Click "Add Equipment" to add the required equipment.
                            </div>
                            @include('front.common.alert', ['input' => 'equipment'])
                            <div id="equipment-datas">
                                <div class="add-equipment-block">
                                    <div
                                        class="equip-link-row mb-2 d-flex justify-content-between align-items-center flex-wrap">
                                        <h4 class="title">
                                            Selected Equipment
                                        </h4>
                                        <span class="link-s">
                                            (<a data-toggle="modal" data-target="#select-equipment-modal" href="#"
                                                class="add-eq-link">Add Equipment</a>)
                                        </span>
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="row" id="equipment-data">

                                    </div>
                                </div>

                            </div>
                            <button class="login-btn w-100">
                                Submit
                            </button>
                        </form>
                    </div>
                    @php
                        $old = '';
                        $old = old('equipment');
                        $quantity = '';
                        $quantity = old('quantity');
                    @endphp
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        // Set the date we're counting down to
        var time = '<?php echo date('F d,Y H:i:s', strtotime('+' . config('settings.cancel_duration') . 'minutes', $quotation->created_at)); ?>';
        // times='<?php echo date('F d,Y h:i:s', $quotation->created_at); ?>';


        var countDownDate = new Date(time).getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

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
                $('#reject').hide();
            }
        }, 1000);

        function generatePDF() {
            let id = '{{ $quotation->id }}';
            console.log(id)
            $.ajax({
                url: window.Laravel.apiUrl + 'print/invoice/' + id,
                headers: {
                    'Authorization': window.Laravel.user_token
                },
                beforeSend: function() {
                    $(".link-loader").show();
                },
                success: function(data) {
                    console.log("this is the response from generate pdf", data);
                    if (data.success == true) {
                        var url = window.Laravel.base + data.data;
                        window.open(url, '_blank');
                    } else {
                        toastr.error(data.data);
                    }
                },
                complete: function() {
                    $(".link-loader").hide();
                },
            });
        }

        function sendInvoice() {
            let id = "{{ $quotation->id }}";
            $.ajax({
                url: window.Laravel.apiUrl + 'send/invoice/' + id,
                headers: {
                    'Authorization': window.Laravel.user_token
                },
                beforeSend: function() {
                    $(".link-loader").show();
                },
                success: function(data) {
                    console.log("this is the response from generate pdf", data);
                    if (data.success == true) {
                        toastr.success(data.message);
                    } else {
                        toastr.error(data.message);
                    }
                },
                complete: function() {
                    $(".link-loader").hide();
                },
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#equipment-datas').hide();
            $('#quotation-form').validate();
            approved = '<?php echo session()->has('errors'); ?>';

            if (approved) {
                $(window).on('load', function() {
                    var jArray = <?php echo json_encode($old); ?>;
                    ids = [];
                    $.each(jArray, function() {
                        ids.push(this.equipment_id); // Here 'this' points to an 'item' in 'items'
                    });
                    submitAjax(ids);

                    $('#send-response-modal').modal('show');
                    var arr = $('.equipment-check:checkbox');
                    $(".equipment-check").each(function(i, field) {
                        $(this).prop('checked', false);
                    });
                    jQuery.each(arr, function(i, field) {
                        console.log($.inArray(field.value, ids))
                        if ($.inArray(field.value, ids) != -1) {
                            $(this).prop('checked', true);
                        }
                    });
                });
            }
            $('#equipment-form').on('submit', function(e) {
                console.log('1234');
                e.preventDefault();
                str = $(this).serializeArray();
                ids = [];
                jQuery.each(str, function(i, field) {
                    ids.push(field.value);
                });
                console.log(ids);
                submitAjax(ids);
            });

            function submitAjax(ids) {
                // eids = [];
                // $(".equipment-ids").each(function(i, field) {
                //     eids.push(field.value);
                // });
                // ids = $(ids).not(eids).get();
                $.ajax({
                    url: window.Laravel.baseUrl + "equipments",
                    type: "get",
                    data: {
                        ids: ids,
                    },
                    success: function(response) {
                        $('#equipment-data').html(response.data);
                        $('#equipment-datas').show();
                        $(".xy").hide();
                        $("#select-equipment-modal").modal('hide');
                        array = <?php echo json_encode($old); ?>;
                        if (Array.isArray(array) && array.length) {
                            x = $(".add-equipment  .quantity:input");
                            console.log(x);
                            $.each(x, function(i, field) {
                                var ed = $(this).siblings('.equipment-ids').val();
                                let y = x;
                                $.each(array, function() {
                                    if (this.equipment_id === ed) {
                                        console.log(field.value = this.quantity, this
                                            .quantity);
                                        return false;
                                    }
                                });
                            });
                        }
                        $(".close-btn").on('click', function() {
                            id = $(this).siblings('.equipment-ids').val();
                            var arr = $('.equipment-check:checkbox:checked');
                            jQuery.each(arr, function(i, field) {
                                if (field.value == id) {
                                    $(this).prop('checked', false);
                                }
                            });
                            $(this).parent().parent().remove();


                        });

                    },
                });
            }
        });
    </script>
@endpush
