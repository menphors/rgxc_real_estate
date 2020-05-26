@extends('backend.app')
@section("title")
    {{ __('Owner') }}
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
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__body kt-portlet__body--fit">
                <div class="card">
                    <div class="card-body">
                        @include("backend.partial.message")
                        <form action="{{ $action }}" method="POST" id="property-owner-form" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="thumbnail" value="{{ @$owner->thumbnail }}">
                            <div class="row">
                                <div class="col-8">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="name">{{ __("Name") }} <span class="text-danger">*</span> </label>
                                                <input type="text" name="name" value="{{ old("name", @$owner->name) }}" class="form-control" required/>
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
                                                <label for="name">{{ __("Phone") }} <span class="text-danger">*</span> </label>
                                                <input type="text" name="phone" value="{{ old("phone",  @$owner->phone) }}" class="form-control" required/>
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
                                                <label for="name">{{ __("Phone2") }}</label>
                                                <input type="text" name="phone2" value="{{ old("phone2", @$owner->phone2) }}" class="form-control"/>
                                                @if ($errors->has('phone2'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('phone2') }}</strong>
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
                                                    <img id="preview-profile-image"  src="{{ asset(config("global.owner_image_path").@$owner->thumbnail) }}" width="100%" onerror="this.src='{{ url('none.png') }}';">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">{{ __("Phone3") }}</label>
                                        <input type="text" name="phone3" value="{{ old("phone3", @$owner->phone3) }}" class="form-control"/>
                                        @if ($errors->has('phone3'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('phone3') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email">{{ __("Email") }}</label>
                                        <input type="text" name="email" value="{{ old("email", @$owner->email) }}" class="form-control"/>
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
                                        <label for="province">{{__("Province")}}</label>
                                        <select name="province" class="form-control province_id @error('province') is-invalid @enderror">
                                            <option value="">{{ __("Please Select") }}</option>
                                            @if(!is_null($provinces))
                                                @foreach($provinces as $key => $province)
                                                    <option value="{{ $key }}" {{ old("province", @$owner->province_id) == $province->id? "selected" : "" }}>{{ $province->title }}</option>
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
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="district">{{__("District")}}</label>
                                        <select name="district" class="form-control district_id @error('district') is-invalid @enderror">
                                            <option value="">{{ __("Please Select") }}</option>
                                            @if(!is_null(@$districts))
                                                @foreach($districts as $key => $district)
                                                    <option value="{{ $key }}" {{ $district->id == @$owner->district_id? "selected" : "" }}>{{ $district->title }}</option>
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
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="commune">{{__("Commune")}}</label>
                                        <select name="commune" class="form-control commune_id @error('commune') is-invalid @enderror">
                                            <option value="">{{ __("Please Select") }}</option>
                                            @if(!is_null(@$communes))
                                                @foreach($communes as $key => $commune)
                                                    <option value="{{ $key }}" {{ $commune->id == @$owner->commune_id? "selected" : "" }}>{{ $commune->title }}</option>
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
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="village">{{__("Village")}}</label>
                                        <select name="village" class="form-control village_id @error('village') is-invalid @enderror">
                                            <option value="">{{ __("Please Select") }}</option>
                                            @if(!is_null(@$villages))
                                                @foreach($villages as $key => $village)
                                                    <option value="{{ $key }}" {{ $village->id == @$owner->village_id? "selected" : "" }}>{{ $village->title }}</option>
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
                                    <div class="form-group">
                                        <label for="address">{{ __("Address") }}</label>
                                        <textarea name="address" class="form-control">{{ old("address", @$owner->address) }}</textarea>
                                        @if ($errors->has('address'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('address') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="remark">{{ __("Remark") }}</label>
                                        <textarea name="remark" class="form-control">{{ old("remark", @$owner->remark) }}</textarea>
                                        @if ($errors->has('remark'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('remark') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row kt-margin-t-20">
                                <div class="col-12 text-right">
                                    <a href="{{ route("administrator.property-owner-listing") }}" class="btn btn-danger">
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
    </section>
@endsection
@section("script")
    <script src="{{ asset("backend/js/jquery.uploadPreview.js") }}"></script>
    <script type="text/javascript">
        (function () {
            $('.kt-menu__item__property_block').addClass('kt-menu__item--open');
            $('.kt-menu__item__property_owner').addClass(' kt-menu__item--active');
            $("#property-owner-form").validate();
            var _token = $('#csrf-token').val();

            $('.province_id').on('change', function (e) {
                e.preventDefault();
                $('.district_id').html('<option value="">None</option>');
                $('.commune_id').html('<option value="">None</option>');
                $('.village_id').html('<option value="">None</option>');

                var id = this.value;
                var get_district_province_url = "{{ url('administrator/property/get-district-province/') }}";

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
                            $('.commune_id').val(`{{ old("commune", "") }}`).trigger("change");
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
                            $('.village_id').val(`{{ old("village") }}`).trigger("change");
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



    </script>
@endsection