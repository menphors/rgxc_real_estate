@extends('backend.app')

@section("title")
{{ __('Sale Report') }}
@endsection

@section('content')
<section class="content">
  <div class="container-fluid">
    {{ Form::open(['url' => route('administrator.sale'), 'method' => 'GET', 'id' => 'form-search']) }}
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
            <div class="form-group">
              <label for="staff">{{ __("Staff") }}</label>
              <select name="staff" class="custom-select" id="staff">
                <option value="">{{__('Please Select')}}</option>
                @foreach($staffs as $staff)
                  <option {{ request('staff')==$staff->id ? 'selected' : '' }} value="{{ $staff->id }}">{{ $staff->name ?? $staff->id_card }} ({{ $staff->type }})</option>
                @endforeach
              </select>
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
          <h1 class="text-center py-4">{{__('Sale Report')}}</h1>

          <h5>
            {{__('Report Date')}}: 
            @if((request('startdate')!='' && request('enddate')!='') || (request('startdate')!='' && (request('startdate') < date('d-m-Y'))))
              {{request('startdate')}} - {{ (request('enddate')=='' || request('enddate')==date('d-m-Y')) ? date('d-m-Y') : request('enddate') }}
            @else
              {{ date('d-m-Y') }}
            @endif
          </h5>
          <table class="table table-bordered table-hover table-sm">
            <thead>
              <tr>
                <th>{{ __('Sale Date') }}</th>
                <th>{{ __('Reference Code') }}</th>
                <th>{{ __('Property Code') }}</th>
                <th>{{ __('Type') }}</th>
                <th class="text-right">{{ __('Price') }}</th>
                <th class="text-right">{{ __('Actual Price') }}</th>
                <th class="text-right">{{ __('Actual Commission') }}</th>
                <th class="">{{ __('Tax') }}</th>
                <th>{{ __('Collector Name') }}</th>
                <th class="text-right">{{ __('Collector Commission') }}</th>
                <th>{{ __('Sale Name') }}</th>
                <th class="text-right">{{ __('Sale Commission') }}</th>
                <th>{{ __('Remark') }}</th>
              </tr>
            </thead>
            <tbody>
              @if($sales->count() > 0)
                @foreach($sales as $key => $sale)
                  <tr>
                    <td>{{ $sale->date }}</td>
                    <td>{{ $sale->ref_no }}</td>
                    <td>{{ $sale->sale_detail->property->code }}</td>
                    <td>{{ ucfirst($sale->sale_detail->property->listing_type) }}</td>
                    <td class="text-right">$ {{ number_format($sale->sale_detail->property->price, 2) }}</td>
                    <td class="text-right">$ {{ number_format($sale->amount, 2) }}</td>
                    <td class="text-right">$ {{ number_format($sale->actual_price_commission, 2) }}</td>
                    <td class="text-right">$ {{ $sale->tax_amount }}</td>
                    <td>
                      @foreach($sale->sale_detail->property->collector as $key => $collector)
                        {{ $collector->staff->name }} {{ $key>0 ? ', ' : '' }}
                      @endforeach
                    </td>
                    <td class="text-right">$ {{ number_format($sale->collector_amount, 2) }}</td>
                    <td>{{ $sale->staff->name!='' ? $sale->staff->name : $sale->staff->id_card }}</td>
                    <td class="text-right">$ {{ number_format($sale->seller_amount, 2) }}</td>
                    <td>{{ strip_tags($sale->note) }}</td>
                  </tr>
                @endforeach
              @endif
            </tbody>
          </table>

          <table class="table table-bordered" style="width:70%;float:right;">
            <tbody>
              <tr>
                <th colspan="4" class="text-right" style="padding:0.5rem;">{{ __("Total Rental Price") }}</th>
                <th colspan="2" class="text-right" style="padding:0.5rem;">$ {{ number_format($total['rental_price'], 2) }}</th>
                <th colspan="4" class="text-right" style="padding:0.5rem;">{{ __("Total Actual Commission") }}</th>
                <th colspan="2" class="text-right" style="padding:0.5rem;">$ {{ number_format($total['actual_commission'], 2) }}</th>
              </tr>
              <tr>
                <th colspan="4" class="text-right" style="padding:0.5rem;">{{ __("Total Sale Price") }}</th>
                <th colspan="2" class="text-right" style="padding:0.5rem;">$ {{ number_format($total['sale_price'], 2) }}</th>
                <th colspan="4" class="text-right" style="padding:0.5rem;">{{ __("Total Tax") }}</th>
                <th colspan="2" class="text-right" style="padding:0.5rem;">$ {{ number_format($total['tax'], 2) }}</th>
              </tr>
              <tr>
                <th colspan="4" class="text-right" style="padding:0.5rem;">{{ __("Total Actual Commission for sale") }}</th>
                <th colspan="2" class="text-right" style="padding:0.5rem;">$ {{ number_format($total['sale_commission'], 2) }}</th>
                <th colspan="4" class="text-right" style="padding:0.5rem;">{{ __("Total Sale Commission") }}</th>
                <th colspan="2" class="text-right" style="padding:0.5rem;">$ {{ number_format($total['sale'], 2) }}</th>
              </tr>
              <tr>
                <th colspan="4" class="text-right" style="padding:0.5rem;">{{ __("Total Actual Commission for rent") }}</th>
                <th colspan="2" class="text-right" style="padding:0.5rem;">$ {{ number_format($total['rental_commission'], 2) }}</th>
                <th colspan="4" class="text-right" style="padding:0.5rem;">{{ __("Total Collector Commission") }}</th>
                <th colspan="2" class="text-right" style="padding:0.5rem;">$ {{ number_format($total['collector'], 2) }}</th>
              </tr>
            </tbody>
          </table>
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
      $('.kt-menu__item__sale').addClass(' kt-menu__item--active');

      $(document).on('click', '.btn-print', function() {
        $("#printArea").print();
      });

      $(document).on('click', '.btn-export', function() {
        var wb = XLSX.utils.table_to_book(document.getElementById('printArea'), {sheet: 'Sheet JS'});
        var wbout = XLSX.write(wb, {bookType: 'xlsx', bookSST: true, type: 'binary'});

        saveAs(new Blob([s2ab(wbout)], {type: 'application/octet-stream'}), 'sale-report({{request('startdate')}}).xlsx');
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
    });

    function s2ab(s) {
      var buf = new ArrayBuffer(s.length);
      var view = new Uint8Array(buf);
      for(var i=0; i<s.length; i++) {
        view[i] = s.charCodeAt(i) & 0xFF;
      }
      return buf;
    }
  </script>
@endsection