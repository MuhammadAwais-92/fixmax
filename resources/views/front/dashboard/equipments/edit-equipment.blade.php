@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <main class="supplier-profile spacing-y">
        <div class="container">
            <div class="row">
                @include('front.dashboard.common.left-sidebar')
                <div class="col-xl-9 col-lg-8 col-md-6">
                    <form action="{{ route('front.dashboard.equipment.save', ['id' => 0]) }}" method="post"
                          enctype="multipart/form-data" id="equipmentForm">
                        @csrf
                        <div class="row">

                            <div class="col-md-12">
                                <div class="common-input ">
                                    @include('front.common.image-upload', [
                                        'imageTitle' => __('Upload Image'),
                                        'inputName' => 'image',
                                        'isRequired' => 1,
                                        'recommend_size'=> '262 x 131',
                                        'allowVideo' => 0,
                                        'imageNumber' => 1,
                                        'allowDelete' => 0,
                                        'displayImageSrc' => imageUrl(
                                            old('image', $equipment->image_url),
                                            263,
                                            131,
                                            95,
                                            1
                                        ),
                                        'value' => old('image', $equipment->image),
                                    ])
                                    <div id="" class="text-danger element16"></div>
                                    @include('front.common.alert', ['input' => 'image'])
                                </div>
                            </div>
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id ?? '' }}">
                            <input type="hidden" name="id" id=""
                                   value="{{ empty(old('id')) ? (!empty($equipment->id) ? $equipment->id : old('id')) : old('id') }}">
                            <div class="col-md-6">
                                <div class="common-input">
                                    <label class="input-label">{{__('Service Name')}} <span
                                            class="text-danger">*</span></label>
                                    <select class="js-example-basic-single" name="service_id" reuqired>
                                        <option value="" readonly="" selected>{{ __('Select Service') }}</option>
                                        @forelse($services as $service)
                                            <option value="{{ $service->id }}"
                                                {{ empty(old('service_id'))? (!empty($equipment->service_id)? ($equipment->service_id == $service->id? 'selected': ''): ''): old('service_id') }}>
                                                {{ translate($service->name) ?? '' }}</option>
                                        @empty
                                            <option value="" disabled selected>{{ __('Select Service') }}
                                            </option>
                                        @endforelse
                                    </select>
                                    <div id="servId"></div>

                                    @include('front.common.alert', ['input' => 'service_id'])
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="common-input">
                                    <label class="input-label">{{__('Equipment Price')}} <span
                                            class="text-danger">*</span></label>
                                    <input type="text"
                                           value="{{ empty(old('price')) ? (!empty($equipment->price) ? $equipment->price : old('price')) : old('price') }}"
                                           name="price" placeholder="{{__('Price')}}" min="1" required>
                                    <div id="price"></div>
                                    @include('front.common.alert', ['input' => 'price'])
                                </div>
                            </div>
                            <?php $x=0; ?>

                            @foreach ($languages as $key => $language )
                            @if($key==config('settings.default_language') || $key=='en')

                            <div class="col-md-6">
                                <div class="common-input">
                                    <label class="input-label">{{ __('Name In') }} {{__($language['title']) }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name[{{$key}}]" maxlength="60"
                                           value="{{ empty(old('name.'.$key.''))? (!empty($equipment->name) && isset($equipment->name[$key]) ?  $equipment->name[$key]: old('name.'.$key.'')): old('name.'.$key.'') }}"
                                           class="form-control " placeholder="{{ __('Equipment Name') }}" required
                                           autocomplete="off">
                                    @include('front.common.alert', ['input' => 'name.'.$key.''])
                                </div>
                            </div>
                            @if($x==1)
                            {{-- <div class="col-lg-12">
                                <button type="button" class="Add-new-field">More Name Translations</button>
                            </div> --}}
                               
                                @endif
                                <?php $x++; ?>
                            @else
                            <div class="col-md-6">
                                <div class="lang-input ">
                                <div class="common-input">
                                    <label class="input-label">{{ __('Name In') }} {{__($language['title']) }} </label>
                                    <input type="text" name="name[{{$key}}]" maxlength="60"
                                           value="{{ empty(old('name.'.$key.''))? (!empty($equipment->name) && isset($equipment->name[$key]) ? $equipment->name[$key]: old('name.'.$key.'')): old('name.'.$key.'') }}"
                                           class="form-control " placeholder="{{ __('Equipment Name') }}" 
                                           autocomplete="off">
                                    @include('front.common.alert', ['input' => 'name.'.$key.''])
                                </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                            {{-- <div class="col-md-6">
                                <div class="common-input">
                                    <label class="input-label">{{ __('Name In Arabic') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name[ar]" maxlength="60"
                                           value="{{ empty(old('name.ar'))? (!empty($equipment->name)? $equipment->name['ar']: old('name.ar')): old('name.ar') }}"
                                           class="form-control " placeholder="{{ __('Equipment Name') }}" required
                                           autocomplete="off">
                                    @include('front.common.alert', ['input' => 'name.ar'])
                                </div>
                            </div> --}}
                     
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="common-input">
                                    <label class="input-label">{{__('Equipment Model')}} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="equipment_model"
                                           value="{{ empty(old('equipment_model'))? (!empty($equipment->equipment_model)? $equipment->equipment_model: old('equipment_model')): old('equipment_model') }}"
                                           placeholder="{{__('Plasthetics')}}" required>
                                    @include('front.common.alert', ['input' => 'equipment_model'])
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="common-input mb-3">
                                    <label class="input-label">{{__('Make')}} <span
                                            class="text-danger">*</span></label>
                                    <input type="number" min="1900" max="2099" step="1" name="make"
                                           value="{{ empty(old('make')) ? (!empty($equipment->make) ? $equipment->make : old('make')) : old('make') }}"
                                           placeholder="{{__('2021')}}" required>
                                    @include('front.common.alert', ['input' => 'make'])

                                </div>
                            </div>
                      
                            @if (!empty($equipment->id))
                                <div class="col-md-12">
                                    <button class="login-btn w-50">
                                        {{__('Update Equipment')}}
                                    </button>
                                </div>
                            @else
                                <div class="col-md-12">
                                    <button class="login-btn w-50">
                                        {{__('Add Equipment')}}
                                    </button>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
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
        $(document).ready(function () {

            $('#equipmentForm').validate({
                ignore: '',
                rules: {
                    'description[en]': {
                        required: true,
                        noSpace: true,
                    },
                    'description[ar]': {
                        required: true,
                        noSpace: true,
                    },
                    'name[en]': {
                        required: true,
                        maxlength: 60,
                        noSpace: true,
                    },
                    'name[{{config('settings.default_language')}}]': {
                        required: true,
                        maxlength: 60,
                        noSpace: true,
                    },
                    'equipment_model': {
                        required: true,
                        maxlength: 60,
                        noSpace: true,
                    },
                    'service_id': {
                        required: true,
                    },
                    'make': {
                        required: true,
                        digits: true,
                        maxlength: 4,

                    },
                    'price': {
                        required: true,
                        digits: true,
                    }
                },
                errorPlacement: function (error, element) {
                    console.log(element.attr("name"));
                    if (element.attr("name") === "service_id") {
                        // error.insertAfter(element.parent());
                        $("#servId").html(error);
                    } else if (element.attr("name") === "category_id") {
                        // error.insertAfter(element.parent());
                        $("#cate").html(error);
                    } else if (element.attr("name") === "price") {
                        // error.insertAfter(element.parent().parent());
                        $("#price").html(error);
                    } else if (element.attr("name") === "time_slots") {
                        error.insertAfter(element);
                    } else if (element.attr("name") === "image") {
                        $(".element16").html(error);
                    } else {
                        error.insertAfter(element);
                    }
                }
            });

            $.validator.addMethod("noSpace", function (value, element) {
                return this.optional(element) || value === "NA" ||
                    value.match(/\S/);
            }, "This field cannot be empty");

            $.validator.addMethod("digits", function (value, element) {
                return this.optional(element) || /[+-]?([0-9]*[.])?[0-9]+$/i.test(value);
            }, "This field should be valid price");

            $("#submit_btn").click(function (e) {
                if ($("#equipmentForm").valid()) {
                    $(this).prop('disabled', true);
                    e.preventDefault();
                    $("#equipmentForm").submit();
                }
            });

        });
    </script>
@endpush
