@extends('front.app')
@section("title")
    {{ __("Home") }}
@endsection

@section('content')

    @include('front.partial._slide_show')

    @include('front.common.property_filter')

    <!-- Property start from here -->
    <section class="at-property-sec">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="at-sec-title at-sec-title-left">
                        <h2>{{ __("Awesome") }} <span>{{__("Property")}}</span></h2>
                        <div class="at-heading-under-line">
                            <div class="at-heading-inside-line"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row animatedParent animateOnce">

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
                                    <img src="{{asset(config("global.property_image_path").$image )}}" onerror="this.src='{{ asset(config("global.property_image_path")."none.png") }}';" alt="">
                                    <div class="at-property-overlayer"></div>
                                    <a class="btn btn-default at-property-btn" href="{{url('/property-detail/'.$property->id)}}" role="button">View Details</a>
                                    <h4 style="background: {{$property->listing_type == 'rent' ? '#038dd5' : ''}}">For {{ucfirst($property->listing_type)}}</h4>
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
                                            {{ $property->code . '-' . ($property->title ? $property->title : 'N/A')}}
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
                <div class="col-md-12 col-sm-12 text-center">
                    <a class="btn btn-default hvr-bounce-to-right" href="{{url('/properties')}}" role="button">{{ __("More Properties") }}</a>
                </div>
            </div>
        </div>
    </section>
    <!-- Property End -->
    {!! @$home_page_widget->content !!}


    <!-- Agents start from here -->
    <section class="at-agents-sec">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="at-sec-title">
                        <h2>{{ __("Our valuable") }} <span>{{ __("Agents") }}</span></h2>
                        <div class="at-heading-under-line">
                            <div class="at-heading-inside-line"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="agent-carousel" data-slick='{"slidesToShow": 4, "slidesToScroll": 1}'>
                        @if(count($agents) > 0)
                            @foreach($agents as $agent)
                                @php
                                    $image = 'default.jpg';
                                    if(!empty(@$agent->thumbnail) && file_exists(public_path().'/photos/account/'.@$agent->thumbnail)){
                                        $image = @$agent->thumbnail;
                                    }
                                @endphp
                                <div class="at-agent-col">
                                    <div class="at-agent-img">
                                        <img src="{{asset('photos/account/'.$image )}}" alt="" style="height: 300px;object-fit: cover;">
                                        <div class="at-agent-social">
                                            <a target="_blank" href="{{!empty(@$agent->fb) ? @$agent->fb : "#"}}"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                            <a target="_blank" href="{{!empty(@$agent->linkedin) ? @$agent->linkedin : "#"}}"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                                            <div class="at-agent-call">
                                                <p>{{!empty(@$agent->phone1) ? @$agent->phone1 : "N/A"}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="at-agent-info">
                                        <h4><a href="{{url('/agent-detail/'.@$agent->id)}}">{{@$agent->name}}</a></h4>
                                        <p>{{ __("sales executive") }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Agents End -->


@endsection
