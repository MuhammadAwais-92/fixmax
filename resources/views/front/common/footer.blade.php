<footer class="site-footer">
    <div class="call-to-action">
        <div class="container">
            <div class="desc-apps-row d-flex justify-content-between align-items-center flex-wrap">
                <div class="desc-block">
                    {{__('Manage the suppliers with our self service Mobile App')}}
                </div>
                <div class="app-google-img-block d-flex justify-content-between align-items-center">
                    <a target="_blank" href="{{config('settings.ios_app')}}">
                        <img src="{{ asset('assets/front/img/app-store.png')}}" alt="app-imgs"
                             class="img-fluid app-imgs">
                    </a>
                    <a target="_blank" href="{{config('settings.android_app')}}">
                        <img src="{{ asset('assets/front/img/google-play.png')}}" alt="app-imgs"
                             class="img-fluid app-imgs">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="main-footer">
        <div class="container-max">
            <div class="container-fluid">
                <div class="main-footer-row d-flex justify-content-between flex-wrap">
                    <div class="logo-quick-links-col d-flex justify-content-between">
                        <div class="footer-logo-block">
                            <a href="{{ route('front.index') }}">
                                <img src="{{ asset('assets/front/img/logo-white.png')}}" alt="footer-logo"
                                     class="img-fluid footer-logo">
                            </a>
                        </div>
                        <div class="quick-links">
                            <div class="f-title">
                                {{__('Quick Links')}}
                            </div>
                            <ul class="f-ul">
                                <li class="items">
                                    <a href="{{route('front.pages',[config('settings.terms_and_conditions')])}}"
                                       class="f-link {!! url()->current() == route('front.pages',[config('settings.terms_and_conditions')]) ?' active':'' !!}">
                                        {{__('Terms & Conditions')}}
                                    </a>
                                </li>
                                <li class="items">
                                    <a href="{{route('front.pages',[config('settings.privacy_policy')])}}"
                                       class="f-link {!! url()->current() == route('front.pages',[config('settings.privacy_policy')]) ?' active':'' !!}">
                                        {{__('Privacy Policy')}}
                                    </a>
                                </li>
                                <li class="items">
                                    <a href="{{route('front.pages','contact-us')}}"
                                       class="f-link {!! url()->current() == route('front.pages','contact-us') ?' active':'' !!}">
                                        {{__('Contact Us')}}
                                    </a>
                                </li>
                                {{-- <li class="items">
                                  <a href="{{ route('front.articles') }}" class="f-link {!! url()->current() == route('front.articles') ?' active':'' !!}">
                                   {{__('Articles')}}
                              </a>
                                </li>
                                <li class="items">
                                  <a href="{{ route('front.faqs') }}" class="f-link {!! url()->current() == route('front.faqs') ?' active':'' !!}">
                                   Faqs
                              </a>
                                </li>
                                <li class="items">
                                  <a href="{{ route('front.gallery') }}" class="f-link  {!! url()->current() == route('front.gallery') ?' active':'' !!}">
                                   Image Gallery
                              </a>
                                </li> --}}
                                <li class="items">
                                    <a href="{{route('front.pages',[config('settings.about_us')])}}"
                                       class="f-link {!! url()->current() == route('front.pages',[config('settings.about_us')]) ?' active':'' !!}">
                                        {{__('About Us')}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="social-get-in-col d-flex justify-content-between">
                        <div class="social-network">
                            <div class="f-title">
                                {{__('Social Network')}}
                            </div>
                            <ul class="f-ul">
                                <li class="items">
                                    <a href="{{config('settings.facebook_url')}}" target="_blank" class="f-link">
                                        {{__('Facebook')}}
                                    </a>
                                </li>
                                <li class="items">
                                    <a href="{{config('settings.google_url')}}" target="_blank" class="f-link">
                                        {{__('Google')}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="get-in-touch">
                            <div class="f-title">
                                {{__('Get in Touch')}}
                            </div>
                            <ul class="f-ul">
                                <li class="items">
                                    <a href="tel:{!! config('settings.contact_number') !!}" class="f-link d-flex">
                                        <span class="space">{{__('Phone:')}}</span><span
                                            dir="ltr">{!! config('settings.contact_number') !!}</span>
                                    </a>
                                </li>
                                <li class="items">
                                    <a href="mailto:{!! config('settings.email') !!}" class="f-link d-flex">
                                        <span class="space">{{__('Email:')}}</span>{!! config('settings.email') !!}
                                    </a>
                                </li>
                                <li class="items">
                                    <a href="fax:{!! config('settings.fax_number') !!}" class="f-link d-flex">
                                        <span class="space">{{__('Fax:')}}</span><span
                                            dir="ltr">{!! config('settings.fax_number') !!}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- copyright section -->
    <div class="copyright-sec">
        <div class="footer-shape">
            <img src="{{ asset('assets/front/img/f-shape.png')}}" alt="f-shape" class="img-fluid f-shape-img">
        </div>
        <div class="p-desc">
            <a href="index.html">{!! config('settings.company_name') !!}</a> - {{__('Copyright')}} {{now()->year}}
            - {{__('All rights reserved')}}
        </div>
    </div>
</footer>
