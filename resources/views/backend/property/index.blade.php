@extends('backend.app')

@section("title")
  {{ __('Property Management') }}   
@endsection

@section("breadcrumb")
  <li class="breadcrumb-item"><a href="{{ url('/administrator') }}">{{ __('Home') }}</a></li>
  <li class="breadcrumb-item active">{{ __('Property Management') }}</li>
@endsection

@section("style")
  <link rel="stylesheet" href="{{asset('backend/plugins/easyAutocomplete/easy-autocomplete.min.css')}}">
@endsection

@section('content')
<section class="content">
  <div class="container-fluid">
    {{ Form::open(['url' => route('administrator.property-listing'), 'method' => 'GET', 'id' => 'form-search']) }}
    <div class="card mb-4">
      <div class="card-body">
        <div class="input-group">
          <select name="province" class="custom-select province_id">
            <option value="">{{__('Province')}}</option>
            @foreach($provinces as $key => $province)
              <option {{ request('province')==$key ? 'selected' : '' }} value="{{ $key }}">{{ $province }}</option>
            @endforeach
          </select>
          <select name="district" class="custom-select district_id">
            <option value="">{{__('District')}}</option>
            @if(!empty($districts))
              @foreach($districts as $key => $district)
                <option {{ request('district')==$key? 'selected' : '' }} value="{{ $key }}">{{ $district }}</option>
              @endforeach
            @endif
          </select>
          <select name="commune" class="custom-select commune_id">
            <option value="">{{__('Commune')}}</option>
            @if(!empty($communes))
              @foreach($communes as $key => $commune)
                <option {{ request('commune')==$key? 'selected' : '' }} value="{{ $key }}">{{ $commune }}</option>
              @endforeach
            @endif
          </select>
          <select name="type" class="custom-select listing-type">
            <option value="">{{__('Listing Type')}}</option>
            @foreach(['rent','sale'] as $type)
              <option {{ request('type')==$type ? 'selected' : '' }} value="{{ $type }}">{{ __(ucwords($type)) }}</option>
            @endforeach
          </select>
          <select name="property_type" class="custom-select property-type">
            <option value="">{{__('Property Type')}}</option>
            @foreach($property_types as $property_type)
              <option {{ request('property_type')==$property_type->id ? 'selected' : '' }} value="{{ @$property_type->id }}">{{ @$property_type->title }}</option>
            @endforeach
          </select>
          <select name="status" class="custom-select status">
            <option {{ request('status')=='' ? 'selected' : '' }} value="">{{__('Status')}}</option>
            <option {{ request('status')=='0' ? 'selected' : '' }} value="0">{{__('Pending')}}</option>
            <option {{ request('status')=='1' ? 'selected' : '' }} value="1">{{__('Submitted')}}</option>
            <option {{ request('status')=='2' ? 'selected' : '' }} value="2">{{__('Reviewed')}}</option>
            <option {{ request('status')=='3' ? 'selected' : '' }} value="3">{{__('Published')}}</option>
            <option {{ request('status')=='6' ? 'selected' : '' }} value="6">{{__('Unpublished')}}</option>
            <option {{ request('status')=='4' ? 'selected' : '' }} value="4">{{__('Solved')}}</option>
            {{-- @foreach(['Pending', 'Submitted', 'Reviewed', 'Published', 'Solved'] as $key => $status)
              <option {{request('status')==$key ? 'selected' : ''}} value="{{ $key }}">{{ __($status) }}</option>
            @endforeach --}}
          </select>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        {{ Form::text('q', (request("q") ?? ''), ['class'=>'form-control q', 'placeholder'=>__('Enter Keyword')]) }}
      </div>

      <div class="col-md-6">
        <button type="button" class="btn btn-info w-100-px" onclick="btnSearch()">
          <i class="fa fa-filter"></i>
          {{ __('Search') }}
        </button>
        <a href="{{ route('administrator.property-listing') }}" class="btn btn-danger">
          <i class="fa fa-search-minus"></i>
          {{ __('Clear') }}
        </a>
        @if(isAdmin() || Auth::user()->can('property.create'))
        <a href="{{ route('administrator.property.create') }}" class="btn btn-info float-right">
          <i class="fa fa-plus"></i>
          {{ __('Add New') }}
        </a>
        @endif
        <a href="{{ route('administrator.property.view-trash') }}" class="btn btn-dark mx-1 float-right">
          <i class="la la-trash"></i> 
          {{ __('Trash') }}
        </a>
      </div>
    </div>
    {{ Form::close() }}

    <div class="kt-widget29 mb-3">
      <div class="kt-widget29__content">
        <h3 class="kt-widget29__title">{{__('Total Properties')}} ({{ $total_properties['total'] }})</h3>
        <div class="kt-widget29__item">
          @foreach($total_properties['data'] as $propertyStatus => $propertyTotal)
            <div class="kt-widget29__info">
              <span class="kt-widget29__subtitle">{{ $propertyTotal['label'] }}</span>
              <span class="kt-widget29__stats" style="color:{{ $propertyTotal['color'] }};">{{ $propertyTotal['value'] }}</span>
            </div>
          @endforeach
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body table-responsive p-0">
            @include("backend.partial.message")
            <br/>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center">{!! __("N<sup><u>o</u></sup>") !!}</th>
                  <th>{!! __("Code") !!}</th>
                  <th>{{ __('Property Title') }}</th>
                  <th class="text-right">{{ __('Cost') }}</th>
                  <th class="text-right">{{ __('Price') }}</th>
                  <th>{{ __('Created At') }}</th>
                  <th class="text-center">{{ __('Status') }}</th>
                  <th>{{ __('Publish') }}</th>
                  <th class="text-right">{{ __('Action') }}</th>
                </tr>
              </thead>
              <tbody>
                @if(!empty($properties))
                  @foreach($properties as $key => $property)
                  <tr>
                    <td class="text-center">{{ str_pad($key + 1, 2, '0', STR_PAD_LEFT) }}</td>
                    <td>
                      <a href="{{ route("administrator.property-view", $property->id) }}">
                        {{ $property->code ?? '' }}
                      </a>
                    </td>
                    <td>{{  @$property->code. '-' .$property->title ?? '' }}</td>
                    <td class="text-right">{{"$ ". number_format($property->cost ?? 0, 2) }}</td>
                    <td class="text-right">{{"$ ". number_format($property->price ?? 0, 2) }}</td>
                    <td>{{ Date('d-m-Y', strtotime($property->created_at)) }}</td>
                    <td class="text-center">
                      <?php
                        if(@$property->status == Constants::PROPERTY_STATUS["padding"]) { //padding
                          echo "<span class='badge badge-danger'>". __("Pending")."</span>";
                        } 
                        elseif(@$property->status == Constants::PROPERTY_STATUS["submitted"]) {
                          echo "<span class='badge badge-info'>". __("Submitted")."</span>";
                        } 
                        elseif(@$property->status == Constants::PROPERTY_STATUS["reviewed"]) {
                          echo "<span class='badge badge-primary'>". __("Reviewed")."</span>";
                        } 
                        elseif(@$property->status == Constants::PROPERTY_STATUS["published"]) {
                          echo "<span class='badge badge-success'>". __("Published")."</span>";
                        } 
                        elseif(@$property->status == Constants::PROPERTY_STATUS["solved"]) {
                          echo "<span class='badge badge-dark'>". __("Solved")."</span>";
                        } 
                        elseif(@$property->status == Constants::PROPERTY_STATUS["deposit"]) {
                          echo "<span class='badge badge-secondary'>". __("Deposit")."</span>";
                        }
                        elseif(@$property->status == Constants::PROPERTY_STATUS["unpublished"]) {
                          echo "<span class='badge badge-secondary'>". __("Unpublished")."</span>";
                        }
                      ?>
                    </td>
                    <td>
                      @if(@$property->status == Constants::PROPERTY_STATUS["published"])
                        <a href="{{ route("administrator.property-change-state", [$property->id, 0]) }}">
                          <span class='badge badge-info'><i class="fa fa-check"></i></span>
                        </a>
                      @elseif(@$property->status == Constants::PROPERTY_STATUS['unpublished'])
                        <a href="{{ route("administrator.property-change-state", [$property->id, 1]) }}">
                          <span class='badge badge-secondary'><i class="fa fa-times"></i></span>
                        </a>
                      @elseif(@$property->status == Constants::PROPERTY_STATUS['reviewed'])
                        <a href="javascript:void(0);" class="property-published" data-property_id="{{ $property->id }}">
                          <span class='badge badge-secondary'><i class="fa fa-globe"></i></span>
                        </a>
                      @endif
                    </td>
                    <td class="text-right">
                      {{-- <a target="_blank" data-property_id="{{ $property->id }}" href="#" title="{{ __('PDF') }}" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-generate-pdf">
                        <i class="fa fa-file-pdf" aria-hidden="true"></i>
                      </a> --}}

                      <a href="#" data-property_id="{{ $property->id }}" title="{{ __('Link') }}" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-generate-link">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                      </a>

                      @if(@$property->status!=Constants::PROPERTY_STATUS["solved"] && @$property->status!=Constants::PROPERTY_STATUS["deposit"])
                        @if(isAdmin() || Auth::user()->can('property.update'))
                        <a href="{{ route('administrator.property.edit', $property->id) }}" title="{{ __('Edit') }}" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                          <i class="la la-edit"></i>
                        </a>
                        @endif
                        @if(isAdmin() || Auth::user()->can('property.delete'))
                        <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-remove" data-url="{!! url('/administrator/property') !!}" data-id="{!! $property->id !!}" onclick="deleteItem(this)" title="{{ __('Delete') }}">
                          <i class="la la-trash text-danger"></i>
                        </a>
                        @endif
                      @endif
                    </td>
                  </tr>
                  @endforeach
                @else
                  <tr>
                    <td class="text-center" colspan="8">{{ __('No data available.') }}</td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>

        {!! Form::pagination($properties) !!}
        {{-- {{ $properties->appends($requestQuery)->links() }} --}}
      </div>
    </div>
  </div>

  <div class="modal modal-stick-to-bottom fade" id="kt_modal_7" role="dialog" data-backdrop="false" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
      <form action="#" method="get" id="form-generate-pdf-url" target="_blank">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{ __("Agent") }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="property_id" value=""/>
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label for="agent">{{ __("Agent") }}</label>
                  <select name="agent" class="form-control" required>
                    <option value="">{{__("Please Select")}}</option>
                    @if(!empty($agents))
                    @foreach($agents as $agent)
                    <option value="{{ $agent->id }}">{{ @$agent->name . "  (". count($agent->property_link) .")"}}</option>
                    @endforeach
                    @endif
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <label for="language">{{ __("Language") }}</label>
                <select name="data[language]" class="form-control">
                  <option value="en">{{ __("English") }}</option>
                  <option value="cn">{{ __("China") }}</option>
                  <option value="kh">{{ __("Khmer") }}</option>
                </select>
              </div>
            </div>
            <br/>

            <h5 style="border-bottom:1px solid #ddd;padding-bottom:5px;margin-bottom:20px;">
              <div class="">
                <label class="kt-checkbox kt-checkbox--success" style="font-size:18px;margin-bottom:0;">
                  <input type="checkbox" checked value="1" name="checkAll" id="select-all">
                  {{__('Detail')}}
                  <span></span>
                </label>
              </div>
            </h5>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <input type="hidden" name="data[address]" value="0">
                  <label class="kt-checkbox kt-checkbox--success">
                    <input type="checkbox" checked name="data[address]" value="1"> {{ __("Address (House No, Street)") }}
                    <span></span>
                  </label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <input type="hidden" name="data[district]" value="0">
                  <label class="kt-checkbox kt-checkbox--success">
                    <input type="checkbox" checked name="data[district]" value="1"> {{ __("District") }}
                    <span></span>
                  </label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <input type="hidden" name="data[commune]" value="0">
                  <label class="kt-checkbox kt-checkbox--success">
                    <input type="checkbox" checked name="data[commune]" value="1"> {{ __("Commune") }}
                    <span></span>
                  </label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <input type="hidden" name="data[land_mark]" value="0">
                  <label class="kt-checkbox kt-checkbox--success">
                    <input type="checkbox" checked name="data[land_mark]" value="1"> {{ __("Land mark") }}
                    <span></span>
                  </label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <input type="hidden" name="data[map]" value="0">
                  <label class="kt-checkbox kt-checkbox--success">
                    <input type="checkbox" checked name="data[map]" value="1"> {{ __("Map") }}
                    <span></span>
                  </label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <input type="hidden" name="data[owner_contract]" value="0">
                  <label class="kt-checkbox kt-checkbox--success">
                    <input type="checkbox" checked name="data[owner_contract]" value="1"> {{ __("Owner Contract") }}
                    <span></span>
                  </label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <input type="hidden" name="data[commission]" value="0">
                  <label class="kt-checkbox kt-checkbox--success">
                    <input type="checkbox" checked name="data[commission]" value="1"> {{ __("Commission") }}
                    <span></span>
                  </label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <input type="hidden" name="data[owner]" value="0">
                  <label class="kt-checkbox kt-checkbox--success">
                    <input type="checkbox" checked name="data[owner]" value="1"> {{ __("Owner Contact") }}
                    <span></span>
                  </label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <input type="hidden" name="data[collector]" value="0">
                  <label class="kt-checkbox kt-checkbox--success">
                    <input type="checkbox" checked name="data[collector]" value="1"> {{ __("Collector") }}
                    <span></span>
                  </label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <input type="hidden" name="data[gallery]" value="0">
                  <label class="kt-checkbox kt-checkbox--success">
                    <input type="checkbox" checked name="data[gallery]" value="1"> {{ __("Gallery") }}
                    <span></span>
                  </label>
                </div>
              </div>
              {{-- <div class="col-md-4">
                <div class="form-group">
                  <input type="hidden" name="data[street]" value="0">
                  <label class="kt-checkbox kt-checkbox--success">
                    <input type="checkbox" checked name="data[street]" value="1"> {{ __("Street") }}
                    <span></span>
                  </label>
                </div>
              </div> --}}
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">
              <i class="la la-long-arrow-left">&nbsp;</i>
              {{ __("Close") }}
            </button>
            <button type="submit" class="btn btn-primary">
              <i class="fa fa-save"></i>
              {{ __("Save") }}
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection

