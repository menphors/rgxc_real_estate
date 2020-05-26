@extends('backend.app')

@section("title")
  {{ __('Property Management') }}
@endsection

@section("style")
  <style type="text/css">
    .select2-selection__rendered {
      line-height: 31px !important;
      padding: unset!important;
      padding-left: 20px!important;
    }
    .select2-container .select2-selection--single {
      height: 35px !important;
    }
    .select2-selection__arrow {
      height: 34px !important;
    }
  </style>
@endsection

@section("breadcrumb")
  <li class="breadcrumb-item"><a href="{{ url('/administrator') }}">{{ __('Home') }}</a></li>
  <li class="breadcrumb-item active">{{ __('Property Management') }}</li>
@endsection

<?php
  if(isset($item)) {
    $property_data = json_decode($item->data, true);
  }
?>

@section('content')
{{ Form::open(['url' => $action, 'method'=> "POST", 'enctype' => 'multipart/form-data']) }}
  {!! Form::input('hidden','id', $item->id??'') !!}

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          @if(@$errors->count() > 0)
          <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
            <div class="alert-text">{{ $error }}</div>
            @endforeach
          </div>
          @endif
          <div class="kt-portlet">
            <div class="kt-form">
              <div class="kt-portlet__body no-padding">

                <div class="kt-portlet kt-portlet--tabs no-margin-bottom">
                  <div class="kt-portlet__head">
                    <div class="kt-portlet__head-toolbar">
                      @include("backend.partial.message")
                      <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-success" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link text-center active tab-info" data-toggle="tab" href="#kt_portlet_base_1_tab_content" role="tab" aria-selected="true" data-ktwizard-state="current">
                            <div class="kt-wizard-v1__nav-body">
                              <div class="kt-wizard-v1__nav-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect id="bound" x="0" y="0" width="24" height="24"/>
                                    <path d="M3.95709826,8.41510662 L11.47855,3.81866389 C11.7986624,3.62303967 12.2013376,3.62303967 12.52145,3.81866389 L20.0429,8.41510557 C20.6374094,8.77841684 21,9.42493654 21,10.1216692 L21,19.0000642 C21,20.1046337 20.1045695,21.0000642 19,21.0000642 L4.99998155,21.0000673 C3.89541205,21.0000673 2.99998155,20.1046368 2.99998155,19.0000673 L2.99999828,10.1216672 C2.99999935,9.42493561 3.36258984,8.77841732 3.95709826,8.41510662 Z M10,13 C9.44771525,13 9,13.4477153 9,14 L9,17 C9,17.5522847 9.44771525,18 10,18 L14,18 C14.5522847,18 15,17.5522847 15,17 L15,14 C15,13.4477153 14.5522847,13 14,13 L10,13 Z" id="Combined-Shape" fill="#000000"/>
                                  </g>
                                </svg>
                              </div>
                              <div class="kt-wizard-v1__nav-label">
                                {{ __('Information') }}
                              </div>
                            </div>
                          </a>
                        </li>

                        {{-- <li class="nav-item">
                            <a class="nav-link text-center" data-toggle="tab" href="#kt_portlet_base_3_tab_content" role="tab" aria-selected="true" data-ktwizard-state="current">
                                <div class="kt-wizard-v1__nav-body">
                                    <div class="kt-wizard-v1__nav-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect id="bound" x="0" y="0" width="24" height="24"/>
                                                <rect id="Rectangle" fill="#000000" opacity="0.3" x="11.5" y="2" width="2" height="4" rx="1"/>
                                                <rect id="Rectangle-Copy-3" fill="#000000" opacity="0.3" x="11.5" y="16" width="2" height="5" rx="1"/>
                                                <path d="M15.493,8.044 C15.2143319,7.68933156 14.8501689,7.40750104 14.4005,7.1985 C13.9508311,6.98949895 13.5170021,6.885 13.099,6.885 C12.8836656,6.885 12.6651678,6.90399981 12.4435,6.942 C12.2218322,6.98000019 12.0223342,7.05283279 11.845,7.1605 C11.6676658,7.2681672 11.5188339,7.40749914 11.3985,7.5785 C11.2781661,7.74950085 11.218,7.96799867 11.218,8.234 C11.218,8.46200114 11.2654995,8.65199924 11.3605,8.804 C11.4555005,8.95600076 11.5948324,9.08899943 11.7785,9.203 C11.9621676,9.31700057 12.1806654,9.42149952 12.434,9.5165 C12.6873346,9.61150047 12.9723317,9.70966616 13.289,9.811 C13.7450023,9.96300076 14.2199975,10.1308324 14.714,10.3145 C15.2080025,10.4981676 15.6576646,10.7419985 16.063,11.046 C16.4683354,11.3500015 16.8039987,11.7268311 17.07,12.1765 C17.3360013,12.6261689 17.469,13.1866633 17.469,13.858 C17.469,14.6306705 17.3265014,15.2988305 17.0415,15.8625 C16.7564986,16.4261695 16.3733357,16.8916648 15.892,17.259 C15.4106643,17.6263352 14.8596698,17.8986658 14.239,18.076 C13.6183302,18.2533342 12.97867,18.342 12.32,18.342 C11.3573285,18.342 10.4263378,18.1741683 9.527,17.8385 C8.62766217,17.5028317 7.88033631,17.0246698 7.285,16.404 L9.413,14.238 C9.74233498,14.6433354 10.176164,14.9821653 10.7145,15.2545 C11.252836,15.5268347 11.7879973,15.663 12.32,15.663 C12.5606679,15.663 12.7949989,15.6376669 13.023,15.587 C13.2510011,15.5363331 13.4504991,15.4540006 13.6215,15.34 C13.7925009,15.2259994 13.9286662,15.0740009 14.03,14.884 C14.1313338,14.693999 14.182,14.4660013 14.182,14.2 C14.182,13.9466654 14.1186673,13.7313342 13.992,13.554 C13.8653327,13.3766658 13.6848345,13.2151674 13.4505,13.0695 C13.2161655,12.9238326 12.9248351,12.7908339 12.5765,12.6705 C12.2281649,12.5501661 11.8323355,12.420334 11.389,12.281 C10.9583312,12.141666 10.5371687,11.9770009 10.1255,11.787 C9.71383127,11.596999 9.34650161,11.3531682 9.0235,11.0555 C8.70049838,10.7578318 8.44083431,10.3968355 8.2445,9.9725 C8.04816568,9.54816454 7.95,9.03200304 7.95,8.424 C7.95,7.67666293 8.10199848,7.03700266 8.406,6.505 C8.71000152,5.97299734 9.10899753,5.53600171 9.603,5.194 C10.0970025,4.85199829 10.6543302,4.60183412 11.275,4.4435 C11.8956698,4.28516587 12.5226635,4.206 13.156,4.206 C13.9160038,4.206 14.6918294,4.34533194 15.4835,4.624 C16.2751706,4.90266806 16.9686637,5.31433061 17.564,5.859 L15.493,8.044 Z" id="Combined-Shape" fill="#000000"/>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="kt-wizard-v1__nav-label">
                                        {{ __('Pricing') }}
                                    </div>
                                </div>
                            </a>
                          </li> --}}

                        <li class="nav-item">
                          <a class="nav-link text-center tab-attribute" data-toggle="tab" href="#kt_portlet_base_2_tab_content" role="tab" aria-selected="true" data-ktwizard-state="current">
                            <div class="kt-wizard-v1__nav-body">
                              <div class="kt-wizard-v1__nav-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect id="bound" x="0" y="0" width="24" height="24"/>
                                    <path d="M10.5,5 L19.5,5 C20.3284271,5 21,5.67157288 21,6.5 C21,7.32842712 20.3284271,8 19.5,8 L10.5,8 C9.67157288,8 9,7.32842712 9,6.5 C9,5.67157288 9.67157288,5 10.5,5 Z M10.5,10 L19.5,10 C20.3284271,10 21,10.6715729 21,11.5 C21,12.3284271 20.3284271,13 19.5,13 L10.5,13 C9.67157288,13 9,12.3284271 9,11.5 C9,10.6715729 9.67157288,10 10.5,10 Z M10.5,15 L19.5,15 C20.3284271,15 21,15.6715729 21,16.5 C21,17.3284271 20.3284271,18 19.5,18 L10.5,18 C9.67157288,18 9,17.3284271 9,16.5 C9,15.6715729 9.67157288,15 10.5,15 Z" id="Combined-Shape" fill="#000000"/>
                                    <path d="M5.5,8 C4.67157288,8 4,7.32842712 4,6.5 C4,5.67157288 4.67157288,5 5.5,5 C6.32842712,5 7,5.67157288 7,6.5 C7,7.32842712 6.32842712,8 5.5,8 Z M5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 C6.32842712,10 7,10.6715729 7,11.5 C7,12.3284271 6.32842712,13 5.5,13 Z M5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 C6.32842712,15 7,15.6715729 7,16.5 C7,17.3284271 6.32842712,18 5.5,18 Z" id="Combined-Shape" fill="#000000" opacity="0.3"/>
                                  </g>
                                </svg>
                              </div>
                              <div class="kt-wizard-v1__nav-label">
                                {{ __('Attribute') }}
                              </div>
                            </div>
                          </a>
                        </li>

                        <li class="nav-item">
                          <a class="nav-link text-center tab-location" data-toggle="tab" href="#kt_portlet_base_4_tab_content" role="tab" aria-selected="true" data-ktwizard-state="current">
                            <div class="kt-wizard-v1__nav-body">
                              <div class="kt-wizard-v1__nav-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect id="bound" x="0" y="0" width="24" height="24"/>
                                    <path d="M5,10.5 C5,6 8,3 12.5,3 C17,3 20,6.75 20,10.5 C20,12.8325623 17.8236613,16.03566 13.470984,20.1092932 C12.9154018,20.6292577 12.0585054,20.6508331 11.4774555,20.1594925 C7.15915182,16.5078313 5,13.2880005 5,10.5 Z M12.5,12 C13.8807119,12 15,10.8807119 15,9.5 C15,8.11928813 13.8807119,7 12.5,7 C11.1192881,7 10,8.11928813 10,9.5 C10,10.8807119 11.1192881,12 12.5,12 Z" id="Combined-Shape" fill="#000000" fill-rule="nonzero"/>
                                  </g>
                                </svg>
                              </div>
                              <div class="kt-wizard-v1__nav-label">
                                {{ __('Location') }}
                              </div>
                            </div>
                          </a>
                        </li>

                        <li class="nav-item">
                          <a class="nav-link text-center tab-image" data-toggle="tab" href="#kt_portlet_base_image_tab_content" role="tab" aria-selected="true" data-ktwizard-state="current">
                            <div class="kt-wizard-v1__nav-body">
                              <div class="kt-wizard-v1__nav-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon id="Shape" points="0 0 24 0 24 24 0 24"/>
                                    <rect id="Rectangle-25" fill="#000000" opacity="0.3" x="2" y="4" width="20" height="16" rx="2"/>
                                    <polygon id="Path" fill="#000000" opacity="0.3" points="4 20 10.5 11 17 20"/>
                                    <polygon id="Path-Copy" fill="#000000" points="11 20 15.5 14 20 20"/>
                                    <circle id="Oval-76" fill="#000000" opacity="0.3" cx="18.5" cy="8.5" r="1.5"/>
                                  </g>
                                </svg>
                              </div>
                              <div class="kt-wizard-v1__nav-label">
                                {{ __('Image') }}
                              </div>
                            </div>
                          </a>
                        </li>

                        <li class="nav-item">
                          <a class="nav-link text-center tab-service" data-toggle="tab" href="#kt_portlet_base_service_tab_content" role="tab" aria-selected="true" data-ktwizard-state="current">
                            <div class="kt-wizard-v1__nav-body">
                              <div class="kt-wizard-v1__nav-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon id="Shape" points="0 0 24 0 24 24 0 24"/>
                                    <rect id="Rectangle-89" fill="#000000" opacity="0.3" x="2" y="5" width="20" height="2" rx="1"/>
                                    <rect id="Rectangle-89-Copy-5" fill="#000000" opacity="0.3" x="2" y="17" width="20" height="2" rx="1"/>
                                    <rect id="Rectangle-89-Copy-2" fill="#000000" opacity="0.3" x="2" y="9" width="5" height="2" rx="1"/>
                                    <rect id="Rectangle-89-Copy-4" fill="#000000" opacity="0.3" x="16" y="13" width="6" height="2" rx="1"/>
                                    <rect id="Rectangle-89-Copy-3" fill="#000000" opacity="0.3" x="9" y="9" width="13" height="2" rx="1"/>
                                    <rect id="Rectangle-89-Copy" fill="#000000" opacity="0.3" x="2" y="13" width="12" height="2" rx="1"/>
                                  </g>
                                </svg>
                              </div>
                              <div class="kt-wizard-v1__nav-label">
                                {{ __('Detail') }}
                              </div>
                            </div>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>

                <div class="kt-portlet__body no-padding">
                  <div class="tab-content">
                    @include('backend.property.info')
                    @include('backend.property.attribute')
                    <!-- include('backend.property.pricing') -->
                    @include('backend.property.location')
                    @include('backend.property.image')
                    @include('backend.property.service')
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
{!! Form::close() !!}
@endsection

