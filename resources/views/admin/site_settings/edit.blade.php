@extends('admin.layouts.app')
@section('breadcrumb')
    @include('admin.common.breadcrumbs')
@endsection

@push('stylesheet-page-level')
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-tools">
                        <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
                            <li class="nav-item m-tabs__item">
                                <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_user_profile_tab_1" role="tab">
                                    <i class="flaticon-share m--hide"></i>
                                    Update Site Settings
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="m_user_profile_tab_1">
                        {!! Form::open(['route' => 'admin.dashboard.site-settings.store', 'method' => 'post', 'role' => 'form', 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}

                        @forelse($settings as $key=>$value)
                            @if($key == 'email_header')
                                @include('admin.common.upload-image',['image_name'=> $key,'new_image' =>old($key, $value), 'current_image'=>imageUrl(old('image', $value), 100,100,90,1), 'title'=>'Email Header', 'image_size'=>'','image_number'=>1])
                            @elseif($key == 'id')
                                {!! Form::text($key, old($key, $value), ['class' => 'form-control', 'id' => $key, 'placeholder' => $key, 'hidden']) !!}
                        @elseif($key=='default_language')
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-3 col-form-label">
                                    {!! $key !!}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-7">
                                  <select name="default_language" class="form-control">
                                    @foreach (cache('LANGUAGES') as $lang) 
                                    <option  @if ($lang['short_code']==$value) selected @endif  value="{{$lang['short_code']}}">
                                              {{$lang['title']}}
                                    </option>
                                    @endforeach
                                  </select>
                                </div>
                            </div>
                        </div>
                                @elseif($key == 'footer_text' || $key == 'news_letter_text')
                                <div class="m-portlet__body">
                                    <div class="form-group m-form__group row">
                                        <label for="example-text-input" class="col-3 col-form-label">
                                            {!! $key !!}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-7">
                                            {!! Form::textarea($key, old($key, $value), ['class' => 'form-control', 'id' => $key, 'placeholder' => $key]) !!}
                                        </div>
                                    </div>
                                </div>
{{--                            @elseif($key == 'purpose')--}}

{{--                                <div class="m-portlet__body">--}}
{{--                                    <div class="form-group m-form__group row">--}}
{{--                                        <label for="example-text-input" class="col-3 col-form-label">--}}
{{--                                            Purpose in english (Comma Separated)--}}
{{--                                            <span class="text-danger">*</span>--}}
{{--                                        </label>--}}
{{--                                        <div class="col-7">--}}
{{--                                            {!! Form::text('purpose_en', old('purpose_en', $value['en']), ['class' => 'form-control', 'id' => $key, 'placeholder' => 'Purpose in english (Comma Separated)']) !!}--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <div class="m-portlet__body">--}}
{{--                                    <div class="form-group m-form__group row">--}}
{{--                                        <label for="example-text-input" class="col-3 col-form-label">--}}
{{--                                            Purpose in arabic (Comma Separated)--}}
{{--                                            <span class="text-danger">*</span>--}}
{{--                                        </label>--}}
{{--                                        <div class="col-7">--}}
{{--                                            {!! Form::text('purpose_ar', old('purpose_ar', $value['ar']), ['class' => 'form-control', 'id' => $key, 'placeholder' => 'Purpose in english (Comma Separated)']) !!}--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            @else
                                <div class="m-portlet__body">
                                    <div class="form-group m-form__group row">
                                        <label for="example-text-input" class="col-3 col-form-label">
                                            {!! $key !!}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-7">
                                            {!! Form::text($key, old($key, $value), ['class' => 'form-control', 'id' => $key, 'placeholder' => $key]) !!}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                        @endforelse




                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions">
                                <div class="row">
                                    <div class="col-4"></div>
                                    <div class="col-7">
                                        <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">
                                            Save changes
                                        </button>
                                        &nbsp;
                                        <a href="{!! route('admin.dashboard.site-settings.index') !!}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection