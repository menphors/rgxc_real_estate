@extends('front.app')
@section("title")
{{ __("Property") }}
@endsection

@section('content')


@include('front.common.property_filter')

<!-- Property start from here -->
<section class="at-property-sec" style="padding: 20px 0 70px;">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-sm-6">
        <div class="at-inner-title-box">
          <h2>{{ __("Properties") }} ({{ $properties->total() }})</h2>
          <p>
            <a href="/">{{ __("Home") }}</a>
            <i class="fa fa-angle-double-right" aria-hidden="true"></i>
            <a href="#">{{ __("Properties") }}</a>
          </p>
        </div>
      </div>
    </div>
    <br/>
    <div class="row">

      @if(count($properties) > 0)
      @foreach($properties as $property)
      @php
      $property = json_decode($property);

      $image = 'default.jpg';
      if(!empty($property->thumbnail) && file_exists(public_path().'/images/property/'.$property->thumbnail)){
        $image = $property->thumbnail;
      }
      @endphp
      <div class="col-md-4 col-sm-6">
        <div class="at-property-item at-col-default-mar">
          <div class="at-property-img property_img_box">
            <img src="{{asset('images/property/'.$image )}}" alt="">
            <div class="at-property-overlayer"></div>
            <a class="btn btn-default at-property-btn" href="{{url('/property-detail/'.$property->id)}}" role="button">{{__('View Details')}}</a>
            <h4 style="background: {{$property->listing_type == 'rent' ? '#038dd5' : ''}}">{{__('For'.' '.ucfirst($property->listing_type))}}</h4>
            <h5>{{"$ ". number_format($property->price ?? 0, 2) }}</h5>
          </div>
          <div class="at-property-dis">
            <ul>
              <li title="Property size"><i class="fa fa-object-group" aria-hidden="true"></i> {{$property->property_size}}m<sup>2</sup></li>
              @if($property->property_type_id <> 1)
              <li title="Bedroom"><i class="fa fa-bed" aria-hidden="true"></i> {{$property->bed_room}}</li>
              <li title="Bathroom"><i class="fa fa-bath" aria-hidden="true"></i> {{$property->bath_room}}</li>
              <li title="Floor number"><i class="fa fa-building-o" aria-hidden="true"></i> {{$property->floor_number}}</li>
              @endif
            </ul>
          </div>
          <div class="at-property-location">
            <h4>
              <a href="{{url('/property-detail/'.$property->id)}}"  class="related_property_title" style="height:30px;margin-top:-10px;">
                {{ @$property->code. "-" . ($property->title ? $property->title : 'N/A')}}
              </a>
            </h4>
            <p>
              <i class="fa fa-map-marker" aria-hidden="true"></i> 
              {{ !empty(@$property->province_id->title) ? @$property->province_id->title : 'N/A' }}
            </p>
          </div>
        </div>
      </div>
      @endforeach
      @else
      <center>{{ __("No Property listing...") }}</center>
      @endif

    </div>

    <div class="at-pagination">
      {{ $properties->appends($requestQuery)->links() }}
    </div>
  </div>
</section>
<!-- Property End -->
@endsection