@extends('admin.layouts.app')
@section('breadcrumb')
    @include('admin.common.breadcrumbs')
@endsection

@push('stylesheet-page-level')
@endpush



@section('content')
    <div class="row">

        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link active" data-toggle="tab" href="#tab_en" role="tab"
                                    id="test1">
                                    <i class="flaticon-share m--hide"></i>
                                    Add Coupons
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">

                    <div class="tab-pane active" id="tab_en">
                        @include('admin.coupons.form', ['languageId' => 1])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script-page-level')
    <script>
        $(document).ready(function() {
            $(".js-toggle-class").hide();
            if ($("#brand_id").val() == "infinite") {
                $(".js-toggle-class").hide();
                $("#coupon_number").attr('value', 0)
                $("#coupon_number").val(0)
            }
            $('#end_date').datepicker({

                todayHighlight: true,
                startDate: new Date(),
                minDate: '{{ now()->endOfDay() }}',
                disabledDates: [new Date()],
                // useCurrent:false

            });


            $("select[name=coupon_type]").on("change", function() {
                let value = $(this).val();

                if (value != undefined && value == 'infinite') {
                    $(".js-toggle-class").hide();
                    $("#coupon_number").attr('value', 0)
                    $("#coupon_number").val(0)

                } else {
                    $(".js-toggle-class").show();
                }


            });
        });
    </script>
@endpush