@section('script')
  <script src="{{ asset('backend/plugins/easyAutocomplete/jquery.easy-autocomplete.js') }}"></script>
  <script type="text/javascript">
    var _token = $('#csrf-token').val();

    $( document ).ready(function() {
      $('.kt-menu__item__property_block').addClass(' kt-menu__item--open');
      $('.kt-menu__item__property').addClass(' kt-menu__item--active');

      $("#form-generate-pdf-url").validate();
      $(".btn-generate-pdf").click(function (e) {
        e.preventDefault();
        var property_id = $(this).data("property_id");
        $("input[name='property_id']").val(property_id);

        var url = `{{ route("administrator.property-generate-pdf", ":property_id") }}`;
        url = url.replace(':property_id', property_id);
        $("#form-generate-pdf-url").attr("action", url);
        $("#kt_modal_7").modal("show");
      });

      $(".btn-generate-link").click(function (e) {
        e.preventDefault();
        var property_id = $(this).data("property_id");
        $("input[name='property_id']").val(property_id);

        var url = `{{ route("administrator.property-generate-link", ":property_id") }}`;
        url = url.replace(':property_id', property_id);
        $("#form-generate-pdf-url").attr("action", url);
        $("#kt_modal_7").modal("show");
      });

      $(".property-published").click(function (e) {
        e.preventDefault();
        var property_id = $(this).data('property_id');

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
            window.location.href = "{{ url('administrator/property/published') }}" + '/' + property_id + '?all=1';

            // $("input[name='property_id']").val(property_id);
            // $("#kt_modal_4").modal("show");
          }
        });
      });
    });

    $("input[name='q']").easyAutocomplete({
      url: function(phrase) {
        return "{{ url('administrator/suggestion') }}";
      },
      getValue: function(element) {
        return element.suggestion;
      },
      ajaxSettings: {
        dataType: "json",
        method: "GET",
        data: {
          dataType: "json"
        }
      },
      preparePostData: function(resp) {
        resp.query = $("input[name='q']").val();
        return resp;
      },
      requestDelay: 100,
      list: {
        onClickEvent: function() {
          var value = $("input[name='q']").getSelectedItemData();
          $("input[name='q']").val(value.code);
          $("#form-search").submit();
        }
      }
    });

    $(document).on('change', '.province_id', function (e) {
      var id = $(this).find(":selected").val();
      if(id == "") {
        $('.district_id').html('<option value="">{{__('District')}}</option>');
        // return false;
      }
      var get_district_province_url = "{{ url('administrator/property/get-district-province/') }}";

      $('.district_id').html('<option value="">{{__('District')}}</option>');

      $.ajax({
        url: get_district_province_url+'/'+(id!='' ? id : 0),
        method: 'GET',
        dataType: "JSON",
        data: { _token:_token },
        success: function(data) {
          var districts = data.districts;
          if(districts.length > 0) {
            // $('.district_id').select2({data:districts});
            var outputDistrict = '<option value="">{{__('District')}}</option>';
            $.each(districts, function(key, value) {
              outputDistrict += "<option value='" + value.id + "'>" + value.text + "</option>";
            });
            $('.district_id').html(outputDistrict);
            $(".district_id").val({{ request('district') }});
            $(".district_id").trigger('change');
          } 
          else {
            $('.district_id').html('<option value="">{{__('District')}}</option>');
          }
          // search();
        }
      });
    }).trigger('change');

    $(document).on('change', '.district_id', function(e) {
      var id = $(this).find(":selected").val();
      if(id == "") {
        $('.commune_id').html('<option value="">{{__('Commune')}}</option>');
        // return false;
      }

      const url = "{{ url('administrator/property/get-commune-district/') }}";
      $.ajax({
        url: url+'/'+(id!='' ? id : 0),
        method: 'GET',
        dataType: "JSON",
        data: { _token:_token },
        success: function(data) {
          var commune = data.communes;
          if(commune.length > 0) {
            var outputCommune = '<option value="">{{__('Commune')}}</option>';
            $.each(commune, function(key, value) {
              outputCommune += "<option value='" + value.id + "'>" + value.text + "</option>";
            });
            $('.commune_id').html(outputCommune);
            $(".commune_id").val({{ request('commune') }});
            $(".commune_id").trigger('change');
          } 
          else {
            $('.commune_id').html('<option value="">{{__('Commune')}}</option>');
          }
          // search();
        }
      });
    }).trigger('change');
    // $(document).on('change', '.listing-type', function(e) {
    //   e.preventDefault();
    //   search();
    // });
    // $(document).on('change', '.property-type', function(e) {
    //   e.preventDefault();
    //   search();
    // });
    // $(document).on('change', '.status', function(e) {
    //   e.preventDefault();
    //   search();s
    // });

    $('#select-all').click(function(event) {
      if(this.checked) {
        // Iterate each checkbox
        $(':checkbox').each(function() {
          this.checked = true;
        });
      } 
      else {
        $(':checkbox').each(function() {
          this.checked = false;
        });
      }
    });

    function search() {
      const params = jQuery.param({
        q: $(".q").val(),
        province: $(".province_id").val(),
        district: $(".district_id").val(),
        type: $(".listing-type").val(),
        property_type: $(".property-type").val(),
        status: $(".status").val()
      });
      const windowLocation = window.location;
      window.location.href = windowLocation.origin + windowLocation.pathname + "?" + params;
    }
  </script>
@stop