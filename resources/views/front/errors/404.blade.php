@extends('front.app')
@section("title")
    {{__("404")}}
@endsection

@section('content')
    <section class="at-error-sec at-over-layer-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
                    <h1>Sorry!</h1>
                    <h2>The page you tried cannot be found</h2>
                    <a href="{{ url()->previous()  }}">Go BACK</a>
                </div>
            </div>
        </div>
    </section>
    @endsection