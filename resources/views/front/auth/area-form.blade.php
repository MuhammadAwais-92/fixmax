@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')

    <main class="login-sec spacing-y">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="login-text">
                        <div class="title">{{__('Select City')}}/{{__('Covered Areas')}}</div>
                        <div class="title-des">{{__('Select the service area and the estimated time')}} </div>
                    </div>
                    <form method="post" action="{{ route('front.auth.covered.areas') }}" id="areaform">
                        @csrf
                        <div class="select-city-areas">
                            <div class="accordion" id="accordionExample">
                                <div class="card-city">
                                    <h2 class="mb-0 city-accordion">
                                        <button class="btn  d-flex align-items-center justify-content-between w-100"
                                            type="button" data-toggle="collapse" data-target="#collapseOne"
                                            aria-expanded="true" aria-controls="collapseOne">
                                            {{ translate($city->name) }}
                                            <div class="arrow-down-mt" data-toggle="collapse" data-target="#collapseOne"
                                                aria-expanded="true" aria-controls="collapseOne">
                                                <img src="{{ asset('assets/front/img/arrow-down2.svg') }}"
                                                    class="img-fluid" alt="">
                                            </div>
                                        </button>

                                    </h2>

                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                        data-parent="#accordionExample">
                                        <div class="inner-city">
                                            <div
                                                class="pt-2 pb-1 inner-city-heading d-flex align-items-center justify-content-between">
                                                <div class="city-name-title">
                                                    <h2>{{__('Areas')}}</h2>
                                                </div>
                                                <div class="city-name-title estimated-box">
                                                    <h2>{{__('Estimated Time')}}</h2>
                                                    @include('front.common.alert', ['input' => 'estimated_time.0'])
                                                </div>
                                            </div>
                                            <?php $i=0; ?>
                                            @foreach ($city->areas as $area)
                                                <div
                                                    class="city-list-input d-flex align-items-center justify-content-between">
                                                    <div class="city-name">
                                                        {{ translate($area->name) }}
                                                    </div>
                                                    <input type="hidden" hidden name="covered_areas[<?php echo $i; ?>][id]" value="0">
                                                    <input type="text" hidden name="covered_areas[<?php echo $i; ?>][city_id]" value="{{ $area->id }}"
                                                        placeholder="{{ __('e.g 50 mins') }}">
                                                    <div class="city-input w-100">
                                                        <div class="common-input-border">
                                                            <input type="number" min="1" max="999" oninput="validity.valid||(value='');"
                                                                name="covered_areas[<?php echo $i; ?>][estimated_time]"
                                                                placeholder="{{ __('e.g 50 mins') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $i++ ?>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button class="login-btn w-100">{{__('Select Covered Areas')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        $("#areaform").validate({
            rules: {
                // "estimated_time[]": "required"
            },
            messages: {
                "estimated_time[]": "Please select Estimated Time",
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.verify-btn-resend').on('click', function() {
                $.ajax({
                    url: window.Laravel.baseUrl + "verification-resend",
                    success: function(res) {
                        if (res.success == true) {
                            toastr.success(res.message, '{{ __('Success') }}');
                        } else {
                            // toastr.error('Something went wrong');
                        }
                    }
                })
            })
        })
    </script>
@endpush
