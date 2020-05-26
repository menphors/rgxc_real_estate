<!-- Main Slider start -->
<section class="at-main-slider">
  <div class="flexslider">
    <ul class="slides">
      @if(!is_null($slide))
        @foreach($slide as $value)
          <li data-thumb="{{ asset(config("global.slide_show_image_path").@$value->thumbnail) }}">
            <a href="{{ @$value->link }}" target="_blank">
              <img src="{{ asset(config("global.slide_show_image_path").@$value->thumbnail) }}" alt="">
              <p class="flex-caption">{{ @$value->title }}</p>
            </a>
          </li>
        @endforeach
      @endif
    </ul>
  </div>
</section>