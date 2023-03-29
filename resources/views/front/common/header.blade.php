<header class="site-header">
    <div onclick="openNav()" class="menu-icon">
        <i class="fas fa-bars"></i>
    </div>
    <div class="top-bar d-flex">
        <a href="tel: {!! config('settings.contact_number') !!}" class="link"><img src="{{ asset('assets/front/img/phone-icon.png') }}"
                alt="bell-icon" class="img-fluid icons"><span dir="ltr"> {!! config('settings.contact_number') !!}</span></a>
        <a class="link"
            href="https://www.google.com/maps/dir//{!! config('settings.latitude') !!},{!! config('settings.longitude') !!}/@ {!! config('settings.latitude') !!},{!! config('settings.longitude') !!},12z"
            dir="ltr" target="_blank"><img src="{{ asset('assets/front/img/map-marker.png') }}" alt="bell-icon"
                class="img-fluid icons">
            {!! config('settings.address') !!}</a>
    </div>
    <div class="container-max">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-sm">
                <!-- Brand/logo -->
                <a class="navbar-brand logo-block" href="{{ route('front.index') }}">
                    <img src="{{ asset('assets/front/img/logo.png') }}" alt="logo" class="img-fluid site-logo">
                </a>

                <!-- Menu -->
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('front.index') }}">{{ __('Home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('front.categories') }}">{{ __('Categories') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('front.suppliers') }}">{{ __('Suppliers') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('front.services') }}">{{ __('Services') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ route('front.featured.services', ['service' => 'featured']) }}">{{ __('Featured') }}</a>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown ctm-dropdown">
                            <button class="dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span>{{ __('More') }}</span><i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item"
                                    href="{{ route('front.pages', [config('settings.about_us')]) }}">{{ __('About Us') }}</a>
                                <a class="dropdown-item"
                                    href="{{ route('front.pages', 'contact-us') }}">{{ __('Contact Us') }}</a>
                                <a class="dropdown-item"
                                    href="{{ route('front.offer.services', ['service' => 'offer']) }}">{{ __('Offers') }}</a>
                                <a class="dropdown-item" href="{{ route('front.articles') }}">{{ __('Articles') }}</a>
                                <a class="dropdown-item" href="{{ route('front.faqs') }}">{{ __('Faqs') }}</a>
                                <a class="dropdown-item"
                                    href="{{ route('front.gallery') }}">{{ __('Image Gallery') }}</a>

                            </div>
                            <div>
                    </li>
                    <li class="nav-item location-drop d-flex align-items-center">
                        <div class="icon location-iconss"><svg xmlns="http://www.w3.org/2000/svg" width="15.384" height="15" viewBox="0 0 15.384 20"><path id="AddressIcon" d="M-8333.989,155.628a36.668,36.668,0,0,1-5.532-7.53,11.926,11.926,0,0,1-1.387-3.965c-.044-.324-.062-.651-.093-.976a7.351,7.351,0,0,1,6.144-7.005c4.3-.846,8.549,1.925,9.163,5.959a8.4,8.4,0,0,1-.657,4.433,23.364,23.364,0,0,1-2.847,4.939,41.711,41.711,0,0,1-3.4,4.146.979.979,0,0,1-.694.371A.97.97,0,0,1-8333.989,155.628Zm-2.449-17.379a5.362,5.362,0,0,0-2.966,5.432,9.327,9.327,0,0,0,1.039,3.274,28.046,28.046,0,0,0,3.77,5.7c.407.493.846.964,1.291,1.469.123-.13.213-.214.291-.308.826-1.011,1.692-2,2.468-3.042a20.366,20.366,0,0,0,2.94-5.31,6.121,6.121,0,0,0,.331-3.464,6.061,6.061,0,0,0-6-4.579A6.463,6.463,0,0,0-8336.438,138.249ZM-8333.3,146a2.985,2.985,0,0,1-3.067-2.879,2.994,2.994,0,0,1,3.095-2.833,2.982,2.982,0,0,1,3.054,2.868A2.983,2.983,0,0,1-8333.3,146Zm0-4.283a1.477,1.477,0,0,0-1.534,1.436,1.475,1.475,0,0,0,1.527,1.419,1.473,1.473,0,0,0,1.546-1.423,1.475,1.475,0,0,0-1.536-1.432Z" transform="translate(8341.001 -136)" fill="#fff"></path></svg></div>
                        <div class="common-input location-select">
                    
                            <select class="js-example-basic-single"  name="header_area" onchange="getval(this) ;"
                            id="header-categories-select-2 ">
                                <option value="">{{__('Location')}}</option>
                                <option value="">{{__('All')}}</option>

                                @foreach ($fronCities as $city)
                                    <optgroup label="{{ translate($city->name) }}"></optgroup>
                                    @foreach ($city->areas as $area)
                                        <option value="{{ $area->id }}"
                                            {{ session()->get('area_id') == $area->id ? 'selected' : '' }}>
                                            {{ translate($area->name) }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                            <!-- <label class="d-block">Select City/Area <span class="text-danger">*</span></label> -->
                          
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('front.pages', [config('settings.about_us')]) }}">{{ __('About Us') }}</a>
                    </li> -->
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('front.pages', 'contact-us') }}">{{ __('Contact Us') }}</a>
                    </li> -->
                    <!-- <li class="nav-item">
                        <button type="button" class="nav-link nav-iocn" id="show_model">
                            <i class="fas fa-map-marked"></i>
                        </button>
                    </li> -->
                </ul>
                {{-- <button type="button" class="map-icon" id="show_model">
                    <i class="fas fa-map-marked"></i>
                </button> --}}
                <!-- language dropdown -->
                <div class="dropdown ctm-dropdown lang-dd width-set-usssss">
                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        @if($locale=='en')
                        <img src="{{ asset('assets/front/img/English.png') }}" class="pr-1">
                        <span> {{ __('English')  }}</span><i class="fas fa-chevron-down"></i>
                        @elseif($locale=='ar')
                        <img src="{{ asset('assets/front/img/Arabic.png') }}" class="pr-1">
                        <span> {{ __('Arabic')  }}</span><i class="fas fa-chevron-down"></i>
                        @elseif($locale=='ru')
                        <img src="{{ asset('assets/front/img/Russian.jpg') }}" class="pr-1">
                        <span> {{ __('Russian')  }}</span><i class="fas fa-chevron-down"></i>
                        @elseif($locale=='ur')
                        <img src="{{ asset('assets/front/img/Urdu.jpg') }}" class="pr-1">
                        <span> {{ __('Urdu')  }}</span><i class="fas fa-chevron-down"></i>
                        @else
                        <img src="{{ asset('assets/front/img/Hindi.jpg') }}" class="pr-1">
                        <span> {{ __('Hindi')  }}</span><i class="fas fa-chevron-down"></i>
                        @endif
                       
                    </button>
                    @php
                        $language = '';
                        if ($locale == 'ar') {
                            $language = 'العربية';
                        } else {
                            $language = __('English');
                        }
                    @endphp
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @foreach ($locales as $shortCode => $lang)
                            <a class="dropdown-item p-1"
                                href="{{ $languages[$lang]['url'] }}">
                                @if( $languages[$lang]['title']=='English')
                                <img src="{{ asset('assets/front/img/English.png') }}" class="pr-1">
                                @elseif( $languages[$lang]['title']=='Arabic')
                                <img src="{{ asset('assets/front/img/Arabic.png') }}" class="pr-1">
                                @elseif( $languages[$lang]['title']=='Hindi')
                                <img src="{{ asset('assets/front/img/Hindi.jpg') }}" class="pr-1">
                                @elseif( $languages[$lang]['title']=='Russian')
                                <img src="{{ asset('assets/front/img/Russian.jpg') }}" class="pr-1">
                                @else
                                <img src="{{ asset('assets/front/img/Urdu.jpg') }}" class="pr-1">
                               
                               @endif

                                {{ $languages[$lang]['title'] }}
                                
                            </a>
                        @endforeach
                    </div>
                </div>
                <!-- notification & User -->
                <div class="d-flex noti-user-block">
                    <div class="notifictaion-block noticount-drop">
                        <div class="dropdown ctm-dropdown">
                            @if (!auth()->check())
                                <button class="noti-btn d-flex" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                    <svg id="Component_20_1" data-name="Component 20 – 1"
                                        xmlns="http://www.w3.org/2000/svg" width="22.055" height="26.464"
                                        viewBox="0 0 22.055 26.464">
                                        <g id="Component_1_1" data-name="Component 1 – 1">
                                            <g id="notification">
                                                <g id="Group_75" data-name="Group 75"
                                                    transform="translate(0 3.859)">
                                                    <g id="Group_74" data-name="Group 74" transform="translate(0)">
                                                        <path id="Path_72" data-name="Path 72"
                                                            d="M64.633,93.129l-1.894-3.156A9.381,9.381,0,0,1,61.4,85.15V82.386a7.719,7.719,0,1,0-15.438,0V85.15a9.381,9.381,0,0,1-1.335,4.823l-1.894,3.156a.551.551,0,0,0,.473.835H64.16a.551.551,0,0,0,.473-.835Zm-20.45-.268,1.393-2.321a10.474,10.474,0,0,0,1.493-5.39V82.386a6.616,6.616,0,1,1,13.232,0V85.15a10.483,10.483,0,0,0,1.492,5.39l1.394,2.321Z"
                                                            transform="translate(-42.657 -74.667)" fill="#fff" />
                                                    </g>
                                                </g>
                                                <g id="Group_77" data-name="Group 77" transform="translate(8.822)">
                                                    <g id="Group_76" data-name="Group 76" transform="translate(0)">
                                                        <path id="Path_73" data-name="Path 73"
                                                            d="M215.538,0a2.208,2.208,0,0,0-2.205,2.205V4.411a.551.551,0,0,0,1.1,0V2.205a1.1,1.1,0,0,1,2.205,0V4.411a.551.551,0,0,0,1.1,0V2.205A2.208,2.208,0,0,0,215.538,0Z"
                                                            transform="translate(-213.333 0)" fill="#fff" />
                                                    </g>
                                                </g>
                                                <g id="Group_79" data-name="Group 79"
                                                    transform="translate(8.271 22.054)">
                                                    <g id="Group_78" data-name="Group 78" transform="translate(0)">
                                                        <path id="Path_74" data-name="Path 74"
                                                            d="M207.809,426.951a.552.552,0,0,0-.953.558,1.654,1.654,0,1,1-2.865,0,.552.552,0,0,0-.953-.558,2.758,2.758,0,1,0,4.77,0Z"
                                                            transform="translate(-202.666 -426.68)" fill="#fff" />
                                                    </g>
                                                </g>
                                            </g>
                                            <path id="Path_185" data-name="Path 185" d="M5841,154.919l1.2,11.467"
                                                transform="translate(-5829.973 -148.728)" fill="none"
                                                stroke="#707070" stroke-width="0.25" opacity="0.25" />
                                            <path id="Path_186" data-name="Path 186"
                                                d="M5841.77,154.748l-3.254,1.273s-1.507,2.089-1.541,2.191-.857,3.63-.857,3.63l-.2,5.136-2.877,5.444h20.545l-2.534-4.828-.686-2.774.275-4.417-2.226-4.178-3.322-1.478h-3.15l3.15-.439v-2.568l-1.952-1.2-1.2.925-.377,1.849Z"
                                                transform="translate(-5832.336 -150.027)" fill="#fff" />
                                            <ellipse id="Ellipse_47" data-name="Ellipse 47" cx="2.593"
                                                cy="1.945" rx="2.593" ry="1.945"
                                                transform="translate(8.434 21.857)" fill="#fff" />
                                        </g>
                                    </svg>


                                    {{ __('Notification') }}

                                </button>
                            @else
                                @if (auth()->check())
                                    <button class="noti-btn d-flex" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <a onclick="seenNotificationCount()">
                                            <svg id="Component_20_1" data-name="Component 20 – 1"
                                                xmlns="http://www.w3.org/2000/svg" width="22.055" height="26.464"
                                                viewBox="0 0 22.055 26.464">
                                                <g id="Component_1_1" data-name="Component 1 – 1">
                                                    <g id="notification">
                                                        <g id="Group_75" data-name="Group 75"
                                                            transform="translate(0 3.859)">
                                                            <g id="Group_74" data-name="Group 74"
                                                                transform="translate(0)">
                                                                <path id="Path_72" data-name="Path 72"
                                                                    d="M64.633,93.129l-1.894-3.156A9.381,9.381,0,0,1,61.4,85.15V82.386a7.719,7.719,0,1,0-15.438,0V85.15a9.381,9.381,0,0,1-1.335,4.823l-1.894,3.156a.551.551,0,0,0,.473.835H64.16a.551.551,0,0,0,.473-.835Zm-20.45-.268,1.393-2.321a10.474,10.474,0,0,0,1.493-5.39V82.386a6.616,6.616,0,1,1,13.232,0V85.15a10.483,10.483,0,0,0,1.492,5.39l1.394,2.321Z"
                                                                    transform="translate(-42.657 -74.667)"
                                                                    fill="#fff" />
                                                            </g>
                                                        </g>
                                                        <g id="Group_77" data-name="Group 77"
                                                            transform="translate(8.822)">
                                                            <g id="Group_76" data-name="Group 76"
                                                                transform="translate(0)">
                                                                <path id="Path_73" data-name="Path 73"
                                                                    d="M215.538,0a2.208,2.208,0,0,0-2.205,2.205V4.411a.551.551,0,0,0,1.1,0V2.205a1.1,1.1,0,0,1,2.205,0V4.411a.551.551,0,0,0,1.1,0V2.205A2.208,2.208,0,0,0,215.538,0Z"
                                                                    transform="translate(-213.333 0)"
                                                                    fill="#fff" />
                                                            </g>
                                                        </g>
                                                        <g id="Group_79" data-name="Group 79"
                                                            transform="translate(8.271 22.054)">
                                                            <g id="Group_78" data-name="Group 78"
                                                                transform="translate(0)">
                                                                <path id="Path_74" data-name="Path 74"
                                                                    d="M207.809,426.951a.552.552,0,0,0-.953.558,1.654,1.654,0,1,1-2.865,0,.552.552,0,0,0-.953-.558,2.758,2.758,0,1,0,4.77,0Z"
                                                                    transform="translate(-202.666 -426.68)"
                                                                    fill="#fff" />
                                                            </g>
                                                        </g>
                                                    </g>
                                                    <path id="Path_185" data-name="Path 185"
                                                        d="M5841,154.919l1.2,11.467"
                                                        transform="translate(-5829.973 -148.728)" fill="none"
                                                        stroke="#707070" stroke-width="0.25" opacity="0.25" />
                                                    <path id="Path_186" data-name="Path 186"
                                                        d="M5841.77,154.748l-3.254,1.273s-1.507,2.089-1.541,2.191-.857,3.63-.857,3.63l-.2,5.136-2.877,5.444h20.545l-2.534-4.828-.686-2.774.275-4.417-2.226-4.178-3.322-1.478h-3.15l3.15-.439v-2.568l-1.952-1.2-1.2.925-.377,1.849Z"
                                                        transform="translate(-5832.336 -150.027)" fill="#fff" />
                                                    <ellipse id="Ellipse_47" data-name="Ellipse 47" cx="2.593"
                                                        cy="1.945" rx="2.593" ry="1.945"
                                                        transform="translate(8.434 21.857)" fill="#fff" />
                                                </g>
                                            </svg>
                                            <span class="icon-count get-center noticount-zero"
                                                id="notification-count">{{ $notificationCount }}</span>

                                            {{ __('Notification') }}
                                        </a>
                                    </button>
                                @endif

                                <div class="dropdown-menu noti-dd" aria-labelledby="dropdownMenuButton">


                                    <notifications calledfrom="header"></notifications>


                                </div>

                            @endif

                        </div>

                    </div>
                    <div class="dropdown ctm-dropdown">
                        <button class="noti-btn d-flex" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg id="Component_2_1" data-name="Component 2 – 1" xmlns="http://www.w3.org/2000/svg"
                                width="24.895" height="26.464" viewBox="0 0 24.895 26.464">
                                <path id="Path_184" data-name="Path 184"
                                    d="M409.111,1554.362c0-.517,0-1.015,0-1.513a5.825,5.825,0,0,1,.646-2.767,4.281,4.281,0,0,1,2.667-2.193,6.973,6.973,0,0,1,3.939-.032,4.465,4.465,0,0,1,3.218,3.346,7.452,7.452,0,0,1,.2,2.343c-.011.265,0,.531,0,.814.088,0,.176-.006.264,0a.455.455,0,0,1,.468.427,4.761,4.761,0,0,1-.087,1.417,2.42,2.42,0,0,1-1.035,1.705.331.331,0,0,0-.1.214c-.048.4-.08.811-.127,1.216a4.409,4.409,0,0,1-.7,1.855c-.209.33-.429.653-.638.983a.513.513,0,0,0-.081.231,10.552,10.552,0,0,0,.057,2.305,1.463,1.463,0,0,0,.475.858,4.1,4.1,0,0,0,1.334.8c.883.35,1.778.672,2.659,1.026a13.316,13.316,0,0,1,2.578,1.357,4.663,4.663,0,0,1,2.041,3.7,6.578,6.578,0,0,1-.034,1.1c-.029.309-.112.392-.426.433a7.977,7.977,0,0,1-1,.065c-1.9.006-3.8,0-5.694,0q-8.005,0-16.011-.006a11.74,11.74,0,0,1-1.236-.061c-.334-.036-.416-.123-.448-.451a4.83,4.83,0,0,1,1.984-4.76,14.307,14.307,0,0,1,3.139-1.6c.837-.328,1.677-.648,2.51-.986a3.825,3.825,0,0,0,.618-.352,1.706,1.706,0,0,0,.853-1.46c.011-.668.01-1.335.008-2a.419.419,0,0,0-.077-.2c-.3-.5-.625-.982-.917-1.485a4.9,4.9,0,0,1-.5-1.994c-.022-.2-.026-.407-.049-.609a.259.259,0,0,0-.08-.171,2.544,2.544,0,0,1-1.094-2,6.759,6.759,0,0,1-.05-1.048c.022-.391.234-.539.628-.516Z"
                                    transform="translate(-402.005 -1547.589)" fill="#fff" />
                            </svg>
                            {{ __('Account') }}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @if (!Auth::check())
                                <a class="dropdown-item"
                                    href="{{ route('front.auth.login') }}">{{ __('Login') }}</a>
                                <a class="dropdown-item"
                                    href="{{ route('front.auth.registration') }}">{{ __('Register') }}</a>
                            @else
                                @if ($userData->isUser())
                                    <a class="dropdown-item"
                                        href="{{ route('front.dashboard.index') }}">{{ __('Profile') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ route('front.dashboard.quotations.index') }}">{{ __('Quotations') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ route('front.dashboard.orders.index') }}">{{ __('My Orders') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ route('front.dashboard.conversations.index') }}">{{ __('Messages') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ route('front.dashboard.addresses.index') }}">{{ __('Saved Addresses') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ route('front.dashboard.edit.password') }}">{{ __('Change Password') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ route('front.dashboard.notification.index') }}">{{ __('Notifications') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ route('front.auth.logout') }}">{{ __('Logout') }}</a>
                                @else
                                    <a class="dropdown-item"
                                        href="{{ route('front.dashboard.index') }}">{{ __('Profile') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ route('front.dashboard.services.index') }}">{{ __('Manage Services') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ route('front.dashboard.quotations.index') }}">{{ __('Manage Quotations') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ route('front.dashboard.equipments.index') }}">{{ __('Manage Equipments') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ route('front.dashboard.orders.index') }}">{{ __('Manage Orders') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ route('front.dashboard.projects.index') }}">{{ __('Portfolio') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ route('front.dashboard.featured-packages.index') }}">{{ __('Feature Package') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ route('front.dashboard.conversations.index') }}">{{ __('Messages') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ route('front.dashboard.packages.index') }}">{{ __('Package Subscription') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ route('front.dashboard.reviews.index') }}">{{ __('Rating & Reviews') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ route('front.dashboard.payment') }}">{{ __('Payment Profile') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ route('front.dashboard.edit.password') }}">{{ __('Change Password') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ route('front.dashboard.notification.index') }}">{{ __('Notifications') }}</a>
                                    <a class="dropdown-item"
                                        href="{{ route('front.auth.logout') }}">{{ __('Logout') }}</a>
                                @endif
                            @endif
                        </div>
                    </div>

                </div>
            </nav>
        </div>
    </div>
</header>
<!-- mobile menu -->
<div id="mySidenav" class="mobile-menu navbar">
    <div onclick="closeNav()" class="close-btn">
        <i class="fas fa-times"></i>
    </div>
    <a href="{{ route('front.index') }}" class="mobile-logo">
        <img src="{{ asset('assets/front/img/logo-white.png') }}" alt="logo-white" class="img-fluid">
    </a>
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('front.index') }}">{{ __('Home') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('front.categories') }}">{{ __('Categories') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('front.suppliers') }}">{{ __('Suppliers') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('front.services') }}">{{ __('Services') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link"
                href="{{ route('front.services', ['service' => 'offer']) }}">{{ __('Offers') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link"
                href="{{ route('front.pages', [config('settings.about_us')]) }}">{{ __('About Us') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('front.pages', 'contact-us') }}">{{ __('Contact Us') }}</a>
        </li>
    </ul>
</div>
@push('scripts')
    @if (\Auth::check())
        <script>
            $(document).ready(function() {
                window.Echo.channel(`fix-max-` + window.Laravel.user_id)
                    .listen('.new-notification', (e) => {
                        getNotificationCount()
                        console.log('new-notification-event=>', e);
                    });
            });

            function getNotificationCount() {
                axios.get(`${window.Laravel.apiUrl}notifications-count`)
                    .then(response => {
                        if (response.data.success) {
                            let notificationCount = response.data.data.collection.notificationCount;
                            console.log(notificationCount, '3434')
                            $('#notification-count').html(notificationCount)
                            // console.log(this.notifications);
                        } else {
                            console.error('Notifications Error =>', response)
                        }
                    })
            }

            function seenNotificationCount() {
                axios.get(`${window.Laravel.apiUrl}notification-seen`)
                    .then(response => {
                        if (response.data.success) {
                            // let notificationCount = response.data.data.collection.notificationCount;
                            $('#notification-count').html(0)
                            // console.log(this.notifications);
                        } else {
                            console.error('Notifications Error =>', response)
                        }
                    })
            }
        </script>
    @endif
@endpush
