@extends('backend.app')
@section("title")
    {{ __('District') }}
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form action="{{ $action }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="code">{{ __("Province") }} <span class="text-danger">*</span> </label>
                            <select name="province_id" class="form-control">
                                @if($provinces->count())
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}" {{ old("province", @$data->province_id)== $province->id? "selected" : "" }}>{{ $province->title }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @if ($errors->has('code'))
                                <span class="text-danger" role="alert">
                                    <i>{{ $errors->first('code') }}</i>
                                </span>
                            @endif

                        </div>
                        <div class="form-group">
                            <label for="code">{{ __("Code") }} <span class="text-danger">*</span> </label>
                            <input type="text" name="code" class="form-control" value="{{ old("code", @$data->code) }}" required>
                            @if ($errors->has('code'))
                                <span class="text-danger" role="alert">
                                    <i>{{ $errors->first('code') }}</i>
                                </span>
                            @endif
                        </div>


                        <div class="kt-portlet kt-portlet--tabs no-margin-bottom">
                            <div class="kt-portlet__head">
                                <div class="kt-portlet__head-toolbar">
                                    <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-success" role="tablist">

                                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                            <li class="nav-item">
                                                <a class="nav-link {{ $localeCode == app()->getLocale() ? 'active' : '' }}" data-toggle="tab" href="#kt_portlet_base_{{$localeCode}}_tab_content" role="tab" aria-selected="true">
                                                    <img width="20" src="{{ asset("backend/media/flags/".$localeCode.".png") }}" alt="" />&nbsp;{!!$properties['name']!!}
                                                </a>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                            <div class="kt-portlet__body no-padding">
                                <div class="tab-content">
                                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        <div class="tab-pane {{ $localeCode == app()->getLocale() ? 'active' : '' }}" id="kt_portlet_base_{{$localeCode}}_tab_content" role="tabpanel">
                                            {{ Form::hidden('lang', $localeCode) }}

                                            <div class="kt-portlet">
                                                <div class="kt-portlet__head">
                                                    <div class="kt-portlet__head-label">
                                                        <h3 class="kt-portlet__head-title">
                                                            ({{$localeCode}})
                                                        </h3>
                                                    </div>
                                                </div>
                                                <div class="kt-form">
                                                    <div class="kt-portlet__body" style="padding-bottom: 0px;">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                {{Form::myText('title_'.$localeCode, old('title_'.$localeCode, (@$data? @$data->translate($localeCode)->title: ""))??'', __('Title'), ['placeholder' => __('') ], $errors, true)}}
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="row kt-margin-t-20">
                            <div class="col-12 text-right">
                                <a href="{{ route("administrator.district-list") }}" class="btn btn-danger">
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
    </section>
    @endsection

@section("script")
    <script type="text/javascript">
        $(function () {
            $('.kt-menu__item__setting').addClass(' kt-menu__item--open');
            $('.kt-menu__item__location').addClass(' kt-menu__item--open');
            $('.kt-menu__item__district').addClass(' kt-menu__item--active');
        })
    </script>
@endsection