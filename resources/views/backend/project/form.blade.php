@extends('backend.app')
@section("title")
    {{ __('Project') }}
@endsection
@section("style")
    <style type="text/css">
        #map {
            height: 100%;
        }
        /* Optional: Makes the sample page fill the window. */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__body kt-portlet__body--fit">
                <div class="card">
                    <div class="card-body">
                        @include("backend.partial.message")
                        <form action="{{ $action }}" method="POST" id="office-form" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-8">
                                    <div class="form-group">
                                        <label for="title">{{ __("Title") }} <span class="text-danger">*</span> </label>
                                        <input type="text" name="title" class="form-control" value="{{old("title", @$project->title)}}" id="title">
                                        @if ($errors->has('title'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="address">{{ __("Address") }}</label>
                                        <textarea class="form-control" name="address" id="address">{{ old("address", @$project->address) }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">{{ __("Description") }}</label>
                                        <textarea rows="4" class="form-control" name="description" id="description">{{ old("description", @$project->description) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-lg-8 offset-2">
                                            <div class="card card-default">
                                                <div class="card-header">
                                                    <h3 class="card-title font-size-1-rem">
                                                        <a href="javascript:;" class="w-100 btn btn-default btn-sm pull-right btn-add btn-add-profile-image"><small>+ {{ __('add logo') }}</small></a>
                                                    </h3>
                                                </div>
                                                <div class="card-body btn-add-profile-image cursor-pointer">
                                                    <input type='file' id="input-profile-image" class="d-none click-input-profile-image" name="thumbnail"  accept="image/*"/>
                                                    <img id="preview-profile-image" src="{{ asset(config("global.project_path"). @$project->thumbnail) }}" onerror="this.src='{{ url('none.png') }}'" width="100%">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div id="map" style="height: 500px;"></div>
                                </div>
                            </div>
                            <input type="hidden" name="lat" id="lat" value="{{ old("lat", (!empty(@$project->latitude)? @$project->latitude: "11.5564")) }}"/>
                            <input type="hidden" name="lon" id="lon" value="{{ old("lon", (!empty(@$project->longitude)? @$project->longitude: "104.9282")) }}"/>
                            <div class="row kt-margin-t-20">
                                <div class="col-12 text-right">
                                    <a href="{{ route("administrator.project-listing") }}" class="btn btn-danger">
                                        <i class="la la-long-arrow-left"></i> {{ __("Back") }}
                                    </a>
                                    <button type="submit" class="btn btn-info">
                                        <i class="fa fa-save"></i>
                                        {{ __("Save") }}
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>

    </section>
    @endsection
@section("script")
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env("GOOGLE_MAPS_KEY") }}&libraries=places&callback=initMap" async defer></script>
    <script type="text/javascript">
        $(function () {
            $('.kt-menu__item__project').addClass(' kt-menu__item--active');

            $('.btn-add-profile-image').click(function (e) {
                return $('#input-profile-image')[0].click();
            });
            $("#input-profile-image").change(function() {
                profileImage(this);
            });
        });

        function profileImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview-profile-image').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        var initMap = function () {
            var myLatLng = {lat: 11.5564, lng: 104.9282};
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position){
                    myLatLng = {lat: position.coords.latitude, lng: position.coords.longitude};
                });
            }

            var map = new google.maps.Map(document.getElementById('map'), {
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
                $('#lat').val(latLng.lat());
                $('#lon').val(latLng.lng());
            });
        };
        </script>
    @endsection