@extends('backend.app')

@section("title")
    {{ __('Role Management') }}
@endsection

@section("breadcrumb")
    <li class="breadcrumb-item"><a href="{{ url('/administrator') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Role Management') }}</li>
@endsection

@section('content')
{{ Form::open(["url" => !empty($item)? route('administrator.role.update', $item->id) : route("administrator.role.store"), "method" => (!empty($item) ? 'PUT' : 'POST'), "enctype" => "multipart/form-data", "id" => "form-role", "class" => "form-horizontal"]) }}
    {!! Form::input('hidden','id', (!empty($item) ? $item->id : '')) !!}
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-default">
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        {{Form::myText('name', $item->title ?? '', __('Name') .' '. __('Role'), ['placeholder' => __('Enter') .' '. __('Name') .' '. __('Role'), 'required'], $errors, true)}}
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::label('name', __('Group') .' '. __('Role')) !!}
                                        {{ Form::select('role_type', config('data.admin.role_types'), $item->role_type ?? '', ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            <label class="m-b-15-px cursor-pointer">
                                <label class=" cursor-pointer">
                                    <label class="kt-checkbox">
                                        <b><u>{!! Form::checkbox('check_all', '', false, ['id' => 'assign_permission', 'class' => 'd-none']) !!}{{ __('Assign All Permission') }}</u></b>
                                        <span></span>
                                    </label>
                                </label>
                            </label>

                            @foreach($list_permission as $key => $permissions)
                                <div class="row" style="">
                                    <div class="col-md-3">
                                        <label class=" cursor-pointer">
                                            <label class="kt-checkbox">
                                                {!! Form::checkbox('check_all', '', false, ['id' => str_replace(' ', '_', strtolower($key))]) !!}
                                                <b>{{ $key }}</b>
                                                <span></span>
                                            </label>
                                        </label>
                                    </div>
                                </div>
                                <div class="row" style="padding-left: 40px">
                                    @foreach($permissions as $id => $per)
                                        <div class="col-md-3" style="">
                                            <label class="f-w-500">
                                                <label class="kt-checkbox">
                                                    {!! Form::checkbox('permission[]', $per, false, [ (in_array($per, $selected_permission))? "checked" : null , 'class' => str_replace(' ', '_', strtolower($key))]) !!} {!! ucfirst(str_replace('_', ' ', $per)) !!}
                                                    <span></span>
                                                </label>

                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                            <div class="rows">
                                <div class="float-right">
                                    <a href="{{ route('administrator.role.index') }}" class="btn btn-danger">
                                        <i class="la la-long-arrow-left">&nbsp;</i>{{ __("Cancel") }}
                                    </a>
                                    {{Form::submitSave(__('Save'), ['class' => 'w-100-px', 'type' => 'submit'])}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
{{ Form::close() }}
@endsection
@section('script')
<script type="text/javascript">
    $( document ).ready(function() {
        $('.kt-menu__item__setting').addClass(' kt-menu__item--open');
        $('.kt-menu__item__role').addClass(' kt-menu__item--active');
    });

    $(function(){
        $('.menu_user').addClass('active');
        $('.menu_user_role').addClass('active');

        $("#assign_permission").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        $("#user_management").click(function(){
            $('.user_management').not(this).prop('checked', this.checked);
        });

        $("#type_management").click(function(){
            $('.type_management').not(this).prop('checked', this.checked);
        });

        $("#role_management").click(function(){
            $('.role_management').not(this).prop('checked', this.checked);
        });

        $("#office_management").click(function(){
            $('.office_management').not(this).prop('checked', this.checked);
        });

        $("#newsletter_management").click(function(){
            $('.newsletter_management').not(this).prop('checked', this.checked);
        });

        $("#property_management").click(function(){
            $('.property_management').not(this).prop('checked', this.checked);
        });

        $("#staff_management").click(function(){
            $('.staff_management').not(this).prop('checked', this.checked);
        });

        $("#owner_management").click(function(){
            $('.owner_management').not(this).prop('checked', this.checked);
        });

        $("#tag_management").click(function(){
            $('.tag_management').not(this).prop('checked', this.checked);
        });

        $("#customer_management").click(function(){
            $('.customer_management').not(this).prop('checked', this.checked);
        });

        $("#project_management").click(function(){
            $('.project_management').not(this).prop('checked', this.checked);
        });

        $("#location_management").click(function(){
            $('.location_management').not(this).prop('checked', this.checked);
        });

        $("#cms_management").click(function(){
            $('.cms_management').not(this).prop('checked', this.checked);
        });

        $("#report_management").click(function(){
            $('.report_management').not(this).prop('checked', this.checked);
        });
    });

    
</script>
@stop
