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
                    <div class="check-shadow-box">
                        <h3 class="my-title">
                            {{ __('Address') }}
                        </h3>
                        <div class="add-desc">
                            <h6 class="prim-title">
                                {{ $checkoutContent->address['address_name'] }}
                            </h6>
                            <p class="prime-title-l">
                                {{ $checkoutContent->address['address'] }}
                            </p>
                            {{-- <p class="prime-title-l">
                    Jeddah
                  </p> --}}
                            <a href="#" dir="ltr" class="prime-title-l">
                                {{ $checkoutContent->address['user_phone'] }}
                            </a>
                        </div>
                    </div>
                    <div class="check-shadow-box  mb-0">
                        <h3 class="my-title">
                            {{ __('Payment Method') }}
                        </h3>
                        <div class="payment-desc">
                            <div class="radio-blocks">
                                <label class="ctm-radio custom-radio custom-radio-center-ha active">
                                    <input type="radio" id="t1">
                                    <span class="checkmark"></span>
                                    <span class="title">{{__('Credit Card')}}</span>
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
                      <input type="radio" value="male" name="gender">
                      <span class="checkmark"></span>
                      <span class="title">Apple Pay</span>
                    </label>
                  </div> --}}
                        </div>
                    </div>
                    <p id="error-show" class="error mb-3"></p>
                    <div class="check-shadow-box">
                        <h3 class="my-title">
                            {{__('Date & Time')}}
                        </h3>
                        <div class="date-time-desc">
                            <ul class="title-value-ul">
                                <li>
                                    <span>{{__('Booked Date:')}}</span>
                                    <span class="value"
                                          dir="ltr">{{date("d/m/Y", strtotime($checkoutContent->date))  }}</span>
                                </li>
                                <li>
                                    <span>{{__('Booked Time:')}}</span>
                                    <span class="value"
                                          dir="ltr">{{date("H:i", strtotime($checkoutContent->time)) }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="check-shadow-box">
                        <h3 class="my-title">
                            {{__('Issue Image')}}
                        </h3>
                        <div class="issue-img-main">
                            @foreach ($checkoutContent->issue_images_url as $image)
                                <div class="issue-img-block">
                                    <img src="{!! imageUrl(url($image), 152, 120, 100, 1) !!}" alt="issue-img"
                                         class="img-fluid issue-img">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="check-shadow-box">
                        <h3 class="my-title">
                            {{__('Requested Service')}}
                        </h3>
                        <div class="requested-service">
                            <div class="sup-type-title d-flex flex-wrap">
                                <span>{{__('Supplier:')}}</span>
                                <span
                                    class="value">{{ translate($checkoutContent->service->supplier->supplier_name) }}</span>
                            </div>
                            <div class="services-row d-flex flex-wrap">
                                <div class="img-block">
                                    @if (str_contains($checkoutContent->image, '.mp4') || str_contains($checkoutContent->image, '.mov'))
                                        <video width="174" height="92" controls muted>
                                            <source src="{{ $checkoutContent->image }}" class="img-fluid"
                                                    type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @else
                                        <img src="{!! imageUrl(url($checkoutContent->image), 174, 92, 100, 1) !!}"
                                             alt="user-img" class="img-fluid user-img">
                                    @endif

                                </div>
                                <div class="desc-block">
                                    <div class="d-flex">
                                        <div class="star-rating-area">
                                            <div class="rating-static clearfix"
                                                 rel="{{ round(getStarRating($checkoutContent->service->average_rating), 1) }}">
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
                                                ({{number_format($checkoutContent->service->average_rating,1)}})
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-p">
                                        {{ translate($checkoutContent->service_name) }}
                                    </div>
                                    <h4 class="serv-price d-flex">
                                        <span>AED{{ $checkoutContent->quoated_price }}</span>
                                    </h4>
                                </div>
                            </div>
                            @if ($checkoutContent->equipment_charges)
                                <div class="equipment-sec">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <h4 class="title">
                                            {{__('Required Equipment(s)')}}
                                        </h4>
                                        <h4 class="title d-flex subtotal">
                                            <span
                                                class="px-05">{{__('Subtotal:')}}</span><span>{{__('AED')}}{{ $checkoutContent->equipment_charges }}</span>
                                        </h4>
                                    </div>
                                    @foreach ($checkoutContent->orderItemsToBeBought as $item)
                                        <div class="euipment-row d-flex flex-wrap">
                                            <div class="img-block">
                                                <img
                                                    src="{!! imageUrl(url($item->equipment->image_url), 123, 75, 100, 1) !!}"
                                                    alt="user-img"
                                                    class="img-fluid user-img">
                                            </div>
                                            <div class="desc-block">
                                                <h4 class="serv-price d-flex">
                                                    <span>{{__('AED')}}{{ $item->price }}</span>
                                                </h4>
                                                <div class="text-p d-flex">
                                                    {{ translate($item->equipment->name) }}<p
                                                        class="px-05 d-flex align-items-center">(<span
                                                            class="pr-05">{{__('Qty:')}}</span><span>{{ $item->qty_2 }}</span>)
                                                    </p>
                                                </div>
                                                <div class="text-p">
                                                    {{ $item->equipment->equipment_model }} -
                                                    {{ $item->equipment->make }}
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
                                {{__('Order Summary')}}
                            </h3>
                            <div class="title-val-block">
                                <div class="title-value-row d-flex justify-content-between align-items-center">
                                    <div class="title">{{__('Service Charges')}}</div>
                                    <div class="value">{{__('AED')}} {{ $checkoutContent->subTotal }}</div>
                                </div>
                                @if($checkoutContent->orderItemsToBeBought->isNotEmpty())
                                    <div class="title-value-row d-flex justify-content-between align-items-center">
                                        <div class="title">{{__('Equipment Charges')}}</div>
                                        <div class="value">{{__('AED')}} {{ $checkoutContent->equipment_charges }}</div>
                                    </div>
                                @endif
                                {{-- <div class="title-value-row d-flex justify-content-between align-items-center">
                                    <div class="title">Discount</div>
                                    <div class="value">AED 100</div>
                                </div>--}}
                                @if($checkoutContent->discount > 0)
                                    <div class="title-value-row d-flex justify-content-between align-items-center">
                                        <div class="title">{{__('Discount')}}({{$checkoutContent->discountPercentage}}
                                            %)
                                        </div>
                                        <div class="value">
                                            -{{__('AED')}} {{$checkoutContent->discount}}
                                        </div>
                                    </div>
                                    <div
                                        class="coupon-row title-value-row d-flex justify-content-between align-items-center">

                                        <div class="left-ol">
                                            <div class="title">{{__('Discount Code Applied')}}</div>
                                            <p>{{$checkoutContent->discountPercentage}}{{__('% discount is applied AED')}} {{$checkoutContent->discount}}</p>
                                        </div>
                                        <div class="value">
                                            <a href="{{route('front.remove.coupon')}}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19"
                                                     viewBox="0 0 21.416 21.024">
                                                    <g id="check_circle_icon_128923"
                                                       transform="translate(-0.998 -0.982)">
                                                        <path id="Path_48307" data-name="Path 48307"
                                                              d="M21,10.625V11.5a9.5,9.5,0,1,1-5.633-8.682"
                                                              transform="translate(0 0)" fill="none" stroke="#022c44"
                                                              stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"/>
                                                        <path id="Path_48308" data-name="Path 48308"
                                                              d="M20.069,4l-8.514,8.523L9,9.969"
                                                              transform="translate(0.931 -0.298)" fill="none"
                                                              stroke="#022c44" stroke-linecap="round"
                                                              stroke-linejoin="round" stroke-width="2"/>
                                                    </g>
                                                </svg>
                                            </a>

                                        </div>
                                    </div>
                                @else
                                    <div class="title-value-row d-flex justify-content-between align-items-center">
                                        <div class="title">{{__('Coupon Discount')}}</div>
                                        <div class="value">
                                            <a href="#" data-toggle="modal" data-target="#add-promo-code"
                                               class="link-btn">
                                                {{__('Enter Promo Code')}}
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                <div class="title-value-row d-flex justify-content-between align-items-center">
                                    <div class="title">{{__('VAT')}}</div>
                                    <div class="value">{{__('AED')}} {{ round($checkoutContent->vat,2) }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="total-row d-flex justify-content-between align-items-center">
                            <div class="title">
                                {{__('Total')}}
                            </div>
                            <div class="to-ptice">
                                {{__('AED')}} {{ round($checkoutContent->grandtotal,2) }}
                            </div>
                        </div>
                    </div>
                    <form id="check-out-form" action="{{ route('front.checkout.cart') }}" method="post">
                        @csrf
                        <input type="hidden" name="order_notes" value="{{ $checkoutContent->order_notes }}">
                        <input type="hidden" name="selected_address" id="selected_address"
                               value="  {{ $checkoutContent->address['id'] }}">
                        <input type="hidden" id="payment_method" name="payment_method" value="paypal">
                        <input type="hidden" id="paymentID" name="paymentID" value="">
                        <input type="hidden" id="payerID" name="payerID" value="">
                        <input type="hidden" id="orderID" name="orderID" value="">
                        <input type="hidden" id="checkout" name="checkout" value="second">
                        <input type="hidden" id="paymentToken" name="paymentToken" value="">
                        <input type="hidden" id="serviceId" name="order_id" value="{{ $checkoutContent->id }}">
                        <input type="hidden" id="selected_total" name="selected_total"
                               value="{{ $checkoutContent->grandtotal }}">
                        <input type="hidden" id="selected_address_price_input" name="selected_address_price_input"
                               value="">
                        <input type="hidden" id="paypal_input" name="paypal_input" value="">
                        <input type="hidden" id="returnUrl" name="returnUrl" value="">
                        <input type="hidden" name="make_checked" value="{{ old('make_checked') }}">
                        <div class="btn-lg btn-col" disabled id="paypal-button">
                        </div>
                    </form>
                    <button type="button"
                            class="check-out js-check-out-btn secondary-btn mw-100" id="book-service">
                        {{ __('Book Service') }}
                    </button>
                </div>
            </div>
        </div>
    </main>
    <div class="modal fade feature-packages-modal order-cancel-mdl not_show" id="add-promo-code" tabindex="-1"
         role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="packages-box">
                    <div class="headline-box">
                        {{ __('Enter Promo Code') }}
                    </div>
                    <div class="innner-sec">
                        <form action="{{ route('front.user.coupon') }}" id="coupon" method="post">
                            @csrf

                            <div class="common-input">
                                <label class="input-label">{{ __('Code') }} <span
                                        class="text-danger">*</span></label>
                                <div class="password-input-box">
                                    <input type="text" placeholder="Code" name="code" required>
                                </div>
                                @include('front.common.alert', ['input' => 'code'])
                            </div>
                            <button class="login-btn w-100">
                                {{ __('Apply') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('scripts')
    <script>

        $("#book-service").click(function () {
            $("#error-show").append("Please select payment method");
        });
        $('#coupon').validate({
            ignore: '',
            rules: {
                'code': {
                    required: true,
                    noSpace: true,
                },
            },
            errorPlacement: function (error, element) {
                console.log(element.attr("name"));
                if (element.attr("name") === "service_id") {
                    // error.insertAfter(element.parent());
                    $("#servId").html(error);
                } else {
                    error.insertAfter(element);
                }
            }
        });
        $.validator.addMethod("noSpace", function (value, element) {
            return this.optional(element) || value === "NA" ||
                value.match(/\S/);
        }, "This field cannot be empty");
        approved = '<?php echo session()->has('errors'); ?>';
        if (approved) {
            $(window).on('load', function () {
                $('#add-promo-code').modal('show');
            });
        }
        document.getElementById("t1").disabled = true;
        $(window).on('load', function () {
            $.ajax({
                url: window.Laravel.baseUrl + "addresses",
                type: "get",
                success: function (response) {
                    $("#selected_address").val(response.defaultAddress.id);
                },
            });
        });
    </script>
    <script type="text/javascript" src="https://www.paypalobjects.com/api/checkout.js"></script>
    <script>
        $(document).ready(function () {
            setTimeout(function () {
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
                validate: function (actions) {
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
                    let usd_value = '{{ getUsdPrice($checkoutContent->grandtotal) }}';
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
                        setTimeout(function () {
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

            setTimeout(function () {
                paypal.Button.render(paypalConfig, '#paypal-button')
            }, 1000);
        };

        $(document).ready(function () {
            // setUpPaypal()

            $("#order_notes").on("keyup", function () {
                $("input[name=order_notes]").val($(this).val());

            });


            $(".js-check-out-btn").on('click', function (e) {
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
            $(".payment_method").on('click', function () {
                let val = $(this).val();
                $("#payment_method").val(val);
                let select_value = $('#selected_address').val();
                console.log(select_value);
                if (val == 'paypal') {
                    $("#error-show").hide();
                    $("#paypal-button").empty();
                    setUpPaypal()

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

            $("input[name=selected_address]").on('click', function () {
                let val = $(this).val();
                $("#selected_address").val(val);
            })
            setTimeout(function () {
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

            $('.checkmark').on("click", function () {
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

            setTimeout(function () {
                $(".quantity").removeAttr('disabled');
                $(".deleteCart").removeAttr('disabled');
                $(".js-check-out-btn").removeAttr('disabled');
                $("input[name=payment_method]").removeAttr('disabled');
                $(".js-toggle-handle").removeAttr('disabled');
            }, 1000)
        })
    </script>

@endpush
