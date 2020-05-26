<div class="row">
  <div class="col-6">
    <div class="row mb-2">
      <div class="col-4 text-right">{{ __("Customer") }}</div>
      <div class="col-1">:</div>
      <div class="col-7">{{ @$sale->customer->name }}</div>
    </div>
    <div class="row mb-2">
      <div class="col-4 text-right">{{ __("Date") }}</div>
      <div class="col-1">:</div>
      <div class="col-7">{{ date("d-M-Y", strtotime(@$sale->date)) }}</div>
    </div>
  </div>
  <div class="col-6">
    <div class="row mb-2">
      <div class="col-4 text-right">{{ __("Reference Code") }}</div>
      <div class="col-1">:</div>
      <div class="col-7">#{{ @$sale->ref_no }}</div>
    </div>
    <div class="row mb-2">
      <div class="col-4 text-right">{{ __("Office") }}</div>
      <div class="col-1">:</div>
      <div class="col-7">{{ $sale->office->name }}</div>
    </div>
    <div class="row mb-2">
      <div class="col-4 text-right">{{ __("Staff") }}</div>
      <div class="col-1">:</div>
      <div class="col-7">{{ $sale->staff->name }}</div>
    </div>
    <div class="row mb-2">
      <div class="col-4 text-right">{{ __("Collector") }}</div>
      <div class="col-1">:</div>
      <div class="col-7">
        @foreach(@$sale->sale_detail->property->collector as $key => $collector)
          {{ $collector->staff->name }} {{ $key>0 ? ', ' : '' }}
        @endforeach
      </div>
    </div>
    <div class="row mb-2">
      <div class="col-4 text-right">{{ __("Type") }}</div>
      <div class="col-1">:</div>
      <div class="col-7">
        {{-- @if($sale->type == Constants::TYPE_SALE) --}}
        @if(@$sale->sale_detail->property->listing_type == "sale")
          <span class="badge badge-info">{{ __("Sale") }}</span>
        @else
          <span class="badge badge-danger">{{ __("Rent") }}</span>
        @endif
        {{-- @else
        <span class="badge badge-secondary">{{ __("Deposit") }}</span>
        @endif --}}
      </div>
    </div>
    @if(isset($sale->data->contract) && file_exists(base_path().'/public'.config("global.contract_path").$sale->data->contract))
    <div class="row mb-2">
      <div class="col-4 text-right">{{ __("Attachment") }}</div>
      <div class="col-1">:</div>
      <div class="col-7">
        <a href="{{ asset(config('global.contract_path').$sale->data->contract) }}" title="" target="_blank">
          {{ __('View Attachment') }}
        </a>
      </div>
    </div>
    @endif
  </div>
</div>

<div class="row" style="display: {{ $sale->type == Constants::TYPE_SALE && @$sale->sale_detail->property->listing_type == 'rent' ? "" : "none" }}">
  <div class="col-6">
    <div class="row">
      <div class="col-4 text-right">{{ __("Start Date") }}</div>
      <div class="col-1">:</div>
      <div class="col-7">{{ date("d-M-Y", strtotime(@$sale->start_date)) }}</div>
    </div>
  </div>
  <div class="col-6">
    <div class="row">
      <div class="col-4 text-right">{{ __("End Date") }}</div>
      <div class="col-1">:</div>
      <div class="col-7">{{ date("d-M-Y", strtotime(@$sale->start_date)) }}</div>
    </div>
  </div>
</div>

<table class="table table-hover table-property-list">
  <thead>
    <th width="70px">#</th>
    <th width="120">{{ __("Code") }}</th>
    <th>{{ __("Title") }}</th>
    <th>{{ __("Commission") }}</th>
    <th width="150">{{ __("Price") }}</th>
  </thead>
  <tbody>
    <tr>
      <td>001</td>
      <td>{{ @$sale->sale_detail->property->code }}</td>
      <td>{{ @$sale->sale_detail->property->title }}</td>
      {{-- <td>{{ @$sale->sale_detail->qty }}</td> --}}
      <td>{!!  @$sale->commission !!}</td>
      <td>{{ "$ ". number_format(@$sale->sale_detail->price, 2) }}</td>
    </tr>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="4" class="text-right" style="vertical-align: middle">
        <span class="font-weight-bold">{{ __("Actual Price Commission") }}:</span>
      </td>
      <td>
        <span class="sub_total text-primary">$ {{ number_format(@$sale->data->actual_price_commission, 2) }}</span>
      </td>
    </tr>
    <tr>
      <td colspan="4" class="text-right" style="vertical-align: middle">
        <span class="font-weight-bold">{{ __("Tax") }} ({{ @$sale->data->tax }}%):</span>
      </td>
      <td>
        <span class="sub_total text-primary">$ {{ number_format((@$sale->data->tax_amount), 2) }}</span>
      </td>
    </tr>
    <tr>
      <td colspan="4" class="text-right" style="vertical-align: middle">
        <span class="font-weight-bold">{{ __("Collector") }} ({{ @$sale->data->collector }}%):</span>
      </td>
      <td>
        <span class="sub_total text-primary">$ {{ number_format((@$sale->data->collector_amount), 2) }}</span>
      </td>
    </tr>
    <tr>
      <td colspan="4" class="text-right" style="vertical-align: middle">
        <span class="font-weight-bold">{{ __("Seller") }} ({{ @$sale->data->seller }}%):</span>
      </td>
      <td>
        <span class="sub_total text-primary">$ {{ number_format((@$sale->data->seller_amount), 2) }}</span>
      </td>
    </tr>
    {{-- <tr style="display: {{ @$sale->type ==  Constants::TYPE_DEPOSIT ? "none" : "" }};">
      <td colspan="4" class="text-right" style="vertical-align: middle">
        <span class="font-weight-bold">{{ __("Discount") }}:</span>
      </td>
      <td>
        <span class="sub_total text-primary">$ {{ number_format(@$sale->sub_total * @$sale->discount / 100, 2) }}</span>
      </td>
    </tr> --}}
    {{-- @if(@$sale->property->listing_type == 'rent')
    <tr>
      <td colspan="4" class="text-right" style="vertical-align: middle">
        <span class="font-weight-bold">{{ __("Deposit") }}:</span>
      </td>
      <td>
        <span class="text-primary">{{ @$sale->deposit }}</span>
      </td>
    </tr>
    @endif --}}
    {{-- <tr style="display: {{ @$sale->type ==  Constants::TYPE_DEPOSIT ? "none" : "" }};">
      <td colspan="4" class="text-right">
        <span class="font-weight-bold">{{ __("Commission") }}:</span>
      </td>
      <td>
        <span class="total-commission text-primary">{{ @$sale->commission }}</span>
      </td>
    </tr> --}}
    <tr style="">
      <td colspan="4" class="text-right" style="vertical-align: middle">
        <span class="font-weight-bold">{{ __("Balance") }}:</span>
      </td>
      <td>
        <span class="total-amount text-primary">$ {{ number_format(@$sale->data->balance, 2) }}</span>
      </td>
    </tr>
  </tfoot>
</table>