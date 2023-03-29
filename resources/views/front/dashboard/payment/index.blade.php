@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <main class="payment-profile-page spacing-y">
        <div class="container">
            <div class="row">
                @include('front.dashboard.common.left-sidebar')

                <div class="col-xl-9 col-lg-8">
                    <div class="payment-profile-tabs-sec">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item custom-tab">
                                <a class="nav-link active" data-toggle="pill" href="#payment-info-tab" role="tab"
                                   aria-controls="all" aria-selected="true">{{__('Payment Info')}}</a>
                            </li>
                            <li class="nav-item custom-tab">
                                <a class="nav-link" data-toggle="pill" href="#payment-profile-tab" role="tab"
                                   aria-controls="pending" aria-selected="false">{{__('Payment Profile')}}</a>
                            </li>
                            <li class="nav-item custom-tab">
                                <a class="nav-link" data-toggle="pill" href="#payment-request-tab" role="tab"
                                   aria-controls="shippied" aria-selected="false">{{__('Release Payment Request')}}</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="payment-info-tab" role="tabpanel"
                                 aria-labelledby="payment-info-tab">
                                <div class="payment-info-card mb-3">
                                    <div
                                        class="header-box d-flex justify-content-around align-items-center text-center">
                                        <div class="title">
                                            {{__('Amount Earned')}}
                                        </div>
                                        <div class="title">
                                            {{__('Available Balance')}}
                                        </div>
                                        <div class="title">
                                            {{__('Amount Released')}}
                                        </div>
                                    </div>
                                    <div class="value-box d-flex justify-content-around align-items-center text-center">
                                        <div class="title">
                                            {{__('AED')}} {{ auth()->user()->total_earning ?? 0 }}
                                        </div>
                                        <div class="title">
                                            {{__('AED')}} {{ auth()->user()->available_balance ?? 0 }}
                                        </div>
                                        <div class="title">
                                            {{__('AED')}} {{ $amount }}
                                        </div>
                                    </div>
                                </div>
                                <div class="payment-info-card mb-3">
                                    <div
                                        class="header-box d-flex justify-content-around align-items-center text-center">
                                        <div class="title">
                                            {{__('Commission Paid')}}
                                        </div>
                                        <div class="title">
                                            {{__('Outstanding Commission')}}
                                        </div>
                                    </div>
                                    <div class="value-box d-flex justify-content-around align-items-center text-center">
                                        <div class="title">
                                            {{__('AED')}} {{ auth()->user()->total_commission ?? 0 }}
                                        </div>
                                        <div class="title">
                                            {{__('AED')}} 0
                                        </div>

                                    </div>
                                </div>
                                <div class="payment-info-card">
                                    <div
                                        class="header-box d-flex justify-content-around align-items-center text-center">
                                        <div class="title">
                                            {{__('Amount')}}
                                        </div>
                                        <div class="title">
                                            {{__('Status')}}
                                        </div>
                                        <div class="title">
                                            {{__('Date')}}
                                        </div>
                                    </div>

                                    @forelse ($withdraws as $withdraw)
                                        <div
                                            class="value-box d-flex justify-content-around align-items-center text-center">
                                            <div class="title">
                                                {{__('AED')}} {{ $withdraw->amount }}
                                            </div>
                                            <div class="title">
                                                {{ $withdraw->status }}
                                            </div>
                                            <div class="title">
                                                {{ \Carbon\Carbon::parse($withdraw->created_at)->format('j F, Y') }}
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center no-payment">
                                           {{__('No payment Request')}}
                                        </div>
                                    @endforelse

                                </div>
                            </div>
                            <div class="tab-pane fade" id="payment-profile-tab" role="tabpanel"
                                 aria-labelledby="payment-profile-tab">
                                <div class="payment-profile-block">
                                    <form action="{{ route('front.dashboard.payment.update') }}" method="post"
                                          id="paymentForm">
                                        @csrf
                                        <div class="row">

                                            <div class="col-12">
                                                <div class="pay-pal-logo-block">
                                                    <img src="{{ asset('assets/front/img/pay-pal.png') }}"
                                                         alt="pay-pal-img" class="img-fluid pay-pal-img">
                                                </div>
                                                <div class="my-title">
                                                    {{__('Save Your Payment Profile')}}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="common-input">
                                                    <label class="input-label">{{__('Client ID')}}</label>
                                                    <input type="text" name="client_id" placeholder="Client ID"
                                                           required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="common-input">
                                                    <label class="input-label">{{__('Secret')}}</label>
                                                    <input type="text" name="secret_id" placeholder="Secret" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="submit" class="login-btn mb-0 w-100">{{__('Save')}}</button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="payment-request-tab" role="tabpanel"
                                 aria-labelledby="payment-request-tab">
                                @if(auth()->user()->client_id && auth()->user()->secret_id)
                                    <div class="payment-profile-block">
                                        <form action="{{ route('front.dashboard.withdraw.payment') }}" method="post"
                                              id="withdrawPaymentForm">
                                            @csrf
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="my-title mt-0">
                                                        {{__('Enter Your Amount')}}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="common-input">
                                                        <label class="input-label">{{__('Amount')}}</label>
                                                        <input type="number" min="1"
                                                               max="{{ auth()->user()->available_balance }}"
                                                               name="amount" placeholder="Amount" required>
                                                        @include('front.common.alert', ['input' => 'amount'])

                                                    </div>
                                                </div>
                                                <div class="col-md-6">

                                                </div>
                                                <div class="col-md-6">
                                                    <button type="submit" class="login-btn mb-0 w-100">{{__('Request Withdraw')}}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                @else
                                    <h3 class="p-text text-danger">{{__('Please update your Payment Profile to create payment requests.')}}</h3>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
@endsection
@push('scripts')
    <script>
        $('#paymentForm').validate({
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            }
        });
    </script>
    <script>
        $('#withdrawPaymentForm').validate({
            ignore: '',
            rules: {
                'amount': {
                    required: true,
                    digits: true,
                },
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            }
        });
        $.validator.addMethod("digits", function (value, element) {
            return this.optional(element) || /[+-]?([0-9]*[.])?[0-9]+$/i.test(value);
        }, "This field should be valid price");
    </script>
@endpush
