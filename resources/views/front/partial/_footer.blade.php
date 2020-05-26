
<footer class="at-main-footer at-over-layer-black">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-12 col-sm-12">
                <div class="at-footer-about-col at-col-default-mar">
                    <div class="at-footer-logo">
                        <img src="{{asset('images/footer-logo.png' )}}" alt="">
                    </div>
                    <hr>
                    <p>{!!  @$footer_left->content  !!}</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12">
                <div class="at-footer-link-col at-col-default-mar">
                    <h4>{{__('Quick links')}}</h4>
                    <div class="at-heading-under-line">
                        <div class="at-heading-inside-line"></div>
                    </div>
                    <ul>
                        <li>
                            <a href="{{url('/')}}">{{__("Home")}}</a>
                        </li>
                        <li>
                            <a href="{{url('/properties')}}">{{__("Properties")}}</a>
                        </li>
                        <li>
                            <a href="{{url('/agents')}}">{{__("Agents")}}</a>
                        </li>
                        <li>
                            <a href="{{url('/about')}}">{{ __("About") }}</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12">
                <div class="at-footer-gallery-col at-col-default-mar" style="color: #dedede!important;">
                    <h4>{{ __("Our Address") }}</h4>
                    <div class="at-heading-under-line">
                        <div class="at-heading-inside-line"></div>
                    </div>
                    <p style="font-size: 12px">
                        {!! $footer_right->content !!}
                    </p>
                    {{-- <div style="margin-left: 20px!important;font-size: 12px;">
                        <span class="fa fa-phone"></span> +855 {{ @$config->data->phone }} <br/>
                        <span class="icofont icofont-email"></span> {{ @$config->data->email }} <br/>
                        <span class="fa fa-map-marker"></span> <span>
                          {{ @$config->data->address}}
                        </span>
                    </div> --}}
                    <br/>
                    <div class="at-social text-left">
                        <span style="padding-top: 20px!important;" href="#">{{ __("We Are Social") }}:</span>
                        <a target="_blank" href="{{ @$config->data->facebook_link }}"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        <a target="_blank" href="{{ @$config->data->twitter_link }}"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                        <a target="_blank" href="{{ @$config->data->linkedin_link }}"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer end -->

<!-- Copyright start from here -->
<section class="at-copyright">
    <div class="container">
        <div class="row">
            <p>{{__('Copyright')}} ©2019 <a href="#">RXGC INVESTMENT</a> {{__('All Rights Reserved')}}</p>
        </div>
    </div>
</section>
<!-- Copyright end