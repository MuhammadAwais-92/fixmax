@extends('admin.layouts.app')

@section('breadcrumb')
    @include('admin.common.breadcrumbs')
@endsection

@push('stylesheet-page-level')
@endpush

@push('script-page-level')
    <script src="{{ asset('assets/admin/js/adv_datatables/csrf_token.js') }}" type="text/javascript"></script>
@endpush

@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Quotation
                        <small>
                            Here You Can View Quotation Details
                        </small>

                    </h3>
                </div>
            </div>
        </div>

        @if (!empty($quotation))
            <div class="col-lg-12 col-md-12">
                <div class="order-detail-main-area">
                    <div class="inner-wrapper-order-dt d-flex justify-content-between w-100">
                        <div class="top-tittle-area-dt w-100">
                            <div class="d-flex justify-content-between w-100">
                                <h2 class="oder-dt-cus-head">{{ __('Quotation ID:') }}
                                    <span>{{ $quotation->order_number }}</span>
                                </h2>
                                {{-- <a target="_blank" href="{{ env('PUBLIC_PATH') }}{{ $quotation->invoice }}"
                                    class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">View
                                    Invoice</a> --}}
                            </div>

                            <h2 class="oder-dt-cus-head-2">{{ __('Placement Time:') }} <span
                                    class="span-time-head-2">{{ date('d/m/Y H:i', $quotation->created_at) }}</span></h2>
                            <h2 class="oder-dt-cus-head-2">{{ __('Scheduled Time:') }} <span
                                    class="span-time-head-2">{{ date('d/m/Y', $quotation->date) }}
                                    {{ date("H:i", strtotime($quotation->time)) }}</span>
                            </h2>
                            <h2 class="oder-dt-cus-head-2">{{ __('status:') }} @if ($quotation->isPending())
                                    <span class="orange-color">{{ ucwords($quotation->status) }}</span>
                                @elseif($quotation->isConfirmed())
                                    <span class="green-color">{{ __('Accepted') }}</span>
                                @elseif($quotation->isVisited())
                                    <span class="blue-color">{{ ucwords($quotation->status) }}</span>
                                @elseif($quotation->isRejected())
                                    <span class="blue-color">{{ __('Cancelled') }}</span>
                                @else
                                    <span class="orange-color">{{ ucwords($quotation->status) }}</span>
                                @endif
                            </h2>

                        </div>
                    </div>

                    <div class="custom-class-for-space-dt">
                        <h2 class="dt-sub-tittle-head">{{ __('Selected Equipments') }}</h2>
                        <div class="inner-content-sup-img d-flex align-items-center">

                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Make</th>
                                        <th scope="col">Model</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Subtotal</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($quotation->orderItems as $key => $orderItem)
                                        <tr>
                                            <th scope="row">{{ $key + 1 }}</th>
                                            <td><img src="{{ imageUrl($orderItem->image, 200, 200) }}"></td>
                                            <td>{{ $orderItem->name['en'] }}</td>
                                            <td>{{ $orderItem->price }}</td>
                                            <td>{{ $orderItem->make }}</td>
                                            <td>{{ $orderItem->equipment_model }}</td>
                                            <td>{{ $orderItem->quantity }}</td>
                                            <td>{{ $orderItem->total }}</td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>




                        </div>

                    </div>

                    <div class="custom-class-for-space-dt">
                        <h2 class="dt-sub-tittle-head">{{ __('Payment Method:') }}</h2>
                        <h4 class="cash-delivey-pay-dt">
                            @if ($quotation->payment_method == 'cash_on_delivery')
                                Cash on Pickup
                            @else
                                Paypal
                            @endif
                        </h4>


                    </div>
                    <div class="custom-class-for-space-dt">
                        <h2 class="dt-sub-tittle-head">{{ __('Service Details:') }}</h2>
                        <div class="property-detail-main-2 d-flex align-items-center">
                            <div class="image-detail-pro">
                                @if (str_contains($quotation->image, '.mp4') || str_contains($quotation->image, '.mov'))
                                    <video width="123" height="65" controls muted>
                                        <source src="{{ $quotation->image }}" class="img-fluid" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @else
                                    <img src="{!! imageUrl(url($quotation->image), 123, 65, 100, 1) !!}" alt="user-img" class="img-fluid">
                                @endif


                            </div>

                            <div class="right-side-content">
                                <h2 class="tittle-company-name">{{ $quotation->service_name['en'] }}</h2>
                                <h3 class="tittle-com-deb"> <span>AED {!! $quotation->min_price !!}</span> - <span>AED
                                        {!! $quotation->max_price !!}</span></h3>
                                {{-- <a href="#" class="view-dt-tittle-com">
                                    <i class="fas fa-map-marker-alt"></i>{{ $quotation->user->address }}
                                </a> --}}

                            </div>


                        </div>



                    </div>
                    <div class="custom-class-for-space-dt">
                        <h2 class="dt-sub-tittle-head">{{ __('User Detail:') }}</h2>
                        <div class="property-detail-main-2 d-flex align-items-center">
                            <div class="image-detail-pro">
                                <img src="@if (empty($quotation->user->image_url)) {{ config('settings.default_image') }} @else {{ imageUrl($quotation->user->image_url, 72, 72, 100, 1) }} @endif"
                                    class="img-fluid" alt="">

                            </div>

                            <div class="right-side-content">
                                <h2 class="tittle-company-name">{{ $quotation->user->user_name }}</h2>
                                <h3 class="tittle-com-deb">{{ $quotation->user->phone }}</h3>
                                <a href="https://maps.google.com/?q={{$quotation->user->latitude}},{{$quotation->user->longitude}}" class="view-dt-tittle-com">
                                    <i class="fas fa-map-marker-alt"></i>{{ $quotation->user->address }}
                                </a>

                            </div>


                        </div>



                    </div>

                    <div class="custom-class-for-space-dt">
                        <h2 class="dt-sub-tittle-head">{{ __('Supplier Detail:') }}</h2>
                        <div class="property-detail-main-2 d-flex align-items-center">
                            <div class="image-detail-pro">
                                <img src="{{ imageUrl($quotation->supplier->image_url, 72, 72, 100, 1) }}"
                                    class="img-fluid" alt="">

                            </div>

                            <div class="right-side-content">
                                <h2 class="tittle-company-name">{{ $quotation->supplier->supplier_name['en'] }}</h2>
                                <h3 class="tittle-com-deb">{{ $quotation->supplier->category->name['en'] }}</h3>
                                <a href="https://maps.google.com/?q={{$quotation->supplier->latitude}},{{$quotation->supplier->longitude}}" class="view-dt-tittle-com">
                                    <i class="fas fa-map-marker-alt"></i> {{ $quotation->supplier->address }}
                                </a>

                            </div>


                        </div>



                    </div>

                    {{-- <div class="custom-class-for-space-dt">
                        <h2 class="dt-sub-tittle-head">{{__('Notes:')}}</h2>
                        <p class="note-p-dec-dt">{{ $order->notes }}</p>

                    </div> --}}

                </div>

                <div class="amount-summary-main-top-dt">
                    <div class="tittle-amount">
                        <h5 class="tittle">{{ __('Amount Summary') }}</h5>
                    </div>
                    @if ($quotation->isConfirmed())
                        <div class=" custom-total-summary d-flex align-items-center justify-content-between">
                            <h3 class="first-tittle">{{ __('Equipment Charges:') }}</h3>
                            <h3 class="second-tittle">AED {{ $quotation->subtotal }}</h3>

                        </div>

                        <div class=" custom-total-summary d-flex align-items-center justify-content-between">
                            <h3 class="first-tittle">{{ __('Service Charges:') }}</h3>
                            <h3 class="second-tittle">AED {{ $quotation->quoated_price }}</h3>

                        </div>


                        <div class=" custom-total-summary d-flex align-items-center justify-content-between">
                            <h3 class="first-tittle">{{ __('VAT') }}</h3>
                            <h3 class="second-tittle">AED {{ $quotation->vat_2 }}</h3>

                        </div>

                        <div class="total-ammount-area d-flex align-items-center justify-content-between">
                            <h3 class="first-tittle">{{ __('Total Amount') }}</h3>
                            <h3 class="second-tittle">AED {{ $quotation->total_amount - $quotation->amount_paid }}</h3>

                        </div>
                    @else
                        @if ($quotation->issue_type == 'know')
                            <div class=" custom-total-summary d-flex align-items-center justify-content-between">
                                <h3 class="first-tittle">{{ __('Equipment Charges:') }}</h3>
                                <h3 class="second-tittle">AED {{ $quotation->subtotal }}</h3>

                            </div>
                        @endif
                        <div class=" custom-total-summary d-flex align-items-center justify-content-between">
                            <h3 class="first-tittle">{{ __('Visit Fee:') }}</h3>
                            <h3 class="second-tittle">AED {{ $quotation->visit_fee }}</h3>

                        </div>


                        <div class=" custom-total-summary d-flex align-items-center justify-content-between">
                            <h3 class="first-tittle">{{ __('VAT') }}</h3>
                            <h3 class="second-tittle">AED {{ $quotation->vat_1 }}</h3>

                        </div>

                        <div class="total-ammount-area d-flex align-items-center justify-content-between">
                            <h3 class="first-tittle">{{ __('Total Amount') }}</h3>
                            <h3 class="second-tittle">AED {{ $quotation->total_amount }}</h3>

                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>

@endsection
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
