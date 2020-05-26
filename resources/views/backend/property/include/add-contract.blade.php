<?php
  $data = json_decode(@$contract->data, true);
?>
<form action="{{ route("administrator.property-owner-contract", $property->id) }}" method="post" enctype="multipart/form-data">
  @csrf
  <input type="hidden" name="contract_id" value="{{ @$contract->id }}"/>
  <div class="row">
    <div class="col-12">
      <div class="form-group">
        <label for="title">{{ __("Title") }}</label>&nbsp;&nbsp;<br/>
        <input type="text" name="title" value="{{ old("title", @$data["title"]) }}"​ class="form-control"/>
      </div>
    </div>
  </div>

  @if($property->listing_type == 'rent')
    <div class="row">
      <div class="col-6">
        <div class="form-group">
          <label for="year_of_contract">{{ __("Year Of Contract") }}</label>&nbsp;&nbsp;<br/>
          <input type="text" name="year_of_contract" value="{{ old("year_of_contract", @$data["year_of_contract"]) }}"​ class="form-control"/>
        </div>
      </div>
      <div class="col-6">
        <div class="form-group">
          <label for="month_of_contract">{{ __("Month Of Contract") }}</label>&nbsp;&nbsp;<br/>
          <input type="text" name="month_of_contract" value="{{ old("month_of_contract", @$data["month_of_contract"]) }}"​ class="form-control"/>
        </div>
      </div>
    </div>
  @endif

  <div class="row">
    <div class="col-12">
      <div class="form-group">
        <label for="furniture">{{ __("Furniture") }}</label>&nbsp;&nbsp;<br/>
        <select name="furniture" class="form-control">
          @foreach(furniture() as $key => $value)
          <option value="{{ $key }}">{{ $value }}</option>
          @endforeach
        </select>
      </div>
    </div>
  </div>

  @if($property->listing_type == 'rent')
    <div class="row">
      <div class="col-12">
        <div class="form-group">
          <label for="deposit">{{ __("Deposit") }}</label>&nbsp;&nbsp;<br/>
          <div class="input-group">
            <select  name="deposit_type" style="width: 70px">
              <option value="1" {{ old("deposit_type", @$data["deposit_type"]) == 1? "selected" : ""}}>{{ __("Month") }}</option>
              <option value="2" {{ old("deposit_type", @$data["deposit_type"]) == 2? "selected" : ""}}>$</option>
            </select>
            <input type="text" name="deposit" value="{{ old("deposit", @$data["deposit"]) }}"​ class="form-control"/>
          </div>
        </div>
      </div>
    </div>
  @endif

  <div class="row">
    <div class="col-12">
      <div class="form-group">
        <label for="commission">{{ __("Commission") }}</label>&nbsp;&nbsp;<br/>
        <div class="input-group">
          <select  name="commission_type" style="width: 70px">
            <option value="1" {{ old("commission_type", @$data["commission_type"]) == 1? "selected" : ""}}>{{ __("$") }}</option>
            <option value="2"  {{ old("commission_type", @$data["commission_type"]) == 2? "selected" : ""}}>%</option>
          </select>
          <input type="text" name="commission" value="{{  old("commission", @$data["commission"]) }}"​ class="form-control"/>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="form-group">
        <label for="contract">{{ __("Property Owner Contract") }}</label>&nbsp;&nbsp;<br/>
        <input type="file" name="contract" value=""​ class="btn btn-primary"/>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12 text-right">
      <a href="{{ route("administrator.property-view", $property->id) }}?action=contract" class="btn btn-danger btn-sm">
        <i class="la la-long-arrow-left"></i>
        {{ __("Back") }}
      </a>
      <button type="submit" name="submit" class="btn btn-primary btn-sm">
        <i class="fa fa-save"></i>
        {{ __("Submit") }}
      </button>
    </div>
  </div>
</form>
<br/><br/>

@if(!empty(@$data["owner_contract"]))
  <iframe width="100%" height="540px" src="{{  asset(config("global.owner_contract_path"). @$data["owner_contract"]) }}"></iframe>
@endif