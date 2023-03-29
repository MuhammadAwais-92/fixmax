@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <main class="login-sec spacing-y">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if (Route::current()->getName() == 'front.services')
                        <div class="page-detail-mt">
                            @if(request()->get('service')=='offer')
                                <div class="commen-title"><span>{{__('Offers')}}</span>
                                    @else
                                        <div class="commen-title"><span>{{__('Services')}}</span>
                                            @endif
                                        </div>
                                </div>
                            @else
                                <div class="page-detail-mt">
                                    <div class="commen-title"><span>{{__('Featured')}}</span></div>
                                </div>
                            @endif
                        </div>
                        <div class="col-lg-3 mb-3 mb-lg-0">
                            <div class="service-filter">
                                <div class="title-block d-flex align-items-center justify-content-between">
                                    <h4 class="title">
                                        {{__('Filters')}}
                                    </h4>
                                    @if (request()->subCategory || request()->keyword || request()->category_id || request()->supplier_id || request()->min_price || request()->max_price)
                                        @if(request()->get('service')=='featured')
                                            <a href="{{ route('front.services', ['service' => 'featured']) }}"
                                               class="close-btn">
                                                <svg id="Component_4_1" data-name="Component 4 – 1"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     width="23.25" height="23.25" viewBox="0 0 23.25 23.25">
                                                    <path id="Path_48606" data-name="Path 48606"
                                                          d="M12-20.625a11.269,11.269,0,0,0-5.812,1.57,11.747,11.747,0,0,0-4.242,4.242A11.269,11.269,0,0,0,.375-9a11.269,11.269,0,0,0,1.57,5.813A11.747,11.747,0,0,0,6.188,1.055,11.269,11.269,0,0,0,12,2.625a11.269,11.269,0,0,0,5.813-1.57,11.747,11.747,0,0,0,4.242-4.242A11.269,11.269,0,0,0,23.625-9a11.269,11.269,0,0,0-1.57-5.812,11.747,11.747,0,0,0-4.242-4.242A11.269,11.269,0,0,0,12-20.625ZM17.719-5.953a.686.686,0,0,1,.141.422.507.507,0,0,1-.141.375L15.844-3.281a.653.653,0,0,1-.4.141.653.653,0,0,1-.4-.141L12-6.375,8.953-3.281a.686.686,0,0,1-.422.141.507.507,0,0,1-.375-.141L6.281-5.156a.653.653,0,0,1-.141-.4.653.653,0,0,1,.141-.4L9.375-9,6.281-12.047a.686.686,0,0,1-.141-.422.507.507,0,0,1,.141-.375l1.875-1.875a.653.653,0,0,1,.4-.141.653.653,0,0,1,.4.141L12-11.625l3.047-3.094a.686.686,0,0,1,.422-.141.507.507,0,0,1,.375.141l1.875,1.875a.653.653,0,0,1,.141.4.653.653,0,0,1-.141.4L14.625-9Z"
                                                          transform="translate(-0.375 20.625)" fill="#fff"/>
                                                </svg>
                                            </a>
                                        @elseif (request()->get('service')=='offer')
                                            <a href="{{ route('front.offer.services', ['service' => 'offer']) }}"
                                               class="close-btn">
                                                <svg id="Component_4_1" data-name="Component 4 – 1"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     width="23.25" height="23.25" viewBox="0 0 23.25 23.25">
                                                    <path id="Path_48606" data-name="Path 48606"
                                                          d="M12-20.625a11.269,11.269,0,0,0-5.812,1.57,11.747,11.747,0,0,0-4.242,4.242A11.269,11.269,0,0,0,.375-9a11.269,11.269,0,0,0,1.57,5.813A11.747,11.747,0,0,0,6.188,1.055,11.269,11.269,0,0,0,12,2.625a11.269,11.269,0,0,0,5.813-1.57,11.747,11.747,0,0,0,4.242-4.242A11.269,11.269,0,0,0,23.625-9a11.269,11.269,0,0,0-1.57-5.812,11.747,11.747,0,0,0-4.242-4.242A11.269,11.269,0,0,0,12-20.625ZM17.719-5.953a.686.686,0,0,1,.141.422.507.507,0,0,1-.141.375L15.844-3.281a.653.653,0,0,1-.4.141.653.653,0,0,1-.4-.141L12-6.375,8.953-3.281a.686.686,0,0,1-.422.141.507.507,0,0,1-.375-.141L6.281-5.156a.653.653,0,0,1-.141-.4.653.653,0,0,1,.141-.4L9.375-9,6.281-12.047a.686.686,0,0,1-.141-.422.507.507,0,0,1,.141-.375l1.875-1.875a.653.653,0,0,1,.4-.141.653.653,0,0,1,.4.141L12-11.625l3.047-3.094a.686.686,0,0,1,.422-.141.507.507,0,0,1,.375.141l1.875,1.875a.653.653,0,0,1,.141.4.653.653,0,0,1-.141.4L14.625-9Z"
                                                          transform="translate(-0.375 20.625)" fill="#fff"/>
                                                </svg>
                                            </a>
                                        @else
                                            <a href="{{ route('front.services') }}" class="close-btn">
                                                <svg id="Component_4_1" data-name="Component 4 – 1"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     width="23.25" height="23.25" viewBox="0 0 23.25 23.25">
                                                    <path id="Path_48606" data-name="Path 48606"
                                                          d="M12-20.625a11.269,11.269,0,0,0-5.812,1.57,11.747,11.747,0,0,0-4.242,4.242A11.269,11.269,0,0,0,.375-9a11.269,11.269,0,0,0,1.57,5.813A11.747,11.747,0,0,0,6.188,1.055,11.269,11.269,0,0,0,12,2.625a11.269,11.269,0,0,0,5.813-1.57,11.747,11.747,0,0,0,4.242-4.242A11.269,11.269,0,0,0,23.625-9a11.269,11.269,0,0,0-1.57-5.812,11.747,11.747,0,0,0-4.242-4.242A11.269,11.269,0,0,0,12-20.625ZM17.719-5.953a.686.686,0,0,1,.141.422.507.507,0,0,1-.141.375L15.844-3.281a.653.653,0,0,1-.4.141.653.653,0,0,1-.4-.141L12-6.375,8.953-3.281a.686.686,0,0,1-.422.141.507.507,0,0,1-.375-.141L6.281-5.156a.653.653,0,0,1-.141-.4.653.653,0,0,1,.141-.4L9.375-9,6.281-12.047a.686.686,0,0,1-.141-.422.507.507,0,0,1,.141-.375l1.875-1.875a.653.653,0,0,1,.4-.141.653.653,0,0,1,.4.141L12-11.625l3.047-3.094a.686.686,0,0,1,.422-.141.507.507,0,0,1,.375.141l1.875,1.875a.653.653,0,0,1,.141.4.653.653,0,0,1-.141.4L14.625-9Z"
                                                          transform="translate(-0.375 20.625)" fill="#fff"/>
                                                </svg>
                                            </a>
                                        @endif
                                    @endif
                                </div>
                                <div class="filter-inner">
                                    <form action="{{ route('front.services') }}">
                                        <div class="common-input search-box">
                                            <input type="text" name="keyword"
                                                   value="{{ request()->keyword ? request()->keyword : '' }}"
                                                   placeholder="{{__('Enter Keyword')}}">
                                            <button class="search-btn">
                                                <img src="{{ asset('assets/front/img/fil-search.svg') }}"
                                                     alt="search-icon"
                                                     class="img-fluid search-icon">
                                            </button>
                                        </div>
                                        @if(Route::current()->getName() == 'front.featured.services')
                                            <input type="hidden" value="featured" name="service">
                                        @endif
                                        @if(Route::current()->getName() == 'front.offer.services')
                                            <input type="hidden" value="offer" name="service">
                                        @endif
                                        <div class="common-input mb-25">
                                            <label class="input-label">{{__('Supplier')}}</label>
                                            <select class="js-example-basic-single" name="supplier_id">
                                                <option value="" readonly=""
                                                        selected>{{__('Select Suppliers')}}</option>
                                                @forelse($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}"
                                                        {{ request()->supplier_id == $supplier->id ? 'selected' : '' }}>
                                                        {{ translate($supplier->supplier_name) }}</option>
                                                @empty
                                                    <option value="" disabled
                                                            selected>{{ __('No supplier have been created') }}
                                                    </option>
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="common-input">
                                            <label class="input-label">
                                                {{__('Min Price')}}
                                            </label>
                                            <input type="text" min="0" maxLength="6" pattern="\d*"
                                                   oninput="validity.valid||(value='');" id="from_price"
                                                   value="{{ request()->min_price ? request()->min_price : '' }}"
                                                   name="min_price" placeholder="0">
                                        </div>
                                        <div class="common-input">
                                            <label class="input-label">
                                                {{__('Max Price')}}
                                            </label>
                                            <input type="text" min="1" maxLength="3" pattern="\d*"
                                                   oninput="validity.valid||(value='');" id="to_price"
                                                   value="{{ request()->max_price ? request()->max_price : '' }}"
                                                   name="max_price" placeholder="999">
                                        </div>
                                        {{-- <div class="common-input price-range-block">
                                <label class="input-label">
                                  Select Price Range
                                </label>
                                <img src="{{ asset('assets/front/img/PriceScroller.png') }}" alt="range-img" class="img-fluid range-img w-100">
                                <div class="price-titles d-flex justify-content-between align-items-center flex-wrap">
                                  <span>$100</span>
                                  <span>$1000</span>
                                </div>
                              </div> --}}
                                        <div class="common-input">
                                            <label class="input-label">
                                                {{__('Price Range')}}
                                            </label>
                                            <input type="text" class="js-range-slider " name="my_range" value=""/>
                                        </div>

                                        <div class="common-input">
                                            <label class="input-label">{{__('Category')}}</label>
                                            <select class="js-example-basic-single" name="category_id" id="category">
                                                <option value="" readonly="" selected>{{__('Select Category')}}</option>
                                                @forelse($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ request()->category_id == $category->id ? 'selected' : '' }}>
                                                        {{ translate($category->name) }}</option>
                                                @empty
                                                    <option value="" disabled
                                                            selected>{{ __('No category have been created') }}
                                                    </option>
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="common-input">
                                            <label class="input-label">{{__('Subcategory')}}</label>
                                            <select class="js-example-basic-single" name="subCategory" id='subCategory'>
                                                <option selected disabled value="">{{ __('Select Subcategory') }}
                                                </option>
                                            </select>
                                        </div>
                                        <button class="secondary-btn mw-100">
                                            {{__('Search')}}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="row">
                                @forelse ($services as $service)
                                    <div class="col-md-4 col-lg-6 col-xl-4 col-sm-6 col-6-ctm ">
                                        <div class="services-card feature-services service-fil">
                                            <div class="img-block">

                                                @if( str_contains($service->default_image, '.mp4') || str_contains($service->default_image, '.mov'))
                                                    <video width="361" height="191" controls muted>
                                                        <source src="{{$service->default_image}}" class="img-fluid"
                                                                type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                @else

                                                    <img
                                                        src="{!! imageUrl(url($service->default_image), 361, 191,95, 3) !!}"
                                                        alt="services-img"
                                                        class="img-fluid services-img">
                                                @endif
                                            </div>
                                            @if ($service->discount)
                                                <div class="discount">
                                                    {{ $service->discount }}% {{__('OFF')}}
                                                </div>
                                            @endif
                                            @if ($service->is_featured)
                                                <div class="feature-box">
                                                    <img src="{{ asset('assets/front/img/feature-icon.svg') }}"
                                                         alt="feature-icon"
                                                         class="img-fluid feature-icon">
                                                </div>
                                            @endif
                                            <div class="desc-block">
                                                <div class="cate-block">
                                                    <span
                                                        class="text-truncate">{!! translate($service->supplier->supplier_name) !!}</span>
                                                </div>
                                                <div class="d-flex align-content-center justify-content-between">
                                                    <div class="star-rating-area">
                                                        <div class="rating-static clearfix"
                                                             rel="{{ round(getStarRating($service->average_rating), 1) }}">
                                                            <label class="full" title="{{__('Awesome - 5 stars')}}"></label>
                                                            <label class="half" title="{{__('Pretty good - 4.5 stars')}}"></label>
                                                            <label class="full" title="{{__('Pretty good - 4 stars')}}"></label>
                                                            <label class="half" title="{{__('Meh - 3.5 stars')}}"></label>
                                                            <label class="full" title="{{__('Meh - 3 stars')}}"></label>
                                                            <label class="half" title="{{__('Kinda bad - 2.5 stars')}}"></label>
                                                            <label class="full" title="{{__('Kinda bad - 2 stars')}}"></label>
                                                            <label class="half" title="{{__('Meh - 1.5 stars')}}"></label>
                                                            <label class="full" title="{{__('Sucks big time - 1 star')}}"></label>
                                                            <label class="half" title="{{__('Sucks big time - 0.5 stars')}}"></label>
                                                        </div>
                                                        <div class="ratilike ng-binding">
                                                            ({{number_format($service->average_rating,1)}})
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="title-row d-flex justify-content-between align-items-center flex-wrap">
                                                    <div class="title text-truncate">
                                                        {!! translate($service->name) !!}
                                                    </div>
                                                </div>
                                                @if ($service->discount > 0)
                                                    <div class="price-sec d-flex">
                                                <span
                                                    class="text-truncate">{{__('AED')}}{{ round($service->discountedMinPrice,2) }} -
                                                    AED{{ round($service->dicountedMaxPrice,2) }}</span>
                                                        <strike
                                                            class="text-truncate">{{__('AED')}}{{ round($service->min_price,2) }}
                                                            -
                                                            {{__('AED')}}{{ round($service->max_price,2) }}</strike>
                                                    </div>
                                                @else
                                                    <div class="price-sec d-flex">
                                                <span class="text-truncate">{{__('AED')}}{{ $service->min_price }} -
                                                    {{__('AED')}}{{ $service->max_price }}</span>
                                                    </div>
                                                @endif
                                                <a href="{{ route('front.service.detail', $service->slug) }}"
                                                   class="arrow-btn"
                                                   tabindex="0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18.707"
                                                         height="6.707"
                                                         viewBox="0 0 18.707 6.707">
                                                        <g id="Component_1_1" data-name="Component 1 – 1"
                                                           transform="translate(0 0.707)">
                                                            <line id="Line_21" data-name="Line 21" x2="18"
                                                                  transform="translate(0 5)" fill="none" stroke="#fff"
                                                                  stroke-width="2"></line>
                                                            <line id="Line_22" data-name="Line 22" x2="5" y2="5"
                                                                  transform="translate(13)" fill="none" stroke="#fff"
                                                                  stroke-width="2"></line>
                                                        </g>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    @include('front.common.alert-empty', [
                                        'message' => __('No Service found.'),
                                    ])
                                @endforelse
                                {{ $services->links('front.common.pagination', ['paginator' => $services]) }}

                            </div>
                        </div>
                </div>
            </div>
    </main>
