<!-- Brand start from here -->
<section class="at-brand-sec">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="brand-carousel" data-slick='{"slidesToShow": 6, "slidesToScroll": 1}'>
                    @if(!is_null(@$carousel))
                        @foreach(@$carousel as $value)
                            <div class="item">
                                <a href="#">
                                    <img src="{{ asset(config("global.carousel_image_path").@$value->thumbnail) }}" alt="" title="{{ @$value->title }}">
                                </a>
                            </div>
                            @endforeach
                        @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Brand End -->