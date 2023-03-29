@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <main class="portfolio manage-equipment spacing-y">
        <div class="container">
            <div class="row">
                @include('front.dashboard.common.left-sidebar')
                <div class="col-xl-9 col-lg-8">
                    <div class="saved-addresses-content">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="secondary-btn btn-17 link-btns" data-toggle="modal"
                                        data-target="#addressModal" id="address-modal">
                                        {{ __('Add New Address') }}
                                    </button>

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
                                                <input type="text" class="ctm-input" hidden name="user_id"
                                                    value="{{ auth()->user()->id }}" id="edit-username">
                                                <input type="text" class="ctm-input" hidden name="id" value="0"
                                                    id="edit-id">
                                                <div class="innner-sec">
                                                    <div class="common-input">
                                                        <label class="input-label">{{ __('Address Name') }} <span
                                                                class="text-danger">*</label>
                                                        <input type="text" name="address_name" required
                                                            placeholder="{{ __('Enter Address Name') }}" id="edit-name">
                                                    </div>
                                                    <div class="common-input">
                                                        <label class="input-label">{{ __('Phone no') }} <span
                                                                class="text-danger">*</label>
                                                        <input type="text" id="supplier-phone" type="tel"
                                                            name="user_phone" placeholder="{{ __('Enter Phone no') }}"
                                                            required autocomplete="off" minlength="11" maxlength="14">
                                                    </div>
                                                    <div class="common-input">
                                                        <label class="input-label">{{ __('City') }} <span
                                                                class="text-danger">*</span></label>
                                                        <select class="js-example-basic-single" name="city_id"
                                                            id="city" required>
                                                            <option value="">{{ __('e.g Ajman') }}</option>
                                                            @foreach ($cities as $city)
                                                                <option value="{{ $city->id }}">
                                                                    {!! translate($city->name) !!}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                    <div class="common-input" id="area_div">
                                                        <label class="input-label">{{ __('Area') }} <span
                                                                class="text-danger">*</span></label>
                                                        <select class="js-example-basic-single" name="area_id"
                                                            id="area" required>


                                                        </select>
                                                    </div>
                                                    <div class="common-input area-map">
                                                        <label class="input-label"> {{ __('Address') }} <span
                                                                class="text-danger">*</span></label>
                                                        <div data-target="#mapModal" data-toggle="modal"
                                                            class="type-pass address-field">
                                                            <input type="text" name="address"
                                                                value="{{ old('address') }}" class="ctm-input address"
                                                                placeholder="{{ __('Select address from map') }}" readonly required
                                                                id="address">
                                                        </div>
                                                        <input type="hidden" name="latitude" id="latitude"
                                                            class="latitude" value="{{ old('latitude') }}">
                                                        <input type="hidden" name="longitude" id="longitude"
                                                            class="longitude" value="{{ old('longitude') }}">

                                                        </select>
                                                    </div>
                                                    <div class="common-input area-map">
                                                        <div id="map"
                                                            style="height: 400px;position: relative;overflow: hidden;">
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-wrap">
                                                        <div class="px-1 w-50">
                                                            <button type="submit" class="secondary-btn mw-100">
                                                                {{ __('Submit') }}
                                                            </button>
                                                        </div>
                                                        <div class="px-1 w-50">
                                                            <button type="button" class="secondary-btn border-btn mw-100"
                                                                type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
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
                            @forelse($addresses as $address)
                                <div class="col-sm-6 col-6-ctm">
                                    <div class="saved-address-card">
                                        <div
                                            class="add-title-type-row d-flex align-items-center justify-content-between flex-wrap">
                                            <h4 class="add-title">
                                                {{ $address->address_name }}
                                            </h4>
                                            @if ($address->default_address)
                                                <h5 class="add-type">
                                                    {{ __('Default Address') }}
                                                </h5>
                                            @else
                                                <div class="add-type">
                                                    <button onclick="setDefault({{ $address->id }})"
                                                        class="make-default">{{ __('Set as Default') }}</button>
                                                </div>
                                            @endif
                                        </div>
                                        <div
                                            class="add-desc-row d-flex justify-content-between flex-wrap align-items-start">
                                            <div class="add-desc-block d-flex flex-column">
                                                <span class="street-add">
                                                    {{ $address->address }}
                                                </span>
                                                {{-- <span class="city">Jeddah</span> --}}
                                                <a href="tel: {{ $address->user_phone }}" dir="ltr">
                                                    {{ $address->user_phone }}
                                                </a>
                                            </div>
                                            <div class="edit-del-btnz d-flex align-items-center justify-content-center">
                                                
                                                    <button class="edit-del-btn edit-address" data-toggle="modal"
                                                    data-target="#addressModal" value="{{ $address->id }}">
                                                        <i class="fas fa-edit link-btns"></i>
                                                    </button>
                                             

                                                <span class="seprater"></span>
                                                <button class="deleteAddress edit-del-btn" data-id="{{ $address->id }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-danger w-100" role="alert">
                                        {{ __('No Address Found') }}
                                    </div>
                                </div>
                            @endforelse
                            {{ $addresses->links('front.common.pagination', ['paginator' => $addresses]) }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
@endsection
@push('scripts')
    <script>
        $(".link-btns").click(function(){
                            $("html").addClass("fix-html");
 
}); 

  $("#addressModal").on('hide.bs.modal', function(){
    $("html").removeClass("fix-html");
  });
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

                            url: window.Laravel.baseUrl + "dashboard/delete-address/" + id,
                            success: function(data) {
                                toastr.success("{{ __('success') }}",
                                    "{{ __('Address removed successfully') }}")
                                location.reload();
                            }
                        })

                    } else {
                        $(".deleteAddress").attr('disabled', false);
                        swal.close()
                    }
                });
        });

        function setDefault(id) {
            let url = window.Laravel.baseUrl + 'dashboard/make-default'
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    id: id
                },
                headers: {
                    'X-CSRF-TOKEN': window.Laravel.csrfToken,

                }
            }).done((res) => {

                if (res.success == false) {

                    toastr.error('{{ __('Error') }}', res.message)
                    location.reload();

                } else {
                    toastr.success('{{ __('Success') }}', res.message)

                    location.reload();


                }
            })
        }
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
                getArea(id);
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