@endsection
@push('scripts')
    <script>
        $(window).on('load', function () {
            category = '<?php echo request()->get('category_id'); ?>';
            if (category) {
                let url = window.Laravel.apiUrl + 'get-sub-categories/' + category;
                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: 'json',
                    success: function (response) {
                        if (locale === 'ar') {
                            var area_data = response.data.collection.map((ar) => {
                                let area = {
                                    id: ar.id,
                                    text: ar.name['ar']
                                }
                                return area;
                            });
                            $("#subCategory").select2({
                                placeholder: "Select Subcategory",
                                data: area_data
                            });
                        } else {
                            var category_data = response.data.collection.map((ar) => {
                                let category = {
                                    id: ar.id,
                                    text: ar.name['en']
                                }
                                return category;
                            });
                            let text = '';
                            subcat = category = '<?php echo request()->get('subCategory'); ?>';
                            jQuery.each(category_data, function (i, field) {
                                if (field.id == subcat) {
                                    text = field;
                                }
                            });
                            $("#subCategory").select2({
                                placeholder: text.text,
                                data: category_data,
                            });
                        }


                    }
                });
            }

        });
        $(document).ready(function () {
            $(".js-range-slider").ionRangeSlider({
                type: "double",
                min: 0,
                max: 1000,
                from: "{{ request()->min_price }}",
                to: "{{ request()->max_price }}",
                skin: "round",
                onChange: function (data) {
                    $('#from_price').val(data.from);
                    $('#to_price').val(data.to);
                }
            });
        });
        $(document).on("change", "#category", function (e) {
            e.preventDefault();
            var category = $("#category option:selected").val();
            $('#subCategory').empty();
            let url = window.Laravel.apiUrl + 'get-sub-categories/' + category;
            $.ajax({
                type: "GET",
                url: url,
                dataType: 'json',
                success: function (response) {
                    if (locale === 'ar') {
                        var area_data = response.data.collection.map((ar) => {
                            let area = {
                                id: ar.id,
                                text: ar.name['ar']
                            }
                            return area;
                        });
                        $("#subCategory").select2({
                            placeholder: "Select Subcategory",
                            data: area_data
                        });
                    } else {
                        var category_data = response.data.collection.map((ar) => {
                            let category = {
                                id: ar.id,
                                text: ar.name['en']
                            }
                            return category;
                        });
                        $("#subCategory").select2({
                            placeholder: "Select Subcategory",
                            data: category_data
                        });
                    }


                }
            });
        });
    </script>
@endpush
