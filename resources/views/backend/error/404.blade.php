@extends('layouts.app')
@section('title')
    404
@endsection
<link href="{{ asset("css/demo1/pages/error/error-5.css") }}" rel="stylesheet" type="text/css">
@section('style')
    <style type="text/css">
        .kt-error-v5 .kt-error_container .kt-error_title > h1{
            margin-top: 5rem!important;
        }
    </style>
@endsection
@section('content')
    <div class="kt-grid kt-grid--ver kt-grid--root">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid  kt-error-v5" style="background-image: url(./assets/media//error/bg5.jpg);">
            <div class="kt-error_container">
                <span class="kt-error_title">
                    <h1>404!</h1>
                </span>
                <p class="kt-error_subtitle">
                    Something went wrong here.
                </p>
                <p class="kt-error_subtitle">
                    <a href="{{ url()->previous() }}" class="btn btn-danger">
                        <i class="la la-long-arrow-left"></i>
                        {{ trans("pms.back") }}
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection
@section("script")

@endsection