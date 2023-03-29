@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <main class="supplier-grid spacing-y">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex flex-wrap justify-content-between align-content-center mb-54 head-dd-row">
                        <div class="page-detail-mt">
                            <div class="commen-title mb-0"><span>{{__('Suppliers')}}</span></div>
                        </div>
                        <div class="dropdown invoice-dd d-flex align-items-center views-dd">
                            <span class="dd-title">{{__('View')}}:</span>
                            <button class="secondary-btn d-flex align-items-center justify-content-between"
                                    type="button"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                @if(request()->get('display_type')=='list')
                                    <span class="mx-05">{{__('List')}}</span> <img
                                        src="{{ asset('assets/front/img/dd-icon.png') }}" alt="arrow-down"
                                        class="img-fluid arrow-down">
                                @else
                                    <span class="mx-05">{{__('Grid')}}</span> <img
                                        src="{{ asset('assets/front/img/dd-icon.png') }}" alt="arrow-down"
                                        class="img-fluid arrow-down">
                                @endif
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                                 style="position: absolute; transform: translate3d(0px, 50px, 0px); top: 0px; left: 0px; will-change: transform;"
                                 x-placement="bottom-start">
                                <a class="dropdown-item"
                                   href="{!! route('front.suppliers', ['display_type' => 'list']) !!}">{{__('List')}}</a>
                                <a class="dropdown-item" href="{!! route('front.suppliers') !!}">{{__('Grid')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 mb-3 mb-xl-0">
                    <div class="service-filter">

                        <div class="title-block d-flex align-items-center justify-content-between">
                            <h4 class="title">
                                {{__('Filters')}}
                            </h4>
                            @if (request()->sort || request()->subCategory || request()->keyword || request()->category_id)
                                <a href="{{route('front.suppliers',['display_type'=>'list'])}}" class="close-btn">
                                    <svg id="Component_4_1" data-name="Component 4 – 1"
                                         xmlns="http://www.w3.org/2000/svg"
                                         width="23.25" height="23.25" viewBox="0 0 23.25 23.25">
                                        <path id="Path_48606" data-name="Path 48606"
                                              d="M12-20.625a11.269,11.269,0,0,0-5.812,1.57,11.747,11.747,0,0,0-4.242,4.242A11.269,11.269,0,0,0,.375-9a11.269,11.269,0,0,0,1.57,5.813A11.747,11.747,0,0,0,6.188,1.055,11.269,11.269,0,0,0,12,2.625a11.269,11.269,0,0,0,5.813-1.57,11.747,11.747,0,0,0,4.242-4.242A11.269,11.269,0,0,0,23.625-9a11.269,11.269,0,0,0-1.57-5.812,11.747,11.747,0,0,0-4.242-4.242A11.269,11.269,0,0,0,12-20.625ZM17.719-5.953a.686.686,0,0,1,.141.422.507.507,0,0,1-.141.375L15.844-3.281a.653.653,0,0,1-.4.141.653.653,0,0,1-.4-.141L12-6.375,8.953-3.281a.686.686,0,0,1-.422.141.507.507,0,0,1-.375-.141L6.281-5.156a.653.653,0,0,1-.141-.4.653.653,0,0,1,.141-.4L9.375-9,6.281-12.047a.686.686,0,0,1-.141-.422.507.507,0,0,1,.141-.375l1.875-1.875a.653.653,0,0,1,.4-.141.653.653,0,0,1,.4.141L12-11.625l3.047-3.094a.686.686,0,0,1,.422-.141.507.507,0,0,1,.375.141l1.875,1.875a.653.653,0,0,1,.141.4.653.653,0,0,1-.141.4L14.625-9Z"
                                              transform="translate(-0.375 20.625)" fill="#fff"/>
                                    </svg>
                                </a>
                            @endif
                        </div>

                        <div class="filter-inner">
                            <form action="{{ route('front.suppliers') }}">
                                <div class="common-input search-box">
                                    <input type="text" name="keyword"
                                           value="{{ request()->keyword ? request()->keyword : '' }}"
                                           placeholder="{{__('Enter Keyword')}}">
                                    <button class="search-btn">
                                        <img src="{{ asset('assets/front/img/fil-search.svg') }}" alt="search-icon"
                                             class="img-fluid search-icon">
                                    </button>
                                </div>
                                <input type="hidden" value="list" name="display_type">
                                <div class="common-input">
                                    <label class="input-label">{{__('Sort By')}}</label>
                                    <select class="js-example-basic-single" name="sort">
                                        <option selected="selected" disabled>{{__('Choose Sorting')}}</option>
                                        <option value="near_to_far"
                                                @if(request()->sort == "near_to_far") selected @endif>{{__('Near To Far')}}
                                        </option>
                                        <option value="latest"
                                                @if(request()->sort == "latest") selected @endif>{{__('Latest')}}
                                        </option>
                                        <option value="rating"
                                                @if(request()->sort == "rating") selected @endif>{{__('Customer Rating')}}
                                        </option>
                                    </select>
                                </div>
                                <div class="common-input">
                                    <label class="input-label">{{__('Category')}}</label>
                                    <select class="js-example-basic-single" name="category" id="category">
                                        <option value="" readonly="" selected>{{__('Select Category')}}</option>
                                        @forelse($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ request()->category_id == $category->id ? 'selected' : '' }}>
                                                {{ translate($category->name) }}</option>
                                        @empty
                                            <option value="" disabled selected>{{ __('No category have been created') }}
                                            </option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="common-input mb-25">
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
                <div class="col-xl-9">
                    @forelse ($suppliers as $supplier)
                        <div class="supplier-list-card d-flex justify-content-between align-items-center">
                            <div class="supplier-left-desc d-flex align-items-center">
                                <div class="supplist-img-block">
                                    <img src="{!! imageUrl(url($supplier->image_url), 191, 168, 100, 1) !!}"
                                         alt="supplier-img" class="img-fluid supplier-img">
                                </div>
                                <div class="supp-desc">
                                    <h3 class="sup-title text-truncate">
                                        {!! translate($supplier->supplier_name) !!}
                                    </h3>
                                    <p class="cate-name text-truncate pr-1">
                                        {!! translate($supplier->category->name) !!}
                                    </p>
                                    <a href="#" class="add-link d-flex">
                                        <i class="fas fa-map-marker-alt"></i><span class="text-truncate">
                                            <span class="text-truncate">{{ $supplier->address }}</span></span>
                                    </a>
                                    <div class="d-flex align-content-center stars-block">
                                        <div class="star-rating-area">
                                            <div class="rating-static clearfix"
                                                 rel="{{ round(getStarRating($supplier->rating), 1) }}">
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
                                            <div class="ratilike ng-binding">({{number_format($supplier->rating,1)}})
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="buttons-block">
                                <a href="{{ route('front.supplier-detail', $supplier->id) }}" class="next-link-btn">
                                    <svg id="NextIcon" xmlns="http://www.w3.org/2000/svg" width="40.455" height="25.586"
                                         viewBox="0 0 40.455 25.586">
                                        <path id="NextIcon-2" data-name="NextIcon"
                                              d="M0,102.768a1.421,1.421,0,0,0,1.421,1.421H35.646l-8.965,8.957a1.417,1.417,0,1,0,2.008,2l11.37-11.378a1.469,1.469,0,0,0,0-2.008L28.68,90.39A1.42,1.42,0,1,0,26.672,92.4l8.957,8.957H1.413A1.4,1.4,0,0,0,0,102.768Z"
                                              transform="translate(0 -89.975)" fill="#fff"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @empty
                        @include('front.common.alert-empty', [
                            'message' => __('No Supplier found.'),
                        ])
                    @endforelse
                    {{ $suppliers->links('front.common.pagination', ['paginator' => $suppliers]) }}
                </div>

            </div>
        </div>
    </main>
@endsection
