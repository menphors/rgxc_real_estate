@extends('backend.app')
@section("title") {{ __('User Management') }} @endsection
@section("breadcrumb")
    <li class="breadcrumb-item"><a href="{{ url('/administrator') }}">Home</a></li>
    <li class="breadcrumb-item active">User</li>
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-default">
                        <div class="card-body">
                            <form action="{{ route("administrator.user.store-change-password", $user->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="old-password">{{ __("Old Password") }} <span class="text-danger">*</span> </label>
                                    <input type="password" name="old_password" value="{{ old("old_password") }}" class="form-control" required/>
                                </div>
                                @if ($errors->has('old_password'))
                                    <span class="text-danger" role="alert">
                                        <i>{{ $errors->first('old_password') }}</i>
                                    </span>
                                @endif

                                <div class="form-group">
                                    <label for="new-password">{{ __("New Password") }} <span class="text-danger">*</span></label>
                                    <input type="password" name="new_password" value="{{ old("new_password") }}" class="form-control" required/>
                                    @if ($errors->has('new_password'))
                                        <span class="text-danger" role="alert">
                                            <i>{{ $errors->first('new_password') }}</i>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">{{ __("Confirm Password") }} <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" value="{{ old("password_confirmation") }}" class="form-control" required/>
                                    @if ($errors->has('password_confirmation'))
                                        <span class="text-danger" role="alert">
                                            <i>{{ $errors->first('password_confirmation') }}</i>
                                        </span>
                                    @endif
                                </div>

                                <div class="row kt-margin-t-20">
                                    <div class="col-12 text-right">
                                        <a href="{{ route("administrator.user.index") }}" class="btn btn-danger">
                                            <i class="la la-long-arrow-left"></i> {{ __("Back") }}
                                        </a>
                                        <button type="submit" class="btn btn-info">
                                            <i class="fa fa-save"></i>
                                            {{ __("Save") }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endsection
@section('script')
    <script language="javascript" type="text/javascript">
        $( document ).ready(function() {
            $('.kt-menu__item__setting').addClass(' kt-menu__item--open');
            $('.kt-menu__item__user').addClass(' kt-menu__item--active');
        });
        </script>
    @endsection