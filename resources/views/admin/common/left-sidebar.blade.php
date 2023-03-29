
<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
    <i class="la la-close"></i>
</button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
    <!-- BEGIN: Aside Menu -->
    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " data-menu-vertical="true" data-menu-scrollable="false" data-menu-dropdown-timeout="500">


        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
            <li class="m-menu__item " aria-haspopup="true" >
                <a  href="{!! route('admin.dashboard.index') !!}" class="m-menu__link ">
                    <i class="m-menu__link-icon flaticon-line-graph"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                Dashboard
                            </span>
                        </span>
                    </span>
                </a>
            </li>
            <li class="{!! str_contains(url()->current(), route('admin.dashboard.cities.index') )?'nav-active':'' !!} m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a  href="{!! route('admin.dashboard.cities.index') !!}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon "></i>
                    <span class="m-menu__link-text">Cities</span>
                </a>
            </li>
            <li class="{!! str_contains(url()->current(), route('admin.dashboard.categories.index') )?'nav-active':'' !!} m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a  href="{!! route('admin.dashboard.categories.index') !!}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon "></i>
                    <span class="m-menu__link-text">Categories</span>
                </a>
            </li>
            <li class="{!! str_contains(url()->current(), route('admin.dashboard.users.index') )?'nav-active':'' !!} m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a  href="{!! route('admin.dashboard.users.index') !!}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon "></i>
                    <span class="m-menu__link-text">Users</span>
                </a>
            </li>

            <li class="{!! str_contains(url()->current(), route('admin.dashboard.suppliers.index') )?'nav-active':'' !!} m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a  href="{!! route('admin.dashboard.suppliers.index') !!}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon "></i>
                    <span class="m-menu__link-text">Suppliers</span>
                </a>
            </li>

            <li class="{!! str_contains(url()->current(), route('admin.dashboard.subscriptions.index') )?'nav-active':'' !!} m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a  href="{!! route('admin.dashboard.subscriptions.index') !!}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon "></i>
                    <span class="m-menu__link-text">Packages</span>
                </a>
            </li>
            <li class="{!! str_contains(url()->current(), route('admin.dashboard.offers.index') )?'nav-active':'' !!} m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a  href="{!! route('admin.dashboard.offers.index') !!}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon "></i>
                    <span class="m-menu__link-text">Offer Banner</span>
                </a>
            </li>
            <li class="{!! str_contains(url()->current(), route('admin.dashboard.pages.index') )?'nav-active':'' !!} m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a  href="{!! route('admin.dashboard.pages.index') !!}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon "></i>
                    <span class="m-menu__link-text">Info Pages</span>
                </a>
            </li>
            <li class="{!! str_contains(url()->current(), route('admin.dashboard.services.index') )?'nav-active':'' !!} m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a  href="{!! route('admin.dashboard.services.index') !!}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon "></i>
                    <span class="m-menu__link-text">Services</span>
                </a>
            </li>
            <li class="{!! str_contains(url()->current(), route('admin.dashboard.equipments.index') )?'nav-active':'' !!} m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a  href="{!! route('admin.dashboard.equipments.index') !!}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon "></i>
                    <span class="m-menu__link-text">Equipments</span>
                </a>
            </li>
            <li class="{!! str_contains(url()->current(), route('admin.dashboard.quotations.index') )?'nav-active':'' !!} m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a  href="{!! route('admin.dashboard.quotations.index') !!}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon "></i>
                    <span class="m-menu__link-text">Quotations</span>
                </a>
            </li>
            <li class="{!! str_contains(url()->current(), route('admin.dashboard.orders.index') )?'nav-active':'' !!} m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a  href="{!! route('admin.dashboard.orders.index') !!}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon "></i>
                    <span class="m-menu__link-text">Orders</span>
                </a>
            </li>
            <li class="{!! str_contains(url()->current(), route('admin.dashboard.projects.index') )?'nav-active':'' !!} m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a  href="{!! route('admin.dashboard.projects.index') !!}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon "></i>
                    <span class="m-menu__link-text">Portfolio</span>
                </a>
            </li>
            <li class="{!! str_contains(url()->current(), route('admin.dashboard.galleries.index') )?'nav-active':'' !!} m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a  href="{!! route('admin.dashboard.galleries.index') !!}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon "></i>
                    <span class="m-menu__link-text">Galleries</span>
                </a>
            </li>

            <li class="{!! str_contains(url()->current(), route('admin.dashboard.articles.index') )?'nav-active':'' !!} m-menu__item  m-menu__item--submenu"
                aria-haspopup="true" data-menu-submenu-toggle="hover">
                <a href="{!! route('admin.dashboard.articles.index') !!}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon "></i>
                    <span class="m-menu__link-text">Articles</span>
                </a>
            </li>
            <li class="{!! str_contains(url()->current(), route('admin.dashboard.faqs.index') )?'nav-active':'' !!} m-menu__item  m-menu__item--submenu"
                aria-haspopup="true" data-menu-submenu-toggle="hover">
                <a href="{!! route('admin.dashboard.faqs.index') !!}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon "></i>
                    <span class="m-menu__link-text">Faqs</span>
                </a>
            </li>
            <li class="{!! str_contains(url()->current(), route('admin.dashboard.site-settings.index') )?'nav-active':'' !!} m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a  href="{!! route('admin.dashboard.site-settings.index') !!}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon "></i>
                    <span class="m-menu__link-text">Site Settings</span>
                </a>
            </li>
            <li class="{!! str_contains(url()->current(), route('admin.dashboard.coupons.index')) ? 'nav-active' : '' !!} m-menu__item  m-menu__item--submenu" aria-haspopup="true"
                data-menu-submenu-toggle="hover">
                <a href="{!! route('admin.dashboard.coupons.index') !!}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon "></i>
                    <span class="m-menu__link-text">
                        Coupon
                    </span>
                </a>
            </li>

            <li class="{!! str_contains(url()->current(), route('admin.dashboard.administrators.index') )?'nav-active':'' !!} m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a  href="{!! route('admin.dashboard.administrators.index') !!}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon "></i>
                    <span class="m-menu__link-text">Administrators</span>
                </a>
            </li>
            
            <li class="{!! str_contains(url()->current(), route('admin.dashboard.withdraw.index') )?'nav-active':'' !!} m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">
                <a  href="{!! route('admin.dashboard.withdraw.index') !!}" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon "></i>
                    <span class="m-menu__link-text">
                        Payment Requests
                    </span>
                </a>
            </li>

        </ul>
    </div>
    <!-- END: Aside Menu -->
</div>
