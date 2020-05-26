@extends('front.app')
@section("title")
    {{ __("Agent Detail") }}
@endsection

@section('content')
    <!-- Inner page heading start from here -->
    <section id="at-inner-title-sec">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="at-inner-title-box">
                        <h2>{{ __("Agent Details") }}</h2>
                        <p><a href="/">{{ __("Home") }}</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="#">{{ __("Agents") }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Inner page heading end -->

    <!-- Agents Details start from here -->
    @php 
        $image = 'default.jpg';
        if(!empty(@$agent->thumbnail) && file_exists(public_path().'/photos/account/'.@$agent->thumbnail)){
            $image = @$agent->thumbnail;
        }
    @endphp
    <section class="at-agents-details-sec">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <div class="at-singel-agent  at-col-default-mar">
                        <img src="{{asset('photos/account/'.$image )}}" alt="{{asset('photos/account/'.$image )}}">
                    </div>
                </div>
                <div class="col-md-8 col-sm-8">
                    <div class="at-agents-details-col">
                        <h4>{{$agent->username ?? 'N/A'}}</h4>
                        <p>{{__("Phone")}} : {{$agent->phone1 ?? 'N/A'}}</p>
                        <p>{{ __("Email") }} : {{$agent->email ?? 'N/A'}}</p>
                        <div class="at-agent-socil-contact">
                            <a target="_blank" href="{{$agent->fb ?? '#'}}" tabindex="0"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            <a target="_blank" href="{{$agent->linkedin ?? '#'}}" tabindex="0"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                        </div>
                        <div class="at-start">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star-half-o" aria-hidden="true"></i>
                        </div>
                        <p>{{$agent->remark ?? 'N/A'}}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3>{{__('OTHER AGENTS')}}</h3>
                </div>
                
                @if(count($other_agents) > 0)
                    @foreach($other_agents as $agent)
                        @php 
                            $image = 'default.jpg';
                            if(!empty(@$agent->thumbnail) && file_exists(public_path().'/photos/account/'.@$agent->thumbnail)){
                                $image = @$agent->thumbnail;
                            }
                        @endphp
                        <div class="col-md-3 col-sm-6">
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
                                    <h4><a href="{{url('/agent-detail/'.@$agent->id)}}">{{@$agent->username}}</a></h4>
                                    <p>{{ __("sales executive") }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <center>{{ __("No Other Agent...") }}</center>
                @endif
                
            </div>
        </div>
    </section>
    <!-- Agents End -->
@endsection