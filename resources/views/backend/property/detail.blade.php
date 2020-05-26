<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Property Detail</title>
  <!--begin::Global Theme Styles(used by all pages) -->
  <link href="{{ asset("backend/vendors/global/vendors.bundle.css") }}" rel="stylesheet" type="text/css"/>
  <link href="{{ asset("backend/css/demo1/style.bundle.css") }}" rel="stylesheet" type="text/css"/>
  <style type="text/css">
    .list-detail ul { list-style: none; font-size: 15px; margin-left: -45px!important; }
    .mrg-left-10 { margin-left: 10px!important; }
    .list-detail ul li:before { content: '✓'; font-weight: bold; font-size: 15px; color: blue; margin-right: 5px; }
    .list-detail ul li { width: 200px!important; }
    body { font-size: 14px!important; font-family: sans-serif; }
    .d-block .form-group { display: inline-block; margin-right: 25px; margin-bottom: 0; }
    @media print {
      body, .card-columns .card { page-break-after: auto; page-break-inside: avoid; }
      .card-columns .card { width: 49%; margin-left: 0.5%; margin-right: 0.5%; float: left; }
    }
  </style>
</head>
<body style="background: #fff;">
  <section class="content">
    <div class="container">
      <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__body kt-portlet__body--fit">
          <div class="container text-right" style="padding:10px;">
            <a data-property_id="{{ $property->id }}" href="javascript:void();" title="{{ __('PDF') }}" class="btn btn-danger btn-sm btn-print">
              <i class="fa fa-file-pdf" aria-hidden="true"></i>
              {{ __('PDF') }}
            </a>
            <a href="javascript:void();" data-toggle="modal" data-target="#modal" data-property_id="{{ $property->id }}" title="{{ __('Link') }}" class="btn btn-primary btn-sm btn-generate-link">
              <i class="fa fa-link" aria-hidden="true"></i>
              {{ __('Link') }}
            </a>
          </div>

          <div class="card" id="printArea">
            <div class="card-body">
              <table class="table">
                <thead>
                  <tr>
                    <th colspan="3" class="text-center">
                      <h4><b>{{ @$property->code. " - " . @$property->title }}</b></h4>
                      <p><i class="fa fa-map-marker"></i> {{ @$property->province_id->title }}</p>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td width="30%">{{ __('Property Code') }}</td>
                    <td width="20px">:</td>
                    <td><b>{{ @$property->code }}</b></td>
                  </tr>
                  <tr>
                    <td width="30%">{{ __('Property Type') }}</td>
                    <td width="20px">:</td>
                    <td style="text-transform: capitalize">{{ __(ucfirst($property->listing_type)) }}</td>
                  </tr>
                  <tr>
                    <td width="30%">{{ __('Listing Type') }}</td>
                    <td width="20px">:</td>
                    <td style="text-transform: capitalize">{{ $property->property_type_id->title }}</td>
                  </tr>
                  <tr>
                    <td width="30%">{{ __('Address') }}</td>
                    <td width="20px">:</td>
                    {{-- <td style="text-transform: capitalize">{{ __('Commune').': '.@$property->commune_id->title . ', '.__('District').': '.@$property->district_id->title . ', '.@$property->province_id->title }}</td> --}}
                    <td style="text-transform: capitalize">{{ @$property->commune_id->title . ', '.@$property->district_id->title . ', '.@$property->province_id->title }}</td>
                  </tr>   
                  <tr>
                    <td width="30%">{{ __('web-property-price') }}</td>
                    <td width="20px">:</td>
                    <td>{{ "$ ". number_format(@$property->price, 2) . (@$property->listing_type == 'rent' ? '/'.__('Month') : '') }}</td>
                  </tr>
                  {{-- <tr>
                    <td width="30%">{{ __('web-property-price-per-sqm') }}</td>
                    <td width="20px">:</td>
                    <td>{{ $data->price_sqm ? "$". number_format(@$data->price_sqm, 2).'/m<sup>2</sup>' : 'N/A' }}</td>
                  </tr> --}}
                  <tr>
                    <td width="30%">{{ __('Properties Size') }}</td>
                    <td width="20px">:</td>
                    <td>
                      @if(in_array($property->property_type_id->title, [__('Land')]))
                        {!! (@$property->habitable_surface.', '.@$property->property_size."m<sup>2</sup>") !!}
                      @else
                        {{ $property->floor_number>0 ? $property->data->total_build_surface : $property->property_size }}m<sup>2</sup>
                      @endif
                    </td>
                  </tr>
                  @if( !in_array(@$property->property_type_id->title, [__("Land"), __("Warehouse")]) )
                    <tr>
                      @if($property->property_type_id->title==__('Condo & Apartment'))
                        <td width="30%">{{ __('Floor Level') }}</td>
                        <td width="20px">:</td>
                        <td>{{ $property->data->floor_level.'th' }}</td>
                      @else
                        <td width="30%">{{ __('Floor Number') }}</td>
                        <td width="20px">:</td>
                        <td>{{ @$property->floor_number }}</td>
                      @endif
                    </tr>
                  @endif
                  @if( !in_array(@$property->property_type_id->title, [__("Land"), __("Warehouse"), __("Office")]) )
                    <tr>
                      <td width="30%">{{ __('Bedroom') }}</td>
                      <td width="20px">:</td>
                      <td>{{ @$property->bed_room }}</td>
                    </tr>
                  @endif
                  @if( !in_array(@$property->property_type_id->title, [__("Land"), __("Warehouse")]) )
                    <tr>
                      <td width="30%">{{ __('Bathroom') }}</td>
                      <td width="20px">:</td>
                      <td>{{ @$property->bath_room }}</td>
                    </tr>
                  @endif
                  @if( !in_array(@$property->property_type_id->title, [__("Land"), __("Warehouse")]) )
                    <tr>
                      <td width="30%">{{ __('Furniture') }}</td>
                      <td width="20px">:</td>
                      <td>
                        @if(!is_null($contract))
                          @foreach($contract as $val)
                            <?php
                            $depositObject = json_decode($val->data);
                            ?>
                            @if(@$depositObject->furniture == 1) 
                              {{__('None')}}
                            @elseif(@$depositObject->furniture == 2) 
                              {{__('Full')}}
                            @else 
                              {{__('Some')}}
                            @endif
                          @endforeach
                        @endif
                      </td>
                    </tr>
                  @endif
                  {{-- <tr>
                    <td width="30%">{{ __('Properties surface (sqm)') }}</td>
                    <td width="20px">:</td>
                    <td>{{ @$property->ground_surface }}</td>
                  </tr> --}}
                  @if($property->listing_type == "rent")
                    <tr>
                      <td width="30%">{{ __('Contract (Year)') }}</td>
                      <td width="20px">:</td>
                      <td>
                        @if(!is_null($contract))
                          @foreach($contract as $val)
                            <?php
                            $depositObject = json_decode($val->data);
                            ?>

                            {!! !empty(@$depositObject->year_of_contract)? (@$depositObject->year_of_contract . ' '.__('Year(s)').', ') : "" !!}
                            {{ __('Deposit') }}:
                            @if(@$depositObject->deposit_type == 1)
                              {!! !empty(@$depositObject->deposit)? (''. @$depositObject->deposit .' '.__('Month(s)').' ') : "" !!}
                            @else
                              {!! floatval(@$depositObject->deposit) > 0 ? "$ " .number_format(@$depositObject->deposit,  2) : "" !!}
                            @endif

                            @if(count($contract) > 1) 
                              <br>
                            @endif
                          @endforeach
                        @endif
                      </td>
                    </tr>
                  @endif
                  <tr>
                    <td width="30%">{{ __('Amenities') }}</td>
                    <td width="20px">:</td>
                    <td class="row">
                      <div class="amentities">
                        <ul class="row list-unstyled">
                          @if(@$property->has_swimming_pool)
                            <li class="col-md-4 col-sm-6"><i class="fa fa-check"></i> {{__('Has swimming pool')}}</li>
                          @endif
                          @if(@$property->has_elevator)
                            <li class="col-md-4 col-sm-6"><i class="fa fa-check"></i> {{__('Has elevator')}}</li>
                          @endif
                          @if(@$property->has_basement)
                            <li class="col-md-4 col-sm-6"><i class="fa fa-check"></i> {{__('Has basement')}}</li>
                          @endif
                          @if(@$property->has_parking)
                            <li class="col-md-4 col-sm-6"><i class="fa fa-check"></i> {{__('Has Parking')}}</li>
                          @endif
                          @foreach($property->data->amentities as $key => $other_service)
                            @if(!empty($other_service))
                              <li class="col-md-4 col-sm-6"><i class="fa fa-check"></i> {{ $other_service }}</li>
                            @endif
                          @endforeach
                        </ul>
                      </div>
                    </td>
                  </tr>

                  <tr>
                    <th colspan="3">
                      <h5 style="margin-bottom:0;margin-top:15px;font-weight:bold;">{{ __('More Detail') }}</h5>
                    </th>
                  </tr>
                  @if($link->data->address == 1)
                    <tr>
                      <td width="30%">{{ __('Full Address') }}</td>
                      <td width="20px">:</td>
                      {{-- <td>
                        {{ @$data->house_no!='' ? (__('House No').': '.@$data->house_no . ', ') : '' }}
                        @if(@$link->data->street == 1)
                          {{ @$data->street!='' ? (__('Street').': '.@$data->street . ', ') : '' }}
                        @endif
                        {{ $property->village_id ? (__('Village').': '.$property->village_id->title . ', ') : '' }}
                        {{ $property->commune_id ? (__('Commune').': '.$property->commune_id->title . ', ') : '' }}
                        @if(@$link->data->district == 1)
                          {{ __('District').': '.@$property->district_id->title . ', ' }}
                        @endif
                        {{ __('Province').': '.@$property->province_id->title }}
                      </td> --}}
                      <td>
                        {{ @$property->data->house_no!='' ? (__('House No').': '.@$property->data->house_no . ', ') : '' }}
                        @if(@$link->data->street == 1)
                          {{ @$property->data->street!='' ? (__('Street').': '.@$property->data->street .  ', ') : '' }}
                        @endif
                        {{ $property->village_id ? (__('Village').': '.$property->village_id->title . ', ') : '' }}
                        {{ $property->commune_id ? ($property->commune_id->title . ', ') : '' }}
                        @if(@$link->data->district == 1)
                          {{@$property->district_id->title . ', ' }}
                        @endif
                        {{@$property->province_id->title }}
                      </td>
                    </tr>
                    <tr>
                      <td width="250">{{__("Land mark")}}</td>
                      <td width="20px">:</td>
                      <td>{{ $property->data->land_mark }}</td>
                    </tr>
                  @endif

                  @if(@$link->data->collector == 1)
                    <tr>
                      <td width="30%">{{ __('Collector') }}</td>
                      <td width="20px">:</td>
                      <td>
                        @if(!empty(@$property->collector))
                          @foreach(@$property->collector as $collector)
                            <span class="badge badge-info">{{ @$collector->staff_id->name }}</span>
                          @endforeach
                        @endif
                      </td>
                    </tr>
                  @endif

                  @if($link->data->map == 1)
                    <tr>
                      <td width="250">{{__("Map Link")}}</td>
                      <td width="20px">:</td>
                      <td style="word-break:break-all;"><a href="{{ $property->data->share_maps_link }}" target="_blank">{{ $property->data->share_maps_link }}</a></td>
                    </tr>
                  @endif

                  @if(@$link->data->commission == 1)
                    <tr>
                      <td width="30%">{{ __('Commission') }}</td>
                      <td width="20px">:</td>
                      <td>
                        @if(!is_null($contract))
                          @foreach($contract as $val)
                            <?php
                            $commissionObject = json_decode($val->data);
                            ?>
                            <span class="badge badge-info">
                              {{ ($property->listing_type == 'rent') ? $commissionObject->year_of_contract . 'year(s) /' : '' }}

                              @if(@$depositObject->commission_type == 1)
                                {!! !empty(@$commissionObject->commission) ? ('$'. number_format(@$commissionObject->commission, 2) ) : "" !!}
                              @else
                                {!! floatval(@$commissionObject->commission) > 0 ? @$commissionObject->commission."%" : "" !!}
                              @endif
                            </span>
                          @endforeach
                        @endif
                      </td>
                    </tr>
                  @endif

                  @if(@$link->data->owner == 1)
                    <tr>
                      <td width="30%">{{ __('Owner Contact') }}</td>
                      <td width="20px">:</td>
                      <td>{{ @$property->data->owner_contact }}</td>
                    </tr>
                  @endif

                  {{-- <tr>
                    <td width="30%">{{ __('Remark') }}</td>
                    <td width="20px">:</td>
                    <td>{!! @$property->remark !!}</td>
                  </tr> --}}

                  {{-- @if( @$property->property_type_id->title != "Land" )
                    <tr>
                      <td width="30%">{{ __('More Feature') }}</td>
                      <td width="20px">:</td>
                      <td>
                        @if(!empty(@$property->front_refer_to))
                        {!!   __('Front refer to') ." ". @config('data.admin.front_refer_to')[\LaravelLocalization::getCurrentLocale()][@$property->front_refer_to]  !!},&nbsp;&nbsp;&nbsp;
                        @endif
                        @if(!empty(@$property->year_of_renovation))
                        {!! @$property->year_of_renovation ." " . __('Year of renovation')  !!},&nbsp;&nbsp;&nbsp;
                        @endif
                        @if(!empty(@$property->year_of_construction))
                        {!! @$property->year_of_construction ." " . __('Year of construction')  !!},&nbsp;&nbsp;&nbsp;
                        @endif
                        @if(!empty(@$property->built_up_surface))
                        {!! @$property->built_up_surface ." " .  __('Built up surface'). " (m<sup>2</sup>)"  !!},&nbsp;&nbsp;&nbsp;
                        @endif
                        @if(!empty(@$property->ground_surface))
                        {!! @$property->ground_surface ." " .  __('Ground surface'). " (m<sup>2</sup>)"  !!}
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td width="30%">{{ __('More Detail') }}</td>
                      <td width="20px">:</td>
                      <td>
                        <div class="list-detail">
                          <ul>
                            @if( @$property->has_swimming_pool)
                            <li> {{ __('Has swimming pool') }}</li>
                            @endif
                            @if( @$property->has_elevator)
                            <li class="mrg-left-10"> {{ __('Has elevator') }}</li>
                            @endif
                            @if( @$property->has_basement)
                            <li class="mrg-left-10"> {{ __('Has basement') }}</li>
                            @endif
                            @if( @$property->has_parking)
                            <li class="mrg-left-10"> {{ __('Has Parking') }}</li>
                            @endif
                            @php
                            $dataOrtherServiceToArray = json_decode($property->data, true);
                            $data= $dataOrtherServiceToArray['other_service'] ?? [];
                            $dataSpecialToArray = json_decode($property->data, true);
                            $dataSpecialToArray = json_decode($property->data, true);
                            @endphp
                            @foreach(config('data.admin.services.orther_service')[\LaravelLocalization::getCurrentLocale()] as $key => $other_service)
                            @if(isset($data[$key]) && $data[$key] == $key)
                            <li class="mrg-left-10">{{ $other_service }}</li>
                            @endif
                            @endforeach

                            @foreach(config('data.admin.services.specials')[\LaravelLocalization::getCurrentLocale()] as $key => $special)
                            @if((isset($dataSpecialToArray['special'][$key]) && $dataSpecialToArray['special'][$key] == $key))
                            <li class="mrg-left-10">{{ $special }}</li>
                            @endif
                            @endforeach
                            @foreach(config('data.admin.services.security')[\LaravelLocalization::getCurrentLocale()] as $key => $security)
                            @if((isset($dataSpecialToArray['security'][$key]) && $dataSpecialToArray['security'][$key] == $key))
                            <li class="mrg-left-10">{{ $security }}</li>
                            @endif
                            @endforeach
                          </ul>
                        </div>
                      </td>
                    </tr>
                  @endif --}}
                </tbody>
              </table>

              <div class="card-columns">
                @foreach(@$property->attachments as $attachment)
                  <div class="card" style="">
                    <img class="img-responsive" src="{{ asset(config("global.property_image_path").$property->id."/".$attachment->name) }}" onerror="this.src='{{ url("none.png") }}';" style="max-width: 100%!important;">
                  </div>
                @endforeach
              </div>

              @if($property->display_on_maps)
                <div class="row">
                  <div class="col-12">
                    <div id="map" style="height: 500px;"></div>
                  </div>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="modal" id="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="text" name="" value="{{ $link->url }}" class="form-control" onclick="this.select();">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Close') }}</button>
        </div>
      </div>
    </div>
  </div>

  <!--begin::Global Theme Bundle(used by all pages) -->
  <script src="{{ asset("backend/vendors/global/vendors.bundle.js") }}" type="text/javascript"></script>
  <script src="{{ asset("backend/js/demo1/scripts.bundle.js") }}" type="text/javascript"></script>
  <script src="{{asset('backend/js/jQuery.print.js')}}" type="text/javascript"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key={{ env("GOOGLE_MAPS_KEY") }}&libraries=places&callback=initMap" async defer></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $(".btn-generate-pdf").on('click', function() {
        setTimeout(function(){
          window.print();
        }, 500);
        window.onafterprint = window.close;
      });
    });

    $(document).on('click', '.btn-print', function() {
      $("#printArea").print();
    });

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
        draggable: false
      });
    }
  </script>
</body>
</html>