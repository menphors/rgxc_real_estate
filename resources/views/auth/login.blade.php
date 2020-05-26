@extends('auth.layout')

@section('content')
    <div class="kt-grid kt-grid--ver kt-grid--root">
        <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v1" id="kt_login">
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--desktop kt-grid--ver-desktop kt-grid--hor-tablet-and-mobile">
                <!--begin::Aside-->
                <div class="kt-grid__item kt-grid__item--order-tablet-and-mobile-2 kt-grid kt-grid--hor kt-login__aside" style="background-image: url({{"backend/media/bg/bg-4.jpg"}});">
                    <div class="kt-grid__item">
                        <a href="#" class="kt-login__logo">
                            <img alt="Logo" src="{{ asset("images/logo.png") }}" width="300px"/>
                        </a>
                    </div>
                    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver">
                        <div class="kt-grid__item kt-grid__item--middle">
                            <h3 class="kt-login__title">Welcome to RXGC!</h3>
                            <h4 class="kt-login__subtitle">Welcome to Real Estate Application.</h4>
                        </div>
                    </div>
                </div>

                <!--begin::Aside-->

                <!--begin::Content-->
                <div class="kt-grid__item kt-grid__item--fluid  kt-grid__item--order-tablet-and-mobile-1  kt-login__wrapper">

                    <!--end::Head-->
                    <!--begin::Body-->
                    <div class="kt-login__body">

                        <!--begin::Signin-->
                        <div class="kt-login__form">
                            <div class="kt-login__title" style="margin-bottom: 30px">
                                <h3>{{ ucwords(__("sign in")) }}</h3>
                            </div>
                            <div class="alert-danger">
                                @if($errors->any())
                                    <span class="alert-text">{{$errors->first()}}</span>
                                @endif
                            </div>
                            <!--begin::Form-->
                            <form id="login-form" method="POST" action="{{ route("user-login") }}">
                                @csrf
                                <div class="form-group">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ __('E-Mail Address') }}" name="email" value="{{ old("email") }}" required autocomplete="off" autofocus>
                                    @error('email')
                                        <span class="text-danger" role="alert">
                                            <i>{{ $message }}</i>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input class="form-control @error('password') is-invalid @enderror" type="password" placeholder="Password" name="password" required autocomplete="current-password">
                                    @error('password')
                                        <span class="text-danger" role="alert">
                                            <i>{{ $message }}</i>
                                        </span>
                                    @enderror
                                </div>

                                <!--begin::Action-->
                                <div class="kt-login__actions pull-right kt-margin-t-0">
                                    <button type="submit" id="kt_login_signin_submit" class="btn btn-sm btn-primary kt-login__btn-primary element">
                                        <span class="fa fa-sign-in"></span>
                                        Sign In
                                    </button>
                                </div>

                                <!--end::Action-->
                            </form>

                            <!--end::Form-->
                        </div>

                        <!--end::Signin-->
                    </div>

                    <!--end::Body-->
                </div>
                <!--end::Content-->
            </div>
        </div>
    </div>
@endsection

@section("script")
    <script type="text/javascript">
        $(document).ready(function () {
            $("#login-form").validate();
        });
    </script>
@endsection
