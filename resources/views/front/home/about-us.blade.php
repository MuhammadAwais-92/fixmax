@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <section class="about-us-sec">
        <div class="container">
            <div class="row">
                <div class="col-12 px-md-0">
                    <div class="commen-title"><span>{{ translate($page->name) }}</span></div>
                </div>
                <div class="col-md-6 mx-auto px-md-0">
                    <div class="about-img-block">
                        <img src="{!! imageUrl(url($page->image_url), 570, 783, 90) !!}" alt="about-img"
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
                                            {{ translate($page->name) }}
                                        </div>
                                        <div class="p-desc">
                                            {!! translate($page->content)  !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="about-desc">
                                        <div class="sm-headline">
                                            {{ translate($mission->name) }}
                                        </div>
                                        <div class="p-desc">
                                            {!! translate($mission->content)  !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <div class="about-desc">
                                        <div class="sm-headline">
                                            {{ translate($vision->name) }}
                                        </div>
                                        <div class="p-desc">
                                            {!! translate($vision->content)  !!}
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
@endsection
