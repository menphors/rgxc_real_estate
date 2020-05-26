@extends('backend.app')
@section("title")
    {{ __('Staff Management') }}    
@endsection
@section("breadcrumb")
    <li class="breadcrumb-item"><a href="{{ url('/administrator') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Staff Management') }}</li>
@endsection
@section('content')
{{ Form::open(['url' => '/administrator/staff'.(!empty($item)?'/'.$item->id:''), 'method'=> (!empty($item)?'PUT':'POST'), 'enctype' => 'multipart/form-data']) }}        
    {!! Form::input('hidden','id', $item->id??'') !!}
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">@if(empty($item)){{ __('Personal Information') }} @else {{ __('Modify') }} @endif</h3>
                          </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    {{Form::myText('name', $item->username??'', __('Name'), ['placeholder' => __('Enter Name'), 'required'], $errors, true)}}
                                </div>
                                <div class="col-sm-6">
                                    {{Form::myText('email', $item->email??'', __('Email'), ['placeholder' => __('Enter Email'), 'required'], $errors, true)}}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="office_id">{{ __("Office") }}</label>
                                    <select class="form-control" name="office_id">
                                        <option value="">{{ __("Please Select") }}</option>
                                        @if($offices->count())
                                            @foreach($offices as $office)
                                                <option value="{{ $office->id }}">{{ $office->name }}</option>
                                                @endforeach
                                            @endif
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    {{Form::myText('id_card', $item->id_card??'', __('ID Card'), ['placeholder' => __('Enter ID Card'), 'required'], $errors, true)}}
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-6">
                                    {{Form::myText('phone1', $item->phone1??'', __('Phone1'), ['placeholder' => __('Enter Phone1'), 'required'], $errors, true)}}
                                </div>
                                <div class="col-sm-6">
                                    {{Form::myText('phone2', $item->phone2??'', __('Phone2'), ['placeholder' => __('Enter Phone2')], [], false)}}
                                </div>
                            </div>

                            {{ Form::label('address', __('Address')) }}
                            {{Form::textarea('address', $item->address??'', ['class' => 'form-control', 'rows' => 3])}}
                            
                        </div>
                    </div>

                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title font-size-1-rem">{{ __('Social Information') }}</h3>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-sm-6">
                                    {{Form::myText('fb', $item->fb??'', __('Facebook'), ['placeholder' => __('Enter Facebook URL')], [], false)}}
                                </div>
                                <div class="col-sm-6">
                                    {{Form::myText('linkedin', $item->linkedin??'', __('LinkedIn'), ['placeholder' => __('Enter LinkedIn URL')], [], false)}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-default">
                        <div class="card-header d-none">
                            <h3 class="card-title font-size-1-rem">
                                <a href="javascript:;" class="w-100 btn btn-default btn-sm pull-right btn-add btn-add-profile-image"><small>+ add Profile Photo</small></a>
                            </h3>
                        </div>
                        <div class="card-body btn-add-profile-image cursor-pointer">
                            <input type='file' id="input-profile-image" class="d-none click-input-profile-image" name="thumbnail" />
                            @if($item && $item->thumbnail != '')
                                <img id="preview-profile-image" src="{{ url('photos/account/'.$item->thumbnail) }}" width="100%">
                            @else
                                <img id="preview-profile-image" src="https://newcart.firebaseapp.com/images/none.png" width="100%">
                            @endif
                        </div>
                    </div>
                    <div class="card card-default">
                        <div class="card-body">
                            {!! Form::label('role', 'Role') !!}<span class="text-danger">&nbsp;*</span>
                            {{Form::select('role[]', $list_role, $selected_role ?? [], ['class' => 'form-control select2-multiple', 'multiple'])}}
                            @if ($errors->has('role')) <p class="text-danger">{{ $errors->first('role') }}</p> @endif
                        </div>
                    </div>
                    <div class="card card-default">
                        <div class="card-body">
                            {!! Form::label('status', 'Status') !!}
                            {{Form::selectPublish('status', $item->user->status??0)}}
                        </div>
                    </div>
                    <div class="card card-default">
                        <div class="card-body">
                            <a href="{{ route('administrator.staff.index') }}" class="btn btn-danger">
                                <i class="la la-long-arrow-left">&nbsp;</i>{{ __("Cancel") }}
                            </a>
                            {{ Form::submitSave(__('Save'), ['class' => 'w-100-px', 'type' => 'submit']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
{!! Form::close() !!}
@endsection
@section('script')
<script type="text/javascript">
    (function () {
        $('.kt-menu__item__setting').addClass(' kt-menu__item--open');
        $('.kt-menu__item__staff').addClass(' kt-menu__item--active');

        //Profile Image
        $('.btn-add-profile-image').click(function (e) {
            return $('#input-profile-image')[0].click();
        });
        $("#input-profile-image").change(function() {
            profileImage(this);
        });

    }).call(this);

    function profileImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview-profile-image').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    
</script>
@stop
