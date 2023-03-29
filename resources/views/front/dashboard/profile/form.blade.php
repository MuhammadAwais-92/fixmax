@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <main class="supplier-edit-profile spacing-y">
        <div class="container">
            <div class="row">
                @include('front.dashboard.common.left-sidebar')
                @if ($user->isUser())
                    <div class="col-xl-9 col-lg-8">
                        <div class="sup-edit-profile-content">
                            <form id="editProfileForm" method="post"
                                  action="{!! route('front.dashboard.update.profile') !!}">
                                @csrf
                                <input type="text" name="user_type" value="{{ old('user_type', $user->user_type) }}"
                                       hidden>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="common-input">
                                            @include('front.common.image-upload', [
                                                'imageTitle' => __('Update Your Display Picture'),
                                                'inputName' => 'image',
                                                'isRequired' => 1,
                                                'allowVideo' => 0,
                                                'recommend_size' => '100 x 100',
                                                'imageNumber' => 1,
                                                'allowDelete' => 1,
                                                'displayImageSrc' => imageUrl(
                                                    old('image', $user->image_url),
                                                    100,
                                                    100,
                                                    95,
                                                    1
                                                ),
                                                'value' => old('image', $user->image),
                                            ])
                                            <div class="image"></div>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="common-input">
                                            @if ($user->isUser())
                                                <label class="input-label">{{ __('Full Name') }} <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="user_name"
                                                       value="{{ old('user_name', $user->user_name) }}"
                                                       placeholder="{{ __('John Doe') }}" required>
                                            @else
                                                <label class="input-label">{{ __('Full Name') }}</label>
                                                <input type="text" name="supplier_name[en]"
                                                       value="{{ old('supplier_name.en', $user->supplier_name['en']) }}"
                                                       placeholder="{{ __('John Doe') }}" required>
                                            @endif
                                            @include('front.common.alert', [
                                                'input' => 'user_name',
                                            ])
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="common-input">
                                            <label class="input-label">{{ __('Email') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                                   placeholder="{{ __('example@mail.com') }}" readonly required>
                                            @include('front.common.alert', ['input' => 'email'])
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="common-input">
                                            <label class="input-label">{{ __('Address') }} <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-address-mt">
                                                <input type="text" name="address" id="address"
                                                       value="{{ old('address', $user->address) }}" class="address"
                                                       placeholder="{{ __('e.g Al-Ain') }}" readonly
                                                       data-target="#register-map-model" data-toggle="modal"
                                                       data-latitude="latitude" data-longitude="longitude"
                                                       data-address="address" required>
                                                <button type="button" class="address-icon"
                                                        data-target="#register-map-model" data-toggle="modal"
                                                        data-latitude="latitude" data-longitude="longitude"
                                                        data-address="address"><i class="fas fa-map-marker-alt"></i>
                                                </button>
                                                <input type="hidden" name="latitude" id="latitude" class="latitude"
                                                       value="{{ old('latitude', $user->latitude) }}">
                                                <input type="hidden" name="longitude" id="longitude" class="longitude"
                                                       value="{{ old('longitude', $user->longitude) }}">
                                            </div>
                                            @include('front.common.alert', ['input' => 'address'])
                                            @include('front.common.alert', ['input' => 'latitude'])
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="common-input">
                                            <label class="input-label">{{ __('Phone Number') }} <span
                                                    class="text-danger">*</span></label>
                                            <div class="d-flex phone-number-input">
                                                <input id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                                                       placeholder="{{__('895632542')}}" type="tel" autocomplete="off"
                                                       data-intl-tel-input-id="0" minlength="11" maxlength="14"
                                                       required>
                                            </div>
                                            @include('front.common.alert', ['input' => 'phone'])
                                            <div class="phone_number"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">

                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex ctm-btnz-block mw-100">
                                            <a href="{{ route('front.dashboard.index') }}"
                                               class="secondary-btn border-btn mw-100 mr-05">
                                                {{ __('Cancel') }}
                                            </a>
                                            <button class="secondary-btn mw-100 ml-05">
                                                {{ __('Update') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
                @if ($user->isSupplier())
                    <div class="col-xl-9 col-lg-8">
                        <div class="change-password-box sup-edit-profile-content">
                            <form id="editProfileForm" method="post"
                                  action="{!! route('front.dashboard.update.profile') !!}">
                                @csrf
                                <input type="text" name="user_type" value="{{ old('user_type', $user->user_type) }}"
                                       hidden>
                                <input type="text" name="city" value="{{ old('city', $user->city_id) }}" hidden>
                                <input type="text" name="address" value="{{ old('address', $user->address) }}" hidden>
                                <input type="text" name="latitude" value="{{ old('latitude', $user->latitude) }}"
                                       hidden>
                                <input type="text" name="longitude" value="{{ old('longitude', $user->longitude) }}"
                                       hidden>
                                {{-- <div class="display-pic-block mb-2">
                                <div class="title">
                                    Update Your Display Picture
                                </div>
                                <div class="sup-img-box">
                                    <img src="img/sup-profile-img-2.jpg" alt="sup-img" class="img-fluid sup-img">
                                    <button class="edit-img-btn">
                                        <i class="fas fa-pen pr-05"></i>Edit Image
                                    </button>
                                </div>
                            </div> --}}

                                <div class="common-input">
                                    @include('front.common.image-upload', [
                                        'imageTitle' => __('Update Your Display Picture'),
                                        'inputName' => 'image',
                                        'isRequired' => 1,
                                        'allowVideo' => 0,
                                        'imageNumber' => 1,
                                        'recommend_size' => '100 x 100',
                                        'allowDelete' => 1,
                                        'displayImageSrc' => imageUrl(
                                            old('image', $user->image_url),
                                            100,
                                            100,
                                            100,
                                            1
                                        ),
                                        'value' => old('image', $user->image),
                                    ])
                                    <div class="image"></div>
                                </div>
                                <?php $x=0; ?>
                                @foreach ($languages as $key => $language )
                                @if($key==config('settings.default_language') || $key=='en')
                                <div class="common-input">
                                    <label class="input-label">{{ __('Company Name') }} ({{__($language['title'])}}) <span
                                            class="text-danger">*</span></label>
                                    <input type="text" type="text" name="supplier_name[{{$key}}]"
                                           value="{{ old('supplier_name.'.$key.'', isset($user->supplier_name[$key]) ? $user->supplier_name[$key] : '' ) }}"
                                           placeholder="{{ __('Charleston') }}" required>
                                    @include('front.common.alert', [
                                        'input' => 'supplier_name.'.$key.'',
                                    ])

                                </div>
                                @if($x==1)
                                {{-- <div class="col-lg-12 p-0">
                                    <button type="button" class="Add-field">More Company Name Translations</button>
                                </div> --}}
                                   
                                    @endif
                                    <?php $x++; ?>
                                @else
                                <div class="lang-new-input">
                                <div class="common-input">
                                    <label class="input-label">{{ __('Company Name') }} ({{__($language['title'])}}) </label>
                                    <input type="text" type="text" name="supplier_name[{{$key}}]"
                                           value="{{ old('supplier_name.'.$key.'', isset($user->supplier_name[$key]) ? $user->supplier_name[$key] : '' ) }}"
                                           placeholder="{{ __('Charleston') }}" >
                                    @include('front.common.alert', [
                                        'input' => 'supplier_name.'.$key.'',
                                    ])

                                </div>
                                </div>
                                @endif
                                @endforeach
                                {{-- <div class="common-input">
                                    <label class="input-label">{{ __('Company Name (Arabic)') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" type="text" name="supplier_name[ar]"
                                           value="{{ old('supplier_name.ar', $user->supplier_name['ar']) }}"
                                           placeholder="{{ __('Charleston') }}" required>
                                    @include('front.common.alert', [
                                        'input' => 'supplier_name.ar',
                                    ])

                                </div> --}}
                                <div class="common-input">
                                    <label class="input-label">{{ __('Email') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" type="email" name="email"
                                           value="{{ old('email', $user->email) }}"
                                           placeholder="{{ __('example@mail.com') }}" readonly required>
                                    @include('front.common.alert', ['input' => 'email'])
                                </div>
                                <div class="common-input">
                                    <label class="input-label">{{ __('Phone Number') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="d-flex phone-number-input">
                                        <input name="phone" id="supplier-phone" type="tel"
                                               value="{{ old('phone', $user->phone) }}" placeholder="{{__('895632542')}}" required
                                               autocomplete="off" minlength="11" maxlength="14">
                                    </div>
                                    @include('front.common.alert', ['input' => 'phone'])
                                    <div class="phone_number"></div>
                                </div>
                                <div class="common-input">
                                    <label class="input-label">{{ __('Address') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="input-address-mt">
                                        <input type="text" name="address" id="address"
                                               value="{{ old('address', $user->address) }}" class="address"
                                               placeholder="{{ __('e.g Al-Ain') }}" readonly
                                               data-target="#register-map-model" data-toggle="modal"
                                               data-latitude="latitude"
                                               data-longitude="longitude" data-address="address" required>
                                        <button type="button" class="address-icon" data-target="#register-map-model"
                                                data-toggle="modal" data-latitude="latitude" data-longitude="longitude"
                                                data-address="address"><i class="fas fa-map-marker-alt"></i></button>
                                        <input type="hidden" name="latitude" id="latitude" class="latitude"
                                               value="{{ old('latitude', $user->latitude) }}">
                                        <input type="hidden" name="longitude" id="longitude" class="longitude"
                                               value="{{ old('longitude', $user->longitude) }}">
                                    </div>
                                    @include('front.common.alert', ['input' => 'address'])
                                    @include('front.common.alert', ['input' => 'latitude'])
                                </div>
                                <div class="covered-area-block mb-2">
                                    <div class="title">
                                        {{ __('City') }}/{{ __('Covered Areas') }} <span
                                            class="text-danger">*</span>
                                    </div>
                                    <div
                                        class="area-name-row d-flex flex-wrap justify-content-between align-items-center">
                                        <h3 class="area-name">
                                            {{ translate($user->city->name) }}
                                        </h3>
                                        <div class="edit-del-btnz-block">
                                            <button type="button" class="edit-del-btn" data-toggle="modal"
                                                    data-target="#area-modal">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" data-toggle="modal" data-target="#area-modal-del"
                                                    class="edit-del-btn">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="area-time-block">
                                        @foreach ($coveredAreas as $area)
                                            @if ($area->area)
                                                <p class="d-flex flex-wrap align-items-center">
                                                    <span
                                                        class="font-light">{{ translate($area->area->name) }}</span><span
                                                        class="mx-05">-</span><span>{{ $area->estimated_time }}mins</span>
                                                </p>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="common-input">
                                    <label class="input-label">{{ __('Visit Fee') }}</label>
                                    <input type="text" class="form-control " id="max1" minlength="1" min="0"
                                           name="visit_fee" value="{{ old('visit_fee', $user->visit_fee) }}"
                                           placeholder="{{ __('e.g 20 AED') }}" required>
                                    @include('front.common.alert', ['input' => 'visit_fee'])

                                </div>
                                {{-- @dd($user->trade_license_image_url,$user->trade_license_image,$user->image_url,$user->image_url) --}}
                                <div class="common-input mb-1">
                                    @include('front.common.image-upload', [
                                        'imageTitle' => __('Attach Your Trade License'),
                                        'inputName' => 'trade_license_image',
                                        'isRequired' => 1,
                                        'allowVideo' => 0,
                                        'recommend_size' => '113 x 85',
                                        'imageNumber' => 2,
                                        'allowDelete' => 1,
                                        'displayImageSrc' => imageUrl(
                                            old('trade_license_image', $user->trade_license_image_url),
                                            113,
                                            85,
                                            95,
                                            1
                                        ),
                                        'value' => old('trade_license_image', $user->trade_license_image),
                                    ])
                                </div>
                                <div class="d-flex ctm-btnz-block mw-100">
                                    <button class="secondary-btn border-btn mw-100 mr-05">
                                        {{ __('Cancel') }}
                                    </button>
                                    <button class="secondary-btn mw-100 ml-05">
                                        {{ __('Update') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @php
                        $coveredAreasArray = $coveredAreas->toArray();
                        $coveredAreasIds = array_column($coveredAreasArray, 'city_id');
                        $cityAreas = $city->areas->toArray();
                        $cityAreasIds = array_column($cityAreas, 'id');
                        $additionalFields = array_diff($cityAreasIds, $coveredAreasIds);

                    @endphp
                    <div class="modal fade feature-packages-modal response-modal" id="area-modal" tabindex="-1"
                         role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="packages-box">
                                    <div class="headline-box">
                                        {{ __('Update Selected Areas') }}
                                    </div>
                                    <div class="innner-sec">
                                        <div class="col-md-12 mx-auto">
                                            <form method="post" action="{{ route('front.auth.covered.areas') }}"
                                                  id="areaform">
                                                @csrf
                                                <div class="select-city-areas">
                                                    <div class="accordion" id="accordionExample">
                                                        <div class="card-city">
                                                            <h2 class="mb-0 city-accordion">
                                                                <button
                                                                    class="btn  d-flex align-items-center justify-content-between w-100"
                                                                    type="button" data-toggle="collapse"
                                                                    data-target="#collapseOne" aria-expanded="true"
                                                                    aria-controls="collapseOne">
                                                                    {{ translate($city->name) }}
                                                                    <div class="arrow-down-mt" data-toggle="collapse"
                                                                         data-target="#collapseOne" aria-expanded="true"
                                                                         aria-controls="collapseOne">
                                                                        <img
                                                                            src="{{ asset('assets/frontimg/arrow-down2.svg') }}"
                                                                            class="img-fluid" alt="">
                                                                    </div>
                                                                </button>

                                                            </h2>

                                                            <div id="collapseOne" class="collapse show"
                                                                 aria-labelledby="headingOne"
                                                                 data-parent="#accordionExample">
                                                                <div class="inner-city">
                                                                    <div
                                                                        class="pt-2 pb-1 inner-city-heading d-flex align-items-center justify-content-between">
                                                                        <div class="city-name-title">
                                                                            <h2>{{ __('Areas') }}</h2>
                                                                        </div>
                                                                        <div class="city-name-title estimated-box">
                                                                            <h2>{{ __('Estimated Time') }}</h2>
                                                                            @include('front.common.alert',
                                                                                ['input' => 'estimated_time.0'])
                                                                        </div>
                                                                    </div>
                                                                    <?php $i = 0; ?>
                                                                    @foreach ($coveredAreas as $area)
                                                                        @if ($area->area)
                                                                            <div
                                                                                class="city-list-input d-flex align-items-center justify-content-between">
                                                                                <div class="city-name">
                                                                                    {{ translate($area->area->name) }}
                                                                                </div>
                                                                                <input type="text" hidden
                                                                                       name="covered_areas[<?php echo $i; ?>][id]"
                                                                                       value="{{ $area->id }}"
                                                                                       placeholder="{{ __('e.g 50 mins') }}">
                                                                                <input type="text" hidden
                                                                                       name="covered_areas[<?php echo $i; ?>][city_id]"
                                                                                       value="{{ $area->city_id }}"
                                                                                       placeholder="{{ __('e.g 50 mins') }}">
                                                                                <div class="city-input w-100">
                                                                                    <div class="common-input-border">
                                                                                        <input type="number" min="1"
                                                                                               value="{{ $area->estimated_time }}"
                                                                                               oninput="validity.valid||(value='');"
                                                                                               name="covered_areas[<?php echo $i; ?>][estimated_time]"
                                                                                               placeholder="{{ __('e.g 50 mins') }}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                        <?php $i++; ?>
                                                                    @endforeach
                                                                    @if (!empty($additionalFields))
                                                                        @foreach ($city->areas as $area)
                                                                            @if (in_array($area->id, $additionalFields))
                                                                                <div
                                                                                    class="city-list-input d-flex align-items-center justify-content-between">
                                                                                    <div class="city-name">
                                                                                        {{ translate($area->name) }}
                                                                                    </div>
                                                                                    <input type="hidden" hidden
                                                                                           name="covered_areas[<?php echo $i; ?>][id]"
                                                                                           value="0">
                                                                                    <input type="text" hidden
                                                                                           name="covered_areas[<?php echo $i; ?>][city_id]"
                                                                                           value="{{ $area->id }}"
                                                                                           placeholder="{{ __('e.g 50 mins') }}">
                                                                                    <div class="city-input w-100">
                                                                                        <div
                                                                                            class="common-input-border">
                                                                                            <input type="number" min="1"
                                                                                                   oninput="validity.valid||(value='');"
                                                                                                   name="covered_areas[<?php echo $i; ?>][estimated_time]"
                                                                                                   placeholder="{{ __('e.g 50 mins') }}">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <?php $i++; ?>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div
                                                    class="ctm-btnz-block renew-btnz d-flex justify-content-between align-items-center mw-100">
                                                    <button class="secondary-btn border-btn mr-1 mw-100" type="button"
                                                            data-dismiss="modal">
                                                        {{ __('Cancel') }}
                                                    </button>
                                                    <button class="secondary-btn ml-1 mw-100">
                                                        {{ __('Update') }}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade feature-packages-modal response-modal" id="area-modal-del" tabindex="-1"
                         role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="packages-box">
                                    <div class="headline-box">
                                        {{ __('Delete Selected Areas') }}
                                    </div>
                                    <div class="innner-sec">
                                        <div class="col-md-12 mx-auto">
                                            <form method="post" action="{{ route('front.auth.covered.areas') }}"
                                                  id="areaform">
                                                @csrf
                                                <div class="select-city-areas">
                                                    <div class="accordion" id="accordionExample">
                                                        <div class="card-city">
                                                            <h2 class="mb-0 city-accordion">
                                                                <button
                                                                    class="btn  d-flex align-items-center justify-content-between w-100"
                                                                    type="button" data-toggle="collapse"
                                                                    data-target="#collapseOne" aria-expanded="true"
                                                                    aria-controls="collapseOne">
                                                                    {{ translate($city->name) }}
                                                                    <div class="arrow-down-mt" data-toggle="collapse"
                                                                         data-target="#collapseOne" aria-expanded="true"
                                                                         aria-controls="collapseOne">
                                                                        <img
                                                                            src="{{ asset('assets/frontimg/arrow-down2.svg') }}"
                                                                            class="img-fluid" alt="">
                                                                    </div>
                                                                </button>

                                                            </h2>

                                                            <div id="collapseOne" class="collapse modal-delete-box show"
                                                                 aria-labelledby="headingOne"
                                                                 data-parent="#accordionExample">
                                                                <div class="inner-city">
                                                                    <div
                                                                        class="pt-2 pb-1 inner-city-heading d-flex align-items-center justify-content-between">
                                                                        <div class="city-name-title">
                                                                            <h2>{{ __('Areas') }}</h2>
                                                                        </div>
                                                                        <div class="city-name-title estimated-box">
                                                                            <h2>{{ __('Estimated Time') }}</h2>
                                                                            @include('front.common.alert',
                                                                                ['input' => 'estimated_time.0'])
                                                                        </div>
                                                                        <div class="city-name-title">

                                                                        </div>
                                                                    </div>
                                                                    @foreach ($coveredAreas as $area)
                                                                        @if ($area->area)
                                                                            <div
                                                                                class="city-list-input d-flex align-items-center justify-content-between">
                                                                                <div class="city-name">
                                                                                    {{ translate($area->area->name) }}
                                                                                </div>
                                                                                <div class="city-input w-100">
                                                                                    <div class="common-input-border">
                                                                                        <span>{{ $area->estimated_time }}{{ __('mins') }}</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="city-name">
                                                                                    <a class="deleteAddress edit-del-btn"
                                                                                       data-id="{{ $area->area->id }}"
                                                                                       class="edit-del-btn">
                                                                                        <i class="fas fa-trash-alt"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div
                                                    class="ctm-btnz-block renew-btnz d-flex justify-content-between align-items-center mw-100">
                                                    <button class="secondary-btn mw-100" type="button"
                                                            data-dismiss="modal">
                                                        {{ __('Cancel') }}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </main>

    @include('front.common.map-modal')
@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        $(".Add-new-field").click(function(){
            $(".lang-input").toggleClass("d-block");

});
$(".Add-field").click(function(){
            $(".lang-new-input").toggleClass("d-block");

});

});
</script>
    <script>
        console.log(window.Laravel.baseUrl);
        $(".deleteAddress").on('click', function (e) {
            let id = $(this).attr('data-id');
            $(".deleteAddress").attr('disabled', 'disabled');
            swal({
                    title: "{{ __('Are you sure you want to unselect this area?') }}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "{{ __('Yes') }}",
                    cancelButtonText: "{{ __('Cancel') }}",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {

                        $.ajax({

                            url: window.Laravel.baseUrl + "delete/covered-areas/" + id,
                            success: function (data) {
                                console.log(data);
                                toastr.success("{{ __('success') }}",
                                    "{{ __('Area removed successfully') }}")
                                location.reload();
                            }
                        })

                    } else {
                        $(".deleteAddress").attr('disabled', false);
                        swal.close()
                    }
                });
        });
        $("#editProfileForm").validate({
            ignore: '',
            rules: {
                'phone': {
                    required: true,
                    tel: true,
                },
                'image': {
                    required: true,
                },
                'supplier_name[en]': {
                    required: true,
                    noSpace: true,
                },
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "password") {
                    error.insertAfter(element);
                } else if (element.attr("name") === "phone") {
                    $(".phone_number").html(error);
                } else if (element.attr("name") === "image") {
                    $(".image").html(error);
                } else {
                    error.insertAfter(element);
                }
            },
        });
        $.validator.addMethod("noSpace", function (value, element) {
            return this.optional(element) || value === "NA" ||
                value.match(/\S/);
        }, "This field cannot be empty");
    </script>
@endpush
