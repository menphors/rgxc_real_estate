@extends('front.app')
@section("title")
    {{__("Company Profile")}}
@endsection
@section("style")
    <style type="text/css">
        .at-service-sec{
            padding: 50px 0px 0px!important;
        }
        .at-plan-sec{
            padding: 30px 0px 0px!important;
        }
    </style>
    @endsection
@section('content')
    <!-- Inner page heading start from here -->
    <section id="at-inner-title-sec">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="at-inner-title-box">
                        <h2>{{ __("Company Profile") }}</h2>
                        <p><a href="{{ route("home") }}">{{ __("Home") }}</a>
                            <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                            <a href="#">{{ __("Company Profile") }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div>

        {!! $cms->content !!}
    </div>

@endsection