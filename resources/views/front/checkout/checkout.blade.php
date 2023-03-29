@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    @php
        $defaultCheckmark = 0;
        $defaultId = 0;
    @endphp
    <main class="checkout spacing-y">
        <div class="container">
            <div class="row">
                <div class="col-sm-7">
                    <div id="replaceAddress" class="check-shadow-box">
                        <h3 class="my-title">
                            {{ __('Address') }}
                        </h3>
                        @if ($cartContent->user->addresses->IsEmpty() || $check)
                            <div class="add-desc">
                                <a href="#" data-toggle="modal" data-target="#addressModal" id="address-modal"
                                    class="link-btn link-btns ">
                                    {{ __('Add New Address') }}
                                </a>
                            </div>
                            <p class="p-text">{{ __('Please add an address to continue.') }}</p>
                        @else
                            <div id="getAddressesModal" class="add-desc">
                                <a href="#" data-toggle="modal" data-target="#get-addresses-modal" class="link-btn">
                                    {{ __('Select Delivery Address') }}
                                </a>
                                {{-- <div class="add-desc" id="default-address">
                                    <h6 class="prim-title">
                                        {{ $cartContent->user->defaultAddress()->address_name }}
                                    </h6>
                                    <p class="prime-title-l">
                                        {{ $cartContent->user->defaultAddress()->address }}
                                    </p> --}}
                                    {{-- <p class="prime-title-l">
                            Jeddah
                          </p> --}}
                                    {{-- <a href="#" dir="ltr" class="prime-title-l">
                                        {{ $cartContent->user->defaultAddress()->user_phone }}
                                    </a>
                                </div> --}}
                            </div>
                        @endif
                    </div>
                    {{-- <div class="check-shadow-box">
                <div class="my-title d-flex justify-content-between align-content-center flex-wrap">
                  <h3>
                    Address
                  </h3>
                  <a href="#" class="link-btn">
                    Add New Address
                  </a>
                </div>
                <div class="add-desc">
                  <div class="d-flex flex-wrap justify-content-between align-content-center mb-1">
                    <h6 class="prim-title mb-0">
                      Home
                    </h6>
                    <div class="edit-del-btnz-block d-flex align-items-center">
                      <button class="edit-del-btn">
                        <i class="fas fa-edit"></i>
                      </button>
                      <span class="seprater"></span>
                      <button class="edit-del-btn">
                        <i class="fas fa-trash-alt"></i>
                      </button>
                    </div>
                  </div>
                  <p class="prime-title-l">
                    Building No 11, 13 Street
                  </p>
                  <p class="prime-title-l">
                    Jeddah
                  </p>
                  <a href="#" dir="ltr" class="prime-title-l">
                    +971 0000 000
                  </a>
                </div>
              </div> --}}
                    <div class="check-shadow-box mb-0 pay-method-box">
                        <h3 class="my-title">
                            {{ __('Payment Method') }}
                        </h3>
                        <div class="payment-desc d-none" id="pm">
                            <div class="radio-blocks">
                                <label class="ctm-radio custom-radio custom-radio-center-ha active">
                                    <input type="radio" id="t1">
                                    <span class="checkmark"></span>
                                    <span class="title">{{ __('Credit Card') }}</span>
                                </label>
                            </div>
                            <div class="radio-blocks">
                                <label class="ctm-radio custom-radio custom-radio-center-ha">
                                    <input type="radio" id="test3" value="paypal" class="payment_method"
                                        name="payment_method">
                                    <span class="checkmark" data-id="paypal"></span>
                                    <span class="title">{{ __('Paypal') }}</span>
                                </label>
                            </div>
                            {{-- <div class="radio-blocks">
                    <label class="ctm-radio custom-radio custom-radio-center-ha">
                      <input type="radio" value="male" id="t2" name="gender">
                      <span class="checkmark"></span>
                      <span class="title">Apple Pay</span>
                    </label>
                  </div> --}}
                        </div>
                    </div>
                    <p id="error-show" class="error mb-3"></p>
                    <div class="check-shadow-box">
                        <h3 class="my-title">
                            {{ __('Date & Time') }}
                        </h3>
                        <div class="date-time-desc">
                            <ul class="title-value-ul">
                                <li>
                                    <span>{{ __('Booked Date') }}:</span>
                                    <span class="value"
                                        dir="ltr">{{ date('d/m/Y', strtotime($cartContent->date)) }}</span>
                                </li>
                                <li>
                                    <span>{{ __('Booked Time') }}:</span>
                                    <span class="value"
                                        dir="ltr">{{ date('H:i', strtotime($cartContent->time)) }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="check-shadow-box">
                        <h3 class="my-title">
                            {{ __('Issue Image') }}
                        </h3>
                        <div class="issue-img-main">
                            @foreach ($cartContent->issue_images_url as $image)
                                <div class="issue-img-block">
                                    <img src="{!! imageUrl(url($image), 152, 120, 100, 1) !!}" alt="issue-img" class="img-fluid issue-img">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="check-shadow-box">
                        <h3 class="my-title">
                            {{ __('Requested Service') }}
                        </h3>
                        <div class="requested-service">
                            <div class="sup-type-title d-flex flex-wrap">
                                <span>{{ __('Supplier') }}:</span>
                                <span class="value">{{ translate($cartContent->service->supplier->supplier_name) }}</span>
                            </div>
                            <div class="services-row d-flex flex-wrap">
                                <div class="img-block">
                                    @if (str_contains($cartContent->service->default_image, '.mp4') ||
                                        str_contains($cartContent->service->default_image, '.mov'))
                                        <video width="174" height="92" controls muted>
                                            <source src="{{ $cartContent->service->default_image }}" class="img-fluid"
                                                type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @else
                                        <img src="{!! imageUrl(url($cartContent->service->default_image), 174, 92, 100, 1) !!}" alt="user-img" class="img-fluid user-img">
                                    @endif

                                </div>
                                <div class="desc-block">
                                    <div class="d-flex">
                                        <div class="star-rating-area">
                                            <div class="rating-static clearfix"
                                                rel="{{ round(getStarRating($cartContent->service->average_rating), 1) }}">
                                                <label class="full" title="{{ __('Awesome - 5 stars') }}"></label>
                                                <label class="half" title="{{ __('Pretty good - 4.5 stars') }}"></label>
                                                <label class="full" title="{{ __('Pretty good - 4 stars') }}"></label>
                                                <label class="half" title="{{ __('Meh - 3.5 stars') }}"></label>
                                                <label class="full" title="{{ __('Meh - 3 stars') }}"></label>
                                                <label class="half" title="{{ __('Kinda bad - 2.5 stars') }}"></label>
                                                <label class="full" title="{{ __('Kinda bad - 2 stars') }}"></label>
                                                <label class="half" title="{{ __('Meh - 1.5 stars') }}"></label>
                                                <label class="full"
                                                    title="{{ __('Sucks big time - 1 star') }}"></label>
                                                <label class="half"
                                                    title="{{ __('Sucks big time - 0.5 stars') }}"></label>
                                            </div>
                                            <div class="ratilike ng-binding">
                                                ({{ number_format($cartContent->service->average_rating, 1) }})
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-p">
                                        {{ translate($cartContent->service->name) }}
                                    </div>
                                    <h4 class="serv-price d-flex">
                                        <div class="d-flex serv-price">
                                            @if ($cartContent->service->service_type == 'offer')
                                                <span>{{ __('AED') }}{{ $cartContent->service->discounted_min_price }}</span>
                                                <span class="mx-05">-</span>
                                                <span>{{ __('AED') }}{{ $cartContent->service->discounted_max_price }}</span>
                                            @else
                                                <span>{{ __('AED') }}{{ $cartContent->service->min_price }}</span><span
                                                    class="mx-05">-</span>
                                                <span>{{ __('AED') }}{{ $cartContent->service->max_price }}</span>
                                            @endif
                                        </div>
                                    </h4>
                                </div>
                            </div>
                            @if ($cartContent->issue_type == 'know')
                                <div class="equipment-sec">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <h4 class="title">
                                            {{ __('Required Equipment(s)') }}
                                        </h4>
                                        <h4 class="title d-flex subtotal">
                                            <span
                                                class="px-05">{{ __('Subtotal') }}:</span><span>{{ __('AED') }}{{ $cartContent->total }}</span>
                                        </h4>
                                    </div>
                                    @foreach ($cartContent->equipments as $equipments)
                                        <div class="euipment-row d-flex flex-wrap">
                                            <div class="img-block">
                                                <img src="{!! imageUrl(url($equipments->equipment->image_url), 123, 75, 100, 1) !!}" alt="user-img"
                                                    class="img-fluid user-img">
                                            </div>
                                            <div class="desc-block">
                                                <h4 class="serv-price d-flex">
                                                    <span>{{ __('AED') }}{{ $equipments->equipment->price }}</span>
                                                </h4>
                                                <div class="text-p d-flex">
                                                    {{ translate($equipments->equipment->name) }} <p
                                                        class="px-05 d-flex align-items-center">(<span
                                                            class="pr-05">{{ __('Qty') }}:</span><span>{{ $equipments->quantity }}</span>)
                                                    </p>
                                                </div>
                                                <div class="text-p">
                                                    {{ $equipments->equipment->equipment_model }} -
                                                    {{ $equipments->equipment->make }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="order-summary-block">
                        <div class="summary-inner">
                            <h3 class="my-title">
                                {{ __('Order Summary') }}
                            </h3>
                            @if ($cartContent->issue_type == 'know')
                                <div class="title-val-block">
                                    <div class="title-value-row d-flex justify-content-between align-items-center">
                                        <div class="title">{{ __('Equipment Fee') }}</div>
                                        <div class="value">{{ __('AED') }} {{ round($cartContent->total, 2) }}</div>
                                    </div>
                                    <div class="title-value-row d-flex justify-content-between align-items-center">
                                        <div class="title">{{ __('Visit Fee') }}</div>
                                        <div class="value">{{ __('AED') }} {{ round($cartContent->visit_fee, 2) }}
                                        </div>
                                    </div>
                                    <div class="title-value-row d-flex justify-content-between align-items-center">
                                        <div class="title">{{ __('VAT') }}</div>
                                        <div class="value">{{ __('AED') }} {{ round($cartContent->vat, 2) }}</div>
                                    </div>
                                </div>
                            @else
                                <div class="title-val-block">
                                    <div class="title-value-row d-flex justify-content-between align-items-center">
                                        <div class="title">{{ __('Visit Fee') }}</div>
                                        <div class="value">{{ __('AED') }} {{ round($cartContent->subTotal, 2) }}
                                        </div>
                                    </div>
                                    <div class="title-value-row d-flex justify-content-between align-items-center">
                                        <div class="title">{{ __('VAT') }}</div>
                                        <div class="value">{{ __('AED') }} {{ round($cartContent->vat, 2) }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="total-row d-flex justify-content-between align-items-center">
                            <div class="title">
                                {{ __('Total') }}
                            </div>
                            <div class="to-ptice">
                                {{ __('AED') }} {{ round($cartContent->grandtotal, 2) }}
                            </div>
                        </div>
                    </div>
                    <form id="check-out-form" action="{{ route('front.checkout.cart') }}" method="post">
                        @csrf
                        <input type="hidden" name="order_notes" value="{{ $cartContent->description }}">
                        <input type="hidden" name="selected_address" id="selected_address" value="">
                        <input type="hidden" id="payment_method" name="payment_method" value="paypal">
                        <input type="hidden" id="paymentID" name="paymentID" value="">
                        <input type="hidden" id="payerID" name="payerID" value="">
                        <input type="hidden" id="orderID" name="orderID" value="">
                        <input type="hidden" id="checkout" name="checkout" value="first">
                        <input type="hidden" id="paymentToken" name="paymentToken" value="">
                        <input type="hidden" id="serviceId" name="service_id" value="{{ $cartContent->service->id }}">
                        <input type="hidden" id="selected_total" name="selected_total"
                            value="{{ $cartContent->grandtotal }}">
                        <input type="hidden" id="selected_address_price_input" name="selected_address_price_input"
                            value="">
                        <input type="hidden" id="paypal_input" name="paypal_input" value="">
                        <input type="hidden" id="returnUrl" name="returnUrl" value="">
                        <input type="hidden" name="make_checked" value="{{ old('make_checked') }}">
                        <input type="hidden" name="order_type" value="{{ $cartContent->issue_type }}">
                        <div class="btn-lg btn-col" disabled id="paypal-button">
                        </div>
                    </form>
                    <button type="button" class="check-out js-check-out-btn secondary-btn mw-100" id="book-service">
                        {{ __('Request Service') }}
                    </button>
                </div>
            </div>
        </div>
    </main>
    <div class="modal fade feature-packages-modal order-cancel-mdl not_show" id="get-addresses-modal" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="packages-box">
                    <div class="headline-box">
                        {{ __('Add Delivery Address') }}
                    </div>
                    <div class="innner-sec" id="addresses-form">

                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade feature-packages-modal " id="addressModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="packages-box">

                    <form method="POST" action="{{ route('front.dashboard.address.store') }}"
                        id="shipping-address-form1">
                        @csrf
                        <div class="headline-box" id="heading">
                            {{ __('Add Address') }}
                        </div>
                        <input type="text" class="ctm-input" hidden name="user_id" value="{{ auth()->user()->id }}"
                            id="edit-username">
                        <input type="text" class="ctm-input" hidden name="id" value="0" id="edit-id">
                        <div class="innner-sec">
                            <div class="common-input">
                                <label class="input-label">{{ __('Address Name') }} <span class="text-danger">*</label>
                                <input type="text" name="address_name" required
                                    placeholder="{{ __('Enter Address Name') }}" id="edit-name">
                            </div>
                            <div class="common-input">
                                <label class="input-label">{{ __('Phone no') }} <span class="text-danger">*</label>
                                <input type="text" id="supplier-phone" type="tel" name="user_phone"
                                    placeholder="{{ __('Enter Phone no') }}" required autocomplete="off" minlength="11"
                                    maxlength="14">
                            </div>
                            <div class="common-input">
                                <label class="input-label">{{ __('City') }} <span class="text-danger">*</span></label>
                                <select class="js-example-basic-single" name="city_id" id="city" required>
                                    <option value="">{{ __('e.g Ajman') }}</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}">
                                            {!! translate($city->name) !!}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="common-input" id="area_div">
                                <label class="input-label">{{ __('Area') }} <span class="text-danger">*</span></label>
                                <select class="js-example-basic-single" name="area_id" id="area" required>


                                </select>
                            </div>
                            <div class="common-input area-map">
                                <label class="input-label"> {{ __('Address') }} <span
                                        class="text-danger">*</span></label>
                                <div data-target="#mapModal" data-toggle="modal" class="type-pass address-field">
                                    <input type="text" name="address" value="{{ old('address') }}"
                                        class="ctm-input address" placeholder="{{ __('Select address from map') }}" readonly required
                                        id="address">
                                </div>
                                <input type="hidden" name="latitude" id="latitude" class="latitude"
                                    value="{{ old('latitude') }}">
                                <input type="hidden" name="longitude" id="longitude" class="longitude"
                                    value="{{ old('longitude') }}">

                                </select>
                            </div>
                            <div class="common-input area-map">
                                <div id="map" style="height: 400px;position: relative;overflow: hidden;">
                                </div>
                            </div>
                            <div class="d-flex flex-wrap">
                                <div class="px-1 w-50">
                                    <button type="submit" id="areabutton" class="secondary-btn mw-100">
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                                <div class="px-1 w-50">
                                    <button type="button" class="secondary-btn border-btn mw-100" type="button"
                                        class="close" data-dismiss="modal" aria-label="Close">
                                        {{ __('Cancel') }}
                                    </button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade feature-packages-modal order-cancel-mdl not_show" id="add-address-modal" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="packages-box">
                    <div class="headline-box">
                        {{ __('Add New Address') }}
                    </div>
                    <div class="innner-sec">
                        <form id="AddAddressForm">
                            @csrf
                            <div class="common-input">
                                <label class="input-label">{{ __('Address') }} <span class="text-danger">*</span></label>
                                <div class="password-input-box">
                                    <input type="text" name="address" id="address" value="" class="address"
                                        placeholder="{{ __('e.g Al-Ain') }}" readonly data-target="#register-map-model"
                                        data-toggle="modal" data-latitude="latitude" data-longitude="longitude"
                                        data-address="address" required>
                                    <button type="button" class="address-icon" data-target="#register-map-model"
                                        data-toggle="modal" data-latitude="latitude" data-longitude="longitude"
                                        data-address="address"><i class="fas fa-map-marker-alt"></i></button>
                                    <input type="hidden" name="latitude" id="latitude" class="latitude"
                                        value="">
                                    <input type="hidden" name="longitude" id="longitude" class="longitude"
                                        value="">
                                </div>
                            </div>
                            <input type="hidden" id="user_id" name="user_id"
                                value="{{ auth()->user()->id ?? '' }}">
                            <input type="hidden" name="id" id="addressId" value="">
                            <div class="common-input">
                                <label class="input-label">{{ __('Address Name') }} <span
                                        class="text-danger">*</span></label>
                                <div class="password-input-box">
                                    <input name="address_name" id="address_name" value="" type="text"
                                        placeholder="{{ __('e.g Home') }}" required>
                                </div>
                                @include('front.common.alert', ['input' => 'time'])
                            </div>
                            <div class="common-input">
                                <label class="input-label">{{ __('Phone Number') }}<span
                                        class="text-danger">*</span></label>
                                <div class="password-input-box">
                                    <input name="user_phone" id="supplier-phone" type="tel" value=""
                                        placeholder="895632542" required autocomplete="off" minlength="11"
                                        maxlength="14">
                                </div>
                                <div class="phone_number"></div>
                            </div>

                            <button class="login-btn w-100">
                                {{ __('Submit') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade feature-packages-modal order-cancel-mdl  not_show" id="edit-address-modal" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="packages-box">
                    <div class="headline-box">
                        {{ __('Update Address') }}
                    </div>
                    <div class="innner-sec">
                        <form id="editAddressForm">
                            @csrf
                            <div class="common-input">
                                <label class="input-label">{{ __('Address') }} <span
                                        class="text-danger">*</span></label>
                                <div class="password-input-box">
                                    <input type="text" name="address" id="address" value="" class="address"
                                        placeholder="{{ __('e.g Al-Ain') }}" readonly data-target="#register-map-model"
                                        data-toggle="modal" data-latitude="latitude" data-longitude="longitude"
                                        data-address="address" required>
                                    <button type="button" class="address-icon" data-target="#register-map-model"
                                        data-toggle="modal" data-latitude="latitude" data-longitude="longitude"
                                        data-address="address"><i class="fas fa-map-marker-alt"></i></button>
                                    <input type="hidden" name="latitude" id="latitude" class="latitude"
                                        value="">
                                    <input type="hidden" name="longitude" id="longitude" class="longitude"
                                        value="">
                                </div>
                            </div>
                            <input type="hidden" class="user_id" id="user_id" name="user_id"
                                value="{{ auth()->user()->id ?? '' }}">
                            <input type="hidden" class="id" name="id" id="addressId" value="">
                            <div class="common-input">
                                <label class="input-label">{{ __('Address Name') }} <span
                                        class="text-danger">*</span></label>
                                <div class="password-input-box">
                                    <input name="address_name" id="address_name" class="address_name" value=""
                                        type="text" placeholder="{{ __('e.g Home') }}" required>
                                </div>
                                @include('front.common.alert', ['input' => 'time'])
                            </div>
                            <div class="common-input">
                                <label class="input-label">{{ __('Phone Number') }}<span
                                        class="text-danger">*</span></label>
                                <div class="password-input-box">
                                    <input name="user_phone" class="user_phone" id="phone" type="tel"
                                        value="" placeholder="895632542" required autocomplete="off"
                                        minlength="11" maxlength="14">
                                </div>
                                <div class="phone_number"></div>
                            </div>


                            <button class="login-btn w-100">
                                {{ __('Update') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @include('front.common.map-modal')
@endsection
@push('scripts')

    <script>
//           $("#myBtn").click(function(){
//     $("#myModal").modal("hide");
//   });

$(".link-btns").click(function(){
                            $("html").addClass("fix-html");
 
}); 

  $("#addressModal").on('hide.bs.modal', function(){
    $("html").removeClass("fix-html");
  });
        $("#book-service").click(function() {
            $("#error-show").append("{{__('please select payment method')}}");
        });
        document.getElementById("t1").disabled = true;
        // document.getElementById("t2").disabled = true;
        $(window).on('load', function() {
            $("#pm").addClass('d-block');
            $.ajax({
                url: window.Laravel.baseUrl + "addresses",
                type: "get",
                success: function(response) {
                    $("#selected_address").val(response.defaultAddress.id);
                },
            });
        });
    </script>
    <script type="text/javascript" src="https://www.paypalobjects.com/api/checkout.js"></script>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                let select_value = $('#selected_address').val();
                if (select_value === "") {
                    $("#test3").attr("checked", false);
                }
            }, 2000);
        });

        function setPaymentClick() {
            var val = $("#payment_method").val();
            let select_value = $('#selected_address').val();
            if (val == 'paypal') {
                // $("#paypal-button").empty();
                // setUpPaypal()
                $("#test3").attr("checked", true);

                $(".js-check-out-btn").css('display', 'none')
                if (select_value !== "") {
                    $('#paypal-button').trigger('click');
                    $("#paypal-button").css("display", "block");
                    $("#paypal-button").css("opacity", "1");
                } else {
                    toastr.error("{{ __('Please add address to proceed') }}");
                }
            } else {
                $("#paypal-button").css("display", "none")
                $("#paypal-button").css("opacity", "0")

                if (select_value !== "") {
                    $(".js-check-out-btn").css('display', 'block');
                    $(".js-check-out-btn").css("opacity", "1");
                } else {
                    toastr.error("{{ __('Please add address to proceed') }}");
                }
            }


        }


        var paypalActions;

        function setUpPaypal() {
            let addressCount = 0;

            let paypalConfig = {
                env: 'sandbox',
                client: {
                    sandbox: 'AR9DVJvSCQyaYqojNmNyjPaz14YM17PkPJ3KlyCbDfEOg4WYZAYctEF5s6Dxkxx-jVWva2xCXOXHWGvl',
                    production: 'xxxxxxxxxx'
                },
                commit: true,
                validate: function(actions) {
                    actions.disable(); // Allow for validation in onClick()
                    paypalActions = actions; // Save for later enable()/disable() calls
                    let addressCount = $('#selected_address').val();
                    let defaultId = '{{ $defaultId ?? '' }}';
                    console.log("both value=>", addressCount, defaultId)

                    if (addressCount != "" || defaultId == 1) {
                        paypalActions.enable();
                    } else {
                        paypalActions.disable();
                        // toastr.error('Please Add address to proceed');
                    }
                },
                payment: (data, actions) => {
                    let usd_value = '{{ getUsdPrice($cartContent->grandtotal) }}';
                    console.log("usd value =>", usd_value);
                    return actions.payment.create({
                        payment: {
                            transactions: [{
                                amount: {
                                    total: usd_value,
                                    currency: 'USD'
                                }
                            }]
                        }
                    });
                },
                onAuthorize: (data, actions) => {
                    return actions.payment.execute().then((payment) => {
                        console.log(data);
                        // let fd=new FormData;
                        $('#paymentID').val(data.paymentID);
                        $('#payerID').val(data.payerID);
                        $('#orderID').val(data.orderID);
                        $('#paymentToken').val(data.paymentToken);
                        $('#returnUrl').val(data.returnUrl);
                        setTimeout(function() {
                            $("#check-out-form").submit();
                        }, 1000);

                    }).catch((error) => {
                        console.log('Eoor =>', error)
                    });
                },
                onError: (error) => {
                    console.log('Eoor1 =>', error)
                },
                onCancel: (data, actions) => {
                    console.log('Eoor2 =>', data)
                }
            };

            setTimeout(function() {
                paypal.Button.render(paypalConfig, '#paypal-button')
            }, 1000);
        };

        $(document).ready(function() {
            // setUpPaypal()

            $("#order_notes").on("keyup", function() {
                $("input[name=order_notes]").val($(this).val());

            });


            $(".js-check-out-btn").on('click', function(e) {
                e.preventDefault();
                let select_value = $('#selected_address').val();
                let checkout = $("#payment_method").val();
                if (checkout == 'paypal') {
                    $('#paypal-button').trigger('click');
                } else {
                    if (select_value == "") {
                        toastr.error("{{ __('Please add address to proceed') }}");
                    } else {
                        $("#check-out-form").submit();
                    }
                }
            });
            $(".payment_method").on('click', function() {
                let val = $(this).val();
                $("#payment_method").val(val);
                let select_value = $('#selected_address').val();
                console.log(select_value);
                if (val == 'paypal') {
                    if (select_value !== "") {
                        $("#error-show").hide();
                        $(".pay-method-box").addClass('mb-3').removeClass('mb-0');
                        $("#paypal-button").empty();
                        setUpPaypal()
                    }


                    $(".js-check-out-btn").css('display', 'none')
                    if (select_value !== "") {
                        $('#paypal-button').trigger('click');
                        $("#paypal-button").css("display", "block");
                        $("#paypal-button").css("opacity", "1");
                    } else {
                        toastr.error("{{ __('Please add address to proceed') }}");
                    }
                } else {
                    $("#paypal-button").css("display", "none")
                    $("#paypal-button").css("opacity", "0")

                    if (select_value !== "") {
                        $(".js-check-out-btn").css('display', 'block');
                        $(".js-check-out-btn").css("opacity", "1");
                    } else {
                        toastr.error("{{ __('Please add address to proceed') }}");
                    }
                }
                if (val != "" && val != undefined && val != null) {
                    $("input[name=pay_type]").val(val);
                }
            })

            $("input[name=selected_address]").on('click', function() {
                let val = $(this).val();
                $("#selected_address").val(val);
            })
            setTimeout(function() {
                let check_box = '{{ old('make_checked') }}';
                let pay_check_box = '{{ old('payment_method') }}';
                if (check_box != "" && check_box != undefined && check_box != null) {
                    $(".checkmark[data-id=" + check_box + "]").trigger('click');
                } else {
                    @if ($defaultCheckmark)
                        $("input[data-id=" + {{ $defaultId }} + ']').trigger('click');
                    @endif
                }
            }, 1000);

            $('.checkmark').on("click", function() {
                let input_id = $(this).attr('data-id');
                if (input_id != "" && input_id != undefined && input_id != null && input_id != "paypal" &&
                    input_id != "cash_on_delivery") {
                    $("input[name=make_checked]").val(input_id);
                }
                let input_error = $("small[input-name=" + $(this).siblings('input').attr('name') + "]");
                if (input_error.length > 0) {
                    input_error.hide();
                }
            });

            setTimeout(function() {
                $(".quantity").removeAttr('disabled');
                $(".deleteCart").removeAttr('disabled');
                $(".js-check-out-btn").removeAttr('disabled');
                $("input[name=payment_method]").removeAttr('disabled');
                $(".js-toggle-handle").removeAttr('disabled');
            }, 1000)


        })
    </script>
    <script>
        $(document).ready(function() {
            $("#AddAddressForm").validate({
                ignore: '',
                rules: {
                    'user_phone': {
                        required: true,
                        tel: true,
                    }
                },
                errorPlacement: function(error, element) {

                    if (element.attr("name") == "password") {
                        error.insertAfter(element);
                    } else if (element.attr("name") == "user_phone") {
                        console.log(element.attr("name"));
                        $(".phone_number").html(error);
                    } else {
                        error.insertAfter(element);
                    }
                },
            });
            $('#AddAddressForm').on('submit', function(e) {
                e.preventDefault();
                if ($('#AddAddressForm').valid()) {
                    var id = $('#addressId').val()
                    var address = $('#address').val();
                    var latitude = $('#latitude').val();
                    var longitude = $('#longitude').val();
                    var user_id = $('#user_id').val();
                    var address_name = $('#address_name').val();
                    var user_phone = $('#supplier-phone').val();
                    $.ajax({
                        url: window.Laravel.baseUrl + "save-adddress",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id: id,
                            address: address,
                            latitude: latitude,
                            longitude: longitude,
                            user_phone: user_phone,
                            address_name: address_name,
                            user_id: user_id,

                        },
                        success: function(response) {
                            console.log(response);
                            getAddress(response.id);
                            $('#add-address-modal').modal('hide');
                            $('#addressId').val("");
                            $('#address').val("");
                            $('#latitude').val("");
                            $('#longitude').val("");
                            $('#supplier-phone').val("");
                            $('#address_name').val("");

                        },
                    });
                }

            });
            $('#editAddressForm').on('submit', function(e) {
                console.log('123');
                e.preventDefault();
                if ($('#editAddressForm').valid()) {
                    var id = $(this).find('.id').val()
                    var address = $(this).find('.address').val();
                    var latitude = $(this).find('.latitude').val();
                    var longitude = $(this).find('.longitude').val();
                    var user_id = $(this).find('.user_id').val();
                    var address_name = $(this).find('.address_name').val();
                    var user_phone = $(this).find('.user_phone').val();
                    $.ajax({
                        url: window.Laravel.baseUrl + "save-adddress",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id: id,
                            address: address,
                            latitude: latitude,
                            longitude: longitude,
                            user_phone: user_phone,
                            address_name: address_name,
                            user_id: user_id,

                        },
                        success: function(response) {
                            console.log(response);
                            getAddress(response.id);
                            $('#edit-address-modal').modal('hide');
                            $('#addressId').val("");
                            $('#address').val("");
                            $('#latitude').val("");
                            $('#longitude').val("");
                            $('#supplier-phone').val("");
                            $('#address_name').val("");

                        },
                    });
                }

            });
            $('#get-addresses-modal').on('shown.bs.modal', function(e) {
                $.ajax({
                    url: window.Laravel.baseUrl + "addresses/{{session()->get('area_id')}}",
                    type: "get",
                    success: function(response) {
                        $('#addresses-form').html(response.data);
                        $('#getAddress').on('submit', function(e) {
                            e.preventDefault();
                            str = $(this).serializeArray();
                            console.log(str);
                            let id = str[0].value;
                            getAddress(id);
                        });
                    },
                });
            });
        });

        function getAddress(id) {
            $.ajax({
                url: window.Laravel.baseUrl + "get-adddress",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id,
                },
                success: function(response) {
                    $('#replaceAddress').html(response
                        .data);
                        $(".link-btns").click(function(){
                            $("html").addClass("fix-html");
 
}); 
                    $("#selected_address").val(response.address.id);
                    $("#paypal-button").empty();
                    if ($("#test3").is(':checked')) {
                        setUpPaypal()
                    }
                    $('.area-map').hide();
                    $('.delete-btn-manage').on('click', function(e) {
                        var id = $(this).data('id');
                        var href = $(this).data('href');
                        swal({
                                title: "{{ __('Are you sure you want to delete this?') }}",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#1C4670",
                                confirmButtonText: "{{ __('Delete') }}",
                                cancelButtonText: "{{ __('No') }}",
                                closeOnConfirm: true,
                                closeOnCancel: true,
                                showLoaderOnConfirm: true
                            },
                            function(isConfirm) {
                                if (isConfirm) {
                                    window.location.href = href;
                                    swal.close();
                                } else {
                                    swal.close();
                                }
                            });
                    });
                    $('#address-modal').on('click', function(e) {
                        $("#area").val('').trigger('change')
                        $("#city").val('').trigger('change')
                        $('#area_div').hide();
                        $('#edit-id').val('')
                        $('#edit-name').val('')
                        $('#supplier-phone').val('+971')
                        $('#edit-details').text('')
                        $('#latitude').val('')
                        $('#longitude').val('')
                        $('#address').val('')
                        $("textarea").text('');
                    });

                    $('#shipping-address-form').validate();
                    $('#area_div').hide();
                    $('#city').on('change', function() {
                        $('.area-map').hide();
                        var id = $('#city').val();

                        getCityArea(id)
                    });
                    $('#area').on('change', function() {
                        $('.area-map').show();
                    });
                    $('#shipping-address-form1').validate();
                    $('.edit-address').on('click', function() {
                        var id = $(this).val();
                        $.ajax({
                                url: window.Laravel.baseUrl + 'dashboard/get-address/' + id,
                                type: 'get',
                                datatype: 'html',
                            })
                            .done(function(data) {
                                $('#edit-id').val(data['id'])
                                $('#edit-name').val(data['address_name'])
                                $('#supplier-phone').val(data['user_phone'])
                                $('#address').val(data['address'])
                                $('#edit-details').text(data['address_description'])
                                $('#latitude').val(data['latitude'])
                                $('#longitude').val(data['longitude'])
                                getCityArea(data['city_id'])
                                $('#city').val(data['city_id']);
                                $('#city').trigger('change');
                                getArea(data['area_id']);
                                setTimeout(function() {
                                    $('#area').val(data['area_id']);
                                    $('#area').trigger('change');
                                }, 2000);
                            })
                            .fail(function(jqXHR, ajaxOptions, thrownError) {
                                alert('{{ __('Something went wrong.') }}');
                            });
                    });

                    //   $('#area').on('select2:select', function(e) {
                    //         var id = $('#area').val();
                    //         approved = '<?php echo session()->get('area_id'); ?>';
                    //         if (approved == id) {
                    //             getArea(id);
                    //             $('#areabutton').removeClass('d-none');
                    //             $('#areabutton').addClass('d-block');

                    //         } else {
                    //             $('.area-map').hide();
                    //             $('#areabutton').removeClass('d-block');
                    //             $('#areabutton').addClass('d-none');
                    //             toastr.error("{{ __('it is not your selecet area') }}");

                    //         }
                    //     });
                    //function here
                    function getArea(id) {
                        $.ajax({
                                url: window.Laravel.baseUrl + 'dashboard/area/' + id,
                                type: 'get',
                                datatype: 'html',
                            })
                            .done(function(data) {
                                initMap(data)
                            })
                            .fail(function(jqXHR, ajaxOptions, thrownError) {
                                alert('Something went wrong.');
                            });
                    }

                    function getCityArea(id) {
                        $.ajax({
                                url: window.Laravel.baseUrl + 'dashboard/city/' + id,
                                type: 'get',
                                datatype: 'html',
                            })
                            .done(function(data) {

                                console.log(data)
                                $('#area_div').show();
                                $('#area').html(data);
                            })
                            .fail(function(jqXHR, ajaxOptions, thrownError) {
                                alert('Something went wrong.');
                            });
                    }

                    function checkPolygon(count_point, polygon_x, polygon_y, lat, long) {
                        let i = 0;
                        let j = 0;
                        let c = 0;
                        for (i = 0, j = count_point; i < count_point; j = i++) {
                            if (((polygon_y[i] > lat != (polygon_y[j] > lat)) &&
                                    (long < (polygon_x[j] - polygon_x[i]) * (lat - polygon_y[i]) / (polygon_y[
                                        j] -
                                        polygon_y[i]) + polygon_x[i])))
                                c = !c;
                        }
                        console.log(c)
                        return c;
                    }

                    function initMap(area) {

                        let polygon = area.polygon;
                        let polygon_x = polygon.map(latlng => latlng.lng)
                        let polygon_y = polygon.map(latlng => latlng.lat)
                        let count_point = polygon.length - 1;
                        let lat = polygon[0].lat
                        let lng = polygon[0].lng
                        // console.log(polygon, polygon_x, polygon_y, count_point, lat, lng)

                        if (this.id > 0) {
                            lat = parseFloat(this.latitude)
                            lng = parseFloat(this.longitude)
                        }
                        // var lastPosition = new google.maps.LatLng(lat, lng);
                        // debugger
                        var map = new google.maps.Map(
                            document.getElementById("map"), {
                                center: new google.maps.LatLng(lat, lng),
                                zoom: 13,
                                mapTypeId: google.maps.MapTypeId.ROADMAP
                            });
                        var marker = new google.maps.Marker({
                            position: {
                                lat: lat,
                                lng: lng
                            },
                            map: map,
                            draggable: true
                        });
                        const region = new google.maps.Polygon({
                            map: map,
                            clickable: false,
                            paths: polygon,
                        });
                        var bounds = new google.maps.LatLngBounds();
                        for (let latlng of polygon) {
                            bounds.extend(new google.maps.LatLng(latlng.lat, latlng.lng));
                        }
                        map.fitBounds(bounds);
                        setTimeout(() => {
                            map.setZoom(15)
                        }, 100)
                        let that = this
                        google.maps.event.addListener(marker, 'dragend', function() {

                            var position = marker.getPosition();

                            if (bounds.contains(position) && checkPolygon(count_point, polygon_x,
                                    polygon_y, marker
                                    .getPosition().lat(), marker.getPosition().lng())) {
                                lastPosition = position
                                var lat = marker.getPosition().lat();
                                var lng = marker.getPosition().lng();
                                const latlng = {
                                    lat: parseFloat(lat),
                                    lng: parseFloat(lng),
                                };

                                const geocoder = new google.maps.Geocoder();
                                geocoder.geocode({
                                    location: latlng
                                }, (results, status) => {
                                    if (status === "OK") {
                                        if (results[0]) {
                                            that.address = results[0].formatted_address;
                                            that.latitude = marker.getPosition().lat();
                                            that.longitude = marker.getPosition().lng();
                                            $('#address').val(that.address)
                                            $('#latitude').val(that.latitude)
                                            $('#longitude').val(that.longitude)
                                        } else {
                                            window.alert("No results found");
                                        }
                                    } else {
                                        window.alert("Geocoder failed due to: " + status);
                                    }
                                });
                            } else {
                                // map.setZoom(15);
                                marker.setPosition(lastPosition)

                            }

                        });

                    }
                    $("form#editAddressForm").each(function(i, e) {

                        $($(e).find(`.address`)).val(response.address.address);
                        $($(e).find(`.latitude`)).val(response.address.latitude);
                        $($(e).find(`.longitude`)).val(response.address.longitude);
                        $($(e).find(`.id`)).val(response.address.id);
                        $($(e).find(`.address_name`)).val(response.address.address_name);
                        $($(e).find(`.user_phone`)).val(response.address.user_phone);

                    });
                    $('#get-addresses-modal').modal('hide');
                    $(".deleteAddress").on('click', function(e) {
                        let id = $(this).attr('data-id');
                        $(".deleteAddress").attr('disabled', 'disabled');
                        swal({
                                title: "{{ __('Do you want to delete this address?') }}",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "{{ __('Yes') }}",
                                cancelButtonText: "{{ __('Cancel') }}",
                                closeOnConfirm: false,
                                closeOnCancel: false
                            },
                            function(isConfirm) {
                                if (isConfirm) {

                                    $.ajax({

                                        url: window.Laravel.baseUrl +
                                            "dashboard/delete-address/" + id,
                                        success: function(data) {
                                            toastr.success("{{ __('success') }}",
                                                "{{ __('Address removed successfully') }}"
                                            )
                                            location.reload();
                                        }
                                    })

                                } else {
                                    $(".deleteAddress").attr('disabled', false);
                                    swal.close()
                                }
                            });
                    });

                },
            });
        }
    </script>
    <script>
        $(document).ready(function() {

            $('.area-map').hide();
            $('.delete-btn-manage').on('click', function(e) {
                var id = $(this).data('id');
                var href = $(this).data('href');
                swal({
                        title: "{{ __('Are you sure you want to delete this?') }}",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#1C4670",
                        confirmButtonText: "{{ __('Delete') }}",
                        cancelButtonText: "{{ __('No') }}",
                        closeOnConfirm: true,
                        closeOnCancel: true,
                        showLoaderOnConfirm: true
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            window.location.href = href;
                            swal.close();
                        } else {
                            swal.close();
                        }
                    });
            });
            $('#address-modal').on('click', function(e) {
                $("#area").val('').trigger('change')
                $("#city").val('').trigger('change')
                $('#area_div').hide();
                $('#edit-id').val('')
                $('#edit-name').val('')
                $('#supplier-phone').val('+971')
                $('#edit-details').text('')
                $('#latitude').val('')
                $('#longitude').val('')
                $('#address').val('')
                $("textarea").text('');
            });

            $('#shipping-address-form').validate();
            $('#area_div').hide();
            $('#city').on('change', function() {
                $('.area-map').hide();
                var id = $('#city').val();

                getCityArea(id)
            });
            $('#area').on('change', function() {
                $('.area-map').show();
            });
            $('#shipping-address-form1').validate();
            $('.edit-address').on('click', function() {
                var id = $(this).val();
                $.ajax({
                        url: window.Laravel.baseUrl + 'dashboard/get-address/' + id,
                        type: 'get',
                        datatype: 'html',
                    })
                    .done(function(data) {
                        $('#edit-id').val(data['id'])
                        $('#edit-name').val(data['address_name'])
                        $('#supplier-phone').val(data['user_phone'])
                        $('#address').val(data['address'])
                        $('#edit-details').text(data['address_description'])
                        $('#latitude').val(data['latitude'])
                        $('#longitude').val(data['longitude'])
                        getCityArea(data['city_id'])
                        $('#city').val(data['city_id']);
                        $('#city').trigger('change');
                        getArea(data['area_id']);
                        setTimeout(function() {
                            $('#area').val(data['area_id']);
                            $('#area').trigger('change');
                        }, 2000);
                    })
                    .fail(function(jqXHR, ajaxOptions, thrownError) {
                        alert('{{ __('Something went wrong.') }}');
                    });
            });

            $('#area').on('select2:select', function(e) {
                var id = $('#area').val();
                approved = '<?php echo session()->get('area_id'); ?>';
                if (approved == id) {
                    getArea(id);
                    $('#areabutton').removeClass('d-none');
                    $('#areabutton').addClass('d-block');

                } else {
                    $('.area-map').hide();
                    $('#areabutton').removeClass('d-block');
                    $('#areabutton').addClass('d-none');
                    toastr.error("{{ __('it is not your selected area') }}");

                }
            });
            //function here
            function getArea(id) {
                $.ajax({
                        url: window.Laravel.baseUrl + 'dashboard/area/' + id,
                        type: 'get',
                        datatype: 'html',
                    })
                    .done(function(data) {
                        initMap(data)
                    })
                    .fail(function(jqXHR, ajaxOptions, thrownError) {
                        alert('Something went wrong.');
                    });
            }

            function getCityArea(id) {
                $.ajax({
                        url: window.Laravel.baseUrl + 'dashboard/city/' + id,
                        type: 'get',
                        datatype: 'html',
                    })
                    .done(function(data) {

                        console.log(data)
                        $('#area_div').show();
                        $('#area').html(data);
                    })
                    .fail(function(jqXHR, ajaxOptions, thrownError) {
                        alert('Something went wrong.');
                    });
            }

            function checkPolygon(count_point, polygon_x, polygon_y, lat, long) {
                let i = 0;
                let j = 0;
                let c = 0;
                for (i = 0, j = count_point; i < count_point; j = i++) {
                    if (((polygon_y[i] > lat != (polygon_y[j] > lat)) &&
                            (long < (polygon_x[j] - polygon_x[i]) * (lat - polygon_y[i]) / (polygon_y[j] -
                                polygon_y[i]) + polygon_x[i])))
                        c = !c;
                }
                console.log(c)
                return c;
            }

            function initMap(area) {

                let polygon = area.polygon;
                let polygon_x = polygon.map(latlng => latlng.lng)
                let polygon_y = polygon.map(latlng => latlng.lat)
                let count_point = polygon.length - 1;
                let lat = polygon[0].lat
                let lng = polygon[0].lng
                // console.log(polygon, polygon_x, polygon_y, count_point, lat, lng)

                if (this.id > 0) {
                    lat = parseFloat(this.latitude)
                    lng = parseFloat(this.longitude)
                }
                // var lastPosition = new google.maps.LatLng(lat, lng);
                // debugger
                var map = new google.maps.Map(
                    document.getElementById("map"), {
                        center: new google.maps.LatLng(lat, lng),
                        zoom: 13,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    });
                var marker = new google.maps.Marker({
                    position: {
                        lat: lat,
                        lng: lng
                    },
                    map: map,
                    draggable: true
                });
                const region = new google.maps.Polygon({
                    map: map,
                    clickable: false,
                    paths: polygon,
                });
                var bounds = new google.maps.LatLngBounds();
                for (let latlng of polygon) {
                    bounds.extend(new google.maps.LatLng(latlng.lat, latlng.lng));
                }
                map.fitBounds(bounds);
                setTimeout(() => {
                    map.setZoom(13)
                }, 100)
                let that = this
                google.maps.event.addListener(marker, 'dragend', function() {

                    var position = marker.getPosition();

                    if (bounds.contains(position) && checkPolygon(count_point, polygon_x, polygon_y, marker
                            .getPosition().lat(), marker.getPosition().lng())) {
                        lastPosition = position
                        var lat = marker.getPosition().lat();
                        var lng = marker.getPosition().lng();
                        const latlng = {
                            lat: parseFloat(lat),
                            lng: parseFloat(lng),
                        };

                        const geocoder = new google.maps.Geocoder();
                        geocoder.geocode({
                            location: latlng
                        }, (results, status) => {
                            if (status === "OK") {
                                if (results[0]) {
                                    that.address = results[0].formatted_address;
                                    that.latitude = marker.getPosition().lat();
                                    that.longitude = marker.getPosition().lng();
                                    $('#address').val(that.address)
                                    $('#latitude').val(that.latitude)
                                    $('#longitude').val(that.longitude)
                                } else {
                                    window.alert("No results found");
                                }
                            } else {
                                window.alert("Geocoder failed due to: " + status);
                            }
                        });
                    } else {
                        // map.setZoom(15);
                        marker.setPosition(lastPosition)

                    }

                });

            }




        })
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNcTmnS323hh7tSQzFdwlnB4EozA3lwcA&libraries=places&language={{ $locale }}">
    </script>
@endpush
