@push('stylesheet-end')
    <style>
        .pac-container {
            z-index: 9999 !important;
        }
    </style>
@endpush
<div class="modal fade size-chart-modal" id="register-map-model" tabindex="-1" role="dialog"
     aria-labelledby="product-detail-modalTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="col-12 mt-2">
                <div class="common-input position-relative">
                    <label class="d-flex input-label">{{__('Address')}}<span class="text-danger">*</span></label>
                    <input type="text" name="address" id="model-address"
                           value="{{old('address')}}" class="ctm-input text-left address-padds-register" dir="ltr"
                           placeholder="{{__('Address')}}" required>
                    <input type="hidden" name="latitude" id="model-latitude" class="latitude"
                           value="{{old('latitude')}}">
                    <input type="hidden" name="longitude" id="model-longitude" class="longitude"
                           value="{{old('longitude')}}">
                </div>

            </div>
            <div class="map-mark-btn-relative">
                <div id="model-map" class="map-height-hah" style="height: 400px">
                </div>
                <div class="map-mark-btn">
                    <a type="button" class="marker" id="mark" onclick="getCurrentPosition()">
                        <img src="{{ asset('assets/front/img/target.png') }}" class="img-fluid">
                    </a>
                </div>
            </div>

            <div class="d-flex justify-content-between my-2 px-2">
                <button type="button" onclick="saveMapInformation()" class="secondary-btn mx-1" class="close"
                        aria-label="Close">
                    <div class="btn-inner-text">
                        {{__('Confirm')}}
                    </div>
                </button>
                <button onclick="closeModel()" class="secondary-btn border-btn mx-1">{{__('Close')}}</button>
            </div>

        </div>
    </div>
</div>


@push('scripts')
    <script>
        $(document).ready(function () {
            $('#register-map-model').on('show.bs.modal', function (event) {
                latitude = ($('#latitude').val()).length > 0 ? $('#latitude').val() : latitude;
                longitude = ($('#longitude').val()).length > 0 ? $('#longitude').val() : longitude;
                console.log(latitude, longitude);
                $('#model-address').val($('.address').val());
                initAutocomplete();

            });
        });
        var latitude = {{config('settings.latitude')}};
        var longitude = {{config('settings.longitude')}};
        var mapId = 'model-map';
        var searchId = 'model-address';
        var latElement = 'model-latitude';
        var lngElement = 'model-longitude';
        var allowGeoRecall = true;

        function getCurrentPosition() {
            $('#address').val('');
            $('#latitude').val('');
            $('#longitude').val('');
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, positionError);

            } else {
                toastr.error("Sorry, your browser does not support HTML5 geolocation.");
            }
        }

        function positionError() {
            toastr.error('Geolocation is not enabled. Please enable to use this feature');
        }

        function showPosition(position) {
            console.log('posiiton accepted')
            var google_map_pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            var google_maps_geocoder = new google.maps.Geocoder();
            google_maps_geocoder.geocode(
                {'latLng': google_map_pos},
                function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK && results[0]) {
                        $('#model-address').val(results[0].formatted_address);
                        lat = [position.coords.latitude];
                        long = [position.coords.longitude];
                        latitude = lat;
                        longitude = long;
                        initAutocomplete();
                    }
                }
            );
            allowGeoRecall = false;
        }

        function initAutocomplete() {
            var map = new google.maps.Map(document.getElementById(mapId), {
                center: {lat: parseFloat(latitude), lng: parseFloat(longitude)},
                zoom: 13,
                mapTypeId: 'roadmap'
            });
            var marker = new google.maps.Marker({
                position: {
                    lat: parseFloat(latitude), lng: parseFloat(longitude)
                },
                map: map,
                draggable: true
            });
            var searchBox = new google.maps.places.SearchBox(document.getElementById(searchId));
            google.maps.event.addListener(searchBox, 'places_changed', function () {

                var places = searchBox.getPlaces();
                var bounds = new google.maps.LatLngBounds();
                var i, place;

                for (i = 0; place = places[i]; i--) {
                    bounds.extend(place.geometry.location);
                    marker.setPosition(place.geometry.location);
                }

                map.fitBounds(bounds);
                map.setZoom(15);

            });
            google.maps.event.addListener(marker, 'position_changed', function () {
                var lat = marker.getPosition().lat();
                var lng = marker.getPosition().lng();
                document.getElementById(latElement).value = lat;
                document.getElementById(lngElement).value = lng;
            });
            google.maps.event.addListener(marker, 'dragend', function () {
                var lat = marker.getPosition().lat();
                var lng = marker.getPosition().lng();
                const latlng = {
                    lat: parseFloat(lat),
                    lng: parseFloat(lng),
                };

                const geocoder = new google.maps.Geocoder();
                geocoder.geocode({location: latlng}, (results, status) => {
                    if (status === "OK") {
                        if (results[0]) {
                            document.getElementById(searchId).value = results[0].formatted_address
                        } else {
                            window.alert("No results found");
                        }
                    } else {
                        window.alert("Geocoder failed due to: " + status);
                    }
                });
            });

        }
    </script>

    <script>
        function saveMapInformation() {
            $('.latitude').val($('#model-latitude').val());
            $('.longitude').val($('#model-longitude').val());
            $('.address').val($('#model-address').val());
            $('#register-map-model').modal('hide');
        }

        function closeModel() {
            $('#register-map-model').modal('hide');
        }
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNcTmnS323hh7tSQzFdwlnB4EozA3lwcA&libraries=places&language={{$locale}}&callback=initAutocomplete"></script>

@endpush
