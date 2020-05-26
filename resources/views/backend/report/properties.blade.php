@extends('backend.app')

@section("title")
{{ __('Property Report') }}
@endsection

@section('content')
<section class="content">
  <div class="container-fluid">
    {{ Form::open(['url' => route('administrator.properties'), 'method' => 'GET', 'id' => 'form-search']) }}
    <div class="card mb-4">
      <div class="card-body">
        <div class="row">
          <div class="col-sm-3">
            <div class="form-group">
              <label for="start-date">{{ __("Start Date") }}</label>
              <div class="input-group date">
                <input type="text" class="form-control" readonly value="{{request('startdate')}}" name="startdate" id="start-date">
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <label for="end-date">{{ __("End Date") }}</label>
              <div class="input-group date">
                <input type="text" class="form-control" readonly value="{{request('enddate')}}" name="enddate" id="end-date">
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <button type="button" class="btn btn-info btn-block" onclick="btnSearch()" style="margin-top:26px;">
              <i class="fa fa-filter"></i>
              {{ __('Search') }}
            </button>
          </div>
        </div>
      </div>
    </div>
    {{ Form::close() }}

    <div class="card">
      <div class="card-body">
        <div class="text-right">
          <button type="button" id="print" class="btn btn-sm btn-print btn-secondary">{{ __('Print') }}</button>
          <button type="button" id="export" class="btn btn-sm btn-export btn-warning">{{ __('Export Excel') }}</button>
        </div>
        <div id="printArea" class="table-responsive">
          <header class="d-flex justify-content-around align-items-center pt-3">
            @if($config->data->logo != '')
              <img src="{{ asset(config('global.config_path').$config->data->logo) }}" alt="" style="height:74px;">
            @endif

            <div class="text-muted">
              <h4>{{ $config->data->site_name }}</h4>
              <p class="mb-0">{!! $config->data->address !!}</p>
            </div>
          </header>
          <h1 class="text-center py-4">{{__('Property Report')}}</h1>

          <h5>
            {{__('Report Date')}}: 
            @if((request('startdate')!='' && request('enddate')!='') || (request('startdate')!='' && (request('startdate') < date('d-m-Y'))))
              {{request('startdate')}} - {{ (request('enddate')=='' || request('enddate')==date('d-m-Y')) ? date('d-m-Y') : request('enddate') }}
            @else
              {{ date('d-m-Y') }}
            @endif
          </h5>
          <div class="table-responsive">
            <table class="table table-bordered table-hover table-sm">
              <thead>
                <tr>
                  <td class="text-center">#</td>
                  <th>{{ __('Property Code') }}</th>
                  <th>{{ __('Property Title') }}</th>
                  <th>{{ __('Owner Contact') }}</th>
                  <th>{{ __('Collector') }}</th>
                  <th class="text-center">{{ __('Property Type') }}</th>
                  <th class="text-center">{{ __('Listing Type') }}</th>
                  <th class="text-right">{{ __('Cost') }}</th>
                  <th class="text-right">{{ __('Price') }}</th>
                  <th class="text-left">{{ __('Province') }}</th>
                  <th class="text-left">{{ __('District') }}</th>
                  <th class="text-left">{{ __('Commune') }}</th>
                  <th class="text-left">{{ __('Village') }}</th>
                  <th>{{ __('Size') }}</th>
                  <th>{{ __('Floor number') }}</th>
                  <th>{{ __('Bed room') }}</th>
                  <th>{{ __('Bath room') }}</th>
                  <th>{{ __('Front refer to') }}</th>
                  <th>{{ __('Year of renovation') }}</th>
                  <th>{{ __('Year of construction') }}</th>
                  <th>{{ __('Built up surface') }}</th>
                  <th>{!! __('Habitable surface') !!}</th>
                  <th>{{ __('Ground surface') }}</th>
                  <th>{{ __('Amenities') }}</th>
                  {{-- <th class="text-left" style="width:90px;">{{ __('Share Map') }}</th> --}}
                  <th class="text-left">{{ __('Created At') }}</th>
                  <th>{{ __('Remark') }}</th>
                  <th class="text-center">{{ __('Status') }}</th>
                </tr>
              </thead>
              <tbody>
                @if($properties->count() > 0)
                  @foreach($properties as $key => $property)
                    <tr>
                      <td class="text-center">{{ $key+1 }}</td>
                      <td>{{ (string)$property->code }}</td>
                      <td>{{ $property->title }}</td>
                      <td>{{ $property->data->owner_contact }}</td>
                      <td>
                        @if(!empty(@$property->collector))
                          @foreach(@$property->collector as $key => $collector)
                            {{ @$collector->staff->name }}{{ $key>0 ? ', ' : '' }}
                          @endforeach
                        @endif
                      </td>
                      <td>{{ @$property->property_type->title }}</td>
                      <td class="text-center">{{ ucfirst($property->listing_type) }}</td>
                      <td class="text-right">$ {{ number_format($property->cost, 2) }}</td>
                      <td class="text-right">$ {{ number_format($property->price, 2) }}</td>
                      <td class="text-left">{{ @$property->province->title ?? '' }}</td>
                      <td class="text-left">{{ @$property->district->title ?? '' }}</td>
                      <td class="text-left">{{ @$property->commune->title ?? '' }}</td>
                      <td class="text-left">{{ @$property->village->title ?? '' }}</td>
                      <td>{{ number_format($property->property_size, 2) }}m<sup>2</sup></td>
                      <td>{{ $property->floor_number }}</td>
                      <td>{{ $property->bed_room }}</td>
                      <td>{{ $property->bath_room }}</td>
                      <td>{!! @config('data.admin.front_refer_to')[\LaravelLocalization::getCurrentLocale()][@$property->front_refer_to] !!}</td>
                      <td>{!! $property->year_of_renovation !!}</td>
                      <td>{!! $property->year_of_construction !!}</td>
                      <td>{!! number_format($property->built_up_surface, 2) !!}m<sup>2</sup></td>
                      <td>{!! $property->habitable_surface !!}</td>
                      <td>{!! number_format($property->ground_surface, 2) !!}m<sup>2</sup></td>
                      <td>
                        @if(@$property->has_swimming_pool)
                          {{__('Has swimming pool')}}, 
                        @endif
                        @if(@$property->has_elevator)
                          {{__('Has elevator')}}, 
                        @endif
                        @if(@$property->has_basement)
                          {{__('Has basement')}}, 
                        @endif
                        @if(@$property->has_parking)
                          {{__('Has Parking')}}, 
                        @endif
                        {{ $property->data->amentities }}
                      </td>
                      {{-- <td style="width:90px;">{!! $property->data->share_maps_link !!}</td> --}}
                      <td class="text-left">{{ $property->created_at }}</td>
                      <td>{{ strip_tags(@$property->remark) }}</td>
                      <td class="text-center">{{ $property->status }}</td>
                    </tr>
                  @endforeach
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section("script")
  <script src="{{ asset('backend/js/jQuery.print.js') }}" type="text/javascript"></script>
  <script src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js" type="text/javascript"></script>
  <script src="https://unpkg.com/blob.js@1.0.1/Blob.js" type="text/javascript"></script>
  <script src="https://unpkg.com/file-saver@1.3.3/FileSaver.js" type="text/javascript"></script>
  <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
  <script type="text/javascript">
    $(function () {
      $('.kt-menu__item__report_block').addClass(' kt-menu__item--open');
      $('.kt-menu__item__properties').addClass(' kt-menu__item--active');

      $(document).on('click', '.btn-print', function() {
        $("#printArea").print();
      });

      $(document).on('click', '.btn-export', function() {
        var wb = XLSX.utils.table_to_book(document.getElementById('printArea'), {sheet: 'Sheet JS'});
        var wbout = XLSX.write(wb, {bookType: 'xlsx', bookSST: true, type: 'binary'});

        saveAs(new Blob([s2ab(wbout)], {type: 'application/octet-stream'}), 'property-report({{request('startdate')}}).xlsx');
      });

      $("#start-date").datepicker({
        uiLibrary: 'bootstrap4',
        format: 'dd-mm-yyyy',
        iconsLibrary: 'fontawesome',
      });

      $("#end-date").datepicker({
        uiLibrary: 'bootstrap4',
        format: 'dd-mm-yyyy',
        iconsLibrary: 'fontawesome',
        minDate: function() {
          return $('#start-date').val();
        }
      });

      function s2ab(s) {
        var buf = new ArrayBuffer(s.length);
        var view = new Uint8Array(buf);
        for(var i=0; i<s.length; i++) {
          view[i] = s.charCodeAt(i) & 0xFF;
        }
        return buf;
      }
    });
  </script>
@endsection