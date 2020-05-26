@extends('backend.app')

@section("title")
{{ __('Commission Report') }}
@endsection

@section('content')
<section class="content">
  <div class="container-fluid">
    {{ Form::open(['url' => route('administrator.commission'), 'method' => 'GET', 'id' => 'form-search']) }}
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
          <button type="button" id="print" class="btn btn-print btn-sm btn-secondary">{{ __('`Print') }}</button>
          <button type="button" id="export" class="btn btn-sm btn-export btn-warning">{{ __('Export Excel') }}</button>
        </div>
        <div id="printArea">
          <header class="text-center py-5">
            <h4>{{__('Commission Report')}}</h4>
            <p>
              @if((request('startdate')!='' && request('enddate')!='') || (request('startdate')!='' && (request('startdate') < date('d-m-Y'))))
                {{request('startdate')}} - {{ (request('enddate')=='' || request('enddate')==date('d-m-Y')) ? date('d-m-Y') : request('enddate') }}
              @else
                {{ date('d-m-Y') }}
              @endif
            </p>
          </header>
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>N<sup><u>o</u></sup></th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Position') }}</th>
                <th class="text-right">{{ __('Total') }}</th>
                <th>{{ __('Reference Code') }}</th>
              </tr>
            </thead>
            <tbody>
              @if($sales->count() > 0)
              @foreach($sales as $key => $sale)
                <tr>
                  <td>{{ str_pad($key + 1, 2, '0', STR_PAD_LEFT) }}</td>
                  <td>{{ $sale->staff->name!='' ? $sale->staff->name : $sale->staff->id_card }}</td>
                  <td>{{ staff_type($sale->staff->type) }}</td>
                  <td class="text-right">${{ strpos($sale->commission, '%')>0 ? number_format($sale->amount * (substr($sale->commission, 0, -1)/100), 2) : $sale->commission }}</td>
                  <td>{{ $sale->ref_no }}</td>
                </tr>
              @endforeach
              @endif
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
      $('.kt-menu__item__commission').addClass(' kt-menu__item--active');

      $(document).on('click', '.btn-print', function() {
        $("#printArea").print();
      });

      $(document).on('click', '.btn-export', function() {
        var wb = XLSX.utils.table_to_book(document.getElementById('printArea'), {sheet: 'Sheet JS'});
        var wbout = XLSX.write(wb, {bookType: 'xlsx', bookSST: true, type: 'binary'});

        saveAs(new Blob([s2ab(wbout)], {type: 'application/octet-stream'}), 'commission-report({{request('startdate')}}).xlsx');
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