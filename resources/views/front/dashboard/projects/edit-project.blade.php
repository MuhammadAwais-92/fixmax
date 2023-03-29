@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <main class="portfolio spacing-y">
        <div class="container">
            <div class="row">
                @include('front.dashboard.common.left-sidebar')
                <div class="col-xl-9 col-lg-8 col-md-12">
                    <form action="{{ route('front.dashboard.project.save', ['id' => 0]) }}" method="post"
                          enctype="multipart/form-data" id="projectForm">
                        @csrf

                        <div class="common-input">
                            @include(
                                'front.common.image-upload-multi-projects',
                                [
                                    'imageTitle' => __('Upload Media'),
                                    'inputName' => 'project_images',
                                    'isRequired' => 1,
                                    'allowVideo' => 0,
                                    'imageNumber' => 0,
                                    'allowDeleteApi' => 1,
                                    'numberOfImages' => 9,
                                    'displayImageSrc' => old(
                                        'project_images',
                                        $project->images
                                    ),
                                    'value' => old('project_images', []),
                                    'required' => true,
                                ]
                            )
                        </div>
                        <div id="" class="text-danger element16"></div>
                        @include('front.common.alert', ['input' => 'project_images'])
                        <div class="change-password-box">
                            <div class="row">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id ?? '' }}">
                                <input type="hidden" name="id" id=""
                                       value="{{ empty(old('id')) ? (!empty($project->id) ? $project->id : old('id')) : old('id') }}">
                                       <?php $x=0; ?>
                                       @foreach ($languages as $key => $language )
                                       @if($key==config('settings.default_language') || $key=='en')
                   
                               <div class="col-md-12">
                                    <div class="common-input">
                                        <label for="" class="input-label">{{ __('Name In') }} {{__($language['title']) }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="name[{{$key}}]" maxlength="60"
                                               value="{{ empty(old('name.'.$key.'')) ? (!empty($project->name) && isset($project->name[$key]) ? $project->name[$key] : old('name.'.$key.'')) : old('name.'.$key.'') }}"
                                               class="form-control " placeholder="{{ __('Project Name') }}" required
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
                                               value="{{ empty(old('name.'.$key.'')) ? (!empty($project->name) && isset($project->name[$key]) ? $project->name[$key] : old('name.'.$key.'')) : old('name.'.$key.'') }}"
                                               class="form-control " placeholder="{{ __('Project Name') }}" 
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
                                               value="{{ empty(old('name.ar')) ? (!empty($project->name) ? $project->name['ar'] : old('name.ar')) : old('name.ar') }}"
                                               class="form-control " placeholder="{{ __('Project Name') }}" required
                                               autocomplete="off">
                                        @include('front.common.alert', ['input' => 'name.ar'])
                                    </div>
                                </div> --}}
                                <?php $x=0; ?>

                                @foreach ($languages as $key => $language )
                                @if($key==config('settings.default_language') || $key=='en')
                                <div class="col-md-12">
                                    <div class="common-input">
                                        <label class="input-label">{{ __('Description In') }} {{__($language['title']) }}<span
                                                class="text-danger">*</span></label>
                                        <textarea class="ctm-textarea" required name="description[{{$key}}]"
                                                  placeholder="{{ __('Lorem ipsum dolor sit am....') }}">{{ empty(old('description.'.$key.''))? (!empty($project->description) && isset($project->description[$key]) ? $project->description[$key]: old('description.'.$key.'')): old('description.'.$key.'') }}</textarea>
                                    </div>
                                    @include('front.common.alert', ['input' => 'description.'.$key.''])
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
                                        <label class="input-label">{{ __('Description In') }} {{__($language['title']) }}</label>
                                        <textarea class="ctm-textarea"  name="description[{{$key}}]"
                                                  placeholder="{{ __('Lorem ipsum dolor sit am....') }}">{{ empty(old('description.'.$key.''))? (!empty($project->description) && isset($project->description[$key]) ? $project->description[$key]: old('description.'.$key.'')): old('description.'.$key.'') }}</textarea>
                                    </div>
                                    @include('front.common.alert', ['input' => 'description.'.$key.''])
                                    </div>
                                </div>
                                @endif
                                @endforeach
                                {{-- <div class="col-md-12">
                                    <div class="common-input">
                                        <label class="input-label">{{__('Description In Arabic')}} <span
                                                class="text-danger">*</span></label>
                                        <textarea class="ctm-textarea" required name="description[ar]"
                                                  placeholder="{{ __('Lorem ipsum dolor sit am....') }}">{{ empty(old('description.ar'))? (!empty($project->description)? $project->description['ar']: old('description.ar')): old('description.ar') }}</textarea>
                                    </div>
                                    @include('front.common.alert', ['input' => 'description.ar'])
                                </div> --}}
                                @if (!empty($project->id))
                                    <div class="col-md-12">
                                        <button class="login-btn w-100">
                                            {{__('Update Project')}}
                                        </button>
                                    </div>
                                @else
                                    <div class="col-md-12">
                                        <button class="login-btn w-100">
                                            {{__('Add Project')}}
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

            $('#projectForm').validate({
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
                },
                errorPlacement: function (error, element) {
                    console.log(element.attr("name"));
                    if (element.attr("name") === "city_id") {
                        // error.insertAfter(element.parent());
                        $("#city").html(error);
                    } else if (element.attr("name") === "category_id") {
                        // error.insertAfter(element.parent());
                        $("#cate").html(error);
                    } else if (element.attr("name") === "price") {
                        // error.insertAfter(element.parent().parent());
                        $("#price").html(error);
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
                if ($("#projectForm").valid()) {
                    $(this).prop('disabled', true);
                    e.preventDefault();
                    $("#projectForm").submit();
                }
            });

        });
    </script>
@endpush
