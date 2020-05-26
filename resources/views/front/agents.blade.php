@extends('front.app')
@section("title")
    {{ __("Agents") }}
@endsection

@section('content')
    <!-- Inner page heading start from here -->
    <section id="at-inner-title-sec">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="at-inner-title-box">
                        <h2>{{ __("Agents") }}</h2>
                        <p><a href="/">{{ __("Home") }}</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="#">{{ __("Agents") }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Inner page heading end -->

    <!-- Agents start from here -->
    <section class="at-agents-sec at-agents-sec-three">
        <div class="container">
            <div class="row">
                {{-- {{$agents}} --}}
                @if(count($agents) > 0)
                    @foreach($agents as $agent)
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
                                    <h4><a href="{{url('/agent-detail/'.@$agent->id)}}">{{@$agent->name}}</a></h4>
                                    <p>{{ __("sales executive") }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <center>{{ __("No Agent listing...") }}</center>
                @endif
            </div>
            <div class="at-pagination ">
                {{ $agents->links() }}
            </div>
        </div>
    </section>
    <!-- Agents End -->
@endsection