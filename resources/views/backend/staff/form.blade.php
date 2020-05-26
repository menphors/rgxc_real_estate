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
                <h5 class="card-title">@if(empty($item)){{ __('Personal Information') }} @else {{ __('Modify') }} @endif</h5>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <label for="staff-type">{{ __("Staff Type") }}</label>
                    <select name="staff_type" class="form-control">
                      @foreach($list_role as $k => $type)
                        <option value="{{ $k }}" {{ old("staff_type", @$item->type) == $k? "selected" : ""  }}>{{ $type }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <br/>
                <div class="row">
                  <div class="col-sm-6">
                    {{Form::myText('name', $item->name??'', __('Name'), ['placeholder' => __('Enter Name'), 'required'], $errors, true)}}
                  </div>
                  <div class="col-sm-6">
                    {{Form::myText('email', $item->email??'', __('Email'), ['placeholder' => __('Enter Email')], $errors, false)}}
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-6">
                    <label for="office_id">{{ __("Office") }}</label>
                    <select class="form-control" name="office_id">
                      {{-- <option value="">{{ __("Please Select") }}</option> --}}
                      @if($offices->count())
                        @foreach($offices as $office)
                          <option value="{{ $office->id }}" {{ old("office_id", @$item->office_id)== $office->id? "selected" : "" }}>{{ $office->name }}</option>
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

                <div class="row">
                  <div class="col-sm-6">
                    <label for="gender">{{ __("Gender") }}</label>
                    <select name="gender" class="form-control">
                      @foreach(gender() as $k => $v)
                        <option value="{{ $k }}" {{ old("gender", @$item->gender)  == $k ? "selected": "" }}>{{ $v }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-sm-6">
                    <label for="dob">{{ __("Date of Birth") }}</label>
                    <div class="input-group date">
                      <input type="text" class="form-control" readonly="" name="dob" value="{{ !empty(@$item->dob)? date("d-M-Y", strtotime(@$item->dob)) : "" }}" placeholder="Select date" id="kt_datepicker_2">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="la la-calendar-check-o"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>

                <br/>
                {{ Form::label('address', __('Address')) }}
                {{ Form::textarea('address', $item->address??'', ['class' => 'form-control', 'rows' => 3])}}
                <br/>
                <div class="row">
                  <div class="col-sm-6">
                    {{Form::myText('fb', $item->fb??'', __('Facebook'), ['placeholder' => __('Enter Facebook URL')], [], false)}}
                  </div>
                  <div class="col-sm-6">
                    {{Form::myText('linkedin', $item->linkedin??'', __('LinkedIn'), ['placeholder' => __('Enter LinkedIn URL')], [], false)}}
                  </div>
                </div>

                <br>
                <hr>
                <h4 class="">{{ __('System') }}</h4>
                <label class="kt-checkbox kt-checkbox--success" style="padding-top: 2px">
                  <input type="checkbox" name="is_user" id="is-user" value="1" {{ @$item->is_user == 1 ? "checked" : "" }}> {{ __("Able to access") }}
                  <span></span>
                </label>

                <div class="row block-hidden" style="display: {{ @$item->is_user==0 ? 'none' : '' }};">
                  <div class="col-sm-6">
                    {{ Form::myEmail('user_email', ((@$item->user->email ?? @$item->email) ?? ''), __('Email'), ['placeholder' => __('Enter Email')], [], false) }}
                  </div>
                  <div class="col-sm-6">
                    {{ Form::myPassword('user_password', __('Password'), ['placeholder' => __('Enter Password')], [], false) }}
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title font-size-1-rem">
                  <a href="javascript:;" class="w-100 btn btn-default btn-sm pull-right btn-add btn-add-profile-image"><small>+ {{ __('add image') }}</small></a>
                </h3>
              </div>
              <div class="card-body btn-add-profile-image cursor-pointer">
                <input type='file' id="input-profile-image" class="d-none click-input-profile-image" name="thumbnail" />
                @if($item && $item->thumbnail != '')
                  <img id="preview-profile-image" src="{{ url('photos/account/'.$item->thumbnail) }}" width="100%">
                @else
                  <img id="preview-profile-image" src="{{ url('none.png') }}" width="100%">
                @endif
              </div>
            </div>
            <div class="card card-default">
              <div class="card-body text-right">
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
    $(document).ready(function() {
      $("input#is-user").on('click', function() {
        let checked = $(this).is(':checked') ? true : false;
        if(checked) {
          $(".block-hidden").show();
        }
        else {
          $(".block-hidden").hide();
        }
      });
    });

    (function () {
      var arrows;
      if (KTUtil.isRTL()) {
        arrows = {
          leftArrow: '<i class="la la-angle-right"></i>',
          rightArrow: '<i class="la la-angle-left"></i>'
        }
      } 
      else {
        arrows = {
          leftArrow: '<i class="la la-angle-left"></i>',
          rightArrow: '<i class="la la-angle-right"></i>'
        }
      }
      $('#kt_datepicker_2').datepicker({
        rtl: KTUtil.isRTL(),
        todayHighlight: true,
        format: "dd-M-yyyy",
        orientation: "bottom left",
        templates: arrows
      });

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
