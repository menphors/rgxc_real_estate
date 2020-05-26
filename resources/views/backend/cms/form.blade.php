@extends('backend.app')
@section("title")
{{ __('CMS') }}
@endsection
@section("style")
@endsection
@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        @include("backend.partial.message")
        <form action="{{ route("administrator.cms-store") }}" method="post" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="hidden_id" value="{{ @$cms->id }}">
          <div class="row">
            <div class="col-12">
              <label for="cms_type">{{ __("CMS Type") }}</label>
              <select name="cms_type" class="form-control">
                <option value="">{{ __("Please Select") }}</option>
                @foreach(Constants::CMS_TYPE as $key => $type)
                  <option value="{{ $key }}" {{ old("cms_type", @$cms->type) == $key ? "selected" : "" }}>{{ $type }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <br/>
          <div class="row">
            <div class="col-12">
              <label for="blog_type">{{ __("Blog Type") }}</label>
              <select name="blog_type" class="form-control">
                <option value="" selected>{{ __("Please Select") }}</option>
              </select>
            </div>
          </div>
          <br>
          <div class="form-group">
            <label for="link">{{__('Link')}}</label>
            <input type="text" name="link" class="form-control" id="link">
          </div>
          <br/>
          <div class="kt-portlet kt-portlet--tabs no-margin-bottom">
            <div class="kt-portlet__head">
              <div class="kt-portlet__head-toolbar">
                <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-success" role="tablist">
                  @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                  <li class="nav-item">
                    <a class="nav-link {{ $localeCode == app()->getLocale() ? 'active' : '' }}" data-toggle="tab" href="#kt_portlet_base_{{$localeCode}}_tab_content" role="tab" aria-selected="true">
                      <img width="20" src="{{ asset("backend/media/flags/".$localeCode.".png") }}" alt="" />&nbsp;{!!$properties['name']!!}
                    </a>
                  </li>
                  @endforeach
                </ul>
              </div>
            </div>
            <div class="kt-portlet__body no-padding ">
              <div class="tab-content">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <div class="tab-pane {{ $localeCode == app()->getLocale() ? 'active' : '' }}" id="kt_portlet_base_{{$localeCode}}_tab_content" role="tabpanel">
                  {{ Form::hidden('lang', $localeCode) }}

                  <div class="kt-portlet">
                    <div class="kt-portlet__head">
                      <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                          ({{$localeCode}})
                        </h3>
                      </div>
                    </div>
                    <div class="kt-form">
                      <div class="kt-portlet__body" style="padding-bottom: 0px;">
                        <div class="row">
                          <div class="col-sm-12">
                            {{Form::myText('title_'.$localeCode, old('title_'.$localeCode, (!is_null(@$cms)? ((@$cms->translate($localeCode)->title) ?? "") : "")), __('Title'), ['placeholder' => __('Enter Title') ], $errors, true)}}
                          </div>
                        </div>

                        <div class="row cms_type_page_widget">
                          <div class="col-sm-12">
                            {{ Form::label('description', __('Description')) }}
                            {{Form::textarea('description_'.$localeCode, old('description_'.$localeCode,   (!is_null(@$cms)? ((@$cms->translate($localeCode)->content) ?? '') : "")), ['class' => 'form-control tinyMCE', 'rows' => 3], $errors, true)}}
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </div>
          <br/>
          <div class="row cms_type_slide_show" style="display: none;">
            <div class="col-lg-12">
              <div class="card card-default">
                <div class="card-header">
                  <h3 class="card-title font-size-1-rem">
                    <a href="javascript:;" class="w-100 btn btn-default btn-sm pull-right btn-add btn-add-profile-image"><small>+ {{ __('add image') }}</small></a>
                  </h3>
                </div>
                <div class="card-body btn-add-profile-image cursor-pointer text-center">
                  <input type='file' id="input-profile-image" class="d-none click-input-profile-image" name="image"  accept="image/*"/>
                  <?php
                  $src = "";
                  if(@$cms->type == Constants::CMS_TYPE_BRAND_CAROUSEL && !empty(@$cms->thumbnail)){
                    $src = asset(config("global.carousel_image_path").@$cms->thumbnail);
                  }elseif(@$cms->type == Constants::CMS_TYPE_SLIDE_SHOW && !empty(@$cms->thumbnail)){
                    $src = asset(config("global.slide_show_image_path").@$cms->thumbnail);
                  }
                  ?>
                  <img id="preview-profile-image" src="{{ $src }}" onerror="this.src='{{ url('images/background/4.jpg') }}'" width="{{ @$cms->type == Constants::CMS_TYPE_BRAND_CAROUSEL ? "300px" : "100%" }}">
                </div>
              </div>
            </div>
          </div>

          <div class="row kt-margin-t-20">
            <div class="col-12 text-right">
              <a href="{{ route("administrator.cms-index") }}" class="btn btn-danger">
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
  function profileImage(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#preview-profile-image').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  $(function () {
    $('.kt-menu__item__cms').addClass('kt-menu__item--active');


    $("#input-profile-image").change(function() {
      profileImage(this);
    });
    $('.btn-add-profile-image').click(function (e) {
      return $('#input-profile-image')[0].click();
    });

    var editor_config = {
      height: '400px',
      path_absolute : "/",
      selector: "textarea.tinyMCE",
      plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern"
      ],
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
      relative_urls: false,
      file_browser_callback : function(field_name, url, type, win) {
        var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
        var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

        var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
        if (type == 'image') {
          cmsURL = cmsURL + "&type=Images";
        } 
        else {
          cmsURL = cmsURL + "&type=Files";
        }

        tinyMCE.activeEditor.windowManager.open({
          file : cmsURL,
          title : 'Filemanager',
          width : x * 0.8,
          height : y * 0.8,
          resizable : "yes",
          close_previous : "no"
        });
      }
    };

    tinymce.init(editor_config);

    $("select[name='cms_type']").change(function (e) {
      e.preventDefault();
      var value = $(this).find(":selected").val();

      if(value == 1) { //widget blog_type
        var html="<option value='1'>{{ __("Home Page") }}</option>";
        html +="<option value='2'>{{ __("Footer Left") }}</option>";
        html +="<option value='3'>{{ __("Footer Right") }}</option>";
        $("select[name='blog_type']").html(html);
        $(".cms_type_slide_show").hide();
        $(".cms_type_page_widget").show();
      } 
      else if(value == 2) { //page
        var html="<option value='1'>{{ __("Company Profile") }}</option>";
        html +="<option value='2'>{{ __("Service") }}</option>";
        $("select[name='blog_type']").html(html);
        $(".cms_type_slide_show").hide();
        $(".cms_type_page_widget").show();
      } 
      else if(value == 3 || value == 4) { // slide show
        $(".cms_type_page_widget").show();
        $(".cms_type_slide_show").show();
        if(value == 4) {
          $("#preview-profile-image").attr("width", "300");
          $("#preview-profile-image").attr("src", `{{ asset("/images/brand/1.jpg") }}`)
        }
      } 
      else if(value == 5) { // sidebar
        var html="<option value='1'>{{ __("Property Detail") }}</option>";
        $("select[name='blog_type']").html(html);
      } 
      else {
        $("select[name='blog_type']").html("<option value=''>`{{ __("Please Select") }}`</option>");
      }
      $("select[name='blog_type']").val(`{{ !empty(old("blog_type", @$cms->blog))? old("blog_type", @$cms->blog): 1 }}`).trigger("change");
    }).trigger("change");
  })
</script>
@endsection