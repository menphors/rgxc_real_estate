@extends('backend.app')
@section("title")
    {{ __('Property Type') }}
@endsection
@section('content')
    <form action="{{ $action }}" method="post" id="property-type-form">
        @csrf
        <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-body">
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
                                                            <label for="title_{{ $localeCode }}">{{ __('Title') }}</label>
                                                            <input type="text" class="form-control" id="title_{{ $localeCode }}" name="title_{{ $localeCode }}" value="{{ old('title_'.$localeCode, (@$property_type ? @$property_type->translate($localeCode)->title : "")) }}" placeholder="{{ __('Enter Title') }}"/>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="row kt-margin-t-20">
                            <div class="col-12 text-right">
                                <a href="{{ route("administrator.property-type-listing") }}" class="btn btn-danger">
                                    <i class="la la-long-arrow-left"></i> {{ __("Back") }}
                                </a>
                                <button type="submit" class="btn btn-info">
                                    <i class="fa fa-save"></i>
                                    {{ __("Save") }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    </form>
    @endsection

@section("script")
    <script type="text/javascript">
        $(function () {
            $("#property-type-form").validate();
            $('.kt-menu__item__property_block').addClass('kt-menu__item--open');
            $('.kt-menu__item__property_type').addClass(' kt-menu__item--active');
        })
    </script>
    @endsection