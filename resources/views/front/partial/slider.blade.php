@php
    $slide = App\Model\Cms::where(["type" => \Constants::CMS_TYPE_SLIDE_SHOW])->orderBy("id", "desc")->get();
@endphp
<div id="main_slider" class="carousel slide" data-ride="carousel">
  <ul class="carousel-indicators carousel-indicators-numbers">
    @for ($i = 1; $i <= $slide->count(); $i++)
        <li data-target="#main_slider" data-slide-to="0" class="{{ $i==1 ? 'active' : '' }}">{{ $i }}</li>
    @endfor
  </ul>
  <div class="carousel-inner">
    @if(!is_null($slide))
        @foreach($slide as $value)
            <div class="carousel-item @if ($loop->first) active @endif" style="background-image:url({{ asset(config("global.slide_show_image_path").@$value->thumbnail) }}); height:550px; background-size:cover;">
                <div class="carousel-caption">
                    <div class="slider_title_box">
                        <h2>{{ __('We are offering') }}</h2>
                    </div>
                    <h1>{!! $value->title !!}</h1>
                    <div class="slider_btn_box"> <a href="{{ @$value->link }}" class="slider_btn">{{ __('Browse Latest Properties') }}</a> </div>
                </div>
            </div>
        @endforeach
    @endif
  </div>
  <div class="property_arrow"> <a class="carousel-control-prev" href="#main_slider" data-slide="prev"> <span class="carousel-control-prev-icon"></span> </a> <a class="carousel-control-next" href="#main_slider" data-slide="next"> <span class="carousel-control-next-icon"></span> </a> </div>
</div>
