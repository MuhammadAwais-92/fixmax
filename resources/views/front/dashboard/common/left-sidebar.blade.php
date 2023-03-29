<div class="col-xl-3 col-lg-4 col-md-6 mb-3 mb-lg-0">
    <ul class="nav-left-mt-a nav flex-column pb-2">
        <li class="nav-item @if (request()->route()->getName() == 'front.dashboard.index' ||
            request()->route()->getName() == 'front.dashboard.edit.profile') active @endif">
            <a href="{{ route('front.dashboard.index') }}" class="nav-link">{{ __('Profile') }}</a>
        </li>
        @if ($userData->isUser())
            <li class="nav-item  @if (request()->route()->getName() == 'front.dashboard.quotations.index' ||
                request()->route()->getName() == 'front.dashboard.quotation.detail') active @endif">
                <a href="{{ route('front.dashboard.quotations.index') }}" class="nav-link">
                    {{ __('Quotations') }}
                </a>
            </li>
            <li class="nav-item  @if (request()->route()->getName() == 'front.dashboard.orders.index' ||
                request()->route()->getName() == 'front.dashboard.order.detail') active @endif">
                <a href="{{ route('front.dashboard.orders.index') }}" class="nav-link">
                    {{ __('My Orders') }}
                </a>
            </li>


            <li class="nav-item @if (request()->route()->getName() == 'front.dashboard.conversations.index') active @endif">
                <a href="{!! route('front.dashboard.conversations.index') !!}" class="nav-link">

                    {{ __('Messages') }}
                </a>
            </li>

            <li class="nav-item">
                <a href="" class="nav-link">
                    {{ __('Manage Cards') }}
                </a>
            </li>
            <li class="nav-item @if (request()->route()->getName() == 'front.dashboard.addresses.index' ||
                request()->route()->getName() == 'front.dashboard.address.edit' || request()->route()->getName() == 'front.dashboard.address.create') active @endif">
                <a href="{{ route('front.dashboard.addresses.index') }}" class="nav-link">
                    {{ __('Saved Addresses') }}
                </a>
            </li>
        @endif
        @if ($userData->isSupplier())
            <li class="nav-item @if (request()->route()->getName() == 'front.dashboard.services.index' ||
                request()->route()->getName() == 'front.dashboard.service.edit' ||  request()->route()->getName() == 'front.dashboard.service.create'))   active @endif">
                <a href="{{ route('front.dashboard.services.index') }}" class="nav-link">
                    {{ __('Manage Services') }}
                </a>
            </li>

            <li class="nav-item  @if (request()->route()->getName() == 'front.dashboard.quotations.index' ||
                request()->route()->getName() == 'front.dashboard.quotation.detail') active @endif">
                <a href="{{ route('front.dashboard.quotations.index') }}" class="nav-link">
                    {{ __('Manage Quotations') }}
                </a>
            </li>


            <li class="nav-item @if (request()->route()->getName() == 'front.dashboard.equipments.index' ||
                request()->route()->getName() == 'front.dashboard.equipment.edit' || request()->route()->getName() == 'front.dashboard.equipment.create') active @endif">
                <a href="{{ route('front.dashboard.equipments.index') }}" class="nav-link">

                    {{ __('Manage Equipments') }}
                </a>
            </li>

            <li class="nav-item  @if (request()->route()->getName() == 'front.dashboard.orders.index' ||
                request()->route()->getName() == 'front.dashboard.order.detail') active @endif">
                <a href="{{ route('front.dashboard.orders.index') }}" class="nav-link">
                    {{ __('Manage Orders') }}
                </a>
            </li>
            <li class="nav-item @if (request()->route()->getName() == 'front.dashboard.projects.index' ||
                request()->route()->getName() == 'front.dashboard.project.edit' || request()->route()->getName() == 'front.dashboard.project.create') active @endif">
                <a href="{{ route('front.dashboard.projects.index') }}" class="nav-link">
                    {{ __('Portfolio') }}
                </a>
            </li>

            {{-- <li class="nav-item @if (request()->route()->getName() == 'front.dashboard.services.featured.index') active @endif">
                <a href="{{ route('front.dashboard.services.featured.index') }}" class="nav-link">Featured Services</a>
            </li> --}}
            <li class="nav-item @if (request()->route()->getName() == 'front.dashboard.featured-packages.index') active @endif">
                <a href="{{ route('front.dashboard.featured-packages.index') }}"
                   class="nav-link">{{ __('Feature Package') }}</a>
            </li>
            <li class="nav-item @if (request()->route()->getName() == 'front.dashboard.conversations.index') active @endif">
                <a href="{!! route('front.dashboard.conversations.index') !!}" class="nav-link">

                    {{ __('Messages') }}
                </a>
            </li>
            <li class="nav-item @if (request()->route()->getName() == 'front.dashboard.packages.index') active @endif">
                <a href="{{ route('front.dashboard.packages.index') }}"
                   class="nav-link">{{ __('Package Subscription') }}</a>
            </li>
            <li class="nav-item @if (request()->route()->getName() == 'front.dashboard.reviews.index') active @endif">
                <a href="{{ route('front.dashboard.reviews.index') }}"
                   class="nav-link">{{ __('Ratings & Reviews') }}</a>
            </li>
            <li class="nav-item @if (request()->route()->getName() == 'front.dashboard.payment') active @endif">
                <a href="{{ route('front.dashboard.payment') }}" class="nav-link">{{ __('Payment Profile') }}</a>
            </li>
        @endif
        <li class="nav-item @if (request()->route()->getName() == 'front.dashboard.edit.password') active @endif">
            <a href=" {{ route('front.dashboard.edit.password') }}"
               class="nav-link">{{ __('change password') }}</a>
        </li>
        <li class="nav-item @if (request()->route()->getName() == 'front.dashboard.notification.index') active @endif">
            <a href="{{ route('front.dashboard.notification.index') }}"
               class="nav-link">{{ __('Notifications') }}</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('front.auth.logout') }}" class="nav-link">{{ __('logout') }}</a>
        </li>
    </ul>
</div>
