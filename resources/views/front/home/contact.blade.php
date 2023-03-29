@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')

    <main class="contact-us spacing-y">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-detail-mt">
                        <h2 class="primary-headline">
                            {{__('Contact Us')}}
                        </h2>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-6-ctm">
                    <div class="contact-info-card">
                        <div class="icon-block">
                            <svg id="LocationIcon" xmlns="http://www.w3.org/2000/svg" width="18" height="25.714"
                                 viewBox="0 0 18 25.714">
                                <path id="LocationIcon-2" data-name="LocationIcon"
                                      d="M19,4a9,9,0,0,0-9,9c0,6.75,9,16.714,9,16.714S28,19.75,28,13A9,9,0,0,0,19,4Zm0,12.214A3.214,3.214,0,1,1,22.214,13,3.215,3.215,0,0,1,19,16.214Z"
                                      transform="translate(-10 -4)" fill="#003149"/>
                            </svg>

                        </div>
                        <div class="desc-block">
                            <h3 class="title text-truncate">
                                {{__('Contact Us')}}
                            </h3>
                            <a href="https://www.google.com/maps/dir//{!! config('settings.latitude') !!},{!! config('settings.longitude') !!}/@ {!! config('settings.latitude') !!},{!! config('settings.longitude') !!},12z"
                               class="add-link" dir="ltr" target="_blank">
                                {!! config('settings.address') !!}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-6-ctm">
                    <div class="contact-info-card">
                        <div class="icon-block">
                            <svg id="CellIcon" xmlns="http://www.w3.org/2000/svg" width="25.065" height="25.063"
                                 viewBox="0 0 25.065 25.063">
                                <path id="CellIcon-2" data-name="CellIcon"
                                      d="M-3300.922-102.442a23.906,23.906,0,0,1-14.469-7.284,23.915,23.915,0,0,1-7.284-14.468.861.861,0,0,1,.475-.86l4.949-2.33a.864.864,0,0,1,1.12.315l3.082,4.786a.865.865,0,0,1-.121,1.07l-1.937,1.934a.864.864,0,0,0-.247.72,10.113,10.113,0,0,0,3.055,5.743,10.113,10.113,0,0,0,5.743,3.054.86.86,0,0,0,.72-.246l1.934-1.936a.866.866,0,0,1,1.069-.121l4.787,3.082a.863.863,0,0,1,.313,1.117l-2.331,4.949a.858.858,0,0,1-.77.48A.849.849,0,0,1-3300.922-102.442Zm1.579-12.527a10.815,10.815,0,0,0-10.8-10.8.864.864,0,0,1-.864-.864.865.865,0,0,1,.864-.865,12.546,12.546,0,0,1,12.533,12.531.865.865,0,0,1-.254.612.867.867,0,0,1-.611.253A.865.865,0,0,1-3299.343-114.969Zm-4.322,0a6.487,6.487,0,0,0-6.482-6.481.865.865,0,0,1-.864-.865.864.864,0,0,1,.864-.864,8.221,8.221,0,0,1,8.211,8.21.865.865,0,0,1-.864.865A.866.866,0,0,1-3303.665-114.969Z"
                                      transform="translate(3322.68 127.5)" fill="#003149"/>
                            </svg>
                        </div>
                        <div class="desc-block">
                            <h3 class="title text-truncate">
                                {{__('Call Us')}}
                            </h3>
                            <a href="tel:{!! config('settings.contact_number') !!}" dir="ltr" class="add-link">
                                {!! config('settings.contact_number') !!}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-6-ctm">
                    <div class="contact-info-card">
                        <div class="icon-block">
                            <svg id="Icon_material-email" data-name="Icon material-email"
                                 xmlns="http://www.w3.org/2000/svg"
                                 width="30" height="24" viewBox="0 0 30 24">
                                <path id="Icon_material-email-2" data-name="Icon material-email"
                                      d="M30,6H6A3,3,0,0,0,3.015,9L3,27a3.009,3.009,0,0,0,3,3H30a3.009,3.009,0,0,0,3-3V9A3.009,3.009,0,0,0,30,6Zm0,6L18,19.5,6,12V9l12,7.5L30,9Z"
                                      transform="translate(-3 -6)" fill="#003149"/>
                            </svg>
                        </div>
                        <div class="desc-block">
                            <h3 class="title text-truncate">
                                {{__('Mail Us')}}
                            </h3>
                            <a href="mailto: {!! config('settings.email') !!}" dir="ltr" class="add-link">
                                {!! config('settings.email') !!}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <form action="{!! route('front.contactUs.email') !!}" id="contact-form" method="post">
                        @csrf
                        <div class="contact-form-block">
                            <div class="common-input ">
                                <label class="input-label">{{__('What can we help you with?')}} <span
                                        class="text-danger">*</span></label>
                                <select class="js-example-basic-single" required name="subject">
                                    <option value="" disabled selected> {{ __('Subject of Email') }}</option>
                                    <option
                                        value="feedback" {!! old('subject') == 'feedback' ? 'selected' : '' !!}>{{ __('Feedback') }}</option>
                                    <option
                                        value="suggestions" {!! old('subject') == 'suggestions' ? 'selected' : '' !!}>{{ __('Suggestions') }}</option>
                                    <option
                                        value="complaints" {!! old('subject') == 'complaints' ? 'selected' : '' !!}>{{ __('Complaints') }}</option>
                                    <option
                                        value="inquiries" {!! old('subject') == 'inquiries' ? 'selected' : '' !!}> {{ __('Inquiries') }}</option>
                                </select>
                                <span id="servId"></span>
                            </div>
                            @include('front.common.alert', ['input' => 'subject'])
                        </div>
                        <div class="common-input">
                            <label class="input-label">{{__('Full Name')}} <span class="text-danger">*</span></label>
                            <input type="text" name="name" required minlength="3" maxlength="60"
                                   placeholder="{{ __('John Doe') }}">
                            @include('front.common.alert', ['input' => 'name'])
                        </div>
                        <div class="common-input">
                            <label class="input-label">{{__('Email')}} <span class="text-danger">*</span></label>
                            <input type="email" name="email" required class="input-label"
                                   placeholder="{{ __('e.g example@mail.com') }}">
                            @include('front.common.alert', ['input' => 'email'])
                        </div>
                        <div class="common-input">
                            <label class="input-label">{{__('Comments')}} <span class="text-danger">*</span></label>
                            <textarea class="ctm-textarea" name="message_text" required
                                      placeholder="{{ __('Lorem ipsum dolor sit amet....') }}"></textarea>
                            @include('front.common.alert', ['input' => 'message_text'])

                        </div>
                        <button class="secondary-btn mw-100 h-5">
                            {{__('Send Message')}}
                        </button>
                    </form>

                </div>
                <div class="col-md-6">
                    <div id="map" class="contact-map-sec">
                        {{-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d232920.73294342324!2d55.60678239508811!3d24.19324132156607!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e8ab145cbd5a049%3A0xf56f8cea5bf29f7f!2sAl%20Ain%20-%20Abu%20Dhabi%20-%20United%20Arab%20Emirates!5e0!3m2!1sen!2s!4v1643634260541!5m2!1sen!2s" style="border:0;" allowfullscreen="" loading="lazy"></iframe> --}}
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection



@push('scripts')
    <script>
        $('#contact-form').validate({
            ignore: '',
            rules: {
                'subject': {
                    required: true,
                    noSpace: true,
                },
                'name': {
                    required: true,
                    noSpace: true,
                },
                'email': {
                    required: true,
                    maxlength: 60,
                    noSpace: true,
                },
                'message_text': {
                    required: true,
                    maxlength: 60,
                    noSpace: true,
                },
            },
            errorPlacement: function (error, element) {
                console.log(element.attr("name"));
                if (element.attr("name") === "subject") {
                    // error.insertAfter(element.parent());
                    $("#servId").html(error);
                } else {
                    error.insertAfter(element);
                }
            },
        });
        $(document).ready(function () {
            $('.feedbackRadio').click(function () {
                $('.feedbackName').empty();
                $('.feedbackName').append($(this).parent('label').text());

            })
            $('.js-example-basic-single').select2({
                placeholder: "{{ __('Select option') }}",
                minimumResultsForSearch: Infinity,
            });

        })
    </script>
    <script>
        var lat = {{ config('settings.latitude') }};
        var lng = {{ config('settings.longitude') }};
        $(document).ready(function () {
            initMap();
        });

        function initMap() {
            console.log("contact map initmap should work");

            // The location of Uluru
            var uluru = {
                lat: lat,
                lng: lng
            };
            var uluru2 = {
                lat: window.currentLat,
                lng: window.currentLng
            };
            var map = new google.maps.Map(
                document.getElementById('map'), {
                    zoom: 15,
                    center: uluru,
                    styles: [{
                        "elementType": "geometry",
                        "stylers": [{
                            "color": "#f5f5f5"
                        }]
                    },
                        {
                            "elementType": "labels.icon",
                            "stylers": [{
                                "visibility": "off"
                            }]
                        },
                        {
                            "elementType": "labels.text.fill",
                            "stylers": [{
                                "color": "#616161"
                            }]
                        },
                        {
                            "elementType": "labels.text.stroke",
                            "stylers": [{
                                "color": "#f5f5f5"
                            }]
                        },
                        {
                            "featureType": "administrative.land_parcel",
                            "elementType": "labels.text.fill",
                            "stylers": [{
                                "color": "#bdbdbd"
                            }]
                        },
                        {
                            "featureType": "poi",
                            "elementType": "geometry",
                            "stylers": [{
                                "color": "#eeeeee"
                            }]
                        },
                        {
                            "featureType": "poi",
                            "elementType": "labels.text.fill",
                            "stylers": [{
                                "color": "#757575"
                            }]
                        },
                        {
                            "featureType": "poi.park",
                            "elementType": "geometry",
                            "stylers": [{
                                "color": "#e5e5e5"
                            }]
                        },
                        {
                            "featureType": "poi.park",
                            "elementType": "labels.text.fill",
                            "stylers": [{
                                "color": "#9e9e9e"
                            }]
                        },
                        {
                            "featureType": "road",
                            "elementType": "geometry",
                            "stylers": [{
                                "color": "#ffffff"
                            }]
                        },
                        {
                            "featureType": "road.arterial",
                            "elementType": "labels.text.fill",
                            "stylers": [{
                                "color": "#757575"
                            }]
                        },
                        {
                            "featureType": "road.highway",
                            "elementType": "geometry",
                            "stylers": [{
                                "color": "#dadada"
                            }]
                        },
                        {
                            "featureType": "road.highway",
                            "elementType": "labels.text.fill",
                            "stylers": [{
                                "color": "#616161"
                            }]
                        },
                        {
                            "featureType": "road.local",
                            "elementType": "labels.text.fill",
                            "stylers": [{
                                "color": "#9e9e9e"
                            }]
                        },
                        {
                            "featureType": "transit.line",
                            "elementType": "geometry",
                            "stylers": [{
                                "color": "#e5e5e5"
                            }]
                        },
                        {
                            "featureType": "transit.station",
                            "elementType": "geometry",
                            "stylers": [{
                                "color": "#eeeeee"
                            }]
                        },
                        {
                            "featureType": "water",
                            "elementType": "geometry",
                            "stylers": [{
                                "color": "#c9c9c9"
                            }]
                        },
                        {
                            "featureType": "water",
                            "elementType": "labels.text.fill",
                            "stylers": [{
                                "color": "#9e9e9e"
                            }]
                        }
                    ]
                });

            var image = "{!! url('assets/front/img/pointer-icon.png') !!}"
            var marker = new google.maps.Marker({
                map: map,
                position: uluru,
                icon: image
            });
            marker.info = new google.maps.InfoWindow({
                content: '<p>{!! config('settings.address') !!}</p> '
            });
            marker.info.open(map, marker);
        }
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNcTmnS323hh7tSQzFdwlnB4EozA3lwcA&libraries=places&callback=initMap">
    </script>
@endPush
