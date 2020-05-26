@extends('backend.app')

@section("title")
{{ __('Sale') }}
@endsection

@section("style")
@endsection

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            {{ Form::open(['url' => route('administrator.sale-listing'), 'method' => 'GET', 'id' => 'form-search']) }}
            <select name="search" class="form-control">
              <option value="">{{ __("Please Select") }}</option>
              <option value="sale" {{ request("search") == 'sale' ? "selected" : "" }}>{{ __("Sale") }}</option>
              <option value="rent" {{ request("search") == 'rent' ? "selected" : "" }}>{{ __("Rent") }}</option>
              <option value="deposit" {{ request("search") == 'deposit' ? "selected" : "" }}>{{ __("Deposit") }}</option>
            </select>
            {{ Form::close() }}
          </div>
          <div class="col-md-6">
            <button type="button" class="btn btn-info w-100-px" onclick="btnSearch()">
              <i class="fa fa-filter"></i>
              {{ __('Search') }}
            </button>
            <a href="{{ route('administrator.sale-listing') }}" class="btn btn-danger">
              <i class="fa fa-search-minus"></i>
              {{ __('Clear') }}
            </a>
            <a href="{{ route('administrator.sale-add') }}" class="btn btn-info float-right">
              <i class="fa fa-plus"></i>
              {{ __('Add New') }}
            </a>

          </div>
          <div class="clearfix">&nbsp;</div>
        </div>

        <div class="card">
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th width="90px">{!! __("N<sup><u>o</u></sup>") !!}</th>
                  <th>{!! __('Ref no') !!}</th>
                  <th>{{ __("Customer") }}</th>
                  <th>{!! __("Date") !!}</th>
                  <th>{{ __("Property") }}</th>
                  {{-- <th>{{ __("Qty") }}</th> --}}
                  <th>{{ __("Amount") }}</th>
                  <th>{{ __("Commission") }}</th>
                  <th>{{ __("Status") }}</th>
                  <th class="text-right">{{ __('Action') }}</th>
                </tr>
              </thead>
              <tbody>
                @if($sales->count())
                @foreach($sales as $key => $sale)
                <tr>
                  <td>{{ str_pad($key + 1, 2, '0', STR_PAD_LEFT) }}</td>
                  <td><a href="{{ route("administrator.sale-detail", $sale->id) }}">{{ $sale->ref_no }}</a></td>
                  <td>{!! @$sale->customer->name . "<br/>" . @$sale->customer->phone !!}</td>
                  <td>{{ date("d-M-Y", strtotime($sale->date)) }}</td>
                  <td>{!! @$sale->sale_detail->property->code . " " . @$sale->sale_detail->property->title !!}</td>
                  {{-- <td>{!!  @$sale->sale_detail->qty !!}</td> --}}
                  <td>{!!  "$ ". number_format(@$sale->amount, 2) !!}</td>
                  <td>{!!  @$sale->commission !!}</td>
                  <td>
                    {{-- @if($sale->type == Constants::TYPE_SALE) --}}
                    @if(@$sale->sale_detail->property->listing_type == "sale")
                      <span class="badge badge-info">{{ __("Sale") }}</span>
                    @else
                      <span class="badge badge-danger">{{ __("Rent") }}</span>
                    @endif
                    {{-- @else
                    <span class="badge badge-secondary">{{ __("Deposit") }}</span>
                    @endif --}}
                  </td>
                  <td class="text-right">
                    <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-remove" data-url="{!! url('/administrator/sale') !!}" data-id="{!! $sale->id !!}" onclick="deleteItem(this)" title="{{ __('Delete') }}">
                      <i class="la la-trash text-danger"></i>
                    </a>
                  </td>
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
<script type="text/javascript">
  $(function () {
    $('.kt-menu__item__sale').addClass(' kt-menu__item--active');
  })
</script>
@endsection