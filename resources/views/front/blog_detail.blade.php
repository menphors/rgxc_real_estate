@extends('front.app')
@section("title")
  {{ __($row->title) }}
@endsection

@section('content')
<section class="at-blog-sec at-blog-details-sec"  style="padding: 20px 0 70px;">
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="at-inner-title-box">
          <h2>{{__("Blog")}}</h2>
          <p>
            <a href="/">{{ __("Home") }}</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i>
            <a href="#">{{ __("Blog") }}</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i>
            <a href="#" style="color:#f1861c;">{{$row->title}}</a>
          </p>
        </div>
      </div>
    </div>

    <br/>

    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="at-blog-box at-col-default-mar">
          <div class="at-blog-img at-blog-big-img">
            <img src="{{ asset(config("global.slide_show_image_path").@$row->thumbnail) }}" alt="">
          </div>
          <h4><a href="#">{{ @$row->title }}</a></h4>
          <div>{!! @$row->content !!}</div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection