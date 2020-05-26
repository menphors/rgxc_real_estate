<!-- begin:: Header -->
<div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed ">

    <!-- begin:: Header Menu -->
    <div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
        <div class="kt-header-mobile__logo">
            <a href="/">
                <img alt="Logo" src="{{ asset("images/logo.png") }}"  width="120px"/>
            </a>
        </div>
        <div class="kt-header-mobile__toolbar">
            <button class="kt-header-mobile__toggler kt-header-mobile__toggler--left" id="kt_aside_mobile_toggler"><span></span></button>
            <button class="kt-header-mobile__topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more"></i></button>
        </div>
    </div>

    <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
    <div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
        <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile  kt-header-menu--layout-default ">
        </div>
    </div>

    <!-- end:: Header Menu -->

    <!-- begin:: Header Topbar -->
    <div class="kt-header__topbar">

        <!--begin: Language bar -->
        <div class="kt-header__topbar-item kt-header__topbar-item--langs">
            <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
                <span class="kt-header__topbar-icon">
                    <img src="{{ asset("backend/media/flags/". app()->getLocale() .".png") }}" alt="" />
                </span>
            </div>
            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround">
                <ul class="kt-nav kt-margin-t-10 kt-margin-b-10">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <li class="kt-nav__item kt-nav__item--active">
                                <a href="{{ url(LaravelLocalization::getLocalizedURL($localeCode, null, [], true)) }}" class="kt-nav__link">
                                @php $lang = $properties['regional'];
                                      $code = explode('_', $lang);
                                      $c = strtolower($code[1]);
                                @endphp
                                <span class="kt-nav__link-icon">
                                    <img src="{{ asset("backend/media/flags/".$localeCode.".png") }}" alt="" />
                                </span>
                                    <span class="kt-nav__link-text">{!!$properties['name']!!}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!--end: Language bar -->

        <!--begin: User Bar -->
        <div class="kt-header__topbar-item kt-header__topbar-item--user">
            <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,0px">
                <div class="kt-header__topbar-user">
                    <span class="kt-header__topbar-welcome kt-hidden-mobile">Hi,</span>
                    <span class="kt-header__topbar-username kt-hidden-mobile">{{ Auth::user()->name }}</span>
                    <img class="kt-hidden" alt="Pic" src="{{ asset("backend/media/users/300_25.jpg") }}" />

                    <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                    <!-- <span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold">S</span> -->
                </div>
            </div>
            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">

                <!--begin: Head -->
                <div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x" style="background-image: url({{ asset("backend/media/misc/bg-1.jpg") }})">
                    <div class="kt-user-card__avatar">
                        <img class="kt-hidden" alt="Pic" src="{{ asset("backend/media/users/300_25.jpg") }}" />

                        <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
                        <!-- <span class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success">S</span> -->
                    </div>
                    <div class="kt-user-card__name">
                        {{ Auth::user()->name }}
                    </div>

                </div>

                <!--end: Head -->

                <!--begin: Navigation -->
                <div class="kt-notification">
                    <a href="#" class="kt-notification__item">
                        <div class="kt-notification__item-icon">
                            <i class="flaticon2-calendar-3 kt-font-success"></i>
                        </div>
                        <div class="kt-notification__item-details">
                            <div class="kt-notification__item-title kt-font-bold">
                                {{ __('My Profile') }}
                            </div>
                        </div>
                    </a>
                    <div class="kt-notification__custom kt-space-between pull-right">
                        <a href="#" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();"
                           class="btn btn-label btn-label-brand btn-sm btn-bold">{{ __("Sign Out") }}</a>
                        <form id="frm-logout" action="{{ route('administrator.user-logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>

                <!--end: Navigation -->
            </div>
        </div>

        <!--end: User Bar -->
    </div>

    <!-- end:: Header Topbar -->
</div>

<!-- end:: Header -->