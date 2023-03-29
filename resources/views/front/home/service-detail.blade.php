@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <main class="services-details spacing-y">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-45">
                    <div class="service-dt-slider-block">
                        <div dir="ltr" class="slider-for">
                            @foreach ($service->images as $image)
                                <div>
                                    <div class="service-big-img">

                                        @if (str_contains($image->file_path, '.mp4') || str_contains($image->file_path, '.mov'))
                                            <video width="555" height="295" controls muted>
                                                <source src="{{ url($image->file_path) }}" class="img-fluid"
                                                    type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @else
                                            <a href="{!! url($image->file_path) !!}" data-lightbox="image-1">
                                                <img src="{!! imageUrl(url($image->file_path), 555, 295, 100, 1) !!}" alt="services-dt-img"
                                                    class="img-fluid services-dt-img">
                                            </a>
                                        @endif
                                        {{-- <img src="{!! imageUrl(url($image->file_path)) !!}" alt="services-dt-img"
                                            class="img-fluid services-dt-img"> --}}
                                        <span class="img-no">
                                            <i class="fas fa-camera"></i>{{ count($service->images) }}
                                        </span>
                                        @if ($service->service_type == 'offer')
                                            <span class="discount">
                                                {{ $service->discount }}% OFF
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach


                        </div>
                        <div dir="ltr" class="slider-nav">
                            @foreach ($service->images as $image)
                                <div>
                                    <div class="silder-sm-block">
                                        @if (str_contains($image->file_path, '.mp4') || str_contains($image->file_path, '.mov'))
                                            <video width="171" height="91">
                                                <source src="{{ url($image->file_path) }}" class="img-fluid"
                                                    type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @else
                                            <img src="{!! imageUrl(url($image->file_path)) !!}" alt="services-dt-img"
                                                class="img-fluid services-dt-img">
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-45">
                    <div class="service-dt-desc-col">
                        <div class="title-price-row d-flex justify-content-between align-items-center flex-wrap">
                            <div class="left-block">
                                <div class="d-flex align-content-center">
                                    <div class="star-rating-area">
                                        <div class="rating-static clearfix"
                                            rel="{{ round(getStarRating($service->average_rating), 1) }}">
                                            <label class="full" title="{{ __('Awesome - 5 stars') }}"></label>
                                            <label class="half" title="{{ __('Pretty good - 4.5 stars') }}"></label>
                                            <label class="full" title="{{ __('Pretty good - 4 stars') }}"></label>
                                            <label class="half" title="{{ __('Meh - 3.5 stars') }}"></label>
                                            <label class="full" title="{{ __('Meh - 3 stars') }}"></label>
                                            <label class="half" title="{{ __('Kinda bad - 2.5 stars') }}"></label>
                                            <label class="full" title="{{ __('Kinda bad - 2 stars') }}"></label>
                                            <label class="half" title="{{ __('Meh - 1.5 stars') }}"></label>
                                            <label class="full" title="{{ __('Sucks big time - 1 star') }}"></label>
                                            <label class="half" title="{{ __('Sucks big time - 0.5 stars') }}"></label>
                                        </div>
                                        <div class="ratilike ng-binding">({{ number_format($service->average_rating, 1) }}
                                            )
                                        </div>
                                    </div>
                                </div>
                                <h3 class="serv-title">
                                    {!! translate($service->name) !!}
                                </h3>
                                <div class="d-flex serv-price">
                                    @if ($service->service_type == 'offer')
                                        <span>{{ __('AED') }}{{ round($service->discountedMinPrice, 2) }}</span><span
                                            class="mx-05">-</span>
                                        <span>{{ __('AED') }}{{ round($service->dicountedMaxPrice, 2) }}</span>
                                    @else
                                        <span>{{ __('AED') }}{{ round($service->min_price, 2) }}</span><span
                                            class="mx-05">-</span>
                                        <span>{{ __('AED') }}{{ round($service->max_price, 2) }}</span>
                                    @endif
                                </div>
                            </div>

                            <div
                                class="right-block d-flex flex-wrap flex-column justify-content-between align-items-end mt-2 mt-sm-0">

                                @if (Auth::check())
                                    @if (auth()->user()->user_type == 'user')
                                        @if (session()->get('area_id'))
                                            <button data-toggle="modal" data-target="#get-quotation-modal"
                                                class="secondary-btn">
                                                {{ __('Get Quotation') }}
                                            </button>
                                        @else
                                            <button type="button" class="secondary-btn" data-toggle="modal"
                                                data-target="#supplier-areas">
                                                {{ __('Change Service Area') }}
                                            </button>
                                            <div class="modal fade feature-packages-modal " id="supplier-areas"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="packages-box">
                                                            <div class="headline-box">
                                                                {{ __('Please select your area') }}
                                                            </div>
                                                            <form id="areaform" action="{{ route('front.area.save') }}"
                                                                method="post">
                                                                @csrf

                                                                <div class="innner-sec">
                                                                    <div class="common-input">
                                                                        <label class="input-label">{{ __('Area') }}<span
                                                                                class="text-danger">*</label>
                                                                        <select class="js-example-basic-single"
                                                                        name="area_id" required>
                                                                            <option value="" readonly="" selected>
                                                                                {{ __('Select Area') }}</option>
                                                                            @forelse($service->supplier->coveredareas as $area)
                                                                                <option value="{{ $area->id }}">
                                                                                    {{ translate($area->name) }}</option>
                                                                            @empty
                                                                                <option value="" disabled selected>
                                                                                    {{ __('Select Area') }}
                                                                                </option>
                                                                            @endforelse

                                                                        </select>
                                                                    </div>
                                                                    <div class="d-flex flex-wrap">
                                                                        <div class="px-1 w-50">
                                                                            <button type="submit"
                                                                                class="secondary-btn mw-100">
                                                                                {{ __('Submit') }}
                                                                            </button>
                                                                        </div>
                                                                        <div class="px-1 w-50">
                                                                            <button type="button"
                                                                                class="secondary-btn border-btn mw-100"
                                                                                type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
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
                                        @endif
                                    @else
                                        <h3 class="title">
                                            {{ __('You are not authorised to get Quotation') }}
                                        </h3>
                                    @endif
                                @else
                                    <?php Session::put('slug', $service->slug); ?>
                                    <a href="{{ route('front.auth.login') }}" class="secondary-btn my-1">
                                        {{ __('Get Quotation') }}
                                    </a>
                                @endif
                                <div class="visit-price d-flex align-items-center">
                                    <span>{{ __('Visit Fee:') }}</span>{{ __('AED') }}
                                    {{ $service->supplier->visit_fee }}
                                </div>

                            </div>
                        </div>
                        <div class="about-supplier-block">
                            <div class="title-time-row d-flex flex-wrap justify-content-between align-items-center">
                                <h3 class="title">
                                    {{ __('About The Supplier') }}
                                </h3>
                                <div class="d-flex flex-wrap gap-1x align-items-center">
                                    <div class="dropdown ctm-dropdown share-dd">
                                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                <path
                                                    d="M384 32C419.3 32 448 60.65 448 96V416C448 451.3 419.3 480 384 480H64C28.65 480 0 451.3 0 416V96C0 60.65 28.65 32 64 32H384zM320 96C284.7 96 256 124.7 256 160C256 162.5 256.1 164.9 256.4 167.3L174.5 212C162.8 199.7 146.3 192 128 192C92.65 192 64 220.7 64 256C64 291.3 92.65 320 128 320C146.3 320 162.8 312.3 174.5 299.1L256.4 344.7C256.1 347.1 256 349.5 256 352C256 387.3 284.7 416 320 416C355.3 416 384 387.3 384 352C384 316.7 355.3 288 320 288C304.6 288 290.5 293.4 279.4 302.5L194.1 256L279.4 209.5C290.5 218.6 304.6 224 320 224C355.3 224 384 195.3 384 160C384 124.7 355.3 96 320 96V96z" />
                                            </svg>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item"
                                                href="https://www.facebook.com/sharer/sharer.php?u={{ route('front.service.detail', $service->slug) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                                    <path
                                                        d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z" />
                                                </svg>
                                            </a>
                                            <a class="dropdown-item"
                                                href="https://api.whatsapp.com//send?text={{ route('front.service.detail', $service->slug) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 488 512">
                                                    <path
                                                        d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                    @if (Auth::check())
                                        @if ($userData && !$userData->isSupplier())
                                            <a href="{{ route('front.dashboard.conversation.start', ['service_id' => $service->id, 'supplier_id' => $service->supplier->id]) }}"
                                                class="chat-btn">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    <path
                                                        d="M256 31.1c-141.4 0-255.1 93.12-255.1 208c0 49.62 21.35 94.98 56.97 130.7c-12.5 50.37-54.27 95.27-54.77 95.77c-2.25 2.25-2.875 5.734-1.5 8.734c1.249 3 4.021 4.766 7.271 4.766c66.25 0 115.1-31.76 140.6-51.39c32.63 12.25 69.02 19.39 107.4 19.39c141.4 0 255.1-93.13 255.1-207.1S397.4 31.1 256 31.1zM127.1 271.1c-17.75 0-32-14.25-32-31.1s14.25-32 32-32s32 14.25 32 32S145.7 271.1 127.1 271.1zM256 271.1c-17.75 0-31.1-14.25-31.1-31.1s14.25-32 31.1-32s31.1 14.25 31.1 32S273.8 271.1 256 271.1zM383.1 271.1c-17.75 0-32-14.25-32-31.1s14.25-32 32-32s32 14.25 32 32S401.7 271.1 383.1 271.1z" />
                                                </svg>
                                            </a>
                                        @endif
                                    @endif
                                    @if (session()->get('area_id') && $service->supplier->getTime($service->supplier))
                                        <span class="sup-time">
                                            {{ $service->supplier->getTime($service->supplier) }}mins
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="supplier-row d-flex align-items-center">
                                <div class="sup-img-block mr-1">
                                    <img src="{!! imageUrl(url($service->supplier->image_url), 85, 85, 90) !!}" alt="sup-img" class="img-fluid sup-img">
                                </div>
                                <div class="sup-desc">
                                    <div class="d-flex align-content-center">
                                        <div class="star-rating-area">
                                            <div class="rating-static clearfix"
                                                rel="{{ round(getStarRating($service->supplier->rating), 1) }}">
                                                <label class="full" title="{{ __('Awesome - 5 stars') }}"></label>
                                                <label class="half"
                                                    title="{{ __('Pretty good - 4.5 stars') }}"></label>
                                                <label class="full" title="{{ __('Pretty good - 4 stars') }}"></label>
                                                <label class="half" title="{{ __('Meh - 3.5 stars') }}"></label>
                                                <label class="full" title="{{ __('Meh - 3 stars') }}"></label>
                                                <label class="half" title="{{ __('Kinda bad - 2.5 stars') }}"></label>
                                                <label class="full" title="{{ __('Kinda bad - 2 stars') }}"></label>
                                                <label class="half" title="{{ __('Meh - 1.5 stars') }}"></label>
                                                <label class="full"
                                                    title="{{ __('Sucks big time - 1 star') }}"></label>
                                                <label class="half"
                                                    title="{{ __('Sucks big time - 0.5 stars') }}"></label>
                                            </div>
                                            <div class="ratilike ng-binding">
                                                ({{ number_format($service->supplier->rating, 1) }})
                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="title">
                                        {!! translate($service->supplier->supplier_name) !!}
                                    </h4>
                                    <p class="p-text">
                                        {!! $service->supplier->category ? translate($service->supplier->category->name) : 'N/A' !!}

                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="service-text-desc">
                            <h3 class="title">
                                {{ __('Description') }}
                            </h3>
                            <p class="primary-text-p">
                                {!! translate($service->description) !!}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="ratting-reviews-sec">
                        <h3 class="review-title">
                            {{ __('Ratings &amp; Reviews') }}
                        </h3>
                        <div class="row">
                            <div class="col-md-6">
                                @if ($service->pendingReviews->isNotEmpty())
                                    <p class="rate-link">
                                        {{ __('Rate Service') }}
                                    </p>

                                    <div class="submit-reviews-block" style="display: none;">
                                        <form action="{{ route('api.auth.reviews.save') }}" id="reviewForm">
                                            <div class="ratting-sec">
                                                <p class="p-text">
                                                    {{ __('Rate Supplier') }}
                                                </p>
                                                <input type="hidden" name="id"
                                                    value="{{ $service->pendingReviews[0]->id }}">
                                                <div class="ratting-starts-block">
                                                    <div class="d-flex align-items-center">
                                                        <fieldset class="rate">
                                                            <input type="radio" id="rating-5" name="rating"
                                                                value="5" />
                                                            <label for="rating-5" title="5 stars"></label>
                                                            <input type="radio" id="rating-4.5" name="rating"
                                                                value="4.5" />
                                                            <label class="half" for="rating-4.5"
                                                                title="4.5 stars"></label>
                                                            <input type="radio" id="rating-4" name="rating"
                                                                value="4" />
                                                            <label for="rating-4" title="4 stars"></label>
                                                            <input type="radio" id="rating-3.5" name="rating"
                                                                value="3.5" />
                                                            <label class="half" for="rating-3.5"
                                                                title="3.5 stars"></label>
                                                            <input type="radio" id="rating-3" name="rating"
                                                                value="3" />
                                                            <label for="rating-3" title="3 stars"></label>
                                                            <input type="radio" id="rating-2.5" name="rating"
                                                                value="3.5" /><label class="half" for="rating-2.5"
                                                                title="2.5 stars"></label>
                                                            <input type="radio" id="rating-2" name="rating"
                                                                value="2" /><label for="rating-2"
                                                                title="2 stars"></label>
                                                            <input type="radio" id="rating-1.5" name="rating"
                                                                value="2.5" /><label class="half" for="rating-1.5"
                                                                title="1.5 stars"></label>
                                                            <input type="radio" id="rating-1" name="rating"
                                                                value="1" /><label for="rating-1"
                                                                title="1 star"></label>
                                                            <input type="radio" id="rating-0.5" name="rating"
                                                                value="0.5" /><label class="half" for="rating-0.5"
                                                                title="0.5 star"></label>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="review-sec">
                                                <div class="common-input">
                                                    <label class="input-label">
                                                        {{ __('Describe your experience (Optional)') }}
                                                    </label>
                                                    <textarea class="ctm-textarea" rows="6" name="review" placeholder="{{ __('Enter your comment here...') }}"></textarea>
                                                </div>
                                                <button class="secondary-btn">
                                                    {{ __('Submit') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                                @if ($reviews->isNotEmpty())
                                    <div class="total-reviews-block">
                                        <div
                                            class="d-flex flex-wrap total-review-row justify-content-between align-items-center">
                                            <div class="left-col">
                                                <div class="review-no">
                                                    {{ number_format((float) $service->average_rating, 1, '.', '') }}
                                                    <span>/5</span>
                                                </div>
                                                <div class="d-flex align-content-center">
                                                    <div class="star-rating-area">
                                                        <div class="rating-static clearfix"
                                                            rel="{{ round(getStarRating($service->average_rating), 1) }}">
                                                            <label class="full"
                                                                title="{{ __('Awesome - 5 stars') }}"></label>
                                                            <label class="half"
                                                                title="{{ __('Pretty good - 4.5 stars') }}"></label>
                                                            <label class="full"
                                                                title="{{ __('Pretty good - 4 stars') }}"></label>
                                                            <label class="half"
                                                                title="{{ __('Meh - 3.5 stars') }}"></label>
                                                            <label class="full"
                                                                title="{{ __('Meh - 3 stars') }}"></label>
                                                            <label class="half"
                                                                title="{{ __('Kinda bad - 2.5 stars') }}"></label>
                                                            <label class="full"
                                                                title="{{ __('Kinda bad - 2 stars') }}"></label>
                                                            <label class="half"
                                                                title="{{ __('Meh - 1.5 stars') }}"></label>
                                                            <label class="full"
                                                                title="{{ __('Sucks big time - 1 star') }}"></label>
                                                            <label class="half"
                                                                title="{{ __('Sucks big time - 0.5 stars') }}"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <span class="no-of-reviews">
                                                    {{ $reviews->total() }} {{ __('Reviews') }}
                                                </span>
                                            </div>
                                            <div class="right-col">
                                                <div class="progress-bars-block">
                                                    <div class="stars-bar-row d-flex align-items-center">
                                                        <div class="d-flex align-content-center">
                                                            <div class="star-rating-area">
                                                                <div class="rating-static clearfix" rel="5">
                                                                    <label class="full"
                                                                        title="{{ __('Awesome - 5 stars') }}"></label>
                                                                    <label class="half"
                                                                        title="{{ __('Pretty good - 4.5 stars') }}"></label>
                                                                    <label class="full"
                                                                        title="{{ __('Pretty good - 4 stars') }}"></label>
                                                                    <label class="half"
                                                                        title="{{ __('Meh - 3.5 stars') }}"></label>
                                                                    <label class="full"
                                                                        title="{{ __('Meh - 3 stars') }}"></label>
                                                                    <label class="half"
                                                                        title="{{ __('Kinda bad - 2.5 stars') }}"></label>
                                                                    <label class="full"
                                                                        title="{{ __('Kinda bad - 2 stars') }}"></label>
                                                                    <label class="half"
                                                                        title="{{ __('Meh - 1.5 stars') }}"></label>
                                                                    <label class="full"
                                                                        title="{{ __('Sucks big time - 1 star') }}"></label>
                                                                    <label class="half"
                                                                        title="{{ __('Sucks big time - 0.5 stars') }}"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="progress">
                                                            <div class="progress-bar" style="width:{{ $rewBar['4'] }}%"
                                                                role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                                                aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="stars-bar-row d-flex align-items-center">
                                                        <div class="d-flex align-content-center">
                                                            <div class="star-rating-area">
                                                                <div class="rating-static clearfix" rel="4">
                                                                    <label class="full"
                                                                        title="{{ __('Awesome - 5 stars') }}"></label>
                                                                    <label class="half"
                                                                        title="{{ __('Pretty good - 4.5 stars') }}"></label>
                                                                    <label class="full"
                                                                        title="{{ __('Pretty good - 4 stars') }}"></label>
                                                                    <label class="half"
                                                                        title="{{ __('Meh - 3.5 stars') }}"></label>
                                                                    <label class="full"
                                                                        title="{{ __('Meh - 3 stars') }}"></label>
                                                                    <label class="half"
                                                                        title="{{ __('Kinda bad - 2.5 stars') }}"></label>
                                                                    <label class="full"
                                                                        title="{{ __('Kinda bad - 2 stars') }}"></label>
                                                                    <label class="half"
                                                                        title="{{ __('Meh - 1.5 stars') }}"></label>
                                                                    <label class="full"
                                                                        title="{{ __('Sucks big time - 1 star') }}"></label>
                                                                    <label class="half"
                                                                        title="{{ __('Sucks big time - 0.5 stars') }}"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="progress">
                                                            <div class="progress-bar" style="width:{{ $rewBar['3'] }}%"
                                                                role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                                                aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="stars-bar-row d-flex align-items-center">
                                                        <div class="d-flex align-content-center">
                                                            <div class="star-rating-area">
                                                                <div class="rating-static clearfix" rel="3">
                                                                    <label class="full"
                                                                        title="{{ __('Awesome - 5 stars') }}"></label>
                                                                    <label class="half"
                                                                        title="{{ __('Pretty good - 4.5 stars') }}"></label>
                                                                    <label class="full"
                                                                        title="{{ __('Pretty good - 4 stars') }}"></label>
                                                                    <label class="half"
                                                                        title="{{ __('Meh - 3.5 stars') }}"></label>
                                                                    <label class="full"
                                                                        title="{{ __('Meh - 3 stars') }}"></label>
                                                                    <label class="half"
                                                                        title="{{ __('Kinda bad - 2.5 stars') }}"></label>
                                                                    <label class="full"
                                                                        title="{{ __('Kinda bad - 2 stars') }}"></label>
                                                                    <label class="half"
                                                                        title="{{ __('Meh - 1.5 stars') }}"></label>
                                                                    <label class="full"
                                                                        title="{{ __('Sucks big time - 1 star') }}"></label>
                                                                    <label class="half"
                                                                        title="{{ __('Sucks big time - 0.5 stars') }}"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="progress">
                                                            <div class="progress-bar" style="width:{{ $rewBar['2'] }}%"
                                                                role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                                                aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="stars-bar-row d-flex align-items-center">
                                                        <div class="d-flex align-content-center">
                                                            <div class="star-rating-area">
                                                                <div class="rating-static clearfix" rel="2">
                                                                    <label class="full"
                                                                        title="{{ __('Awesome - 5 stars') }}"></label>
                                                                    <label class="half"
                                                                        title="{{ __('Pretty good - 4.5 stars') }}"></label>
                                                                    <label class="full"
                                                                        title="{{ __('Pretty good - 4 stars') }}"></label>
                                                                    <label class="half"
                                                                        title="{{ __('Meh - 3.5 stars') }}"></label>
                                                                    <label class="full"
                                                                        title="{{ __('Meh - 3 stars') }}"></label>
                                                                    <label class="half"
                                                                        title="{{ __('Kinda bad - 2.5 stars') }}"></label>
                                                                    <label class="full"
                                                                        title="{{ __('Kinda bad - 2 stars') }}"></label>
                                                                    <label class="half"
                                                                        title="{{ __('Meh - 1.5 stars') }}"></label>
                                                                    <label class="full"
                                                                        title="{{ __('Sucks big time - 1 star') }}"></label>
                                                                    <label class="half"
                                                                        title="{{ __('Sucks big time - 0.5 stars') }}"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="progress">
                                                            <div class="progress-bar" style="width:{{ $rewBar['1'] }}%"
                                                                role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                                                aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="stars-bar-row d-flex align-items-center">
                                                        <div class="d-flex align-content-center">
                                                            <div class="star-rating-area">
                                                                <div class="rating-static clearfix" rel="1">
                                                                    <label class="full"
                                                                        title="{{ __('Awesome - 5 stars') }}"></label>
                                                                    <label class="half"
                                                                        title="{{ __('Pretty good - 4.5 stars') }}"></label>
                                                                    <label class="full"
                                                                        title="{{ __('Pretty good - 4 stars') }}"></label>
                                                                    <label class="half"
                                                                        title="{{ __('Meh - 3.5 stars') }}"></label>
                                                                    <label class="full"
                                                                        title="{{ __('Meh - 3 stars') }}"></label>
                                                                    <label class="half"
                                                                        title="{{ __('Kinda bad - 2.5 stars') }}"></label>
                                                                    <label class="full"
                                                                        title="{{ __('Kinda bad - 2 stars') }}"></label>
                                                                    <label class="half"
                                                                        title="{{ __('Meh - 1.5 stars') }}"></label>
                                                                    <label class="full"
                                                                        title="{{ __('Sucks big time - 1 star') }}"></label>
                                                                    <label class="half"
                                                                        title="{{ __('Sucks big time - 0.5 stars') }}"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="progress">
                                                            <div class="progress-bar "
                                                                style="width:{{ $rewBar['0'] }}%" role="progressbar"
                                                                aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @forelse ($reviews as $review)
                            <div class="reviews-card">
                                <div class="title-img-time-row d-flex justify-content-between">
                                    <div class="img-title-block d-flex align-items-center">
                                        <div class="user-img-block">
                                            <img src="{!! imageUrl(url($review->user->image_url), 50, 50, 100, 1) !!}" alt="user-img" class="img-fluid user-img">
                                        </div>
                                        <div class="title-star-block">
                                            <h4 class="user-name text-truncate">
                                                {{ $review->user->user_name }}
                                            </h4>
                                            <div class="star-rating-area">
                                                <div class="rating-static clearfix"
                                                    rel="{{ round(getStarRating($review->rating), 1) }}">
                                                    <label class="full" title="{{ __('Awesome - 5 stars') }}"></label>
                                                    <label class="half"
                                                        title="{{ __('Pretty good - 4.5 stars') }}"></label>
                                                    <label class="full"
                                                        title="{{ __('Pretty good - 4 stars') }}"></label>
                                                    <label class="half" title="{{ __('Meh - 3.5 stars') }}"></label>
                                                    <label class="full" title="{{ __('Meh - 3 stars') }}"></label>
                                                    <label class="half"
                                                        title="{{ __('Kinda bad - 2.5 stars') }}"></label>
                                                    <label class="full"
                                                        title="{{ __('Kinda bad - 2 stars') }}"></label>
                                                    <label class="half" title="{{ __('Meh - 1.5 stars') }}"></label>
                                                    <label class="full"
                                                        title="{{ __('Sucks big time - 1 star') }}"></label>
                                                    <label class="half"
                                                        title="{{ __('Sucks big time - 0.5 stars') }}"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="time">
                                        {!! \Carbon\Carbon::parse($review->updated_at)->diffForHumans() !!}
                                    </span>
                                </div>
                                <p class="p-text">
                                    {{ $review->review }}
                                </p>
                            </div>
                        @empty
                            @include('front.common.alert-empty', [
                                'message' => __('No Review found.'),
                            ])
                        @endforelse
                        {{ $reviews->links('front.common.pagination', ['paginator' => $reviews]) }}


                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- selected equipment Modal -->
    {{-- <div class="modal fade feature-packages-modal order-cancel-mdl get-quotation-modal select-equipment-modal"
        id="selected-equipment-modal" style="z-index: 9999999;" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="packages-box">
                    <div class="headline-box">
                        Get Quotation
                    </div>
                    <div class="innner-sec">
                        <div class="modal-desc px-1">
                            <div class="common-input">
                                <label class="input-label">Select Date</label>
                                <div class="password-input-box">
                                    <input id="datepicker" type="text" class="cursor-input" placeholder="Date">
                                    <svg id="cal-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16">
                                    <path id="Path_48305" data-name="Path 48305" d="M-.375-9h-13.25a.362.362,0,0,1-.266-.109A.362.362,0,0,1-14-9.375V-10.5a1.447,1.447,0,0,1,.438-1.062A1.447,1.447,0,0,1-12.5-12H-11v-1.625a.362.362,0,0,1,.109-.266A.362.362,0,0,1-10.625-14h1.25a.362.362,0,0,1,.266.109A.362.362,0,0,1-9-13.625V-12h4v-1.625a.362.362,0,0,1,.109-.266A.362.362,0,0,1-4.625-14h1.25a.362.362,0,0,1,.266.109A.362.362,0,0,1-3-13.625V-12h1.5a1.447,1.447,0,0,1,1.063.438A1.447,1.447,0,0,1,0-10.5v1.125a.362.362,0,0,1-.109.266A.362.362,0,0,1-.375-9Zm-13.25,1H-.375a.362.362,0,0,1,.266.109A.362.362,0,0,1,0-7.625V.5A1.447,1.447,0,0,1-.437,1.563,1.447,1.447,0,0,1-1.5,2h-11a1.447,1.447,0,0,1-1.062-.437A1.447,1.447,0,0,1-14,.5V-7.625a.362.362,0,0,1,.109-.266A.362.362,0,0,1-13.625-8ZM-10-1.625a.362.362,0,0,0-.109-.266A.362.362,0,0,0-10.375-2h-1.25a.362.362,0,0,0-.266.109A.362.362,0,0,0-12-1.625v1.25a.362.362,0,0,0,.109.266A.362.362,0,0,0-11.625,0h1.25a.362.362,0,0,0,.266-.109A.362.362,0,0,0-10-.375Zm0-4a.362.362,0,0,0-.109-.266A.362.362,0,0,0-10.375-6h-1.25a.362.362,0,0,0-.266.109A.362.362,0,0,0-12-5.625v1.25a.362.362,0,0,0,.109.266A.362.362,0,0,0-11.625-4h1.25a.362.362,0,0,0,.266-.109A.362.362,0,0,0-10-4.375Zm4,4a.362.362,0,0,0-.109-.266A.362.362,0,0,0-6.375-2h-1.25a.362.362,0,0,0-.266.109A.362.362,0,0,0-8-1.625v1.25a.362.362,0,0,0,.109.266A.362.362,0,0,0-7.625,0h1.25a.362.362,0,0,0,.266-.109A.362.362,0,0,0-6-.375Zm0-4a.362.362,0,0,0-.109-.266A.362.362,0,0,0-6.375-6h-1.25a.362.362,0,0,0-.266.109A.362.362,0,0,0-8-5.625v1.25a.362.362,0,0,0,.109.266A.362.362,0,0,0-7.625-4h1.25a.362.362,0,0,0,.266-.109A.362.362,0,0,0-6-4.375Zm4,4a.362.362,0,0,0-.109-.266A.362.362,0,0,0-2.375-2h-1.25a.362.362,0,0,0-.266.109A.362.362,0,0,0-4-1.625v1.25a.362.362,0,0,0,.109.266A.362.362,0,0,0-3.625,0h1.25a.362.362,0,0,0,.266-.109A.362.362,0,0,0-2-.375Zm0-4a.362.362,0,0,0-.109-.266A.362.362,0,0,0-2.375-6h-1.25a.362.362,0,0,0-.266.109A.362.362,0,0,0-4-5.625v1.25a.362.362,0,0,0,.109.266A.362.362,0,0,0-3.625-4h1.25a.362.362,0,0,0,.266-.109A.362.362,0,0,0-2-4.375Z" transform="translate(14 14)" fill="#ccc"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="common-input">
                                <label class="input-label">Select Time</label>
                                <div class="password-input-box date-box">
                                    <input type="text" class="timepicker cursor-input" placeholder="Time">
                                    <svg id="cal-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16">
                                    <path id="Path_48305" data-name="Path 48305" d="M-.375-9h-13.25a.362.362,0,0,1-.266-.109A.362.362,0,0,1-14-9.375V-10.5a1.447,1.447,0,0,1,.438-1.062A1.447,1.447,0,0,1-12.5-12H-11v-1.625a.362.362,0,0,1,.109-.266A.362.362,0,0,1-10.625-14h1.25a.362.362,0,0,1,.266.109A.362.362,0,0,1-9-13.625V-12h4v-1.625a.362.362,0,0,1,.109-.266A.362.362,0,0,1-4.625-14h1.25a.362.362,0,0,1,.266.109A.362.362,0,0,1-3-13.625V-12h1.5a1.447,1.447,0,0,1,1.063.438A1.447,1.447,0,0,1,0-10.5v1.125a.362.362,0,0,1-.109.266A.362.362,0,0,1-.375-9Zm-13.25,1H-.375a.362.362,0,0,1,.266.109A.362.362,0,0,1,0-7.625V.5A1.447,1.447,0,0,1-.437,1.563,1.447,1.447,0,0,1-1.5,2h-11a1.447,1.447,0,0,1-1.062-.437A1.447,1.447,0,0,1-14,.5V-7.625a.362.362,0,0,1,.109-.266A.362.362,0,0,1-13.625-8ZM-10-1.625a.362.362,0,0,0-.109-.266A.362.362,0,0,0-10.375-2h-1.25a.362.362,0,0,0-.266.109A.362.362,0,0,0-12-1.625v1.25a.362.362,0,0,0,.109.266A.362.362,0,0,0-11.625,0h1.25a.362.362,0,0,0,.266-.109A.362.362,0,0,0-10-.375Zm0-4a.362.362,0,0,0-.109-.266A.362.362,0,0,0-10.375-6h-1.25a.362.362,0,0,0-.266.109A.362.362,0,0,0-12-5.625v1.25a.362.362,0,0,0,.109.266A.362.362,0,0,0-11.625-4h1.25a.362.362,0,0,0,.266-.109A.362.362,0,0,0-10-4.375Zm4,4a.362.362,0,0,0-.109-.266A.362.362,0,0,0-6.375-2h-1.25a.362.362,0,0,0-.266.109A.362.362,0,0,0-8-1.625v1.25a.362.362,0,0,0,.109.266A.362.362,0,0,0-7.625,0h1.25a.362.362,0,0,0,.266-.109A.362.362,0,0,0-6-.375Zm0-4a.362.362,0,0,0-.109-.266A.362.362,0,0,0-6.375-6h-1.25a.362.362,0,0,0-.266.109A.362.362,0,0,0-8-5.625v1.25a.362.362,0,0,0,.109.266A.362.362,0,0,0-7.625-4h1.25a.362.362,0,0,0,.266-.109A.362.362,0,0,0-6-4.375Zm4,4a.362.362,0,0,0-.109-.266A.362.362,0,0,0-2.375-2h-1.25a.362.362,0,0,0-.266.109A.362.362,0,0,0-4-1.625v1.25a.362.362,0,0,0,.109.266A.362.362,0,0,0-3.625,0h1.25a.362.362,0,0,0,.266-.109A.362.362,0,0,0-2-.375Zm0-4a.362.362,0,0,0-.109-.266A.362.362,0,0,0-2.375-6h-1.25a.362.362,0,0,0-.266.109A.362.362,0,0,0-4-5.625v1.25a.362.362,0,0,0,.109.266A.362.362,0,0,0-3.625-4h1.25a.362.362,0,0,0,.266-.109A.362.362,0,0,0-2-4.375Z" transform="translate(14 14)" fill="#ccc"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="common-input">
                                <label class="input-label">Comments</label>
                                <textarea class="ctm-textarea" placeholder="" Lotem ipsum dolor></textarea>
                            </div>
                            <div class="common-input mb-1">
                                <label class="input-label">Take Issue Image</label>
                                <div class="upload-sec d-flex align-items-center flex-wrap">
                                    <!-- image upload -->
                                    <div class="qust-filed">
                                        <div class="form-control d-flex align-items-center justify-content-center">
                                            <input type="file" id="choose-file" class="input-file d-none">
                                            <label for="choose-file"
                                                class="btn-tertiary js-labelFile d-flex align-items-center flex-column">
                                                <i class="fas fa-camera"></i>
                                                <span class="js-fileName Poppins-Regular">Open Camera</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- image upload -->
                                </div>
                            </div>
                            <div class="common-input">
                                <label class="input-label">Select</label>
                                <div class="role-radio">
                                    <label class="custom-radio">
                                        I know the issue (<a data-toggle="modal" data-target="#select-equipment-modal"
                                            href="#">Select Equipment</a>)
                                        <input type="radio" checked="checked" name="Role">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="role-radio">
                                    <label class="custom-radio">
                                        I do not know the issue <span>(Visit Fee will apply=AED 50)</span>
                                        <input type="radio" checked="checked" name="Role">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="add-equipment-block">
                                <div
                                    class="equip-link-row mb-2 d-flex justify-content-between align-items-center flex-wrap">
                                    <h4 class="title">
                                        Selected Equipment
                                    </h4>
                                    <span class="link-s">
                                        (<a href="#" class="add-eq-link">Add Equipment</a>)
                                    </span>
                                </div>
                            </div>
                            <div class="container">
                                <div class="row select-eq-row">
                                    <div class="cols col-sm-6 col-6-ctm px-0">
                                        <div class="portfolio-add-card">
                                            <div class="img-add-del-btn">
                                                <div class="img-block">
                                                    <img src="img/equipment-img.jpg" alt="portfolio-img"
                                                        class="img-fluid portfolio-img">
                                                </div>
                                            </div>
                                            <h3 class="price text-truncate">
                                                AED20
                                            </h3>
                                            <h3 class="title text-truncate">
                                                Plastic Pipe Fitting Elbow
                                            </h3>
                                            <h3 class="title text-truncate">
                                                Plasthetics - 2021
                                            </h3>
                                            <button class="close-btn">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <button class="login-btn w-100">
                                Submit
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- select equipment Modal -->
    <div style="z-index:99999;" class="modal fade feature-packages-modal select-equipment-modal"
        id="select-equipment-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="packages-box">
                    <div class="headline-box">
                        {{ __('Select Equipment(s)') }}
                    </div>
                    <div class="innner-sec">
                        <div class="container">
                            <form id="equipment-form">
                                <div class="equipment-card-sec">
                                    <div class="row">
                                        @forelse ($service->equipments as $equipment)
                                            <div class="col-sm-6 col-6-ctm px-1">
                                                <div class="portfolio-add-card">
                                                    <div class="check-box">
                                                        <label class="custom-check">
                                                            <input type="checkbox" value="{{ $equipment->id }}"
                                                                class="equipment-check" name="equipment[]">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                    <div class="img-add-del-btn">
                                                        <div class="img-block">
                                                            <img src="{!! imageUrl(url($equipment->image_url), 246, 150, 100, 1) !!}" alt="portfolio-img"
                                                                class="img-fluid portfolio-img">
                                                        </div>
                                                    </div>
                                                    <h3 class="price text-truncate">
                                                        {{ __('AED') }} {{ $equipment->price }}
                                                    </h3>
                                                    <h3 class="title text-truncate">
                                                        {{ translate($equipment->name) }}
                                                    </h3>
                                                    <h3 class="title text-truncate">
                                                        {{ $equipment->equipment_model }} - {{ $equipment->make }}
                                                    </h3>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="alert alert-danger w-100" role="alert">
                                                {{ __('No Equipment Found') }}
                                            </div>
                                        @endforelse


                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 px-sm-1 px-2">
                                        <button type="submit" class="login-btn w-100">
                                            {{ __('Select') }}
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Get quotation modal -->
    <div class="modal fade feature-packages-modal order-cancel-mdl get-quotation-modal select-equipment-modal "
        id="get-quotation-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="packages-box">
                    <div class="headline-box">
                        {{ __('Get Quotation') }}
                    </div>
                    <div class="innner-sec">
                        <div class="modal-desc px-1">
                            <form action="{{ route('front.add.cart') }}" method="post" id="quotation-form">
                                @csrf
                                <div class="common-input">
                                    <label class="input-label">{{ __('Select Date') }}<span
                                            class="text-danger">*</span></label>
                                    <div class="password-input-box">
                                        <input autocomplete="off" id="datepicker" min="{{ Carbon\Carbon::now() }}"
                                            type="text" name="date"
                                            value="{{ empty(old('date')) ? (isset($cartData) && !empty($cartData->date) ? $cartData->date : old('date')) : old('date') }}"
                                            required class="cursor-input" placeholder="{{__('Date')}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="17"
                                            viewBox="0 0 15 17">
                                            <g id="Component_13_1" data-name="Component 13 – 1"
                                                transform="translate(0 1)">
                                                <text id="_" data-name="" transform="translate(14 14)"
                                                    fill="#ccc" font-size="16"
                                                    font-family="FontAwesome5FreeSolid, 'Font Awesome \35  Free Solid'">
                                                    <tspan x="-14" y="0"></tspan>
                                                </text>
                                            </g>
                                        </svg>
                                    </div>
                                    @include('front.common.alert', ['input' => 'date'])
                                </div>
                                <input type="hidden" name="service_id" value="{{ $service->id }}">
                                <input type="hidden" name="id"
                                    value="{{ isset($cartData) && !empty($cartData->id) ? $cartData->id : '0' }}">
                                <div class="common-input">
                                    <label class="input-label">{{ __('Select Time') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="password-input-box">
                                        <input type="text" id="tim" autocomplete="off" name="time"
                                            value="{{ empty(old('time')) ? (isset($cartData) && !empty($cartData->time) ? $cartData->time : old('time')) : old('time') }}"
                                            class="cursor-input" required placeholder="{{__('Time')}}">
                                        <svg id="Component_14_1" data-name="Component 14 – 1"
                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 16 16">
                                            <text id="_" data-name="" transform="translate(16 14)"
                                                fill="#ccc" font-size="16"
                                                font-family="FontAwesome5FreeSolid, 'Font Awesome \35  Free Solid'">
                                                <tspan x="-16" y="0"></tspan>
                                            </text>
                                        </svg>
                                    </div>
                                    @include('front.common.alert', ['input' => 'time'])
                                </div>
                                <div class="common-input">
                                    <label class="input-label">{{ __('Comments') }} <span
                                            class="text-danger">*</span></label>
                                    <textarea class="ctm-textarea" name="description" placeholder="{{ __('Lorem ipsum dolor') }}" required>{{ empty(old('description')) ? (isset($cartData) && !empty($cartData->description) ? $cartData->description : old('description')) : old('description') }}</textarea>
                                </div>
                                <div class="common-input mb-1">
                                    @include('front.common.image-upload-multi', [
                                        'imageTitle' => __('Take Issue Image'),
                                        'inputName' => 'issue_images',
                                        'isRequired' => 1,
                                        'allowVideo' => 0,
                                        'imageNumber' => 2,
                                        'allowDeleteApi' => 1,
                                        'numberOfImages' => 3,
                                        'displayImageSrc' => old(
                                            'issue_images',
                                            isset($cartData) && !empty($cartData->issue_images)
                                                ? $cartData->issue_images
                                                : ''
                                        ),
                                        'value' => old(
                                            'issue_images',
                                            isset($cartData) && !empty($cartData->issue_images)
                                                ? $cartData->issue_images
                                                : ''
                                        ),
                                        'required' => true,
                                    ])
                                </div>
                                @include('front.common.alert', ['input' => 'issue_images'])
                                @include('front.common.alert', ['input' => 'equipment'])
                                <div class="common-input">
                                    <label class="input-label">{{__('Select')}} <span class="text-danger">*</span></label>
                                    <div class="role-radio">
                                        <label class="custom-radio">
                                            {{ __('I know the issue') }} (<a data-toggle="modal" id="select-equipment"
                                                data-target="#select-equipment-modal"
                                                href="#">{{ __('Select Equipment') }}</a>)
                                            <input type="radio" id="issue1" name="issue_type" value="know"
                                                required
                                                {{ isset($cartData) && !empty($cartData->issue_type) && $cartData->issue_type == 'know' ? 'checked="checked"' : 'checked="checked"' }}>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="role-radio">
                                        <label class="custom-radio">
                                            {{ __('I do not know the issue') }}
                                            <span>({{ __('Visit Fee will apply=AED') }}
                                                {{ $service->supplier->visit_fee }})</span>
                                            <input type="radio" id="issue2" name="issue_type" value="not know"
                                                {{ isset($cartData) && !empty($cartData->issue_type) && $cartData->issue_type == 'not know' ? 'checked="checked"' : '' }}>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>

                                <div id="equipment-datas">
                                    <div class="add-equipment-block">
                                        <div
                                            class="equip-link-row mb-2 d-flex justify-content-between align-items-center flex-wrap">
                                            <h4 class="title">
                                                {{ __('Selected Equipment') }}
                                            </h4>
                                            <span class="link-s">
                                                (<a data-toggle="modal" data-target="#select-equipment-modal"
                                                    href="#" class="add-eq-link">{{ __('Add Equipment') }}</a>)
                                            </span>
                                        </div>
                                    </div>
                                    <div class="container">
                                        <div class="row select-eq-row" id="equipment-data">

                                        </div>
                                    </div>

                                </div>
                                <button class="login-btn w-100">
                                    {{ __('Submit') }}
                                </button>
                            </form>
                        </div>
                        @php
                            $old = '';
                            $old = old('equipment');
                            $quantity = '';
                            $quantity = old('quantity');
                            $cartids = isset($cartData) && !empty($cartData->equipments) ? $cartData->equipments->pluck('equipment_id')->toArray() : null;
                            $cartDatas = isset($cartData) && !empty($cartData->equipments) ? $cartData->equipments->toArray() : null;
                            $issue = old('issue_type');
                        @endphp
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
  
        $(document).ready(function() {
            // oldIds=[];
            // oldIds='<?php $old; ?>';
            $('#areaform').validate({
                ignore: '',
                rules: {
                    area_id: {
                        required: true
                    },
                },
                errorPlacement: function(error, element) {
                    //Custom position: first name
                    if (element.attr("name") == "rating") {
                        error.insertAfter(element.parent().parent().parent());
                    } else {
                        error.insertAfter(element.parent());
                    }
                },
            });
            $('#reviewForm').validate({
                ignore: '',
                rules: {
                    rating: {
                        required: true
                    },
                },
                errorPlacement: function(error, element) {
                    //Custom position: first name
                    if (element.attr("name") == "rating") {
                        error.insertAfter(element.parent().parent().parent());
                    } else {
                        error.insertAfter(element.parent());
                    }
                },
            });

            $(`#reviewForm`).submit(function(e) {
                $(`input[name='rating']`).val();
                if ($(this).valid()) {
                    if ('' == window.Laravel.user_token) {
                        e.preventDefault();
                        window.location.href = "{{ route('front.auth.login') }}";
                    }
                    e.preventDefault();
                    console.log($(this).serialize(), window.Laravel.user_token);
                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: $(this).serialize(),
                        headers: {
                            Authorization: window.Laravel.user_token,
                        },
                        success: function(data) {
                            if (data.success == true) {
                                toastr.success(data.message);
                                window.location.reload();
                            } else {
                                toastr.error(data.message);
                            }
                        }
                    });
                }
            });

            $('#equipment-datas').hide();

            approved = '<?php echo session()->has('errors'); ?>';

            if (approved) {
                $(window).on('load', function() {
                    var jArray = <?php echo json_encode($old); ?>;
                    ids = [];
                    $.each(jArray, function() {
                        ids.push(this.equipment_id); // Here 'this' points to an 'item' in 'items'
                    });
                    submitAjax(ids);

                    $('#get-quotation-modal').modal('show');
                    var arr = $('.equipment-check:checkbox');
                    $(".equipment-check").each(function(i, field) {
                        $(this).prop('checked', false);
                    });
                    jQuery.each(arr, function(i, field) {
                        console.log($.inArray(field.value, ids))
                        if ($.inArray(field.value, ids) != -1) {
                            $(this).prop('checked', true);
                        }
                    });
                    issue = '<?php echo $issue; ?>';
                    if (issue) {
                        if (issue == 'know') {
                            $(`#issue1`).attr('checked', 'checked');


                        } else {
                            $(`#issue2`).attr('checked', 'checked');
                        }
                    }
                });
            } else {
                cartIds = '<?php echo $cartids != null ? json_encode($cartids) : ''; ?>';
                if (cartIds.length !== 0) {
                    qeids = [];
                    qeids = JSON.parse(cartIds);
                    checkid = cartIds;
                    // console.log("🚀 ~ file: service-detail.blade.php ~ line 908 ~ $ ~ qeids", qeids)

                    var arr = $('.equipment-check:checkbox');
                    $(".equipment-check").each(function(i, field) {
                        console.log(
                            "🚀 ~ file: service-detail.blade.php ~ line 913 ~ $ ~ $.inArray(field.value, qeids)>=-1",
                            checkid.indexOf(field.value))
                        if (checkid.indexOf(field.value) > -1) {
                            $(this).prop('checked', true);
                        }

                    });
                    submitAjax(qeids);
                }


            }

            $('#quotation-form').validate({
                rules: {
                    'date': {
                        required: true,
                    },
                    'time': {
                        required: true,
                    },
                    'description': {
                        required: true,
                        noSpace: true,
                    },

                },
                errorPlacement: function(error, element) {
                    console.log(element.attr("name"));
                    if (element.attr("name") === "issue_images") {
                        // error.insertAfter(element.parent());
                        $("#issue").html(error);
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
            $.validator.addMethod("noSpace", function(value, element) {
                return this.optional(element) || value === "NA" ||
                    value.match(/\S/);
            }, "This field cannot be empty");
            $('input:radio[name="issue_type"]').change(
                function() {
                    if (this.checked && this.value == 'know') {
                        $('#equipment-datas').show();
                        $("#select-equipment").prop("disabled", false);
                    } else {
                        $('#equipment-datas').hide();
                        $("#select-equipment").prop("disabled", true);

                    }
                });

            $('#equipment-form').on('submit', function(e) {
                e.preventDefault();
                str = $(this).serializeArray();
                ids = [];
                jQuery.each(str, function(i, field) {
                    ids.push(field.value);
                });
                console.log(ids);
                submitAjax(ids);
            });

            function submitAjax(ids) {
                // eids = [];
                // $(".equipment-ids").each(function(i, field) {
                //     eids.push(field.value);
                // });
                // ids = $(ids).not(eids).get();
                $.ajax({
                    url: window.Laravel.baseUrl + "equipments",
                    type: "get",
                    data: {
                        ids: ids,
                    },
                    success: function(response) {
                        $('#equipment-data').html(response.data);
                        $('#equipment-datas').show();
                        $("#select-equipment-modal").modal('hide');
                        array = <?php echo json_encode($old); ?>;
                        if (array === null) {
                            storData = <?php echo json_encode($cartDatas); ?>;
                            if (storData !== null) {
                                console.log(storData);
                                x = $(".add-equipment  .quantity:input");
                                console.log(x);
                                $.each(x, function(i, field) {
                                    var ed = $(this).siblings('.equipment-ids').val();
                                    let y = x;
                                    $.each(storData, function(i, o) {
                                        if (this.equipment_id == ed) {
                                            field.value = this.quantity, this.quantity;
                                            return false;
                                        }
                                    });
                                });
                            }


                        } else {
                            x = $(".add-equipment  .quantity:input");
                            console.log(x);
                            $.each(x, function(i, field) {
                                var ed = $(this).siblings('.equipment-ids').val();
                                let y = x;
                                $.each(array, function() {
                                    if (this.equipment_id === ed) {
                                        console.log(field.value = this.quantity, this
                                            .quantity);
                                        return false;
                                    }
                                });
                            });
                        }


                        $(".close-btn").on('click', function() {
                            id = $(this).siblings('.equipment-ids').val();
                            var arr = $('.equipment-check:checkbox:checked');
                            jQuery.each(arr, function(i, field) {
                                if (field.value == id) {
                                    $(this).prop('checked', false);
                                }
                            });
                            $(this).parent().parent().remove();


                        });
                    },
                });
            }
        });
    </script>
@endpush
