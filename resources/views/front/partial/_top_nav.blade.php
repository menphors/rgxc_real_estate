
    <!-- /topbar start-->
    <div class="topbar">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-sm-6 col-6">
            <div class="mail_box">
              <p> <i class="fa fa-envelope-o"></i> <a href="mailto:{{ @$config->data->email }}">{{ @$config->data->email }}</a>
                    <span style="margin-right: 20px;"></span>
                <a href="tel:123-456-7890"><i class="fa fa-phone"></i>+855 {{ @$config->data->phone }}</a>
              </p>
            </div>

          </div>
          <div class="col-lg-6 col-sm-6 col-6">
            <div class="phone_box">
                <p> Social Media:
                    <a href="{{ @$config->data->facebook_link }}"><i class="fa fa-facebook"></i></a>
                    <a href="{{ @$config->data->twitter_link }}"><i class="fa fa-linkedin"></i></a>
                    <a href="{{ @$config->data->linkedin_link }}"><i class="fa fa-youtube"></i></a>
                </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /topbar end-->

    <!-- /carousel start-->
    @if (Request::is('/'))
        @include('front.partial.slider')
    @endif
    <!-- /carousel end-->

    <!-- /header start-->
    <header>
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <nav class="navbar navbar-expand-lg navbar-dark">

              <!--  Show this only on mobile to medium screens  -->
              <a class="navbar-brand d-none d-lg-block phone_logo" href="{{ url('/') }}"><img class="img-fluid" src="{{ (isset($config->data->logo) && $config->data->logo!='') ? asset(config('global.config_path').$config->data->logo) : asset('/images/logo.png')}}" alt=""></a>
              <button class="navbar-toggler navbar-toggler-right collapsed" type="button" data-toggle="collapse" data-target="#navbarToggle" aria-controls="navbarToggle" aria-expanded="false" aria-label="Toggle navigation"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>

              {{-- <!--  Use flexbox utility classes to change how the child elements are justified  --> --}}
              <div class="collapse navbar-collapse justify-content-between" id="navbarToggle">
                <ul class="navbar-nav">
                    <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                        <a class="nav-link" href="{{url('/')}}">Home</a>
                    </li>
                    <li class="nav-item {{ Request::is('properties') ? 'active' : '' }}">
                        <a class="nav-link " href="{{url('/properties')}}">{{__("Properties")}}</a>
                    </li>
                    <li class="nav-item {{ Request::is('agents') ? 'active' : '' }}">
                        <a class="nav-link" href="{{url('/agents')}}">{{__("Agents")}}</a>
                    </li>

                    <li class="nav-item dropdown {{ Request::is("service") || Request::is("company-profile") ? "active" : "" }}">
                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __("Company") }}
                        </a>
                        <ul class="dropdown-menu wow fadeInUp sub-menu-animation" aria-labelledby="navbarDropdownMenuLink">
                            <li>
                                <a class="dropdown-item {{ Request::is("company-profile") ? "active" : "" }}" href="{{route('company-profile')}}">{{ __("Company Profile") }}</a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ Request::is("service") ? "active" : "" }}" href="{{ route("service") }}">{{ __("Service") }}</a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <!--   Show this only lg screens and up   -->
                        <a class="navbar-brand d-none d-lg-block desktop_logo" href="{{url('/')}}">
                            <img class="img-fluid" src="{{ (isset($config->data->logo) && $config->data->logo!='') ? asset(config('global.config_path').$config->data->logo) : asset('/images/logo.png')}}" alt="">
                        </a>
                        <ul class="navbar-nav">
                            <li class="nav-item"><a class="nav-link" href="#">NEWS</a> </li>
                            <li class="nav-item {{ Request::is("contact") ? "active" : "" }}"> <a class="nav-link"  href="{{url('/contact')}}">{{__("Contact")}}</a> </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @if(!auth()->user())
                                        {{ __("sign in") }}
                                    @elseif(auth()->user() && auth()->user()->isAdmin())
                                        {{ auth()->user()->roles()->first()->title ?? '' }}
                                    @else
                                        {{ auth()->user()->staff->name ?? '' }}
                                  @endif
                                </a>
                                <ul class="dropdown-menu wow fadeInUp sub-menu-animation" aria-labelledby="navbarDropdownMenuLink">

                                        @if(!auth()->user())
                                        <li>
                                            <a class="dropdown-item text-uppercase" href="{{ route("administrator") }}">{{ __("sign in") }}</a>
                                        </li>
                                      @elseif(auth()->user() && auth()->user()->isAdmin())
                                        <li>
                                            <a class="dropdown-item text-uppercase" href="{{ url("administrator/dashboard") }}"> {{ auth()->user()->roles()->first()->title ?? '' }}</a>
                                        </li>

                                      @else
                                        <a href="#">{{ auth()->user()->staff->name ?? '' }}</a>
                                        <div class="" style="padding-left:20px;float:left;">
                                          <i class="icofont icofont-logout"></i>
                                          <a href="#" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();" class="">{{ __("Sign Out") }}</a><form id="frm-logout" action="{{ route('administrator.user-logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                                        </div>
                                      @endif</li>
                                </ul>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        @if (app()->getLocale()==$localeCode)
                                            <img src="{{ asset("backend/media/flags/".$localeCode.".png") }}" alt=""  style="width: 25px;" /> {!!$properties['name']!!}
                                        @endif
                                    @endforeach
                                </a>
                                <ul class="dropdown-menu wow fadeInUp sub-menu-animation" aria-labelledby="navbarDropdownMenuLink">
                                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        <li>
                                            <a class="dropdown-item {{ app()->getLocale()==$localeCode ? 'active' : '' }}" href="{{ url('locale/'.$localeCode) }}" >
                                                @php
                                                    $lang = $properties['regional'];
                                                    $code = explode('_', $lang);
                                                    $c = strtolower($code[1]);
                                                @endphp
                                                <span class="text-uppercase">
                                                    <img class="mr-4" src="{{ asset("backend/media/flags/".$localeCode.".png") }}" alt=""  style="width: 25px;" /> {!!$properties['name']!!}
                                                </span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>

                        </ul>
              </div>
            </nav>
          </div>
        </div>
      </div>
    </header>
    <!-- /heaer end-->



      <!-- Header top start -->

      {{-- <div class="at-header-topbar">
        <div class="container">
          <div class="row">
            <div class="col-lg-2">
              <p><i class="icofont icofont-ui-head-phone"></i> +855 {{ @$config->data->phone }}</p>
            </div>
            <div class="col-lg-3">
              <p class="at-respo-right"><i class="icofont icofont-email"></i> <a href="#">{{ @$config->data->email }}</a>
              </p>
            </div>
            <div class="col-lg-7 text-right">
              <span class="pull-right" style="margin-left: 20px">
                <a target="_blank" href="{{ @$config->data->facebook_link }}"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                <a target="_blank" href="{{ @$config->data->twitter_link }}"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                <a target="_blank" href="{{ @$config->data->linkedin_link }}"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
              </span>

              <span class="pull-right" style="margin-left: 20px">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <a href="{{ url(LaravelLocalization::getLocalizedURL($localeCode, null, [], true)) }}" class="kt-nav__link">
                  @php $lang = $properties['regional'];
                  $code = explode('_', $lang);
                  $c = strtolower($code[1]);
                  @endphp
                  <span class="kt-nav__link-icon">
                    <img src="{{ asset("backend/media/flags/".$localeCode.".png") }}" alt=""  style="width: 25px;" />
                  </span>
                </a>
                @endforeach
              </span>
              <span class="at-sign-in-up pull-right" style="margin-left: 20px">
                <p>
                  @if(!auth()->user())
                    <i class="icofont icofont-sign-in"></i>
                    <a href="{{ route("administrator") }}">{{ __("sign in") }}</a>
                  @elseif(auth()->user() && auth()->user()->isAdmin())
                    <i class="icofont icofont-dashboard"></i>
                    <a href="{{ url("administrator/dashboard") }}">{{ auth()->user()->roles()->first()->title ?? '' }}</a>
                  @else
                    <i class="icofont icofont-user-alt-4"></i>
                    <a href="#">{{ auth()->user()->staff->name ?? '' }}</a>
                    <div class="" style="padding-left:20px;float:left;">
                      <i class="icofont icofont-logout"></i>
                      <a href="#" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();" class="">{{ __("Sign Out") }}</a><form id="frm-logout" action="{{ route('administrator.user-logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                    </div>
                  @endif
                </p>
              </span>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <div class="col-lg-2 text-center"></div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-5 at-full-wd480"></div>
          </div>
        </div>
      </div> --}}
      <!-- Header top end -->
