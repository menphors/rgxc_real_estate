@extends('backend.app')
@section("title") {{ __('User Management') }} @endsection
@section("breadcrumb")
    <li class="breadcrumb-item"><a href="{{ url('/administrator') }}">{{ __("Home") }}</a></li>
    <li class="breadcrumb-item active">{{ __("User") }}</li>
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-default">
                        <div class="card-body">
                            @include("backend.partial.message")
                            {{ Form::open(['url' => '/administrator/user'.(!empty($item)?'/'.$item->id:''), 'method'=> (!empty($item)?'PUT':'POST')]) }}        
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <input type="hidden" value="{{$item->id??''}}" name="user_id">
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <label for="name">{{ __("Name") }}</label>
                                                        <input type="name" name="name" class="form-control" value="{{ old("name", @$item->name) }}" required>
                                                        @if ($errors->has('name'))
                                                            <span class="text-danger" role="alert">
                                                                <i>{{ $errors->first('name') }}</i>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="email">{{ __("Email") }} <span class="text-danger">*</span> </label>
                                                        <input type="email" name="email" class="form-control" value="{{ old("email", @$item->email) }}" required>
                                                        @if ($errors->has('email'))
                                                            <span class="text-danger" role="alert">
                                                                <i>{{ $errors->first('email') }}</i>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="phone">{{ __("Phone") }}</label>
                                                        <input type="number" name="phone" class="form-control" value="{{ old("phone", @$item->phone) }}">
                                                        @if ($errors->has('phone'))
                                                            <span class="text-danger" role="alert">
                                                                <i>{{ $errors->first('phone') }}</i>
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <div id="div-pass" class="col-md-12 no-padding" style="display: {{ !empty(@$item)? "none": "" }}">
                                                        <div class="form-group">
                                                            <label for="password">{{ __("Password") }} <span class="text-danger">*</span></label>
                                                            <input type="password" name="password" value="{{ old("password") }}" class="form-control"/>
                                                            @if ($errors->has('password'))
                                                                <span class="text-danger" role="alert">
                                                                    <i>{{ $errors->first('password') }}</i>
                                                                </span>
                                                            @endif
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="password_confirmation">{{ __("Confirmation Password") }} <span class="text-danger">*</span></label>
                                                            <input type="password" name="password_confirmation" value="{{ old("password_confirmation") }}" class="form-control"/>
                                                            @if ($errors->has('password_confirmation'))
                                                                <span class="text-danger" role="alert">
                                                                    <i>{{ $errors->first('password_confirmation') }}</i>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                {!! Form::input('hidden','id', $item->id??'') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 right-col">
                                        <div class="panel panel-default">
                                            <div class="panel-heading category-header">
                                                {!! Form::label('role_id', 'Role') !!}
                                                <span class="text-danger">*</span>
                                            </div>
                                            <div class="panel-body">
                                                {{Form::mySelect('role', $list_role, $selected_role, '', ['class'=>'list-role'])}}

                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading category-header">{!! Form::label('status', 'Status') !!}</div>
                                            <div class="panel-body">
                                                {{Form::selectPublish('status', $item->status??0)}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="pull-right">
                                            {{Html::linkCancel(url('/administrator/user'))}}
                                            {{Form::submitSave('Submit')}}
                                        </div>
                                    </div>
                                </div>

                            {!! Form::close() !!}
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
    $(document).ready(function(){
        if($("#chnpassword").length != 0){
            changepassword($("#chnpassword"));
        }

    });
</script>

@stop
