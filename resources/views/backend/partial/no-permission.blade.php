@extends('backend.app')
@section("title")
    {{ __("No Permission") }}
@endsection
@section("breadcrumb")
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active">{{ __("No Permission") }}</li>
    @endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="callout callout-info">
              <h5>{{ __("No Permission") }}</h5>
              <b><i class="fas fa-info"></i>  {{ __("Warning!") }}</b> You don't have permission to access this page.
            </div>
        </div>
    </section>
@endsection
