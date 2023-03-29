@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <main class="manage-orders spacing-y">
        <div class="container">
            <div class="row">
                @include('front.dashboard.common.left-sidebar')
                <div class="col-xl-9 col-lg-8">
                    <div class="review-content">
                        <div class="title-rating-row d-flex justify-content-between align-items-center flex-wrap">
                            <h3 class="title">
                                {{__('Ratings & Reviews')}}
                            </h3>
                            <div class="star-rating-area d-flex">
                                <div class="rating-static clearfix" rel="{{getStarRating(auth()->user()->rating)}}">
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
                                <div class="ratilike ng-binding">({{$reviews->total()}})</div>
                            </div>
                        </div>

                        @forelse ($reviews as $review)
                            <div class="reviews-card">
                                <div class="title-img-time-row d-flex justify-content-between">
                                    <div class="img-title-block d-flex align-items-center">
                                        <div class="user-img-block">
                                            <img src="{!! imageUrl(url($review->user->image), 50, 50, 100, 1) !!}"
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
                                                    <label class="half"
                                                           title="{{__('Pretty good - 4.5 stars')}}"></label>
                                                    <label class="full" title="{{__('Pretty good - 4 stars')}}"></label>
                                                    <label class="half" title="{{__('Meh - 3.5 stars')}}"></label>
                                                    <label class="full" title="{{__('Meh - 3 stars')}}"></label>
                                                    <label class="half" title="{{__('Kinda bad - 2.5 stars')}}"></label>
                                                    <label class="full" title="{{__('Kinda bad - 2 stars')}}"></label>
                                                    <label class="half" title="{{__('Meh - 1.5 stars')}}"></label>
                                                    <label class="full"
                                                           title="{{__('Sucks big time - 1 star')}}"></label>
                                                    <label class="half"
                                                           title="{{__('Sucks big time - 0.5 stars')}}"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="time">
                                                    {!! \Carbon\Carbon::parse($review->updated_at)->diffForHumans() !!} </span>
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
@endsection
