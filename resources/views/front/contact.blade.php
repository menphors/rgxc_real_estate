@extends('front.app')
@section("title")
    {{ __("Contact") }}
@endsection

@section('content')
    <!-- /page_banner stsrt-->
    <div class="carousel_box">
        <div class="banner-style-2" style="background-image:url({{asset('assets/images/page_banner.jpg')}}); background-position: center;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="inner_title">
                            <h2>Get In Touch</h2>
                            <div class="title_box_border"></div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ul id="banner_link">
                            <li>Contact Us</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page_banner end-->

    <!-- /contactdeatil start-->
    <div class="contact_box">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="contact_detail">
                        <h2>Our<span class="text_change"> Contact</span></h2>
                        <div class="contact_border"></div>
                        @if ($message = Session::get('success'))
                            <p>{{ $message }}</p>
                        @endif
                        <div class="address_detail_box">
                            <div class="contact_address">
                                <div class="contact_address_icon"> <img class="img-fluid" src="{{asset('assets/images/placeholder.png')}}" alt=""> </div>
                                <div class="contact_address_con">
                                    <p>{{ @$config->data->address }} </p>
                                </div>
                            </div>
                            <div class="contact_phone">
                                <div class="contact_phone_icon"> <img class="img-fluid" src="{{asset('assets/images/phone-footer.png')}}" alt=""> </div>
                                <div class="contact_phone_con">
                                    <p><a href="tel:{{ @$config->data->phone }}">{{ @$config->data->phone }}</a></p>
                                </div>
                            </div>
                            <div class="contact_mail">
                                <div class="contact_mail_icon"> <img class="img-fluid" src="{{asset('assets/images/envelope.png')}}" alt=""> </div>
                                <div class="contact_mail_con">
                                    <p><a href="mailto:{{ @$config->data->email }}">{{ @$config->data->email }}</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="contact_form_box">
                        <form id="ajax-contact" method="post" action="{{url('contact')}}">
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="text" class="contact_form_detail"  id="name" name="name" value="{{ old("name") }}" placeholder="{{ __("Your Name") }}" required>
                                </div>
                                <div class="col-lg-6">
                                    <input type="email" class="contact_form_detail"  class="form-control" id="email" name="email" value="{{ old("email") }}" placeholder="{{ __("Email") }}" required>
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" name="phone" id="phone" class="contact_form_detail" value="{{ old("phone") }}" placeholder="{{ __("Phone") }}"required>
                                </div>
                                <div class="col-lg-6">
                                    <input  class="contact_form_detail" id="subject" name="subject" value="{{ old("subject") }}" placeholder="{{ __("Subject") }}" required>
                                </div>
                                <div class="col-md-12">
                                    <textarea  class="contact_form_detail1" id="message" name="message" rows="5" placeholder="{{ __("Message") }}" required>{{ old("message") }}</textarea>
                                </div>
                                <div class="col-md-12">
                                    <div class="submit_btn_box">
                                        <input name="submit" class="btn btn-default hvr-bounce-to-right" type="submit" value="Submit Now">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /contactdeatil end-->

    <!-- /google_map start-->
    <div class="contact_map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7818.051765658361!2d104.93509217537152!3d11.550000978801386!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x310956d330da8527%3A0x7eff3ca8d12ecc0f!2sKoh+Pich!5e0!3m2!1sen!2skh!4v1566230799707!5m2!1sen!2skh" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
    </div>
    <!-- /google_map end-->

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
@push('js')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env("GOOGLE_MAPS_KEY") }}&libraries=places&callback=initMap" async defer></script>

    <script type="text/javascript">
        var initMap = function () {

            var myLatLng = {lat: parseFloat($('.lat-span').val()), lng: parseFloat($('.lon-span').val())};

            var map = new google.maps.Map(document.getElementById('googleMap'), {
                center: myLatLng,
                zoom: 13
            });

            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: 'RXGC',
                draggable: true
            });

            google.maps.event.addListener(marker, 'dragend', function(marker) {
                var latLng = marker.latLng;
                document.getElementById('lat-span').innerHTML = latLng.lat();
                document.getElementById('lon-span').innerHTML = latLng.lng();
                $('.lat-span').val(latLng.lat());
                $('.lon-span').val(latLng.lng());
            });
        }
    </script>
@endpush
