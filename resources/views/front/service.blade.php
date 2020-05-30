@extends('front.app')
@section("title")
    {{ __("Service") }}
@endsection

@section('content')
<!-- /page_banner start-->
<div class="carousel_box">
    <div class="banner-style-2" style="background-image:url({{asset('assets/images/page_banner.jpg')}}); background-position: center;">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-6">
                    <div class="inner_title">
                        <h2>Services</h2>
                        <div class="title_box_border"></div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <ul id="banner_link">
                        <li>Our Services</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page_banner end-->

<!-- /inner_services start-->
<div class="inner_services">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="inner_services_box">
                    <div class="inner_services_img"> <img class="img-fluid" src="{{asset('assets/images/design.png')}}" alt=""> </div>
                    <div class="inner_services_con">
                        <h2>Design</h2>
                        <p>Nulla suscipit sapien sapien, non mollis mauris cursus nec. Nam vitae ligula et metus.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="inner_services_box">
                    <div class="inner_services_img"> <img class="img-fluid" src="{{asset('assets/images/concept.png')}}" alt=""> </div>
                    <div class="inner_services_con">
                        <h2>Concept</h2>
                        <p>Aliquam dictum elit vitae mauris facilisis, at dictum urna dignissim donec vel lectus vel felis.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="inner_services_box">
                    <div class="inner_services_img"> <img class="img-fluid" src="{{asset('assets/images/building.png')}}" alt=""> </div>
                    <div class="inner_services_con">
                        <h2>Building</h2>
                        <p>if you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything...</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="inner_services_box">
                    <div class="inner_services_img"> <img class="img-fluid" src="{{asset('assets/images/idea.png')}}" alt=""> </div>
                    <div class="inner_services_con">
                        <h2>Ideas</h2>
                        <p>Nulla suscipit sapien sapien, non mollis mauris cursus nec. Nam vitae ligula et metus.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="inner_services_box">
                    <div class="inner_services_img"> <img class="img-fluid" src="{{asset('assets/images/creativity.png')}}" alt=""> </div>
                    <div class="inner_services_con">
                        <h2>Creativity</h2>
                        <p>Creativity suscipit sapien sapien, non mollis mauris cursus nec. Nam vitae ligula et metus.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="inner_services_box">
                    <div class="inner_services_img"> <img class="img-fluid" src="{{asset('assets/images/decor.png')}}" alt=""> </div>
                    <div class="inner_services_con">
                        <h2>Decor</h2>
                        <p>Nulla suscipit sapien sapien, non mollis mauris cursus nec. Nam vitae ligula et metus.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /inner_services end-->

<!-- /testimonials start-->
<section class="testimonials inner_testimonials">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="title-box">
                    <h2>Client <span class="text_change">Testimonials</span></h2>
                    <div class="title_border1"></div>
                </div>
            </div>
            <div class="col-lg-12">
                <div id="testimonials_slider" class="carousel slide" data-ride="carousel">
                    <ul class="carousel-indicators carousel-indicators-numbers">
                        <li data-target="#testimonials_slider" data-slide-to="0" class="active">01.</li>
                        <li data-target="#testimonials_slider" data-slide-to="1">02.</li>
                        <li data-target="#testimonials_slider" data-slide-to="2">03.</li>
                    </ul>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="carousel-caption2">
                                <div class="testimonials_img"> <img class="img-fluid" src="{{asset('assets/images/testimonials_1.jpg')}}" alt=""> </div>
                                <div class="testimonials_con">
                                    <h3>John Doe & Elina Smith</h3>
                                    <h4>miami Florida, USA</h4>
                                    <p>This theme is so beautiful, easy to customize (even with no coding knowledge). It has some many features (and some that I keep discovering!!). The customer service is amazing.</p>
                                    <p>I won’t forgot to mention that their customer support is amazing. Thank you very much indeed.</p>
                                    <div class="testimonials_btn"> <a href="#" class="testiminials_button">View Project</a> </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="carousel-caption2">
                                <div class="testimonials_img"> <img class="img-fluid" src="{{asset('assets/images/testimonials_1.jpg')}}" alt=""> </div>
                                <div class="testimonials_con">
                                    <h3>Alana Dyan</h3>
                                    <h4>miami Florida, USA</h4>
                                    <p>This theme is so beautiful, easy to customize (even with no coding knowledge). It has some many features (and some that I keep discovering!!). The customer service is amazing.</p>
                                    <p>I recommend this theme to anyone looking for a real estate WP theme, or something similar that can be adapted.</p>
                                    <div class="testimonials_btn"> <a href="#" class="testiminials_button">View Project</a> </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="carousel-caption2">
                                <div class="testimonials_img"> <img class="img-fluid" src="{{asset('assets/images/testimonials_1.jpg')}}" alt=""> </div>
                                <div class="testimonials_con">
                                    <h3>Orpha Letitia</h3>
                                    <h4>miami Florida, USA</h4>
                                    <p>This theme is so beautiful, easy to customize (even with no coding knowledge). It has some many features (and some that I keep discovering!!). The customer service is amazing.</p>
                                    <p>I recommend this theme to anyone looking for a real estate WP theme, or something similar that can be adapted.</p>
                                    <div class="testimonials_btn"> <a href="#" class="testiminials_button">View Project</a> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="property_arrow"> <a class="carousel-control-prev" href="#testimonials_slider" data-slide="prev"> <span class="carousel-control-prev-icon"></span> </a> <a class="carousel-control-next" href="#testimonials_slider" data-slide="next"> <span class="carousel-control-next-icon"></span> </a> </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /testimonials end-->

<!-- /call_to_action start-->
<section class="call_to_action">
    <div class="container">
        <div class="row">
            <div class="offset-2 col-lg-8">
                <div class="call_con">
                    <h2>Looking for a best real estate deals?</h2>
                    <div class="call_btn"><a href="{{url('contact')}}" class="call_to_action_btn">Contact Us</a></div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /call_to_action end-->
@endsection
