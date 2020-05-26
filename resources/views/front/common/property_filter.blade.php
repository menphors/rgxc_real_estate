<!-- Main Search start from here -->
<section class="main-search-field">
  <div class="text-center">
    <h2 style="margin-bottom:32px;color:#fff;text-transform:capitalize;">{!! str_replace('{xxx}', ''.$total_properties.'', __('Find {xxx} properties here')) !!}</h2>
  </div>

  {{-- @if(\Auth::check()) --}}
    {{ Form::open(array('url' => '/properties', 'method' => 'GET')) }}
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-6">
            <div class="at-col-default-mar">
              <select name="province">
                <option value="" selected>{{__('Province')}}</option>
                @if($provinces->count())
                  @foreach($provinces as $province)
                    <option value="{{$province->id}}" {{$province->id == $is_filter['province_id'] ? "selected" : ""}}>{{$province['title']}}</option>
                  @endforeach
                @endif
              </select>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="at-col-default-mar">
              <select class="div-toggle to_show_district" data-target=".my-info-1" name="district">
                <option value="" data-show=".acitveon" selected>{{__('District')}}</option>
              </select>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="at-col-default-mar">
              <select class="div-toggle" data-target=".my-info-1" name="listing_type">
                <option value="" data-show=".acitveon" selected>{{__('Listing Type')}}</option>
                <option value="sale" data-show=".acitveon" {{$is_filter['listing_type'] == "sale" ? "selected" : ""}}>{{__('Sale')}}</option>
                <option value="rent" data-show=".acitveon" {{$is_filter['listing_type'] == "rent" ? "selected" : ""}}>{{__('Rent')}}</option>
              </select>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="at-col-default-mar">
              <select class="div-toggle" data-target=".my-info-1" name="property_type">
                <option value="0" data-show=".acitveon" selected>{{__('Property Type')}}</option>
                @if($property_types->count())
                @foreach($property_types as $property_type)
                <option value="{{ $property_type->id }}" {{ $is_filter['property_type'] == $property_type->id ? "selected" : "" }}>{{ $property_type->title }}</option>
                @endforeach
                @endif
              </select>
            </div>
          </div>
        </div>
        {{-- {{ Route::current()->uri() }} --}}

        @if(Route::current()->uri() == 'properties' || Route::current()->uri() == 'cn/properties' || Route::current()->uri() == 'kh/properties' || Route::current()->uri() == 'en/properties')
        <div class="row">
          <div class="col-lg-3 col-md-6">
            <div class="at-col-default-mar">
              <select name="bedroom">
                <option value="0" selected>{{__('Bedroom')}}</option>
                @for($i=1;$i<=10;$i++)
                  <option value="{{ $i }}" {{ $is_filter['bedroom'] == $i ? "selected" : "" }}>{{ $i }}</option>
                @endfor
                <option value="{{ 'greater' }}" {{ $is_filter['bedroom'] == $i ? "selected" : "" }}>{{ '> 10' }}</option>
              </select>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="at-col-default-mar">
              <select name="bathroom">
                <option value="0" selected>{{__('Bathroom')}}</option>
                @for($i=1;$i<=10;$i++)
                  <option value="{{ $i }}" {{ $is_filter['bathroom'] == $i ? "selected" : "" }}>{{ $i }}</option>
                @endfor
                <option value="{{ 'greater' }}" {{ $is_filter['bedroom'] == $i ? "selected" : "" }}>{{ '> 10' }}</option>
              </select>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="at-col-default-mar">
              <input type="number" value="{{ $is_filter['price_from'] }}" step="any" name="min_price" class="at-input" placeholder="{{__("Min Price")}}">
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="at-col-default-mar">
              <input type="number" value="{{ $is_filter['price_to'] }}" step="any" name="max_price" class="at-input" placeholder="{{__("Max Price")}}">
            </div>
          </div>
        </div>
        @endif

        <div class="row">
          <div class="col-lg-3">
            <div class="at-col-default-mar">
              <select name="project">
                <option value="0" selected>{{__('Project')}}</option>
                @if($projects->count())
                  @foreach($projects as $project)
                    <option value="{{ $project->id }}" {{ $is_filter['project'] == $project->id ? "selected" : "" }}>{{ $project->title }}</option>
                  @endforeach
                @endif
              </select>
            </div>
          </div>
          <div class="col-lg-9">
            <div class="at-col-default-mar">
              <div class="input-group">
                <div class="input-group-btn search-panel">
                  <button class="btn at-input dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span id="search_concept">{{ __(in_array($is_filter['option'], ['code', 'keyword']) ? ucwords($is_filter['option']) : 'Keyword') }}</span> <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#keyword">{{__('Keyword')}}</a></li>
                    <li><a class="dropdown-item" href="#code">{{__('Code')}}</a></li>
                  </ul>
                </div>
                <input type="hidden" name="option" value="{{ $is_filter['option']!='' ? $is_filter['option'] : 'keyword' }}" id="search_option">
                <input type="text" name="search" class="at-input" value="{{ $is_filter['search'] }}" placeholder="{{__('Search by keyword or properties code')}}">
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-3 col-md-6 col-lg-offset-6 text-right" style="padding-top:10px;">
            @if(Route::current()->uri() == '/' || Route::current()->uri() == 'cn' || Route::current()->uri() == '/kh' || Route::current()->uri() == '/en')
              <a href="{{ url('properties') }}" title="" style="color:#fff;text-decoration:underline;">{{ __('Advance Search') }}</a>
            @endif
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="at-col-default-mar" style="padding:0px">
              <button class="btn btn-default hvr-bounce-to-right property_filter_btn" type="submit" style="border-radius: 5px;">{{__('web-search')}}</button>
            </div>
          </div>
        </div>
      </div>
    {!! Form::close() !!}
  {{-- @else --}}
    {{-- <div class="row" style="display: flex; justify-content: center;">
      <div class="col-lg-3 col-md-6">
        <div class="at-col-default-mar" style="padding:0px">
          <a href="#" class="btn btn-default hvr-bounce-to-right property_filter_btn" style="border-radius: 5px;">{{ __('Start Now') }}</a>
        </div>
      </div>
    </div> --}}
  {{-- @endif --}}
