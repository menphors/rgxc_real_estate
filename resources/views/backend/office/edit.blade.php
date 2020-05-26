@extends('backend.app')
@section("title")
    {{ __('Office') }}
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
                        <form action="{{ route("administrator.office-update", $office->id) }}" method="POST" id="office-form" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ @$office->id }}" name="office_id"/>
                            <input type="hidden" value="{{ @$office->thumbnail }}" name="thumbnail"/>
                            <input type="hidden" value="{{ @$office->picture }}" name="picture"/>
                            <div class="row">
                                <div class="col-8">
                                    <div class="row kt-margin-t-20 {{ @$office->is_main != 1? "hide" : "" }}">
                                        <div class="col-12">
                                            <label class="kt-checkbox">
                                                <input type="checkbox" name="is_main" value="1" {{ old("is_main", @$office->is_main) == 1 ? "checked" : "" }}><b>{{__("Head Office")}}</b>
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="name">{{__("Name")}} <span class="text-danger">*</span></label>
                                                <input type="text" name="name" value="{{ old("name", @$office->name) }}" class="form-control @error('name') is-invalid @enderror" required/>
                                                @if ($errors->has('name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="phone">{{__("Phone")}} <span class="text-danger">*</span> </label>
                                                <input type="text" name="phone" value="{{ old("phone", @$office->phone) }}" class="form-control @error('phone') is-invalid @enderror" required/>
                                                @if ($errors->has('phone'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('phone') }}</strong>
                                                    </span>
                                                    @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email">{{__("Email")}} </label>
                                                <input type="email" name="email" value="{{ old("email", @$office->email) }}" class="form-control @error('email') is-invalid @enderror" />
                                                @if ($errors->has('email'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                    @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="address">{{__("Address")}}</label>
                                                <input type="text" name="address" value="{{ old("address", @$office->address) }}" class="form-control @error('address') is-invalid @enderror"/>
                                                @if ($errors->has('address'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('address') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
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
                                                    <img id="preview-profile-image" src="{{ asset(config("global.office_image_path")."thumbnail/". @$office->thumbnail) }}" width="100%">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="description">{{__("Description")}}</label>
                                        <textarea rows="5" class="form-control @error('description') is-invalid @enderror" name="description">{{ old("description", @$office->description) }}</textarea>
                                        @if ($errors->has('description'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="province">{{__("Province")}}</label>
                                        <select name="province" class="form-control province_id @error('province') is-invalid @enderror">
                                            <option value="">{{ __("Please Select") }}</option>
                                            @if(!is_null($provinces))
                                                @foreach($provinces as $key => $province)
                                                    <option value="{{ $key }}" {{ $key == @$office->province_id? "selected" : "" }}>{{ $province }}</option>
                                                    @endforeach
                                                @endif
                                        </select>
                                        @if ($errors->has('province'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('province') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="district">{{__("District")}}</label>

                                        <select name="district" class="form-control district_id @error('district') is-invalid @enderror">
                                            <option value="">{{ __("Please Select") }}</option>
                                            @if(!is_null($districts))
                                                @foreach($districts as $key => $district)
                                                    <option value="{{ $key }}" {{ $key == @$office->district_id? "selected" : "" }}>{{ $district }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->has('district'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('district') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="commune">{{__("Commune")}}</label>
                                        <select name="commune" class="form-control commune_id @error('commune') is-invalid @enderror">
                                            <option value="">{{ __("Please Select") }}</option>
                                            @if(!is_null($communes))
                                                @foreach($communes as $key => $commune)
                                                    <option value="{{ $key }}" {{ $key == @$office->commune_id? "selected" : "" }}>{{ $commune }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->has('commune'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('commune') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="village">{{__("Village")}}</label>
                                        <select name="village" class="form-control village_id @error('village') is-invalid @enderror">
                                            <option value="">{{ __("Please Select") }}</option>
                                            @if(!is_null($villages))
                                                @foreach($villages as $key => $village)
                                                    <option value="{{ $key }}" {{ $key == @$office->village_id? "selected" : "" }}>{{ $village }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->has('village'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('village') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div id="map" style="height: 500px;"></div>
                                </div>
                            </div>
                            <input type="hidden" name="lat" id="lat" value="{{ @$office->latitude }}"/>
                            <input type="hidden" name="lon" id="lon" value="{{ @$office->longitude }}"/>
                            <div class="row kt-margin-t-20">
                                <div class="col-12 text-right">
                                    <a href="{{ route("administrator.office-listing") }}" class="btn btn-danger">
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
            <!-- end:: Content -->
        </div>
        </div>
    </section>
    @endsection
@section("script")
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env("GOOGLE_MAPS_KEY") }}&libraries=places&callback=initMap" async defer></script>
    <script src="{{ asset("backend/js/jquery.uploadPreview.js") }}"></script>
    <script type="text/javascript">
        (function () {
            $('.kt-menu__item__office').addClass(' kt-menu__item--active');
            $("#office-form").validate();
            var _token = $('#csrf-token').val();

            $('.province_id').on('change', function (e) {
                var optionSelected = $("option:selected", this);
                var id = this.value;
                var get_district_province_url = "{{ url('administrator/property/get-district-province/') }}";

                if(id=='') {
                    $('.district_id').html('<option value="">None</option>');
                    $('.commune_id').html('<option value="">None</option>');
                    $('.village_id').html('<option value="">None</option>');
                    return false;
                }

                $.ajax({
                    url: get_district_province_url+'/'+id,
                    method: 'GET',
                    dataType: "JSON",
                    data: { _token:_token },
                    success: function(data) {

                        var districts = data.districts;
                        if(districts.length > 0) {
                            $('.district_id').select2(
                                {data:districts}
                            );
                        } else {
                            $('.district_id').html('<option value="">None</option>');
                            $('.commune_id').html('<option value="">None</option>');
                            $('.village_id').html('<option value="">None</option>');
                        }

                    }
                });
            });

            $('.district_id').on('change', function (e) {
                var optionSelected = $("option:selected", this);
                var id = this.value;
                var get_commune_district_url = "{{ url('administrator/property/get-commune-district/') }}";
                if(id=='') {
                    $('.commune_id').html('<option value="">None</option>');
                    $('.village_id').html('<option value="">None</option>');
                    return false;
                }

                $.ajax({
                    url: get_commune_district_url+'/'+id,
                    method: 'GET',
                    dataType: "JSON",
                    data: { _token:_token },
                    success: function(data) {
                        var communes = data.communes;
                        if(communes.length > 0) {
                            $('.commune_id').select2(
                                {data:communes}
                            );
                        } else {
                            $('.commune_id').html('<option value="">None</option>');
                            $('.village_id').html('<option value="">None</option>');
                        }
                    }
                });
            });

            $('.commune_id').on('change', function (e) {
                var optionSelected = $("option:selected", this);
                var id = this.value;
                var get_village_commune_url = "{{ url('administrator/property/get-village-commune/') }}";
                if(id=='') {
                    $('.village_id').html('<option value="">None</option>');
                    return false;
                }

                $.ajax({
                    url: get_village_commune_url+'/'+id,
                    method: 'GET',
                    dataType: "JSON",
                    data: { _token:_token },
                    success: function(data) {
                        var villages = data.villages;
                        if(villages.length > 0) {
                            $('.village_id').select2(
                                {data:villages}
                            );
                        } else {
                            $('.village_id').html('<option value="">None</option>');
                        }
                    }
                });
            });

            $('.btn-add-profile-image').click(function (e) {
                return $('#input-profile-image')[0].click();
            });
            $("#input-profile-image").change(function() {
                profileImage(this);
            });

        }).call(this);

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
            var myLatLng = {lat: parseFloat(`{{ $office->latitude }}`), lng: parseFloat(`{{ $office->longitude }}`)};
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position){
                    myLatLng = {lat: position.coords.latitude, lng: position.coords.longitude};
                });
            }
            console.log(myLatLng);

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