@extends('front.app')
@section("title")
    {{ __("Contact") }}
@endsection

@section('content')
    <!-- Inner page heading start from here -->
    <section id="at-inner-title-sec">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="at-inner-title-box">
                        <h2>{{ __("Contact Us") }}</h2>
                        <p><a href="/">{{ __("Home") }}</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="#">{{ __("Contact") }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Inner page heading end -->

    <!-- Contact Start from here -->
    <section class="at-contact-sec">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6">

                    <div class="at-contact-form at-col-default-mar">
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                        @endif
                        <form id="ajax-contact" method="post" action="{{url('contact')}}">
                            @csrf
                            <input type="text" class="form-control" id="name" name="name" value="{{ old("name") }}" placeholder="{{ __("Your Name") }}" required>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old("email") }}" placeholder="{{ __("Email") }}" required>
                            <input type="text" class="form-control" id="subject" name="subject" value="{{ old("subject") }}" placeholder="{{ __("Subject") }}" required>
                            <textarea class="form-control" id="message" name="message" rows="5" placeholder="{{ __("Message") }}" required>{{ old("message") }}</textarea>
                            <button class="btn btn-default hvr-bounce-to-right" type="submit">{{ __("Sent Message") }}</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="at-info-box at-col-default-mar">
                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                        &nbsp;{{ @$config->data->email }}
                    </div>
                    <div class="at-info-box at-col-default-mar">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                        &nbsp;{{ @$config->data->phone }}
                    </div>
                    <div class="at-info-box at-col-default-mar">
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                        &nbsp;{{ @$config->data->address }}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--  Contact end-->
    <!-- <input type="hidden" name="lat-span" class="lat-span" value="11.5499904">
    <input type="hidden" name="lon-span" class="lon-span" value="104.9307148">
    <div id="googleMap" style="width:100%; height:400px;"></div> -->
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7818.051765658361!2d104.93509217537152!3d11.550000978801386!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x310956d330da8527%3A0x7eff3ca8d12ecc0f!2sKoh+Pich!5e0!3m2!1sen!2skh!4v1566230799707!5m2!1sen!2skh" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
@endsection

@section('script')
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
@endsection
