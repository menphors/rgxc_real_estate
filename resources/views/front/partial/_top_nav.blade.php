<section class="at-main-herader-sec">
  <!-- Header top start -->
  <div class="at-header-topbar">
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
  </div>
  <!-- Header top end -->

  <!-- Header navbar start -->
  <div class="at-navbar fixed-header" style="background-color: #717171!important;">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <nav class="navbar navbar-default" style="background: #717171!important;">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="{{url('/')}}">
                <img src="{{ (isset($config->data->logo) && $config->data->logo!='') ? asset(config('global.config_path').$config->data->logo) : asset('/images/logo.png')}}" alt="">
              </a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" data-hover="dropdown" data-animations="fadeInUp">
              <ul class="nav navbar-nav navbar-right" style="margin-top: 11px;">
                <li class="{{ (request()->is('/')) ? 'active' : '' }}">
                  <a href="{{url('/')}}">{{__("Home")}}</a>
                </li>
                <li  class="{{ (request()->is('properties') || request()->is('property-detail/*')) ? 'active' : '' }}">
                  <a href="{{url('/properties')}}">{{__("Properties")}}</a>
                </li>
                <li class="{{ (request()->is('agents')) ? 'active' : '' }}">
                  <a href="{{url('/agents')}}">{{__("Agents")}}</a>
                </li>
                <li class="dropdown {{ Route::is("service") || Route::is("company-profile") ? "active" : "" }}">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ __("About") }} <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                  <ul class="dropdown-menu">
                    <li><a href="{{route('company-profile')}}">{{ __("Company Profile") }}</a></li>
                    <li><a href="{{ route("service") }}">{{ __("Service") }}</a></li>
                  </ul>
                </li>
                <li {{ (request()->is('contact')) ? 'active' : '' }}><a href="{{url('/contact')}}">{{__("Contact")}}</a></li>
              </ul>
            </div>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <!-- Header navbar end -->
</section>