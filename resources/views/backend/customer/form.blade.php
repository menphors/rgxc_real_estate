@extends('backend.app')
@section("title")
    {{ __('Customer') }}
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
            <div class="card">

                <div class="card-body">
                    @include("backend.partial.message")
                        <form action="{{ route("administrator.customer-store") }}" method="POST" id="office-form" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ @$customer->id }}" name="customer_id">
                            <div class="row">
                                <div class="col-8">

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="name">{{__("Name")}} <span class="text-danger">*</span></label>
                                                <input type="text" name="name" value="{{ old("name", @$customer->name) }}" class="form-control @error('name') is-invalid @enderror" required/>
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
                                                <label for="phone">{{__("Phone1")}} <span class="text-danger">*</span> </label>
                                                <input type="number" name="phone" value="{{ old("phone",  @$customer->phone) }}" class="form-control @error('phone') is-invalid @enderror" required/>
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
                                                <label for="phone2">{{__("Phone2")}}</label>
                                                <input type="number" name="phone2" value="{{ old("phone2",  @$customer->phone2) }}" class="form-control @error('phone2') is-invalid @enderror"/>
                                                @if ($errors->has('phone2'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('phone2') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email">{{__("Email")}} <span class="text-danger">*</span></label>
                                                <input type="email" name="email" value="{{ old("email",  @$customer->email) }}" class="form-control @error('email') is-invalid @enderror" required/>
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
                                                <label for="id_card">{{__("Card ID")}} <span class="text-danger">*</span></label>
                                                <input type="number" name="id_card" value="{{ old("id_card",  @$customer->id_card) }}" class="form-control @error('id_card') is-invalid @enderror" required/>
                                                @if ($errors->has('id_card'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('id_card') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="gender">{{__("Gender")}}</label>
                                                <div class="kt-radio-inline">
                                                    <label class="kt-radio">
                                                        <input type="radio" name="gender" value="0" {{ old("gender", @$customer->gender) == 0 ? "checked" : "" }}> {{ __("Male") }}
                                                        <span></span>
                                                    </label>
                                                    <label class="kt-radio">
                                                        <input type="radio" name="gender" value="1" {{ old("gender", @$customer->gender) == 1 ? "checked" : "" }}> {{ __("Female") }}
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="gender">{{__("Language")}}</label>
                                                <div class="kt-radio-inline">
                                                    <label class="kt-radio">
                                                        <input type="radio" name="language" value="0" {{ old("language", @$customer->language) == 0 ? "checked" : "" }}> {{ __("Khmer") }}
                                                        <span></span>
                                                    </label>
                                                    <label class="kt-radio">
                                                        <input type="radio" name="language" value="1" {{ old("language", @$customer->language) == 1 ? "checked" : "" }}> {{ __("English") }}
                                                        <span></span>
                                                    </label>
                                                    <label class="kt-radio">
                                                        <input type="radio" name="language" value="2" {{ old("language", @$customer->language) == 2 ? "checked" : "" }}> {{ __("China") }}
                                                        <span></span>
                                                    </label>
                                                </div>
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
                                                    <img id="preview-profile-image" src="{{ asset(config("global.customer_image_path")."thumbnail/". @$customer->thumbnail) }}" onerror="this.src='{{ url('none.png') }}'" width="100%">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="wechat">{{ __("Wechat") }}</label>
                                        <input type="text" name="wechat" value="{{ old("wechat", @$customer->wechat) }}" class="form-control"/>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="telegram">{{ __("Telegram") }}</label>
                                        <input type="text" name="telegram" value="{{ old("telegram", @$customer->telegram) }}" class="form-control"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="fb">{{ __("Facebook") }}</label>
                                        <input type="text" name="fb" value="{{ old("fb", @$customer->fb) }}" class="form-control"/>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="linkedin">{{ __("LinkedIn") }}</label>
                                        <input type="text" name="linkedin" value="{{ old("linkedin", @$customer->linkedin) }}" class="form-control"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="address">{{__("Address")}}</label>
                                        <input type="text" name="address" value="{{ old("address", @$customer->address) }}" class="form-control @error('address') is-invalid @enderror">
                                        @if ($errors->has('address'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('address') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row kt-margin-t-20">
                                <div class="col-12 text-right">
                                    <a href="{{ route("administrator.customer-listing") }}" class="btn btn-danger">
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
    </section>
@endsection
@section("script")

    <script type="text/javascript">
        (function () {
            $('.kt-menu__item__customer').addClass(' kt-menu__item--active');
            $("#office-form").validate();

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