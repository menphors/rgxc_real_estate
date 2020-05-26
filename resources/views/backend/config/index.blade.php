@extends('backend.app')

@section("title")
  {{ __('Config') }}
@endsection

@section("style")
@endsection

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <form action="{{ route("administrator.config-store") }}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-8">
              <div class="form-group">
                <label for="phone">{{ __("Site Name") }}</label>
                <input type="text" name="site_name" value="{{ old("site_name", @$config->data->site_name) }}" class="form-control" placeholder=""/>
              </div>
              <div class="form-group">
                <label for="phone">{{ __("Phone") }}</label>
                <input type="text" name="phone" value="{{ old("phone", @$config->data->phone) }}" class="form-control" placeholder="xxx xxx xxx"/>
              </div>
              <div class="form-group">
                <label for="email">{{ __("Email") }}</label>
                <input type="text" name="email" value="{{ old("email", @$config->data->email) }}" class="form-control" placeholder="rxgc@gmail.com"/>
              </div>
              <div class="form-group">
                <label for="facebook-link">{{ __("Facebook Link") }}</label>
                <input type="text" name="facebook_link" value="{{ old("facebook_link", @$config->data->facebook_link) }}" class="form-control"/>
              </div>
              <div class="form-group">
                <label for="twitter-link">{{ __("Twitter Link") }}</label>
                <input type="text" name="twitter_link" value="{{ old("twitter_link", @$config->data->twitter_link) }}" class="form-control"/>
              </div>
              <div class="form-group">
                <label for="linkedin-link">{{ __("Linkedin Link") }}</label>
                <input type="text" name="linkedin_link" value="{{ old("linkedin_link", @$config->data->linkedin_link) }}" class="form-control"/>
              </div>
              <div class="form-group">
                <label for="copy-right">{{ __("Copy Right") }}</label>
                <input type="text" name="copy_right" value="{{ old("copy_right", @$config->data->copy_right) }}" class="form-control"/>
              </div>
              <div class="form-group">
                <label for="address">{{ __("Address") }}</label>
                <textarea type="text" id="address" rows="3" name="address" class="form-control">{{ old("address", @$config->data->address) }}</textarea>
              </div>
            </div>
            <div class="col-4">
              <div class="card card-default mb-4">
                <div class="card-header">
                  <h5 class="card-title mb-0">{{ __('Site Logo') }}</h5>
                </div>
                <div class="card-body btn-add-site-logo-image cursor-pointer">
                  @if($config && $config->data->site_logo != '')
                    <img id="preview-profile-image" src="{{ asset(config('global.config_path').$config->data->site_logo) }}" width="100%">
                  @else
                    <img id="preview-site-logo-image" src="{{ url('none.png') }}" width="100%">
                  @endif

                  <div class="custom-file">
                    <input type='file' id="input-site-logo-image" class="custom-file-input click-input-site-logo-image" name="site_logo" />
                    <label class="custom-file-label" for="input-site-logo-image">{{ __('Browse') }}</label>
                  </div>
                </div>
              </div>

              <div class="card card-default mb-4">
                <div class="card-header">
                  <h5 class="card-title mb-0">{{ __('Fav Icon') }}</h5>
                </div>
                <div class="card-body btn-add-fav-image cursor-pointer">
                  @if($config && $config->data->fav != '')
                    <img id="preview-profile-image" src="{{ asset(config('global.config_path').$config->data->fav) }}" width="100%">
                  @else
                    <img id="preview-fav-image" src="{{ url('none.png') }}" width="100%">
                  @endif

                  <div class="custom-file">
                    <input type='file' id="input-fav-image" class="custom-file-input click-input-fav-image" name="fav" />
                    <label class="custom-file-label" for="input-fav-image">{{ __('Browse') }}</label>
                  </div>
                </div>
              </div>

              <div class="card card-default mb-4">
                <div class="card-header">
                  <h5 class="card-title mb-0">{{ __('Company Logo') }}</h5>
                </div>
                <div class="card-body btn-add-logo-image cursor-pointer">
                  @if($config && $config->data->logo != '')
                    <img id="preview-profile-image" src="{{ asset(config('global.config_path').$config->data->logo) }}" width="100%">
                  @else
                    <img id="preview-logo-image" src="{{ url('none.png') }}" width="100%">
                  @endif

                  <div class="custom-file">
                    <input type='file' id="input-logo-image" class="custom-file-input click-input-logo-image" name="logo" />
                    <label class="custom-file-label" for="input-logo-image">{{ __('Browse') }}</label>
                  </div>
                </div>
              </div>

              <div class="card card-default mb-4">
                <div class="card-header">
                  <h5 class="card-title mb-0">{{ __('Watermark') }}</h5>
                </div>
                <div class="card-body btn-add-watermark-image cursor-pointer">
                  @if($config && $config->data->watermark != '')
                    <img id="preview-profile-image" src="{{ asset(config('global.config_path').$config->data->watermark) }}" width="100%">
                  @else
                    <img id="preview-watermark-image" src="{{ url('none.png') }}" width="100%">
                  @endif

                  <div class="custom-file">
                    <input type='file' id="input-watermark-image" class="custom-file-input click-input-watermark-image" name="watermark" />
                    <label class="custom-file-label" for="input-watermark-image">{{ __('Browse') }}</label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row kt-margin-t-20">
            <div class="col-12 text-right">
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

@section('script')
  <script type="text/javascript">
    $( document ).ready(function() {
      $('.kt-menu__item__setting').addClass(' kt-menu__item--open');
      $('.kt-menu__item__config').addClass(' kt-menu__item--active');

      //Site Logo Image
      $("#input-site-logo-image").change(function() {
        profileImage(this, "#preview-site-logo-image");
      });

      //Logo Image
      $("#input-logo-image").change(function() {
        profileImage(this, "#preview-logo-image");
      });

      //Fav Image
      $("#input-fav-image").change(function() {
        profileImage(this, "#preview-fav-image");
      });

      //Watermark Image
      $("#input-watermark-image").change(function() {
        profileImage(this, "#preview-watermark-image");
      });
    });

    function profileImage(input, output) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $(output).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
  </script>
@endsection