</section>
<!-- Main Search End -->

{{-- @if(\Auth::check()) --}}
@section("style")
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-tagsinput.css') }}">
@endsection

@section('script')
<script src="{{ asset('js/bootstrap-tagsinput.min.js') }}" type="text/javascript"></script>
<script>
  $(document).ready(function() {
    $('select[name="province"]').trigger("change");
    $('select[name="province"]').change(function(e) {
      $('.to_show_district').html('');
      var district_id = `{{ request("district") }}`;

      var province_id = $(this).val();
      if(province_id != ''){
        $.ajax({
          type: "GET",
          url: "{{ url('get-district-by-province-id') }}" +'/'+province_id,
        }).done(function( respone ) {
          var html = '';
          html += '<option value="">{{__("District")}}</option>';
          $.each(respone, function(key, district) {
            html += '<option value="'+district.id+'">'+district.title+'</option>';
            $('.to_show_district').html(html);
          });
          $("select[name='district']").val(district_id).trigger("change");
        });
      } 
      else {
        var html = '';
        html += '<option value="">{{__("District")}}</option>';
        $('.to_show_district').append(html);
      }
    }).trigger("change");

    let searchBox = $("input[name='search']");
    searchBox.tagsinput({
      tagClass: 'label-warning'
    });
  });

  $("select[name='property_type']").on('change', function(e) {
    const propertyType = this.options[this.selectedIndex].text;

    if(propertyType == 'Land') {
      $("select[name='bedroom']").attr('disabled', true);
      $("select[name='bathroom']").attr('disabled', true);
    }
    else {
      $("select[name='bedroom']").attr('disabled', false);
      $("select[name='bathroom']").attr('disabled', false);
    }
    e.preventDefault();
  });

  $('.search-panel .dropdown-menu').find('a').click(function(e) {
    e.preventDefault();
    var param = $(this).attr("href").replace("#", "");
    var concept = $(this).text();
    $('.search-panel span#search_concept').text(concept);
    $('.input-group #search_option').val(param);
  });
</script>
@endsection
{{-- @endif --}}