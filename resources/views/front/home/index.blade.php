@extends('front.layouts.app')
@section('content')
    <!-- mobile menu -->
    <div id="mySidenav" class="mobile-menu navbar">
        <div onclick="closeNav()" class="close-btn">
            <i class="fas fa-times"></i>
        </div>
        <a href="index.html" class="mobile-logo">
            <img src="img/logo-white.png" alt="logo-white" class="img-fluid">
        </a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link active" href="index.html">{{ __('Home') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="categories.html">{{ __('Categories') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="suppliers-grid.html">{{ __('Suppliers') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="services.html">{{ __('Services') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="about-us.html">{{ __('About Us') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contact-us.html">{{ __('Contact Us') }}</a>
            </li>
        </ul>
    </div>
    <!-- banner Section -->
    <section class="banner-section" style="background-image: url({{ asset('assets/front/img/banner-bg.jpg') }});">
        <div class="container-max">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="banner-desc">
                            <div class="banner-title">
                                {{ __('No Time For') }} <br>
                                <span>{{ __('Home') }}</span> {{ __('Maintenance?') }}
                            </div>
                            <p class="p-desc">
                                {{ __('Our mission is to provide the best home maintenance service at a reasonable price without sacrificing quality.') }}
                            </p>
                            {{-- <a href="{{route('front.services')}}" class="primary-btn">
                                Book Service
                            </a> --}}
                            <form action="{{ route('front.suppliers') }}" method="GET">
                                <div class="bann-search-box">
                                    <input type="text" name="keyword" placeholder="{{__("Supplier")}}">
                                    <button class="primary-btn">
                                        {{ __('Search') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- services icons section -->
    <section class="services-sec">
        <div class="container">
            <div class="services-icons-row d-flex flex-wrap align-items-center justify-content-center">
                @forelse ($categories->take(5) as $category)
                    <div class="services-grid">
                        <a href="{!! route('front.services', ['category_id' => $category->id]) !!}">
                            <div class="service-icon-card ">
                                <div class="img-fluid card-img-block">
                                    <img src="{{ imageUrl(url($category->image_url), 97, 97, 100, 1) }}" alt="card-img"
                                         class="img-fluid card-img">
                                </div>
                                <div class="card-title">
                                    {{ translate($category->name) }}
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                @endforelse


            </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- mobile slider -->
                    <div class="mobile-slider">
                        <div class="services-icon-slider-mobile">
                            @forelse ($categories as $category)
                                <div>
                                    <a href="{!! route('front.services', ['category_id' => $category->id]) !!}">
                                        <div class="service-icon-card">
                                            <div class="img-fluid card-img-block">
                                                <img src="{{ imageUrl(url($category->image_url), 97, 97, 100, 1) }}"
                                                     alt="card-img" class="img-fluid card-img">
                                            </div>
                                            <div class="card-title">
                                                {{ translate($category->name) }}
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @empty
                            @endforelse


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Supplier section -->
    <section class="supplier-sec">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="headline-row d-flex">
                        <h2 class="primary-headline">
                            {{__('Top Rated Suppliers')}}
                        </h2>
                    </div>
                </div>
                <!-- <div class="col-md-12 px-md-0"> -->
                <!-- <div dir="ltr" class="supplier-slider"> -->
                @forelse ($suppliers as $supplier)
                    <div class="col-xl-3 col-md-4 col-sm-6 col-6-ctm">
                        <div class="supplier-card text-center mx-0">
                            <div class="img-block">
                                <img src="{!! imageUrl(url($supplier->image_url), 191, 168, 100, 1) !!}"
                                     alt="supplier-img"
                                     class="img-fluid supplier-img">
                            </div>
                            <div class="title">
                                {!! translate($supplier->supplier_name) !!}
                            </div>
                            <p class="p-desc">
                                {!! translate($supplier->category->name) !!}
                            </p>
                            <div class="d-flex align-content-center justify-content-between">
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
                                    <div class="ratilike ng-binding">({{ number_format($supplier->rating, 1) }})
                                    </div>
                                </div>
                            </div>
                            <a href="#" class="map-link d-flex align-items-center justify-content-center">
                               
                                <svg id="Component_20_1" data-name="Component 20 – 1"
                                     xmlns="http://www.w3.org/2000/svg" width="11.832" height="16.903"
                                     viewBox="0 0 11.832 16.903">
                                    <path id="Path_58" data-name="Path 58"
                                          d="M15.916,4A5.917,5.917,0,0,0,10,9.916C10,14.353,15.916,20.9,15.916,20.9s5.916-6.55,5.916-10.987A5.917,5.917,0,0,0,15.916,4Zm0,8.029a2.113,2.113,0,1,1,2.113-2.113A2.114,2.114,0,0,1,15.916,12.029Z"
                                          transform="translate(-10 -4)" fill="#022c44"/>
                                </svg>
                                <span class="text-truncate">
                                       
                                    @if (session()->get('area_id'))   {!! translate($supplier->selected_area) !!} @else {{ $supplier->address }} @endif
                                        </span>
                                       
                            </a>
                            <a href="{{ route('front.supplier-detail', $supplier->id) }}"
                               class="secondary-btn mx-auto">
                                {{__('View Details')}}
                            </a>
                            @if (session()->get('area_id'))
                            <span class="sup-time">
                                        {!! $supplier->estimated_time !!}mins
                                    </span>
                                    @endif
                            
                  
                        </div>
                    </div>
            @empty
            @endforelse


            <!-- </div>
        </div> -->
            </div>
        </div>
    </section>
    <!-- discount banner section -->
    @if ($offers->isNotEmpty())
        <div class="offer-slider">
            @foreach ($offers as $offer)
                <div>
                    <section class="discount-banner"
                             style="background-image: url({{ imageUrl($offer->image, 1920, 535, 90, 3) ?? '' }});">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="discount-desc text-center">
                                        {!! translate($offer->content) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Our Services Section -->
    <section id="services-sec" class="our-services">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="headline-row d-flex">
                        <h2 class="primary-headline">
                            {{__('Our Services')}}
                        </h2>
                    </div>
                </div>
                <div class="col-md-12 px-md-0">
                    <div dir="ltr" class="services-slider">
                        @forelse ($services as $service)
                            <div>
                                <div class="services-card">
                                    <div class="img-block">
                                        @if (str_contains($service->default_image, '.mp4') || str_contains($service->default_image, '.mov'))
                                            <video width="361" height="191" controls muted>
                                                <source src="{{ $service->default_image }}" class="img-fluid"
                                                        type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @else
                                            <img src="{!! imageUrl(url($service->default_image), 361, 191, 100, 0) !!}"
                                                 alt="services-img"
                                                 class="img-fluid services-img">
                                        @endif
                                    </div>
                                    @if ($service->discount)
                                        <div class="discount">
                                            {{ $service->discount }}% OFF
                                        </div>
                                    @endif
                                    <div class="desc-block">
                                        <div class="cate-block">
                                            <span
                                                class="text-truncate">{!! translate($service->supplier->supplier_name) !!}</span>
                                        </div>
                                        <div
                                            class="title-row d-flex justify-content-between align-items-center flex-wrap">
                                            <div class="title">
                                                {!! translate($service->name) !!}
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
                                                        ({{ number_format($service->average_rating, 1) }})
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($service->discount > 0)
                                            <div class="price d-flex">
                                                <span class="text-truncate mw-100">{{__('AED')}}{{ $service->discountedMinPrice }}
                                                    -
                                                    {{__('AED')}}{{ $service->dicountedMaxPrice }}</span>
                                                <strike class="text-truncate mw-100">{{__('AED')}}{{ $service->min_price }} -
                                                    {{__('AED')}}{{ $service->max_price }}</strike>
                                            </div>
                                        @else
                                            <div class="price d-flex">
                                                <span class="text-truncate mw-100">{{__('AED')}}{{ $service->min_price }} -
                                                    {{__('AED')}}{{ $service->max_price }}</span>
                                            </div>
                                        @endif

                                        <a href="{{ route('front.service.detail', $service->slug) }}"
                                           class="arrow-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18.707" height="6.707"
                                                 viewBox="0 0 18.707 6.707">
                                                <g id="Component_1_1" data-name="Component 1 – 1"
                                                   transform="translate(0 0.707)">
                                                    <line id="Line_21" data-name="Line 21" x2="18"
                                                          transform="translate(0 5)" fill="none" stroke="#fff"
                                                          stroke-width="2"/>
                                                    <line id="Line_22" data-name="Line 22" x2="5"
                                                          y2="5" transform="translate(13)" fill="none"
                                                          stroke="#fff" stroke-width="2"/>
                                                </g>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                        @endforelse


                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- How it works section -->
    <section id="how-work" class="how-work">
        <div class="sec-title text-center">
            {{__('How It Works')}}
        </div>
        <div class="line-img-block">
            <svg xmlns="http://www.w3.org/2000/svg" width="1940.033" height="123.212" viewBox="0 0 1940.033 113.212">
                <g id="DottedPath" transform="translate(0.821 2.504)"> -->
                    <path id="dotted-line" data-name="Path 48305"
                          d="M-22945.721-13632.684s374.125-146.918,586.281-103.879,453.969,92.162,732.281,24.787,732.281,34.025,732.281,34.025"
                          transform="translate(22946.635 13746.968)" fill="none"/>
                </g>
                <use stroke="#fff" class="c-dashed-line__path" xlink:href="#dotted-line"/>
                <use stroke="#022c44" class="c-dashed-line__dash" xlink:href="#dotted-line"/>
            </svg>
        </div>
        <div class="works-main-block">
            <div class="container-fluid">
                <div class="grid-row d-flex justify-content-between align-items-center flex-wrap">
                    <div class="how-work-card text-center">
                        <div class="icon-block">
                            <img src="{{ asset('assets/front/img/calendar.png') }}" alt="work-icon"
                                 class="img-fluid work-icon">
                        </div>
                        <div class="desc-block">
                            <div class="title">
                                {{__('Pick A Time')}}
                            </div>
                            <div class="p-desc">
                                {{__('We are at 7pm to 12pm and you can easily reschedule online.')}}
                            </div>
                        </div>
                    </div>
                    <div class="how-work-card text-center">
                        <div class="icon-block">
                            <img src="{{ asset('assets/front/img/book.png') }}" alt="work-icon"
                                 class="img-fluid work-icon">
                        </div>
                        <div class="desc-block">
                            <div class="title">
                                {{__('Book Instantly')}}
                            </div>
                            <div class="p-desc">
                                {{__('We will confirm your appointment take care of your payments.')}}
                            </div>
                        </div>
                    </div>
                    <div class="how-work-card text-center">
                        <div class="icon-block">
                            <img src="{{ asset('assets/front/img/worker.png') }}" alt="work-icon"
                                 class="img-fluid work-icon">
                        </div>
                        <div class="desc-block">
                            <div class="title">
                                {{__('Your Pro Arrives')}}
                            </div>
                            <div class="p-desc">
                                {{__('A fully equipped professional will show up on time at your doorstep!')}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- about us section -->
    @if ($aboutUs)
        <section class="about-us-sec about-home">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 mx-auto px-md-0">
                        <div class="about-img-block">
                            <img src="{!! imageUrl(url($aboutUs->image_url), 570, 783, 90) !!}" alt="about-img"
                                 class="img-fluid about-img">
                        </div>
                    </div>
                    <div class="col-md-6 mx-auto px-md-0">
                        <div class="about-desc-block">
                            <div id="about-carousel" class="carousel slide" data-ride="carousel">

                                <!-- Indicators -->
                                <ul class="carousel-indicators">
                                    <li data-target="#about-carousel" data-slide-to="0" class="active"></li>
                                    <li data-target="#about-carousel" data-slide-to="1"></li>
                                    <li data-target="#about-carousel" data-slide-to="2"></li>
                                    {{-- <li data-target="#about-carousel" data-slide-to="3"></li> --}}
                                </ul>

                                <!-- The slideshow -->
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <div class="about-desc">
                                            <div class="sm-headline">
                                                {{ translate($aboutUs->name) }}
                                            </div>
                                            <div class="p-desc">
                                                {!! translate($aboutUs->content) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <div class="about-desc">
                                            <div class="sm-headline">
                                                {{ translate($mission->name) }}
                                            </div>
                                            <div class="p-desc">
                                                {!! translate($vision->content) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <div class="about-desc">
                                            <div class="sm-headline">
                                                {{ translate($vision->name) }}

                                            </div>
                                            <div class="p-desc">
                                                {!! translate($vision->content) !!}
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="carousel-item">
                                    <div class="about-desc">
                                        <div class="sm-headline">
                                            About Us
                                        </div>
                                        <div class="p-desc">
                                            Lorem ipsum dolor sit amet, ea cum tota
                                            sadipscing, an sed accusata gubergren. Cu
                                            sale impetus aliquando vim. Vis tation
                                            aliquam perpetua in, ei has modo
                                            perpetua expetenda, ut wisi facilisi eum.
                                            Sed laudem menandri efficiantur cu, est
                                            ut facilis graecis.
                                        </div>
                                    </div>
                                </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
@push('scripts')
    <script>
        // $('#supplier-search').submit(function() {
        //     e.preventDefault();
        //         let supplier = $('#search_by_supplier').val();

        //         window.location.href = "{{ route('front.suppliers') }}?keyword=" + supplier;

        // });
    </script>
@endpush
