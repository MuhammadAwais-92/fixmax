{!! Form::model($city, ['url' => $action, 'method' => 'post',  'class' => 'm-form m-form--fit m-form--label-align-right', 'enctype' => 'multipart/form-data']) !!}
<?php $x = 0; ?>
@foreach ($languages as $key => $language )
@if($key==config('settings.default_language') || $key=='en')
<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Name In {{$language['title']}}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            {!! Form::text('name['.$key.']',old('name['.$key.']', $city->name[$key]), ['class' => 'form-control', 'placeholder' => 'Title', 'required'=>'required']) !!}
        </div>
    </div>
{{--    <input type="hidden" name="parent_id" value="0">--}}

</div>
@if ($x == 1)
{{-- <button type="button" class="Add-field">More Question Translations</button> --}}
@endif
<?php $x++; ?>
@else
<div class="lang-input">
<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Name In {{$language['title']}}
        </label>
        <div class="col-7">
            {!! Form::text('name['.$key.']',old('name['.$key.']', $city->name[$key]), ['class' => 'form-control', 'placeholder' => 'Title']) !!}
        </div>
    </div>
{{--    <input type="hidden" name="parent_id" value="0">--}}

</div>
</div>
@endif
@endforeach
<div class="m-portlet__body">
    {{-- <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Name in Arabic') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            {!! Form::text('name[ar]',old('name[ar]', $city->name['ar']), ['class' => 'form-control', 'placeholder' => 'Title', 'required'=>'required']) !!}
        </div>
    </div> --}}
    <div class="m-form__group row" style="margin-top:40px">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Select Location') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            <div class="d-flex align-items-center justify-contnet-between mb-3">
                {!! Form::text('address', old('address'), ['class' => 'form-control', 'placeholder' => 'Search map', 'id'=>'address']) !!}
                <div class="ml-2">
                    <button type="button" onclick="recreateMap()" class="btn btn-accent m-btn m-btn--air m-btn--custom">
                        Reset
                    </button>
                </div>
                @if($city->id > 0)
                    <div class="ml-2">
                        <button type="button" onclick="editMap()" class="btn btn-accent m-btn m-btn--air m-btn--custom">
                            Edit
                        </button>
                    </div>
                @endif
            </div>
            <div id="map" style="height:400px; width:100%; margin-top:5px"></div>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Selected Polygon lat/long
        </label>
        <div class="col-7">
            <textarea class="form-control" disabled name="vertices" id="vertices" cols="50"
                      rows="10">{{old('polygon',$city->polygon) ?? ''}}</textarea>
        </div>
    </div>
    <input type="hidden" name="parent_id" value="{{$city->parent_id?$city->parent_id:$parent}}">
    <input type="hidden" name="city_id" value="{{$parent}}">
    <input type="text" name="latitude" id="latitude" value="{{$city->latitude}}" hidden>
    <input type="text" name="longitude" id="longitude" value="{{$city->longitude}}" hidden>
    <input type="text" name="polygon" id="polygon" value="{{old('polygon',$city->polygon)}}" hidden>

</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">

            <input type="hidden" value="PUT" name="_method">
{{--            <input type="hidden" name="language_id" value="{!! $languageId !!}">--}}
            <div class="col-4"></div>
            <div class="col-7">
                @if($cityId == 0)
                    <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-3">
                        Add Area
                    </button>
                @else
                    <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-3">
                        Update Area
                    </button>
                @endif
                <a href="{!! route('admin.dashboard.cities.index') !!}"
                   class="btn btn-secondary m-btn m-btn--air m-btn--custom">Cancel</a>
            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}
<script>
    $(document).ready(function () {
        $('.select_image').hide();
    });

    $(document).ready(function () {
        $(document).on('change', '.btn-file :file', function () {
            var input = $(this),
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [label]);
        });

        $('.btn-file :file').on('fileselect', function (event, label) {

            var input = $(this).parents('.input-group').find(':text'),
                log = label;

            if (input.length) {
                input.val(log);
            } else {
                if (log) alert(log);
            }

        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#img-upload').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function () {
            readURL(this);
        });
    });
</script>
