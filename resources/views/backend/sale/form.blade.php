@extends('backend.app')
@section("title")
{{ __('Sale') }}
@endsection

@section("style")
  <link rel="stylesheet" href="{{asset('backend/plugins/easyAutocomplete/easy-autocomplete.min.css')}}">
  <style>
    .spinner {width:100%;height:100%;position:fixed;top:0;left:0;z-index:99;background-color:rgba(0,0,0,0.4);}
    .form-control[readonly] {background-color:#f7f8fa!important;}
    .easy-autocomplete-container { z-index: 9; }
  </style>
@endsection

@section('content')
<div id="loading-popup" style="display:none;">
  <div class="d-flex justify-content-center align-items-center spinner">
    <div class="spinner-border text-warning" style="width: 3rem; height: 3rem;" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <form action="{{ route("administrator.store-sale") }}" method="post" id="sale-form" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label for="sale_date">{{ __("Sale Date") }} <span class="text-danger">*</span></label>
                <div class="input-group date">
                  <input type="text" class="form-control @error('sale_date') is-invalid @enderror" required readonly placeholder="{{ __("Select Date") }}" value="{{old("sale_start", date("d-m-Y"))}}" name="sale_date" id="sale-date">
                </div>
                @if ($errors->has('sale_date'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('sale_date') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="sale_date">{{ __("Reference Code") }} <span class="text-danger">*</span></label>
                <input type="text" value="{{ old('ref_no', $reference_no) }}" placeholder="ref no" required name="ref_no" id="ref-no" class="form-control @error('ref_no') is-invalid @enderror"/>
                @if ($errors->has('ref_no'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('ref_no') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="office">{{ __("Office") }} <span class="text-danger">*</span></label>
                <select name="office" class="custom-select" id="office" required>
                  <option value="">{{ __("Please Select") }}</option>
                  @if(!is_null($offices))
                    @foreach($offices as $office)
                      <option value="{{ $office->id }}">{{ $office->name }}</option>
                    @endforeach
                  @endif
                </select>
                @if ($errors->has('office'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('office') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="staff">{{ __("Staff") }} <span class="text-danger">*</span></label>
                <select name="staff" class="custom-select" id="staff" required>
                  <option value="">{{ __("Please Select") }}</option>
                  @if(!is_null($staffs))
                    @foreach($staffs as $staff)
                      <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                    @endforeach
                  @endif
                </select>
                @if ($errors->has('staff'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('staff') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="customer">{{ __("Customer") }} <span class="text-danger">*</span></label>
                <select name="customer" class="form-control selectpicker" id="customer" data-live-search="true" required>
                  <option value="">{{ __("Please Select") }}</option>
                  @if(!is_null($customers))
                    @foreach($customers as $customer)
                      <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                  @endif
                </select>
                @if ($errors->has('customer'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('customer') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="collectors">{{ __("Collector") }}</label>
                <input type="text" value="" readonly id="collectors" class="form-control"/>
                <input type="hidden" value="" name="collectors" readonly/>
              </div>
            </div>
          </div>

          <div class="card border-warning mb-4">
            <div class="card-header">
              <h4 class="mb-0">{{ __("Property") }}</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="property">{{ __("Property") }} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control property" required placeholder="{{ __('Property Code') }}" autocomplete="off">
                    <input type="hidden" name="property" value="{{old('property')}}">
                    {{-- <select name="property" class="form-control selectpicker property" data-live-search="true" required>
                      <option value="">{{ __("Please Select") }}</option>
                      @if(!is_null($properties))
                        @foreach($properties as $property)
                          <option value="{{ $property->id }}" data-code="{{ $property->code }}" data-title="{{ $property->title }}" data-price="{{ $property->price }}" data-listing_type="{{ ucfirst($property->listing_type) }}">{{ $property->code. " -- ". $property->title }}</option>
                        @endforeach
                      @endif
                    </select> --}}
                  </div>
                </div>
                <div class="col-md-4 col-sm-6 sale_type">
                  <div class="form-group">
                    <label for="listing-type">{{ __("Type") }}</label>
                    <input type="text" class="form-control" readonly value="{{old("listing_type")}}" name="listing_type" id="listing-type">
                  </div>
                </div>
              </div>

              <div class="row property-type-rent rental-things">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="start_date">{{ __("Start Date") }} <span class="text-danger">*</span></label>
                    <div class="input-group date">
                      <input type="text" class="form-control" readonly placeholder="{{ __("Select Date") }}" value="{{old("estimate_start", date("d-m-Y"))}}" name="start_date" id="start-date">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="month-of-contract">{{ __("Year Of Contract") }} <span class="text-danger">*</span></label>
                    <select name="month_of_contract" class="custom-select" id="month-of-contract" data-live-search="true"></select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="end_date">{{ __("End Date") }}</label>
                    <div class="input-group date">
                      <input type="text" class="form-control" readonly placeholder="{{ __("Select Date") }}" value="{{ old("estimate_completion", date("d-m-Y", strtotime("+1 month"))) }}" name="end_date" id="end-date">
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-4 rental-things">
                  <div class="form-group">
                    <label for="deposit">{{ __("Deposit") }}</label>
                    <input type="text" value="{{ old('deposit') }}" placeholder="" name="deposit" id="deposit" class="form-control"/>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="price">{{ __("Rental Price") }}</label>
                    <input type="text" value="{{ old('price', 0) }}" placeholder="" name="price" id="price" class="form-control"/>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="commission">{{ __("Commission") }}</label>
                    <div class="input-group">
                      <input type="text" value="{{ old('commission', 0) }}" placeholder="" name="commission" id="commission" class="form-control"/>
                      <input type="text" readonly value="{{ old('commission_amount') }}" placeholder="" name="commission_amount" id="commission-amount" class="form-control"/>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="actual-price">{{ __("Actual Price") }}</label>
                    <input type="text" value="{{ old('actual_price', 0) }}" name="actual_price" id="actual-price" class="form-control"/>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="actual-price-commission">{{ __("Actual Price Commission") }}</label>
                    <input type="text" value="{{ old('actual_price_commission', 0) }}" name="actual_price_commission" id="actual-price-commission" class="form-control"/>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4 col-sm-6">
              <div class="form-group">
                <label for="payment-method">{{ __("Payment Method") }} <span class="text-danger">*</span></label>
                <select name="payment_method" class="custom-select @error('sale_date') is-invalid @enderror" id="payment-method" required>
                  <option value="">{{ __("Please Select") }}</option>
                  <option value="cash">{{ __("Cash") }}</option>
                  <option value="cheque">{{ __("Cheque") }}</option>
                  <option value="bank">{{ __("Bank") }}</option>
                </select>
                @if ($errors->has('sale_date'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('sale_date') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="col-md-4 col-sm-6">
              <div class="form-group">
                <label>{{ __("Payment Note") }}</label>
                <input type="text" name="payment_note" value="{{ old('payment_note') }}" id="payment-note" class="form-control" placeholder="">
              </div>
            </div>
            <div class="col-md-4 col-sm-6">
              <div class="form-group">
                <label>{{ __("Attach Document") }}</label>
                <div class="custom-file">
                  <input type="file" name="contract" class="custom-file-input" id="attachment" />
                  <label for="attachment" class="custom-file-label">{{ __("Browse") }}...</label>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>{{ __("Remark") }}</label>
                <textarea name="remark" id="remark" rows="5" class="form-control summernote">{{ old('remark') }}</textarea>
              </div>
            </div>
          </div>

          <div class="row justify-content-end">
            <div class="col-md-8">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th colspan="3">{{__("Staff Commission")}}</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td colspan="2">{{ __('Actual Price Commission') }}</td>
                    <td width="30%" class="text-right">$ <span class="label-price">{{ number_format(0, 2) }}</span></td>
                  </tr>
                  <tr>
                    <td>{{ __('Tax') }} (%)</td>
                    <td width="40%"><input type="number" name="tax" id="tax" value="{{ old('tax', 0) }}" class="form-control form-control-sm"></td>
                    <td width="30%" class="text-right">$ <span class="label-tax">{{ number_format(0, 2) }}</span></td>
                  </tr>
                  <tr>
                    <td>{{ __('Collector') }} (%)</td>
                    <td width="40%"><input type="number" name="collector" id="collector" value="{{ old('collector', 0) }}" class="form-control form-control-sm"></td>
                    <td width="30%" class="text-right">$ <span class="label-collector">{{ number_format(0, 2) }}</span></td>
                  </tr>
                  <tr>
                    <td>{{ __('Seller') }} (%)</td>
                    <td width="40%"><input type="number" name="seller" id="seller" value="{{ old('seller', 0) }}" class="form-control form-control-sm"></td>
                    <td width="30%" class="text-right">$ <span class="label-seller">{{ number_format(0, 2) }}</span></td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="2" class="text-right">{{ __('Balance') }}</th>
                    <th class="text-right">$ <span class="label-balance">{{ number_format(0, 2) }}</span></th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
          
          {{-- <br/>
          <table class="table table-hover table-property-list">
            <thead>
              <th width="70px">#</th>
              <th width="120">{{ __("Code") }}</th>
              <th>{{ __("Title") }}</th>
              <th width="150">{{ __("Qty") }}</th>
              <th width="200">{{ __("Listing Type") }}</th>
              <th width="150">{{ __("Price") }}</th>
            </thead>
            <tbody>
              <tr>
                <td colspan="6" class="text-center">{{ __("Not Found!") }}</td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="5" class="text-right" style="vertical-align: middle">
                  <span class="font-weight-bold">{{ __("Sub Total") }}:</span>
                </td>
                <td>
                  <span class="sub_total text-primary">$ 0.00</span>
                  <input type="hidden" name="sub_total" class="sub_total"/>
                </td>
              </tr>
              <tr class="discount-panel">
                <td colspan="5" class="text-right" style="vertical-align: middle">
                  <span class="font-weight-bold">{{ __("Discount") }} (%):</span>
                </td>
                <td>
                  <input type="number" max="100" value="" style="width: 250px" placeholder="0.00" name="discount" class="form-control"/>
                </td>
              </tr>
              <tr class="deposit-amount-panel">
                <td colspan="5" class="text-right" style="vertical-align: middle">
                  <span class="font-weight-bold">{{ __("Deposit") }}:</span>
                </td>
                <td>
                  <span class="deposit_amount deposit-amount-sale text-primary">$ 0.00</span>
                  <input type="hidden" value="" style="width: 250px" placeholder="0.00" name="deposit_amount" class="form-control deposit_amount"/>
                </td>
              </tr>
              <tr>
                <td colspan="5" class="text-right">
                  <span class="font-weight-bold">{{ __("Commission") }}:</span>
                </td>
                <td>
                  <span class="total-commission text-primary">$ 0.00</span>
                  <input type="hidden" class="total-commission text-primary" name="commission_owner" value="{{ old('commission_owner') }}"/>
                </td>
              </tr>
              <tr>
                <td colspan="5" class="text-right">
                  <span class="font-weight-bold">{{ __("Amount") }}:</span>
                </td>
                <td>
                  <span class="total-amount text-primary">$ 0.00</span>
                  <input type="hidden" class="total-amount text-primary" name="amount" value="{{ old('amount') }}"/>
                </td>
              </tr>

              <tr class="deposit-panel">
                <td colspan="5" class="text-right" style="vertical-align: middle">
                  <span class="font-weight-bold">{{ __("Deposit") }} ($): </span>
                </td>
                <td>
                  <span class="total-deposit text-primary">$ 0.00</span>
                  <input type="number" style="width: 250px" placeholder="0.00" class="total-deposit text-primary form-control" name="deposit" value="{{ old('deposit') }}"/>
                </td>
              </tr>
            </tfoot>
          </table>
          <b></b> --}}
          {{-- <div class="staff_commission"></div> --}}
          <div class="rows">
            <div class="float-right">
              <a href="{{ route('administrator.sale-listing') }}" class="btn btn-danger">
                <i class="la la-long-arrow-left">&nbsp;</i>{{ __("Cancel") }}
              </a>
              <button type="submit" class="btn btn-primary btn-submit">
                <i class="fa fa-save"></i>
                {{ __('Save') }}
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
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<script src="{{ asset('backend/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('backend/plugins/easyAutocomplete/jquery.easy-autocomplete.js') }}"></script>
<script type="text/javascript">
  var property = new Array();
  var contracts = new Array();
  var monthOfContract = 1;
  var priceTax = 0;
  var priceCollector = 0;
  var priceSeller = 0;
  var balance = 0;
  var commission = 0;
  var commissionAmount = 0;
  var deposit = 0;
  const today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());

  $(function () {
    $('.kt-menu__item__sale').addClass(' kt-menu__item--active');

    $('.summernote').summernote({height:250});

    $("#sale-form").validate();

    $("#sale-date").datepicker({
      uiLibrary: 'bootstrap4',
      format: 'dd-mm-yyyy',
      iconsLibrary: 'fontawesome',
      // minDate: today
    });

    $(".property").easyAutocomplete({
      url: function(phrase) {
        return "{{ url('administrator/sale/suggestion') }}";
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
        resp.query = $(".property").val();
        return resp;
      },
      requestDelay: 100,
      list: {
        onClickEvent: function() {
          var value = $(".property").getSelectedItemData();
          suggestedProperty(value.id);
        }
      }
    });

    //$("select[name='type']").trigger("change");
    $("select[name='type']").change(function (e) {
      e.preventDefault();
      var type = $(this).find(":selected").val();

      if(type == 1){ // sale
        $(".discount-panel").show();
        $(".deposit-panel").hide();
        $(".deposit-panel").hide();
        $("input[name='deposit']").hide();
        $("input[name='deposit']").removeAttr("required");
      } else {
        $(".discount-panel").hide();
        $(".total-deposit").hide();
        $(".deposit-panel").show();
        $("input[name='deposit']").show();
        $("input[name='deposit']").attr("required", "required");
        $(".deposit-amount-sale").show();
      }
    }).trigger("change");

    $("input[name='discount']").keyup(function (e) {
      e.preventDefault();
      var sub_total = parseFloat($(".sub_total").val());
      var discount = parseFloat($(this).val());
      var deposit = parseFloat($(".deposit_amount").val());
      if(discount > 100){
        return false;
      }
      if(Number.isNaN(discount)){
        discount = 0;
      }
      if(Number.isNaN(sub_total)){
        sub_total = 0;
      }
      if(Number.isNaN(deposit)){
        deposit = 0;
      }

      var amount = sub_total - ((discount * sub_total)/ 100);

      if(deposit > 0) {
        amount = amount - deposit;
      }
      $(".total-amount").html("$ "+ amount.toFixed(2));
      $(".total-amount").val(amount);
    });

    $("input[name='actual_price_commission']").on('keyup', function(e) {
      e.preventDefault();

      commissionAmount = $(this).val();
      $('.label-price').html(parseFloat(commissionAmount).toFixed(2));

      $("input[name='tax']").trigger('keyup');
      $("input[name='collector']").trigger('keyup');
      $("input[name='seller']").trigger('keyup');
    });

    $("input[name='tax']").on('keyup', function(e) {
      e.preventDefault();
      priceTax = parseFloat(((commissionAmount) * $(this).val()) / 100).toFixed(2);
      // balance = parseFloat(commissionAmount - (priceCollector - )).toFixed(2);

      $(".label-tax").html(priceTax);
      $('.label-balance').html((commissionAmount - priceTax).toFixed(2));
    });

    $("input[name='collector']").on('keyup', function(e) {
      e.preventDefault();
      priceCollector = parseFloat((commissionAmount - priceTax) * ($(this).val() / 100)).toFixed(2);
      balance = parseFloat(commissionAmount) - (parseFloat(priceTax) + parseFloat(priceCollector) + parseFloat(priceSeller));

      $(".label-collector").html(priceCollector);
      $(".label-balance").html(parseFloat(balance).toFixed(2));
    });

    $("input[name='seller']").on('keyup', function(e) {
      e.preventDefault();
      priceSeller = parseFloat((commissionAmount - priceTax) * ($(this).val() / 100)).toFixed(2);
      balance = parseFloat(commissionAmount) - (parseFloat(priceTax) + parseFloat(priceCollector) + parseFloat(priceSeller));

      $(".label-seller").html(priceSeller);
      $(".label-balance").html(balance.toFixed(2));
    });

    $('#start-date').datepicker({
      uiLibrary: 'bootstrap4',
      format: 'dd-mm-yyyy',
      iconsLibrary: 'fontawesome',
      // minDate: today,
      maxDate: function () {
        return $('#end-date').val();
      },
      change: function (e) {
        if(null !== e.target.value) {
          const value = moment(e.target.value, "DD-MM-YYYY").toString();
          const nextValue = moment(value).add(monthOfContract, "M").format("DD-MM-YYYY");
          $("#end-date").datepicker().value(nextValue);
          // console.log(nextValue);

          // var date1 = $(this).val().split("-");
          // date1 = new Date(date1[2], date1[1] - 1, date1[0]);
          // var date2 = $('#end-date').val().split("-");
          // date2 = new Date(date2[2], date2[1] - 1, date2[0]);
          // var month = monthDiff(date1, date2);
          // calculate(month)
        }
      }
    });

    $('#end-date').datepicker({
      uiLibrary: 'bootstrap4',
      format: 'dd-mm-yyyy',
      iconsLibrary: 'fontawesome',
      minDate: function () {
        return $('#start-date').val();
      },
      // change: function (e) {
      //   if(null !== e.target.value) {
      //     var date2 = $(this).val().split("-");
      //     date2 = new Date(date2[2], date2[1] - 1, date2[0]);
      //     var date1 = $('#start-date').val().split("-");
      //     date1 = new Date(date1[2], date1[1] - 1, date1[0]);
      //     var month = monthDiff(date1, date2);
      //     calculate(month)
      //   }
      // }
    });

    $("#month-of-contract").change(function(e) {
      monthOfContract = $(this).val();
      currentIndex = $(this).find(':selected').data('index');
      // console.log(monthOfContract);

      const firstDate = $("#start-date").val();
      const currentDate = moment(firstDate, "DD-MM-YYYY".toString());
      const nextDate = moment(currentDate).add(monthOfContract, "M").format("DD-MM-YYYY");
      $("#end-date").datepicker().value(nextDate);

      // console.log(currentIndex, contracts[currentIndex]);
      if(contracts[currentIndex]) {
        let contract = contracts[currentIndex];
        deposit = contract.data.deposit_type==2 ? ('$'+contract.data.deposit) : (contract.data.deposit+' {{__("Month")}}');
        if(contract.data.commission_type==2) {
          commission = contract.data.commission + '%';
          commissionAmount = parseFloat(property.price * contract.data.commission / 100).toFixed(2);
        } 
        else {
          commission = parseInt((contract.data.commission * 100) / property.price) + '%';
          commissionAmount = parseFloat(contract.data.commission).toFixed(2);
        }

        $("#deposit").val(deposit);
        $("input[name='commission']").val(commission);
        $("input[name='commission_amount']").val(commissionAmount);
      }
    });

    $("#office").change(function(e) {
      const url = `{{ route("administrator.staff-by-office", ":office_id") }}`;

      $.ajax({
        url: url.replace(':office_id', $(this).val()),
        dataType: 'json',
        success: function(res) {
          if(res.status == 'ok') {
            var staff = $("#staff");
            staff.empty();
            staff.append("<option value=''>{{ __("Please Select") }}</option>");
            $.each(res.data, function(key, item) {
              staff.append("<option value='"+item.id+"'>"+(item.name==null?'':item.name)+"</option>");
            });
          }
        },
        error: function(err) {
          console.log(err);
        }
      });
    });

    $("#property").change(function(e) {
      e.preventDefault();

      $("#loading-popup").show();
      
      var commission = 0;
      var commissionAmount = 0;
      var deposit = 0;
      // var code = $(this).find(":selected").data("code");
      // var title = $(this).find(":selected").data("title");
      // var price = $(this).find(":selected").data("price");
      // var listing_type = $(this).find(":selected").data("listing_type");
      var property_id = $(this).find(":selected").val();
      const url = `{{ route("administrator.sale-get-property-data", ":property_id") }}`;

      // if(listing_type == "Rent"){
      //   $("input[name='start_date']").attr("required", "required");
      //   $("input[name='end_date']").attr("required", "required");
      //   $(".property-type-rent").show();
      //   $(".rent").show();
      // } 
      // else {
      //   $("input[name='start_date']").removeAttr("required");
      //   $("input[name='end_date']").removeAttr("required");
      //   $(".property-type-rent").hide();
      //   $(".rent").hide();
      // }

      // var html = "<tr>";
      // html +="<td><input type='hidden' value='"+ property_id +"' name='property_id'/>"+ property_id +"</td>";
      // html +="<td><input type='hidden' value='"+ code +"' name='code'/>"+ code +"</td>";
      // html +="<td><input type='hidden' value='"+ title +"' name='title'/>"+ title +"</td>";
      // html += '<td class="rent"><span class="qty-month">1</span><input type="hidden" value="1" name="qty"/></td>';
      // html +="<td><input type='hidden' value='"+ listing_type +"' name='price'/>"+ listing_type +"</td>";
      // html +="<td class='text-primary'><input type='hidden' value='"+ price +"' name='price'/>$ "+ price.toFixed(2) + (listing_type == "Rent"?"/Month":"") +"</td>";
      // html +="</tr>";
      // var amount = parseFloat(price);
      // var discount = $("input[name='discount']").val();
      // if(discount != undefined && discount != ""){
      //   amount = amount - parseFloat($("input[name='discount']").val());
      // }

      // $(".table-property-list tbody").html(html);
      // $(".sub_total").html("$ "+ price.toFixed(2));
      // $(".sub_total").val(price);
      // $(".total-amount").html("$ "+ amount.toFixed(2));
      // $(".total-amount").val(amount);
      
      $.ajax({
        url: url.replace(':property_id', property_id),
        dataType: 'json', // added data type
        success: function(res) {
          if(res.status == 1) {
            property = res.data.property;
            console.log(property);

            if(property.listing_type == 'rent') {
              $(".rental-things").show();
              $(".sale-things").hide();
            } 
            else {
              $(".rental-things").hide();
              $(".sale-things").show();
            }

            if(property.contracts.length > 0) {
              monthOfContract = property.contracts[0].data.year_of_contract * 12;

              if(property.listing_type == 'rent') {
                deposit = property.contracts[0].data.deposit_type==2 ? ('$'+property.contracts[0].data.deposit) : (property.contracts[0].data.deposit+' {{__("Month")}}');
              }

              commission = property.contracts[0].data.commission_type==2 ? (property.contracts[0].data.commission+'%') : ('$'+property.contracts[0].data.commission);
              if(property.listing_type == 'sale') {
                commissionAmount = property.contracts[0].data.commission_type==2 ? parseFloat(property.price * property.contracts[0].data.commission / 100).toFixed(2) : 0;
              }

              const firstDate = $("#start-date").val();
              const currentDate = moment(new Date(firstDate));
              const nextDate = moment(currentDate).add(monthOfContract, "M").format("DD-MM-YYYY");
              $("#end-date").datepicker().value(nextDate);

              var monthOfContractSelector = $("#month-of-contract");
              $.each(property.contracts, function(key, item) {
                monthOfContractSelector.append("<option value='"+(item.data.year_of_contract * 12)+"'>"+(item.data.year_of_contract * 12)+' Month'+"</option>");
              });
              // monthOfContractSelector.selectpicker('refresh');

              $("input[name='deposit']").val(deposit);
              $("input[name='commission']").val(commission);
              $("input[name='commission_amount']").val(commissionAmount);
            }

            // $(".total-commission").html("$ " +(res.data.from_owner).toFixed(2));
            // $(".total-commission").val(res.data.from_owner);
            // $(".staff_commission").html(res.data.staff_commission);
            // if(res.data.deposit > 0) {
            //   var deposit = res.data.deposit;
            //   amount = parseFloat(amount) - parseFloat(deposit);
            //   $(".deposit_amount").val(res.data.deposit);
            //   $(".deposit_amount").html("$ "+ (res.data.deposit));
            //   $(".total-amount").html("$ "+ amount.toFixed(2));
            //   $(".total-amount").val(amount);

            //   //if property already deposit need to hide sale type
            //   $("select[name='type']").val(1).trigger("change");
            //   $(".sale_type").hide();
            //   $(".deposit-amount-panel").show();
            //   $(".deposit-amount-sale").show();
            // } 
            // else {
            //   $(".sale_type").show();
            //   $(".deposit-amount-panel").hide();
            //   $(".deposit-amount-sale").hide();
            // }
            $("input[name='listing_type']").val(property.listing_type);
            $("input[name='collectors']").val(property.collector[0].staff_id.id_card);
            $("input[name='price']").val(property.price.toFixed(2));
            $("input[name='actual_price']").val((property.price - commissionAmount).toFixed(2));
            $("input[name='actual_price_commission']").val(property.price.toFixed(2));

            $(".label-price, .label-balance").html($("input[name='actual_price']").val());
          }
          else {
            return false;
            alert(res.message);
          }

          $("#loading-popup").hide();
        }
      });
    });
  });

  function suggestedProperty(id) {
    $("#loading-popup").show();
    
    const url = `{{ route("administrator.sale-get-property-data", ":property_id") }}`;
    
    $.ajax({
      url: url.replace(':property_id', id),
      dataType: 'json', // added data type
      success: function(res) {
        if(res.status == 1) {
          property = res.data.property;
          $("input[name='property']").val(property.id);
          console.log(property);

          if(property.listing_type == 'rent') {
            $("label[for='price']").html("{{__('Rental Price')}} ($/{{__('Month')}})");
            $("label[for='actual-price']").html("{{__('Actual Price')}} ($/{{__('Month')}})");
            $(".rental-things").show();
            $(".sale-things").hide();
          } 
          else {
            $("label[for='price']").html("{{__('Sale Price')}}");
            $("label[for='price']").html("{{__('Actual Price')}}");
            $(".rental-things").hide();
            $(".sale-things").show();
          }

          if(property.contracts.length > 0) {
            contracts = property.contracts;
            monthOfContract = property.contracts[0].data.year_of_contract * 12;

            if(property.contracts[0].data.month_of_contract != null) {
              monthOfContract = parseInt(monthOfContract) + parseInt(property.contracts[0].data.month_of_contract);
            }

            if(property.listing_type == 'rent') {
              deposit = property.contracts[0].data.deposit_type==2 ? ('$'+property.contracts[0].data.deposit) : (property.contracts[0].data.deposit+' {{__("Month")}}');
            }

            if(property.contracts[0].data.commission_type==2) {
              commission = property.contracts[0].data.commission + '%';
              commissionAmount = parseFloat(property.price * property.contracts[0].data.commission / 100).toFixed(2);
            } else {
              commission = parseInt((property.contracts[0].data.commission * 100) / property.price) + '%';
              commissionAmount = parseFloat(property.contracts[0].data.commission).toFixed(2);
            }

            const firstDate = $("#start-date").val();
            const currentDate = moment(new Date(firstDate));
            const nextDate = moment(currentDate).add(monthOfContract, "M").format("DD-MM-YYYY");
            $("#end-date").datepicker().value(nextDate);

            var monthOfContractSelector = $("#month-of-contract");
            monthOfContractSelector.empty();
            $.each(property.contracts, function(key, item) {
              var yearToMonth = parseInt(item.data.year_of_contract) * 12;
              if(item.data.month_of_contract != null) {
                yearToMonth = yearToMonth + parseInt(item.data.month_of_contract);
              }
              monthOfContractSelector.append("<option data-index='"+key+"' value='"+yearToMonth+"'>"+(yearToMonth)+' Month'+"</option>");
            });
            // monthOfContractSelector.selectpicker('refresh');

            $("input[name='deposit']").val(deposit);
            $("input[name='commission']").val(commission);
            $("input[name='commission_amount']").val(commissionAmount);
          }
          // console.log(contracts);

          $("input[name='listing_type']").val(property.listing_type);
          $("input[name='collectors']").val(property.collector.length>0 ? property.collector[0].staff_id.id_card : '');
          $("#collectors").val(property.collector.length>0 ? (property.collector[0].staff_id.id_card + ' - ' + property.collector[0].staff_id.username) : '');
          $("input[name='price']").val(property.price.toFixed(2));
          $("input[name='actual_price']").val((property.price).toFixed(2));
          $("input[name='actual_price_commission']").val(commissionAmount);

          $(".label-price, .label-balance").html($("input[name='actual_price_commission']").val());
        }
        else {
          return false;
          alert(res.message);
        }

        $("#loading-popup").hide();
      }
    });
  }

  function calculate(month) {
    var deposit = $(".deposit_amount").val();
    var price = $(".property").find(":selected").data("price");
    var amount = parseFloat(price) * parseFloat(month);
    var discount = $("input[name='discount']").val();
    if(discount != undefined && discount != ""){
      amount = amount - parseFloat($("input[name='discount']").val());
    }

    if(deposit > 0){
      amount = amount - deposit;
    }
    sub_total = (parseFloat(price) * parseFloat(month));
    $(".sub_total").html("$ "+ sub_total.toFixed(2));
    $(".sub_total").val(sub_total);
    $(".total-amount").html("$ "+ amount.toFixed(2));
    $(".total-amount").val(amount);
    $(".qty-month").html(month);
    $("input[name='qty']").val(month);
  }

  function monthDiff(d1, d2) {
    var months;
    months = (d2.getFullYear() - d1.getFullYear()) * 12;
    months -= d1.getMonth();
    months += d2.getMonth();
    return months <= 0 ? 0 : months;
  }
</script>
@endsection