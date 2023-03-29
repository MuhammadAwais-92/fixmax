@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <main class="supplier-details spacing-y">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="supplier-dt-img-block">
                        <img src="{!! imageUrl(url($supplier->image_url), 360, 360, 90) !!}" alt="supplier-dt-img"
                             class="img-fluid supplier-dt-img">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="supplier-dt-desc-block">
                        <div class="sup-desc">
                            <div class="ratting-time-row d-flex justify-content-between align-items-center">
                                <div class="d-flex align-content-center">
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
                                        <div class="ratilike ng-binding"> ({{number_format($supplier->rating,1)}})</div>
                                    </div>
                                </div>
                                @if (session()->get('area_id') && $supplier->estimated_time)
                                <span class="sup-time">
                                    {!! $supplier->estimated_time !!}{{ __('mins') }}
                                </span>
                                @endif
                            </div>
                            <h3 class="title">
                                {!! translate($supplier->supplier_name) !!}
                            </h3>
                            <p class="service-name">
                                {!! translate($supplier->category->name) !!}
                            </p>
                            <a target="_blank"
                               href="https://maps.google.com/?q={{$supplier->latitude}},{{$supplier->longitude}}"
                               class="add-link d-flex align-items-center">
                                <svg id="LocationIcon" xmlns="http://www.w3.org/2000/svg" width="14.645" height="20.922"
                                     viewBox="0 0 14.645 20.922">
                                    <path id="LocationIcon-2" data-name="LocationIcon"
                                          d="M17.323,4A7.324,7.324,0,0,0,10,11.323c0,5.492,7.323,13.6,7.323,13.6s7.323-8.107,7.323-13.6A7.324,7.324,0,0,0,17.323,4Zm0,9.938a2.615,2.615,0,1,1,2.615-2.615A2.616,2.616,0,0,1,17.323,13.938Z"
                                          transform="translate(-10 -4)" fill="#022c44"/>
                                </svg>
                                <span class="text-truncate"> {{ $supplier->address }}</span>
                            </a>
                        </div>
                        <div class="contact-info-block">
                            <a href="tel:{{ $supplier->phone }}" class="num-link d-flex align-items-center">
                                <svg id="CellIcon" xmlns="http://www.w3.org/2000/svg" width="15.631" height="20.842"
                                     viewBox="0 0 15.631 20.842">
                                    <path id="CellIcon-2" data-name="CellIcon"
                                          d="M3.962,20.637a13.526,13.526,0,0,1,0-19.129.7.7,0,0,1,.866-.1L7.466,3.058a.7.7,0,0,1,.279.853l-1.319,3.3a.7.7,0,0,1-.719.436L3.435,7.418a10.813,10.813,0,0,0,0,7.307L5.706,14.5a.7.7,0,0,1,.719.436l1.319,3.3a.7.7,0,0,1-.279.853L4.828,20.735a.7.7,0,0,1-.866-.1Zm6.1-16.75a2.607,2.607,0,0,1,0,2.648A.491.491,0,0,1,9.3,6.64l-.243-.233a.492.492,0,0,1-.092-.587,1.305,1.305,0,0,0,0-1.219.492.492,0,0,1,.092-.587L9.3,3.781a.491.491,0,0,1,.762.105ZM13.8.174a7.827,7.827,0,0,1,0,10.072.49.49,0,0,1-.714.038l-.236-.226a.489.489,0,0,1-.038-.667,6.522,6.522,0,0,0,0-8.362.489.489,0,0,1,.038-.667l.236-.226A.49.49,0,0,1,13.8.174ZM11.924,2a5.218,5.218,0,0,1,0,6.413.491.491,0,0,1-.727.053l-.237-.227a.488.488,0,0,1-.052-.648,3.913,3.913,0,0,0,0-4.768.488.488,0,0,1,.052-.648l.237-.227A.491.491,0,0,1,11.924,2Z"
                                          transform="translate(0 0)" fill="#022c44"/>
                                </svg>
                                <span dir="ltr">{{ $supplier->phone }}</span>
                            </a>
                            <a href="mailto:{{ $supplier->email }}" class="num-link d-flex align-items-center">
                                <svg id="Component_8_1" data-name="Component 8 – 1" xmlns="http://www.w3.org/2000/svg"
                                     width="18" height="13.5" viewBox="0 0 18 13.5">
                                    <path id="Path_48305" data-name="Path 48305"
                                          d="M17.648-9.035a.174.174,0,0,1,.229-.035A.228.228,0,0,1,18-8.859v7.172a1.627,1.627,0,0,1-.492,1.2,1.627,1.627,0,0,1-1.2.492H1.688a1.627,1.627,0,0,1-1.2-.492A1.627,1.627,0,0,1,0-1.687V-8.859a.193.193,0,0,1,.123-.193.227.227,0,0,1,.229.018q1.16.879,5.414,3.973l.352.316a13.985,13.985,0,0,0,1.336.914A3.293,3.293,0,0,0,9-3.375a3.121,3.121,0,0,0,1.547-.492,9.816,9.816,0,0,0,1.336-.914l.352-.281Q16.383-8.051,17.648-9.035ZM9-4.5a2.244,2.244,0,0,0,1.125-.422,8.378,8.378,0,0,0,1.09-.773l.352-.246q4.43-3.2,5.941-4.395l.176-.141A.8.8,0,0,0,18-11.145v-.668a1.627,1.627,0,0,0-.492-1.2,1.627,1.627,0,0,0-1.2-.492H1.688a1.627,1.627,0,0,0-1.2.492A1.627,1.627,0,0,0,0-11.812v.668a.8.8,0,0,0,.316.668l.246.176q1.547,1.2,5.871,4.359l.352.246a8.378,8.378,0,0,0,1.09.773A2.244,2.244,0,0,0,9-4.5Z"
                                          transform="translate(0 13.5)" fill="#022c44"/>
                                </svg>
                                <span dir="ltr">{{ $supplier->email }}</span>
                            </a>
                            <div class="row mt-3">
                                <div class="col-md-6 col-6-ctm">
                                    <a href="{!! route('front.services', ['supplier_id' => $supplier->id]) !!}"
                                       class="secondary-btn border-btn mw-100">
                                        <span>{{ __('View Services') }}</span> <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                                @if(Auth::check())
                                    @if($userData && !$userData->isSupplier())
                                        <div class="col-md-6 col-6-ctm mt-sm-0 mt-2 ">
                                            <a href="{{route('front.dashboard.conversation.start', ['service_id'=> 0, 'supplier_id'=> $supplier->id])}}"
                                               class="secondary-btn border-btn mw-100">
                                                <span>{{ __('Message Supplier') }}</span> <i
                                                    class="fas fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="portfolio-reviews-block">
                        <ul class="nav nav-pills my-5" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#portfolio-tab"
                                   role="tab" aria-controls="pills-home" aria-selected="true">
                                    {{ __('Portfolio') }}
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#reviews-tab"
                                   role="tab" aria-controls="pills-profile" aria-selected="false">
                                    {{ __('Reviews') }}
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="portfolio-tab" role="tabpanel"
                                 aria-labelledby="pills-home-tab">
                                <div class="portfolio-content-block">
                                    <div class="row">
                                        @forelse ($projects as $project)


                                            <div class="col-lg-3 col-md-4 col-sm-6 col-6-ctm">
                                                <a href="{{ route('front.project-detail', $project->id) }}">
                                                    <div class="portfolio-dt-card">
                                                        <div class="port-img-block">
                                                            <img
                                                                src="{!! imageUrl(url($project->default_image), 262, 222, 90) !!}"
                                                                alt=""
                                                                class="img-fluid port-img">
                                                        </div>
                                                        <div class="desc-block">
                                                            <h3 class="title text-truncate">
                                                                {!! translate($project->name) !!}
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>

                                        @empty
                                            @include('front.common.alert-empty', ['message' => __('No Article found.')])
                                        @endforelse
                                        {{ $projects->links('front.common.pagination', ['paginator' => $projects]) }}
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="reviews-tab" role="tabpanel"
                                 aria-labelledby="pills-profile-tab">
                                <div class="ratting-reviews-sec">
                                    <h3 class="review-title">
                                        {{__('Ratings & Reviews')}}
                                    </h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            @if ($supplier->pendingReviews->isNotEmpty())
                                                <p class="rate-link">
                                                    {{__('Rate Supplier')}}
                                                </p>
                                                <div class="submit-reviews-block">
                                                    <form action="{{ route('api.auth.reviews.save') }}" id="reviewForm">
                                                        <div class="ratting-sec">
                                                            <p class="p-text">
                                                                {{__('Rate Supplier')}}
                                                            </p>
                                                            <input type="hidden" name="id"
                                                                   value="{{ $supplier->pendingReviews[0]->id }}">
                                                            <div class="ratting-starts-block">
                                                                <div class="d-flex align-items-center">
                                                                    <fieldset class="rate">
                                                                        <input type="radio" id="rating-5" name="rating"
                                                                               value="5"/>
                                                                        <label for="rating-5" title="5 stars"></label>
                                                                        <input type="radio" id="rating-4.5"
                                                                               name="rating"
                                                                               value="4.5"/>
                                                                        <label class="half" for="rating-4.5"
                                                                               title="4.5 stars"></label>
                                                                        <input type="radio" id="rating-4" name="rating"
                                                                               value="4"/>
                                                                        <label for="rating-4" title="4 stars"></label>
                                                                        <input type="radio" id="rating-3.5"
                                                                               name="rating"
                                                                               value="3.5"/>
                                                                        <label class="half" for="rating-3.5"
                                                                               title="3.5 stars"></label>
                                                                        <input type="radio" id="rating-3" name="rating"
                                                                               value="3"/>
                                                                        <label for="rating-3" title="3 stars"></label>
                                                                        <input type="radio" id="rating-2.5"
                                                                               name="rating"
                                                                               value="3.5"/><label class="half"
                                                                                                   for="rating-2.5"
                                                                                                   title="2.5 stars"></label>
                                                                        <input type="radio" id="rating-2" name="rating"
                                                                               value="2"/><label for="rating-2"
                                                                                                 title="2 stars"></label>
                                                                        <input type="radio" id="rating-1.5"
                                                                               name="rating"
                                                                               value="2.5"/><label class="half"
                                                                                                   for="rating-1.5"
                                                                                                   title="1.5 stars"></label>
                                                                        <input type="radio" id="rating-1" name="rating"
                                                                               value="1"/><label for="rating-1"
                                                                                                 title="1 star"></label>
                                                                        <input type="radio" id="rating-0.5"
                                                                               name="rating"
                                                                               value="0.5"/><label class="half"
                                                                                                   for="rating-0.5"
                                                                                                   title="0.5 star"></label>
                                                                    </fieldset>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="review-sec">
                                                            <div class="common-input">
                                                                <label class="input-label">
                                                                    {{__('Describe your experience (Optional)')}}
                                                                </label>
                                                                <textarea class="ctm-textarea" rows="6" name="review"
                                                                          placeholder="{{ __('Enter your comment here...') }}"></textarea>
                                                            </div>
                                                            <button class="secondary-btn">
                                                                {{__('Submit')}}
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
                                                                {{ number_format((float)$supplier->rating, 1, '.', '')}}
                                                                <span>/5</span>
                                                            </div>
                                                            <div class="d-flex align-content-center">
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
                                                                </div>
                                                            </div>
                                                            <span class="no-of-reviews">
                                                                {{ $reviews->count() }} {{__('Reviews')}}
                                                            </span>
                                                        </div>
                                                        <div class="right-col">
                                                            <div class="progress-bars-block">
                                                                <div class="stars-bar-row d-flex align-items-center">
                                                                    <div class="d-flex align-content-center">
                                                                        <div class="star-rating-area">
                                                                            <div class="rating-static clearfix" rel="5">
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
                                                                        </div>
                                                                    </div>
                                                                    <div class="progress">
                                                                        <div class="progress-bar"
                                                                             style="width:{{$rewBar['4']}}%"
                                                                             role="progressbar"
                                                                             aria-valuenow="75" aria-valuemin="0"
                                                                             aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="stars-bar-row d-flex align-items-center">
                                                                    <div class="d-flex align-content-center">
                                                                        <div class="star-rating-area">
                                                                            <div class="rating-static clearfix" rel="4">
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
                                                                        </div>
                                                                    </div>
                                                                    <div class="progress">
                                                                        <div class="progress-bar"
                                                                             style="width:{{$rewBar['3']}}%"
                                                                             role="progressbar"
                                                                             aria-valuenow="75" aria-valuemin="0"
                                                                             aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="stars-bar-row d-flex align-items-center">
                                                                    <div class="d-flex align-content-center">
                                                                        <div class="star-rating-area">
                                                                            <div class="rating-static clearfix" rel="3">
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
                                                                        </div>
                                                                    </div>
                                                                    <div class="progress">
                                                                        <div class="progress-bar"
                                                                             style="width:{{$rewBar['2']}}%"
                                                                             role="progressbar"
                                                                             aria-valuenow="75" aria-valuemin="0"
                                                                             aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="stars-bar-row d-flex align-items-center">
                                                                    <div class="d-flex align-content-center">
                                                                        <div class="star-rating-area">
                                                                            <div class="rating-static clearfix" rel="2">
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
                                                                        </div>
                                                                    </div>
                                                                    <div class="progress">
                                                                        <div class="progress-bar"
                                                                             style="width:{{$rewBar['1']}}%"
                                                                             role="progressbar"
                                                                             aria-valuenow="75" aria-valuemin="0"
                                                                             aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="stars-bar-row d-flex align-items-center">
                                                                    <div class="d-flex align-content-center">
                                                                        <div class="star-rating-area">
                                                                            <div class="rating-static clearfix" rel="1">
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
                                                                        </div>
                                                                    </div>
                                                                    <div class="progress">
                                                                        <div class="progress-bar"
                                                                             style="width:{{$rewBar['0']}}%"
                                                                             role="progressbar"
                                                                             aria-valuenow="75" aria-valuemin="0"
                                                                             aria-valuemax="100"></div>
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
                                                        <img
                                                            src="{!! imageUrl(url($review->user->image_url), 50, 50, 100, 1) !!}"
                                                            alt="user-img"
                                                            class="img-fluid user-img">
                                                    </div>
                                                    <div class="title-star-block">
                                                        <h4 class="user-name text-truncate">
                                                            {{ $review->user->user_name }}
                                                        </h4>
                                                        <div class="star-rating-area">
                                                            <div class="rating-static clearfix"
                                                                 rel="{{ round(getStarRating($review->rating), 1) }}">
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
                </div>
            </div>
        </div>
    </main>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            if (window.location.href.indexOf("reviews") > -1) {
                $('#pills-profile-tab').addClass('active show');
                $('#reviews-tab').addClass('active show');
                $('#pills-home-tab').removeClass('active show');
                $('#portfolio-tab').removeClass('active show');
            } else {
                $('#pills-profile-tab').removeClass('active show');
                $('#reviews-tab').removeClass('active show');
                $('#pills-home-tab').addClass('active show');
                $('#portfolio-tab').addClass('active show');
            }
        });
        $(document).ready(function () {
            $('#reviewForm').validate({
                ignore: '',
                rules: {
                    rating: {
                        required: true
                    },
                },
                errorPlacement: function (error, element) {
                    //Custom position: first name
                    if (element.attr("name") == "rating") {
                        error.insertAfter(element.parent().parent().parent());
                    } else {
                        error.insertAfter(element.parent());
                    }
                },
            });
            $(`#reviewForm`).submit(function (e) {
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
                        success: function (data) {
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
        });
    </script>
@endpush
