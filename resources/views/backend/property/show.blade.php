@extends('backend.app')

@section("title")
{{ __('Property Management') }}
@endsection

@section("style")
<style type="text/css">
  /* Tabs*/
  section .section-title {
    text-align: center;
    color: #007b5e;
    text-transform: uppercase;
  }
  #tabs{
    background: #007b5e;
    color: #eee;
  }
  #tabs h6.section-title{
    color: #eee;
  }

  #tabs .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
    color: orange;
    background-color: transparent;
    border-color: transparent transparent #f3f3f3;
    border-bottom: 4px solid !important;
    font-size: 14px;
    font-weight: bold;
  }
</style>
@endsection

@section('content')
  <div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
      <div class="kt-subheader__main">
        <h3 class="kt-subheader__title">{{ __("Property")." #".@$property->code }}</h3>
        <span class="kt-subheader__separator kt-subheader__separator--v"></span>
        <div class="kt-subheader__breadcrumbs">
          @can('property.commission')
            <span class="kt-subheader__breadcrumbs-separator"></span>
            <a href="{{ route('administrator.property-view', $property->id) }}" class="kt-subheader__breadcrumbs-link {{ request("action") == "" || request("action") == "information"? "text-danger" : "" }}" title="{{ __("Information") }}">
              {{ __("Information") }}
            </a>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
          @endcan

          @can('property.gallery')
            <span class="kt-subheader__breadcrumbs-separator"></span>
            <a href="{{ route('administrator.property-view', $property->id) }}?action=gallery" class="kt-subheader__breadcrumbs-link {{ request("action") == "gallery"? "text-danger" : "" }}" title="{{ __("Gallery") }}">
              {{ __("Gallery") }}
            </a>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
          @endcan

          {{-- @can('property.commission')
            <span class="kt-subheader__breadcrumbs-separator"></span>
            <a href="{{ route('administrator.property-view', $property->id) }}?action=commission" class="kt-subheader__breadcrumbs-link {{ request("action") == "commission"? "text-danger" : "" }}" title="{{ __("Setup Commission") }}">
              {{ __("Commission") }}
            </a>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
          @endcan --}}

          @can('property.contract')
            <span class="kt-subheader__breadcrumbs-separator"></span>
            <a href="{{ route('administrator.property-view', $property->id) }}?action=contract" class="kt-subheader__breadcrumbs-link {{ request("action") == "contract"? "text-danger" : "" }}" title="{{ __("Contract") }}">
              {{ __("Contract") }}
            </a>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
          @endcan

          {{-- @can('property.assign-staff')
            <span class="kt-subheader__breadcrumbs-separator"></span>
            <a href="{{ route('administrator.property-view', $property->id) }}?action=assign-staff" class="kt-subheader__breadcrumbs-link {{ request("action") == "assign-staff"? "text-danger" : "" }}" title="{{ __("Assign staff to property") }}">
              {{ __("Staff") }}
            </a>
          @endcan --}}
        </div>
      </div>
      <div class="kt-subheader__toolbar">
        <a href="{{ route('administrator.property-listing') }}" title="{{ __("Assign staff to property") }}" class="text-danger">
          <i class="la la-long-arrow-left"></i>
          {{ __("Back") }}
        </a>
      </div>
    </div>
  </div>

  <br/>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        @include("backend.partial.message")
        <div class="card-body">
          <div class="row">
            <div class="col-12 text-right">
              @if($property->status != Constants::PROPERTY_STATUS["solved"])
                <a href="{{ route('administrator.property.edit', $property->id) }}" class="btn btn-info btn-sm">
                  <i class="la la-pencil"></i>
                  {{ __("Edit") }}
                </a>
              @endif
              @if($property->status ==  Constants::PROPERTY_STATUS["padding"])
                <a href="#" class="btn btn-primary btn-sm send-property-to-office" data-url="{{ route('administrator.send-property-to-office', $property->id) }}">
                  <i class="fa fa-paper-plane"></i>
                  {{ __("Send to office") }}
                </a>
              @elseif($property->status == Constants::PROPERTY_STATUS["submitted"])
                <a href="#" class="btn btn-primary btn-sm property-completed-reviewed" data-url="{{ route('administrator.property-completed-reviewed', $property->id) }}">
                  <i class="fa fa-check"></i>
                  {{ __("Completed reviewed") }}
                </a>
              @elseif($property->status == Constants::PROPERTY_STATUS["reviewed"])
                <a href="#" class="btn btn-primary btn-sm property-published">
                  <i class="fa fa-globe"></i>
                  {{ __("Published to website") }}
                </a>
              @endif
            </div>
          </div>
          <br/>
          @if(request("action") == "gallery")
            @include("backend.property.include.gallery")
            @elseif(request("action") == "commission")
            @include("backend.property.include.commission")
          @elseif(request("action") == "contract")
            @if(request("method") == "add" || request("method") == "edit")
              @include("backend.property.include.add-contract")
            @else
              @include("backend.property.include.contract")
            @endif
          @elseif(request("action") == "assign-staff")
            @include("backend.property.include.assign_to_staff")
          @elseif(request("action") == "payment_transaction")
            @include("backend.property.include.payment_transaction")
          @else
            @include("backend.property.include.information")
          @endif
        </div>
      </div>
    </div>

    <div class="modal fade" id="kt_modal_4" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('administrator.property-published', $property->id) }}" method="POST" id="staff-form">
          @csrf
          <input type="hidden" name="property_id" value="{{ $property->id }}"/>
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">{{ __("Select Sale") }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="staff">{{ __("Staff") }}</label><br/>
                <select name="staff[]" class="form-control select2-multiple" style="width:100%;" multiple>
                  @if($sales->count())
                  @foreach($sales as $sale)
                  <option value="{{ $sale->id }}">{{ @$sale->name }}</option>
                  @endforeach
                  @endif
                </select>
                <div id="staff[]-error" class="error invalid-feedback"></div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">
                <i class="la la-long-arrow-left"></i> {{ __("Back") }}
              </button>
              <button type="submit" class="btn btn-info">
                <i class="fa fa-save"></i>
                {{ __("Save") }}
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <form action="" method="post" id="property-action">
      @csrf
    </form>
  </section>
