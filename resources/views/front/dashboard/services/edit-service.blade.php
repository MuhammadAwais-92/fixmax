@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <main class="supplier-profile spacing-y">
        <div class="container">
            <div class="row">
                @include('front.dashboard.common.left-sidebar')
                <div class="col-xl-9 col-lg-8 col-md-12">
                    <form action="{{ route('front.dashboard.service.save', ['id' => 0]) }}" method="post"
                          enctype="multipart/form-data" id="serviceForm">
                        @csrf
                        <div class="common-input mb-0">
                            @include(
                                'front.common.image-upload-multi-service',
                                [
                                    'imageTitle' => __('Upload Media'),
                                    'inputName' => 'service_images',
                                    'isRequired' => 1,
                                    'allowVideo' => 1,
                                    'imageNumber' => 2,
                                    'allowDeleteApi' => 1,
                                    'numberOfImages' => 10,
                                    'displayImageSrc' => old(
                                        'service_images',
                                        $service->images
                                    ),
                                    'value' => old('service_images', []),
                                    'required' => true,
                                ]
                            )
                            <div id="" class="text-danger element16"></div>
                        </div>

                        @include('front.common.alert', ['input' => 'service_images'])
                        <div class="change-password-box">

                            <div class="row">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id ?? '' }}">
                                <input type="hidden" name="id" id=""
                                       value="{{ empty(old('id')) ? (!empty($service->id) ? $service->id : old('id')) : old('id') }}">
                                       <?php $x=0; ?>
                                       @foreach ($languages as $key => $language )
                               @if($key==config('settings.default_language') || $key=='en')
                                <div class="col-md-12">
                                    <div class="common-input">
                                        <label for="" class="input-label">{{ __('Name In') }} {{__($language['title']) }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="name[{{$key}}]" maxlength="60"
                                               value="{{ empty(old('name.'.$key.'')) ? (!empty($service->name) && isset($service->name[$key]) ? $service->name[$key] : old('name.'.$key.'')) : old('name.'.$key.'') }}"
                                               class="form-control " placeholder="{{ __('Service Name') }}" required
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
                                <div class="col-md-12">
                                  
                                    <div class="lang-input">
                                        <div class="common-input">
                                            <label for="" class="input-label">{{ __('Name In') }} {{__($language['title']) }} </label>
                                            <input type="text" name="name[{{$key}}]" maxlength="60"
                                                   value="{{ empty(old('name.'.$key.'')) ? (!empty($service->name) && isset($service->name[$key]) ? $service->name[$key] : old('name.'.$key.'')) : old('name.'.$key.'') }}"
                                                   class="form-control " placeholder="{{ __('Service Name') }}" 
                                                   autocomplete="off">
                                            @include('front.common.alert', ['input' => 'name.'.$key.''])
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                                {{-- <div class="col-md-12">
                                    <div class="common-input">
                                        <label for="" class="input-label">{{ __('Name In Arabic') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="name[ar]" maxlargth="60"
                                               value="{{ empty(old('name.ar')) ? (!empty($service->name) ? $service->name['ar'] : old('name.ar')) : old('name.ar') }}"
                                               class="form-control " placeholder="{{ __('Service Name') }}" required
                                               autocomplete="off">
                                        @include('front.common.alert', ['input' => 'name.ar'])
                                    </div>
                                </div> --}}
                                <div class="col-md-12">
                                    <div class="common-input">
                                        <label class="input-label">{{ translate($category->name) }} <span
                                                class="text-danger">*</span></label>
                                        <select class="js-example-basic-single" name="category_id" reuqired>
                                            <option value="" readonly=""
                                                    selected>{{ __('Select Subcategory') }}</option>
                                            @forelse($category->subCategories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ empty(old('category_id'))? (!empty($service->category_id)? ($service->category_id == $category->id? 'selected': ''): ''): (old("category_id") ==  $category->id ? "selected":"") }}>
                                                    {{ translate($category->name) ?? '' }}</option>
                                            @empty
                                                <option value="" disabled selected>{{ __('Select Subcategory') }}
                                                </option>
                                            @endforelse
                                        </select>
                                        <div id="catId"></div>
                                        @include('front.common.alert', ['input' => 'category_id'])
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="common-input">
                                        @if (!$service->is_featured)
                                            <label class="input-label">{{ ('Feature Service') }} </label>
                                            <select class="js-example-basic-single" name="featured_subscription">
                                                <option value="" readonly="" selected>{{ __('Select feature package') }}
                                                </option>
                                                @forelse($activeFeaturedSubscription as $obj)
                                                    <option value="{{ $obj->id }}">
                                                        {{isset($obj->package) == true ? translate($obj->package['name']) : 'Data not given' }}
                                                    </option>
                                                @empty
                                                    <option value="" disabled
                                                            selected>{{ __('No featured package purchased') }}
                                                    </option>
                                                @endforelse
                                            </select>
                                        @else
                                            <label class="input-label">{{ ('Feature Service') }} </label>
                                            <input type="text" class="ctm-input"
                                                   value="{{ $service->userFeaturedSubscriptions? translate($service->userFeaturedSubscriptions->package['name']): 'No data given' }}"
                                                   disabled>
                                        @endif
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="common-input">
                                        <label class="input-label">{{__('Minimum Price')}} <span
                                                class="text-danger">*</span></label>
                                        <input type="number" name="min_price" class="form-control " minlength="1"
                                               id="min1"
                                               min="1"
                                               value="{{ empty(old('min_price'))? (!empty($service->min_price)? $service->min_price: old('min_price')): old('min_price') }}"
                                               placeholder="{{ __('AED 100') }}">
                                        <div id="min_price"></div>
                                        @include('front.common.alert', ['input' => 'min_price'])
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="common-input">
                                        <label class="input-label">{{__('Maximum Price')}} <span
                                                class="text-danger">*</span></label>
                                        <input type="number" name="max_price" class="form-control " id="max1"
                                               minlength="1"
                                               min="1"
                                               value="{{ empty(old('max_price'))? (!empty($service->max_price)? $service->max_price: old('max_price')): old('max_price') }}"
                                               placeholder="{{ __('AED 300') }}">
                                        <div id="max_price"></div>
                                        @include('front.common.alert', ['input' => 'max_price'])
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="common-input mb-3">
                                        <label class="input-label">{{__('Offer Discount')}} ({{__('Optional')}})</label>
                                        <input type="number" name="discount"
                                               value="{{ empty(old('discount')) ? (!empty($service->discount) ? $service->discount : '') : old('discount') }}"
                                               placeholder="{{__('Discount')}}" max="90">
                                        @include('front.common.alert', [
                                            'input' => 'discount',
                                        ])
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="common-input mb-3">
                                        <label class="input-label">{{__('Offer Expiration Date')}}</label>
                                        <div class="password-input-box date-box">
                                            <input type="text" id="datepicker1" autocomplete="off"
                                                   value="{{ empty(old('expiry_date'))? (!empty($service->expiry_date)? date('d-m-Y', $service->expiry_date): old('expiry_date')): old('expiry_date') }}"
                                                   name="expiry_date" placeholder="{{__('Expiration Date')}}">
                                            @include('front.common.alert', [
                                                'input' => 'expiry_date',
                                            ])
                                            <svg id="cal-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="16"
                                                 viewBox="0 0 14 16">
                                                <path id="Path_48305" data-name="Path 48305"
                                                      d="M-.375-9h-13.25a.362.362,0,0,1-.266-.109A.362.362,0,0,1-14-9.375V-10.5a1.447,1.447,0,0,1,.438-1.062A1.447,1.447,0,0,1-12.5-12H-11v-1.625a.362.362,0,0,1,.109-.266A.362.362,0,0,1-10.625-14h1.25a.362.362,0,0,1,.266.109A.362.362,0,0,1-9-13.625V-12h4v-1.625a.362.362,0,0,1,.109-.266A.362.362,0,0,1-4.625-14h1.25a.362.362,0,0,1,.266.109A.362.362,0,0,1-3-13.625V-12h1.5a1.447,1.447,0,0,1,1.063.438A1.447,1.447,0,0,1,0-10.5v1.125a.362.362,0,0,1-.109.266A.362.362,0,0,1-.375-9Zm-13.25,1H-.375a.362.362,0,0,1,.266.109A.362.362,0,0,1,0-7.625V.5A1.447,1.447,0,0,1-.437,1.563,1.447,1.447,0,0,1-1.5,2h-11a1.447,1.447,0,0,1-1.062-.437A1.447,1.447,0,0,1-14,.5V-7.625a.362.362,0,0,1,.109-.266A.362.362,0,0,1-13.625-8ZM-10-1.625a.362.362,0,0,0-.109-.266A.362.362,0,0,0-10.375-2h-1.25a.362.362,0,0,0-.266.109A.362.362,0,0,0-12-1.625v1.25a.362.362,0,0,0,.109.266A.362.362,0,0,0-11.625,0h1.25a.362.362,0,0,0,.266-.109A.362.362,0,0,0-10-.375Zm0-4a.362.362,0,0,0-.109-.266A.362.362,0,0,0-10.375-6h-1.25a.362.362,0,0,0-.266.109A.362.362,0,0,0-12-5.625v1.25a.362.362,0,0,0,.109.266A.362.362,0,0,0-11.625-4h1.25a.362.362,0,0,0,.266-.109A.362.362,0,0,0-10-4.375Zm4,4a.362.362,0,0,0-.109-.266A.362.362,0,0,0-6.375-2h-1.25a.362.362,0,0,0-.266.109A.362.362,0,0,0-8-1.625v1.25a.362.362,0,0,0,.109.266A.362.362,0,0,0-7.625,0h1.25a.362.362,0,0,0,.266-.109A.362.362,0,0,0-6-.375Zm0-4a.362.362,0,0,0-.109-.266A.362.362,0,0,0-6.375-6h-1.25a.362.362,0,0,0-.266.109A.362.362,0,0,0-8-5.625v1.25a.362.362,0,0,0,.109.266A.362.362,0,0,0-7.625-4h1.25a.362.362,0,0,0,.266-.109A.362.362,0,0,0-6-4.375Zm4,4a.362.362,0,0,0-.109-.266A.362.362,0,0,0-2.375-2h-1.25a.362.362,0,0,0-.266.109A.362.362,0,0,0-4-1.625v1.25a.362.362,0,0,0,.109.266A.362.362,0,0,0-3.625,0h1.25a.362.362,0,0,0,.266-.109A.362.362,0,0,0-2-.375Zm0-4a.362.362,0,0,0-.109-.266A.362.362,0,0,0-2.375-6h-1.25a.362.362,0,0,0-.266.109A.362.362,0,0,0-4-5.625v1.25a.362.362,0,0,0,.109.266A.362.362,0,0,0-3.625-4h1.25a.362.362,0,0,0,.266-.109A.362.362,0,0,0-2-4.375Z"
                                                      transform="translate(14 14)" fill="#ccc"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <?php $x=0; ?>
                               @foreach ($languages as $key => $language )
                               @if($key==config('settings.default_language') || $key=='en')

                                <div class="col-md-12">
                                    <div class="common-input">
                                        <label class="input-label">{{__('Description In')}} {{__($language['title'])}} <span
                                                class="text-danger">*</span></label>
                                        <textarea class="ctm-textarea" required name="description[{{$key}}]"
                                                  placeholder="{{ __('Lorem ipsum dolor sit am....') }}">{{ empty(old('description.'.$key.''))? (!empty($service->description) && isset($service->description[$key]) ? $service->description[$key]: old('description.'.$key.'')): old('description.'.$key.'') }}</textarea>
                                        @include('front.common.alert', [
                                            'input' => 'description.'.$key.'',
                                        ])
                                    </div>

                                </div>
                                @if($x==1)
                                {{-- <div class="col-lg-12">
                                    <button type="button" class="Add-field">More Description Translations</button>
                                </div> --}}
                                   
                                    @endif
                                    <?php $x++; ?>
                                @else
                                <div class="col-md-12">
                                    <div class="lang-new-input ">
                                    <div class="common-input">
                                        <label class="input-label">{{__('Description In')}} {{__($language['title'])}} </label>
                                        <textarea class="ctm-textarea"  name="description[{{$key}}]"
                                                  placeholder="{{ __('Lorem ipsum dolor sit am....') }}">{{ empty(old('description.'.$key.''))? (!empty($service->description) && isset($service->description[$key]) ? $service->description[$key]: old('description.'.$key.'')): old('description.'.$key.'') }}</textarea>
                                        @include('front.common.alert', [
                                            'input' => 'description.'.$key.'',
                                        ])
                                    </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                                {{-- <div class="col-md-12">
                                    <div class="common-input">
                                        <label class="input-label">{{__('Description In Arabic')}} <span
                                                class="text-danger">*</span></label>
                                        <textarea class="ctm-textarea" required name="description[ar]"
                                                  placeholder="{{ __('Lorem ipsum dolor sit am....') }}">{{ empty(old('description.ar'))? (!empty($service->description)? $service->description['ar']: old('description.ar')): old('description.ar') }}</textarea>
                                        @include('front.common.alert', [
                                            'input' => 'description.ar',
                                        ])
                                    </div>

                                </div> --}}
                                @if (!empty($service->id))
                                    <div class="col-md-12">
                                        <button class="login-btn w-100">
                                            {{__('Update Service')}}
                                        </button>
                                    </div>
                                @else
                                    <div class="col-md-12">
                                        <button class="login-btn w-100">
                                            {{__('Add Service')}}
                                        </button>
                                    </div>
                                @endif

                            </div>

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

            $('#serviceForm').validate({
                ignore: '',
                rules: {
                    'description[en]': {
                        required: true,
                        noSpace: true,
                    },
                    'description[{{config('settings.default_language')}}]': {
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
                    'min_price': {
                        required: true,
                        digits: true,
                        // le:  '#max1',
                    },
                    'category_id': {
                        required: true,
                    },
                    'max_price': {
                        required: true,
                        digits: true,
                        // ge:  '#min1',
                    },
                },
                errorPlacement: function (error, element) {
                    console.log(element.attr("name"));
                    if (element.attr("name") === "service_id") {
                        // error.insertAfter(element.parent());
                        $("#servId").html(error);
                    } else if (element.attr("name") === "category_id") {
                        // error.insertAfter(element.parent());
                        $("#catId").html(error);
                    } else if (element.attr("name") === "min_price") {
                        // error.insertAfter(element.parent().parent());
                        $("#min_price").html(error);
                    } else if (element.attr("name") === "max_price") {
                        // error.insertAfter(element.parent().parent());
                        $("#max_price").html(error);
                    } else if (element.attr("name") === "time_slots") {
                        error.insertAfter(element);
                    } else if (element.attr("name") === "images") {
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
                if ($("#serviceForm").valid()) {
                    $(this).prop('disabled', true);
                    e.preventDefault();
                    $("#serviceForm").submit();
                }
            });

        });
    </script>
@endpush
