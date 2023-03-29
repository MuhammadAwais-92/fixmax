@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <main class="supplier-profile spacing-y">
        <div class="container">
            <div class="row">
                @include('front.dashboard.common.left-sidebar')
                <div class="col-xl-9 col-lg-8">
                    <div class="add-adsresses-content">
                        <form action="{{ route('front.dashboard.address.save', ['id' => 0]) }}" method="post"
                              enctype="multipart/form-data" id="addressForm">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6 col-6-ctm">
                                    <div class="common-input">
                                        <label class="input-label">{{__('Address')}} <span class="text-danger">*</span></label>
                                        <div class="input-address-mt">
                                            <input type="text" name="address" id="address"
                                                   value="{{ old('phone', $address->address) }}" class="address"
                                                   placeholder="{{ __('e.g Al-Ain') }}" readonly
                                                   data-target="#register-map-model" data-toggle="modal"
                                                   data-latitude="latitude" data-longitude="longitude"
                                                   data-address="address"
                                                   required>
                                            <button type="button" class="address-icon" data-target="#register-map-model"
                                                    data-toggle="modal" data-latitude="latitude"
                                                    data-longitude="longitude"
                                                    data-address="address"><i class="fas fa-map-marker-alt"></i>
                                            </button>
                                            <input type="hidden" name="latitude" id="latitude" class="latitude"
                                                   value="{{ old('phone', $address->latitude) }}">
                                            <input type="hidden" name="longitude" id="longitude" class="longitude"
                                                   value="{{ old('phone', $address->longitude) }}">
                                        </div>
                                        @include('front.common.alert', ['input' => 'address'])
                                    </div>
                                </div>
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id ?? '' }}">
                                <input type="hidden" name="id" id=""
                                       value="{{ empty(old('id')) ? (!empty($address->id) ? $address->id : old('id')) : old('id') }}">
                                <div class="col-sm-6 col-6-ctm">
                                    <div class="common-input">
                                        <label class="input-label">{{__('Address Name')}} <span
                                                class="text-danger">*</span></label>
                                        <input name="address_name" value="{{ old('phone', $address->address_name) }}"
                                               type="text" placeholder="{{__('e.g Home')}}" required>
                                        @include('front.common.alert', [
                                            'input' => 'address_name',
                                        ])
                                    </div>

                                </div>
                                <div class="col-sm-6 col-6-ctm">
                                    <div class="common-input">
                                        <label class="input-label">{{__('Phone Number')}} <span
                                                class="text-danger">*</span></label>
                                        <div class="d-flex phone-number-input">
                                            <input name="user_phone" id="supplier-phone" type="tel"
                                                   value="{{ old('user_phone', $address->user_phone) }}"
                                                   placeholder="{{__('895632542')}}" required autocomplete="off"
                                                   minlength="11"
                                                   maxlength="14">
                                        </div>
                                        @include('front.common.alert', [
                                            'input' => 'user_phone',
                                        ])
                                        <div class="phone_number"></div>
                                    </div>

                                </div>
                                <div class="col-sm-6 col-6-ctm">

                                </div>
                                <div class="col-sm-6 col-6-ctm">
                                    <div class="d-flex ctm-btnz-block mw-100">
                                        <a href="{{ route('front.dashboard.addresses.index') }}"
                                           class="secondary-btn border-btn mw-100 mr-05">
                                            {{__('Cancel')}}
                                        </a>
                                        <button class="secondary-btn mw-100 ml-05">
                                            {{__('Update')}}
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('front.common.map-modal')
@endsection

@push('scripts')
    <script>
        $("#addressForm").validate({
            ignore: '',
            rules: {
                'user_phone': {
                    required: true,
                    tel: true,
                }
            },
            errorPlacement: function (error, element) {

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
    </script>
@endpush