@endsection

@section("script")
<script src="https://maps.googleapis.com/maps/api/js?key={{ env("GOOGLE_MAPS_KEY") }}&libraries=places&callback=initMap" async defer></script>
<script type="text/javascript">
  $(function () {
    $("select[name='staff[]']").select2({
      maximumSelectionLength: 2
    });
    $('.kt-menu__item__property_block').addClass('kt-menu__item--open');
    $('.kt-menu__item__property').addClass('kt-menu__item--active');

    $(".property-completed-reviewed").click(function (e) {
      e.preventDefault();
      Swal.fire({
        title: `{{ __("are-you-sure") }}`,
        text: `{{ __('completed-reviewed-confirm') }}`,
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: `{{ __("Yes") }}`,
        cancelButtonText: `{{ __("Cancel") }}`
      }).then((result) => {
        if (result.value) {
          var url = $(this).data("url");
          $("#property-action").attr("action", url);
          $("#property-action").submit();
        }
      });
    });

    $(".property-published").click(function (e) {
      e.preventDefault();

      Swal.fire({
        title: `{{ __("are-you-sure") }}`,
        text: `{{ __('published-confirm') }}`,
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: `{{ __("Yes") }}`,
        cancelButtonText: `{{ __("Cancel") }}`
      }).then((result) => {
        if (result.value) {
          $("#kt_modal_4").modal("show");
        }
      });
    });

    $(".send-property-to-office").click(function (e) {
      e.preventDefault();
      Swal.fire({
        title: `{{ __("are-you-sure") }}`,
        text: `{{ __('submit-property-to-office-confirm') }}`,
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: `{{ __("Yes") }}`,
        cancelButtonText: `{{ __("Cancel") }}`
      }).then((result) => {
        if (result.value) {
          var url = $(this).data("url");
          $("#property-action").attr("action", url);
          $("#property-action").submit();
        }
      });
    });

    $(".btn-remove").click(function (e) {
      e.preventDefault();
      var id = $(this).data("id");

      Swal.fire({
        title: `{{ __("are-you-sure") }}`,
        text: `{{ __('delete-confirm') }}`,
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: `{{ __("Yes") }}`,
        cancelButtonText: `{{ __("Cancel") }}`
      }).then((result) => {
        if (result.value) {
          $("#"+id).submit();
        }
      });
    });

    $(".btn-contract-remove").click(function (e) {
      e.preventDefault();
      var id = $(this).data("contract_id");

      Swal.fire({
        title: `{{ __("are-you-sure") }}`,
        text: `{{ __('delete-confirm') }}`,
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: `{{ __("Yes") }}`,
        cancelButtonText: `{{ __("Cancel") }}`
      }).then((result) => {
        if (result.value) {
          console.log(id);
          $("#"+id).submit();
        }
      });
    });

    $('.kt-menu__item__property').addClass(' kt-menu__item--active');

    $('.btn-add-profile-image').click(function (e) {
      return $('#input-profile-image')[0].click();
    });
    $("#input-profile-image").change(function() {
      profileImage(this);
    });

    $('.gallery a').simpleLightbox();
    $("input[name='furniture']").tagsinput();
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
    var myLatLng = {lat: parseFloat(`{{ $property->latitude }}`), lng: parseFloat(`{{ $property->longitude }}`)};

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
@endsection