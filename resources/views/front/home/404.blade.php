@extends('front.layouts.app')
@section('content')
    <section class="error-page">
        <div class="content-box">
            <div class="error-img-block">
                <img src="{{ asset('assets/front/img/404-img.png')}}" alt="404-img" class="img-fluid error-img">
            </div>
            <h3 class="title">
                {{__("Oops! We Couldn't Find Your Page")}}
            </h3>
            <p class="text-desc">
                {{__("It appears that you've lost your way either through an outdated link or a type on the page you were trying to reach. Please feel free to return to the front page. We are very sorry for any inconvenience.")}}
            </p>
            <a href="{{route('front.index')}}" class="primary-btn mx-auto">
                {{__('Back to Homepage')}}
            </a>
        </div>
    </section>

@endsection