@section('script')
  <script src="https://maps.googleapis.com/maps/api/js?key={{ env("GOOGLE_MAPS_KEY") }}&libraries=places&callback=initMap" async defer></script>

  @if(isset($item))
    {{ Form::hidden('province_id', $item->province_id ?? '', ['class' => 'edit-project-id']) }}
    <script type="text/javascript">
      (function () {
        var province_id = $('.edit-project-id').val();
        setTimeout(function() {
          $('.province_id').find('option[value="'+ province_id +'"]').prop('selected', true).change();
        }, 3000);
      }).call(this);
    </script>
  @endif

  <script type="text/javascript">
    (function () {
      $("input[name='owner_contact']").tagsinput();

      $("input[name='latitude']").keyup(function () {
        initMap();
      });

      $("input[name='longitude']").keyup(function () {
        initMap();
      });

      $('select[name="property_type"]').change(function (e) {
        e.preventDefault();
        if($(this).val() == 1){ // land
          // $(".type-sqm").html("sqm");
          //  $(".no_land").hide();
        } 
        else {
          //  $(".type-sqm").html("");
          //  $(".no_land").show();
        }
      }).trigger("change");

      $("input[name='property_size']").keyup(function () {
        var value = Number($(this).val());
        var floor_number = Number($("input[name='floor_number']").val());
        var total = parseFloat(value) * parseFloat(floor_number);

        $("input[name='total_build_surface']").val(total);
      });

      $("input[name='floor_number']").keyup(function () {
        var value = Number($(this).val());
        var floor_number = Number($("input[name='property_size']").val());
        var total = parseFloat(value) * parseFloat(floor_number);

        $("input[name='total_build_surface']").val(total);
      });

      $("select[name='listing_type']").change(function (e) {
        e.preventDefault();
        var value = $(this).find(":selected").val();
        if(value == "rent"){
          $(".pricing-type").html(" /month");
        } 
        else {
          $(".pricing-type").html(" ($)");
        }
      });

      $('.summernote').summernote({
        height:250
      });
      $('.kt-menu__item__property_block').addClass(' kt-menu__item--open');
      $('.kt-menu__item__property').addClass(' kt-menu__item--active');

      // Feature Image
      $('.btn-add-profile-image').click(function (e) {
        return $('#input-profile-image')[0].click();
      });
      $("#input-profile-image").change(function() {
        profileImage(this);
      });
      $('.btn-info-click').on('click', function() {
        $('.tab-attribute').trigger('click');
      });
      $('.btn-attribute-click').on('click', function() {
        $('.tab-location').trigger('click');
      });
      $('.btn-location-click').on('click', function() {
        $('.tab-image').trigger('click');
      });
      $('.btn-image-click-back').on('click', function() {
        $('.tab-location').trigger('click');
      });
      $('.btn-location-click-back').on('click', function() {
        $('.tab-attribute').trigger('click');
      });
      $('.btn-attribute-click-back').on('click', function() {
        $('.tab-info').trigger('click');
      });
      $('.btn-image-click').on('click', function() {
        $('.tab-service').trigger('click');
      });
      $('.btn-other-service-click-back').on('click', function() {
        $('.tab-image').trigger('click');
      });
      $("input[name='display_on_maps']").change(function() {
        if(this.checked) {
          $('.is-map').removeClass('d-none');
        } 
        else {
          $('.is-map').addClass('d-none');
        }
      });

      var _token = $('#csrf-token').val();

      $('.province_id').on('change', function (e) {
        var id = $(this).find(":selected").val();
        if(id == ""){
          $('.district_id').html('<option value="">None</option>');
          $('.commune_id').html('<option value="">None</option>');
          $('.village_id').html('<option value="">None</option>');
          return false;
        }
        var get_district_province_url = "{{ url('administrator/property/get-district-province/') }}";

        $('.district_id').html('<option value="">None</option>');
        $('.commune_id').html('<option value="">None</option>');
        $('.village_id').html('<option value="">None</option>');

        $.ajax({
          url: get_district_province_url+'/'+id,
          method: 'GET',
          dataType: "JSON",
          data: { _token:_token },
          success: function(data) {
            var districts = data.districts;
            if(districts.length > 0) {
              $('.district_id').html('<option value="">None</option>');
              $('.district_id').select2(
                {data:districts}
                );
              $('.district_id').val(`{{ old("district", (!empty(@$item->district_id)? @$item->district_id : "")) }}`).trigger("change");
            } 
            else {
              $('.district_id').html('<option value="">None</option>');
              $('.commune_id').html('<option value="">None</option>');
              $('.village_id').html('<option value="">None</option>');
            }
          }
        });
      }).trigger("change");

      $('#kt_modal_1_2').on('hidden.bs.modal', function () {
        $("input[name='name']").val("");
        $("input[name='email']").val("");
        $("input[name='phone']").val("");
        $("input[name='phone2']").val("");
      });
      
      $('.district_id').on('change', function (e) {
        var id = $(this).find(":selected").val();
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
              $('.commune_id').html('<option value="">None</option>');
              $('.commune_id').select2(
                {data:communes}
                );
              $('.commune_id').val(`{{ old("commune", (!empty(@$item->commune_id)? @$item->commune_id : "")) }}`).trigger("change");
            } 
            else {
              $('.commune_id').html('<option value="">None</option>');
              $('.village_id').html('<option value="">None</option>');
            }
          }
        });
      });

      $('.commune_id').on('change', function (e) {
        e.preventDefault();
        var id = $(this).find(":selected").val();
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
              $('.village_id').html('<option value="">None</option>');
              $('.village_id').select2(
                {data:villages}
                );
              $('.village_id').val(`{{ old("village", (!empty(@$item->village_id)? @$item->village_id : "")) }}`).trigger("change");
            } 
            else {
              $('.village_id').html('<option value="">None</option>');
            }
          }
        });
      });

      $('.btn-save-collector').click(function (e) {
        e.preventDefault();

        var url = `{{ route("administrator.property-create-collector") }}`;
        var name = $("input[name='name']").val();
        var email = $("input[name='email']").val();
        var phone1 = $("input[name='phone']").val();
        var phone2 = $("input[name='phone2']").val();
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
          type: "POST",
          url: url,
          data: {_token: CSRF_TOKEN, name: name, email: email, phone1: phone1, phone2: phone2},
          dataType: 'JSON',
          success: function(data) {
            //console.log(data.data);
            if(data.status == true){
              $("#collector").append(data.data);
              $("#kt_modal_1_2").modal("hide");
            }
            else {
              $('.error-message').html(data.message);
            }
          },
          error: function (error) {
            console.log(error);
          }
        });
      });
    }).call(this);

    $(document).ready(function() {
      $("#tags").select2({
        ajax: {
          url: "{{ url('administrator/tag/search') }}",
          dataType: 'json',
          data: function(params) {
            return {
              search: params.term,
              type: 'public'
            };
          },
          processResults: function(data) {
            return {
              results: data
            };
          }
        }
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
      var myLatLng = {lat: parseFloat($('.lat-span').val()), lng: parseFloat($('.lon-span').val())};

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
        document.getElementById('lat-span').innerHTML = latLng.lat();
        document.getElementById('lon-span').innerHTML = latLng.lng();
        $('.lat-span').val(latLng.lat());
        $('.lon-span').val(latLng.lng());
      });
    }
</script>
@stop
