@extends('front.app')
@section("title")
    {{ __("Service") }}
@endsection

@section('content')
    <!-- Inner page heading start from here -->
    <section id="at-inner-title-sec">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="at-inner-title-box">
                        <h2>{{ __("About") }}</h2>
                        <p><a href="/">{{ __("Home") }}</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="#">{{ __("About") }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Inner page heading end -->

    <div>
        {!! $cms->content !!}
    </div>
@endsection