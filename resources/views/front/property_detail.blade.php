@extends('front.app')

@section("title")
  {{__("Property Detail")}}
@endsection

@section('content')
<!-- Property start from here -->
<section class="at-property-sec at-property-right-sidebar"  style="padding: 20px 0 70px;">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-sm-6">
        <div class="at-inner-title-box">
          <h2>{{__("Properties Detail")}}</h2>
          <p>
            <a href="/">{{ __("Home") }}</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i>
            <a href="#">{{ __("Properties") }}</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i>
            <a href="#" style="color:#f1861c;">{{$property->title}}</a>
          </p>
        </div>
      </div>
    </div>

    <br/>

    <div class="row">
      <div class="col-lg-9">
        <div class="at-property-details-col">
          <div id="myCarousel" class="carousel slide" data-ride="carousel">
            @php
              $image = 'default.jpg';
              if(!empty($property->thumbnail)) {
                $image = $property->thumbnail;
              }
            @endphp

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
              <div class="item active gallery">
                <a href="{{ asset(config("global.property_image_path").$image) }}" class="big">
                  <img src="{{asset(config("global.property_image_path").$image )}}" alt="" class="slide_image_size">
                </a>
              </div>
              @if(count(@$property->attachments) > 0)
                <?php $i=0; ?>
                @foreach(@$property->attachments as $attachment)
                  <div class="item gallery">
                    <a href="{{ asset(config("global.property_image_path").'/'.@$property->id.'/'.@$attachment->name) }}" class="big">
                      <img src="{{asset(config("global.property_image_path").'/'.@$property->id.'/'.@$attachment->name )}}" alt="" class="slide_image_size">
                    </a>
                  </div>
                  <?php $i++ ?>
                @endforeach
              @endif
            </div>
            <!-- End Carousel Inner -->

            <ul class="nav nav-pills" style="margin-left: -2px">
              @if(count(@$property->attachments) > 0)
                <li data-target="#myCarousel" data-slide-to="0" class="active">
                  <a href="#">
                    <img src="{{asset(config("global.property_image_path").$image )}}" alt="" class="sub_slide_image_size">
                  </a>
                </li>

                @foreach(@$property->attachments as $key => $attachment)
                  <li data-target="#myCarousel" data-slide-to="{{$key+1}}">
                    <a href="#">
                      <img src="{{asset(config("global.property_image_path").'/'.@$property->id.'/'.@$attachment->name )}}" alt="" class="sub_slide_image_size">
                    </a>
                  </li>
                @endforeach
              @endif
            </ul>
          </div>
          <!-- End Carousel -->

          <div class="at-sec-title at-sec-title-left">
            <h2>{{ @$property->code }} - {{$property->title ? $property->title : 'N/A'}}</h2>
            <div class="at-heading-under-line">
              <div class="at-heading-inside-line"></div>
            </div>
            <p>
              <i class="fa fa-map-marker"></i> {{ @$property->province_id->title }}
            </p>

            <br>
            <div class="row at-property-features">
              <ul class="col-md-6">
                <li class="bg-white">{{__('web-property-price')}} : <span class="pull-right label-price">{{number_format(@$property->price, 2)}}$</span></li>
                <li class="bg-white">{{__('Price per sqm')}} : <span class="pull-right label-price">{!! @$property->data->price_sqm ? @$property->data->price_sqm.'/m<sup>2</sup>' : 'N/A' !!}</span></li>
                <li class="bg-white">{{__('web-property-size')}} : <span class="pull-right">{{@$property->habitable_surface ? @$property->habitable_surface : 0}}</span></li>
                <li class="bg-white">{{__('Properties surface (sqm)')}} : <span class="pull-right">{{@$property->property_size ? @$property->property_size : 0}}m<sup>2</sup></span></li>
              </ul>
              <ul class="col-md-6">
                <li class="bg-white">{{__('web-property-id')}} : <span class="pull-right">{{@$property->code ? strtoupper(@$property->code) : "N/A"}}</span></li>
                <li class="bg-white">{{__('Property Type')}} : <span class="pull-right">{{@$property->property_type_id->title }}</span></li>
                <li class="bg-white">{{__('Listing Type')}} : <span class="pull-right">{{ __(ucfirst(@$property->listing_type)) }}</span></li>
                <li class="bg-white">{{__('Address')}} : <span class="pull-right">{{ @$property->district_id->title.', '. $property->province_id->title }}</span></li>
              </ul>
            </div>

            @if(count(@$property->property_tag) > 0)
              <div class="mt-3">
                <h4>{{ __('Tags') }}</h4>
                <div class="at-sidebar-tags" style="font-size:14px;">
                  @foreach(@$property->property_tag as $property_tag)
                    <a href="{{ url('properties').'?option=keyword&search='.$property_tag->tag->title }}" class=""><i class="fa fa-tag"></i> {{ $property_tag->tag->title }}</a>
                  @endforeach
                </div>
              </div>
            @endif

            <div class="mt-3">{!!$property->remark ? $property->remark : '' !!}</div>
          </div>

          @if(@$property->property_type_id->title != __("Land"))
          <div class="at-sec-title at-sec-title-left">
            <h2>{{__('web-features')}}</h2>
            <div class="at-heading-under-line">
              <div class="at-heading-inside-line"></div>
            </div>
          </div>
          <div class="row at-property-features">
            <div class="col-md-6 clearfix">
              <ul>
                <li>{{__('web-floor-number')}} : <span class="pull-right">{{!empty(@$property->floor_number) ? $property->floor_number : 0}}</span></li>
                <li>{!!__('Total Build Surface')!!} : <span class="pull-right">{{!empty(@$property->data->total_build_surface) ? $property->data->total_build_surface : 0}}</span></li>
                <li>{{__('Floor Level')}} : <span class="pull-right">{{!empty(@$property->data->floor_level) ? $property->data->floor_level : 0}}</span></li>
                <li>{{__('Bedroom')}} : <span class="pull-right">{{!empty(@$property->bed_room) ? $property->bed_room : 0}}</span></li>
                <li>{{__('Bathroom')}} : <span class="pull-right">{{!empty(@$property->bath_room) ? $property->bath_room : 0}}</span></li>
              </ul>
            </div>
            <div class="col-md-6">
              <ul>
                <li>{{__('Built up surface')}} : <span class="pull-right">{{@$property->built_up_surface ? @$property->built_up_surface : 0}}m<sup>2</sup></span></li>
                <li>{{__('Ground surface')}} : <span class="pull-right">{{@$property->ground_surface ? @$property->ground_surface : 0}}</span></li>
                <li>{{__('web-basement')}} : <span class="pull-right">{{@$property->front_refer_to ? @$property->front_refer_to : 0}}</span></li>
                <li>{{__('Year Renovation')}} : <span class="pull-right">{{@$property->year_of_renovation ? @$property->year_of_renovation : "N/A"}}</span></li>
                <li>{{__('web-year-construction')}} : <span class="pull-right">{{@$property->year_of_construction ? @$property->year_of_construction : "N/A"}}</span></li>
              </ul>
            </div>
          </div>
          @endif

          @if(@$property->property_type_id->title != __("Land"))
          <div class="at-sec-title at-sec-title-left">
            <h2>{{__('More Detail')}}</h2>
            <div class="at-heading-under-line">
              <div class="at-heading-inside-line"></div>
            </div>
          </div>
          <div class="amentities">
            <ul>
              {!! $property->has_swimming_pool==1 ? '<li><i class="fa fa-check"></i> '.__('Has swimming pool').'</li>' : '' !!}
              {!! $property->has_elevator==1 ? '<li><i class="fa fa-check"></i> '.__('Has elevator').'</li>' : '' !!}
              {!! $property->has_basement==1 ? '<li><i class="fa fa-check"></i> '.__('Has basement').'</li>' : '' !!}
              {!! $property->has_parking==1 ? '<li><i class="fa fa-check"></i> '.__('Has Parking').'</li>' : '' !!}

              @foreach($property->data->amentities as $key => $other_service)
                @if(!empty($other_service))
                  <li><i class="fa fa-check"></i> {{ __($other_service) }}</li>
                @endif
              @endforeach
            </ul>
          </div>
          @endif
        </div>
      </div>

      <div class="col-lg-3">
        <div class="at-sidebar at-col-default-mar">
          <div class="at-latest-news">
            <h3 class="at-sedebar-title" style="margin-bottom: unset!important;">{{ __("Contact") }}</h3>
            <p>{!! !empty(@$sidebar->content) ? @$sidebar->content : "N/A" !!}</p>

            {{-- <div class="at-divider-container">
              <div class="at-divider">{{__('Or')}}</div>
            </div>
            <form class="at-form-area at-enquiry-form" action="" method="POST">
              @csrf
              <div class="form-group">
                <input type="text" name="value" placeholder="{{ __('Name') }}" class="form-control mb-0" id="enquiry_value">
              </div>
              <div class="form-group">
                <input type="text" name="value" placeholder="{{ __('Preferred Contact') }}" class="form-control mb-0" id="enquiry_value">
              </div>
              <div class="form-group">
                <textarea name="enquiry_description" placeholder="{{ __('Write message to our agent here') }}" rows="5" class="form-control mb-0" id="enquiry_description"></textarea>
              </div>
              <button type="submit" class="btn btn-block hvr-bounce-to-right" id="">{{ __('Contact') }}</button>
            </form> --}}
          </div>

          <div class="at-latest-news">
            <h3 class="at-sedebar-title" style="margin-bottom: unset!important;">{{__("Related Properties")}}</h3>
            <ul>
              @if(count(@$relate_properties) > 0)
              @foreach($relate_properties as $relate_property)
              @php
              $relate_property = json_decode($relate_property);

              $image = 'default.jpg';
              if(!empty($relate_property->thumbnail) && file_exists(public_path().'/images/property/'.$relate_property->thumbnail)){
                $image = $relate_property->thumbnail;
              }
              @endphp
              <li style="height:100px;">
                <div class="at-news-item">
                  <img src="{{asset(config("global.property_image_path").$image )}}" alt="" style="object-fit:cover">
                  <h4>
                    <a href="{{url('/property-detail').'/'.$relate_property->id}}" class="related_property_title">{{$relate_property->title}}</a>
                  </h4>
                  <span class="related_property_description">
                    {{ @$relate_property->code  }}<br/>
                    <i class="fa fa-map-marker"></i> {!! @$relate_property->province_id->title !!}
                  </span>
                </div>
              </li>
              @endforeach
              @else
              {{ __("Not Found!") }}
              @endif
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Property End -->
@endsection

@section("script")
<script src="{{ asset('js/bootstrap-select.js') }}" type="text/javascript"></script>
<script type="text/javascript">
  $(function () {
    $('.gallery a').simpleLightbox();
    $("select.selectpicker").selectpicker();
  })
</script>
@endsection