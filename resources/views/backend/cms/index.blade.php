@extends('backend.app')

@section("title")
    {{ __('CMS') }}
@endsection

@section("style")
@endsection

@section('content')
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="row">
            <div class="col-md-6">
              {{ Form::open(['url' => route('administrator.cms-index'), 'method' => 'GET', 'id' => 'form-search']) }}
                <select name="filter" class="form-control" onchange="this.form.submit()">
                  <option value="">{{ __("Please Select") }}</option>
                  @foreach(Constants::CMS_TYPE as $key => $type)
                    <option value="{{ $key }}" {{ request("filter") == $key ? "selected" : "" }}>{{ $type }}</option>
                  @endforeach
                </select>
              {{ Form::close() }}
            </div>
            <div class="col-md-6">
              <button type="button" class="btn btn-info w-100-px" onclick="btnSearch()">
                <i class="fa fa-filter"></i>
                {{ __('Search') }}
              </button>
              <a href="{{ route('administrator.cms-index') }}" class="btn btn-danger">
                <i class="fa fa-search-minus"></i>
                {{ __('Clear') }}
              </a>
              @if(isAdmin() || Auth::user()->can('cms.add'))
              <a href="{{ route('administrator.cms-create') }}" class="btn btn-info float-right">
                <i class="fa fa-plus"></i>
                {{ __('Add New') }}
              </a>
              @endif
            </div>
            <div class="clearfix">&nbsp;</div>
          </div>
          <div class="card">
            <div class="card-body table-responsive p-0">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>#</th>
                    <th></th>
                    <th>{{ __('Slug') }}</th>
                    <th>{{ __('Type') }}</th>
                    <th>{{ __('Blog') }}</th>
                    <th>{{ __('Created At') }}</th>
                    <th>{{ __('Updated At') }}</th>
                    <th width="90px">{{ __('Action') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @if($cms->count())
                    @foreach($cms as $key => $value)
                      <tr>
                        <td>{{ str_pad($key + 1, 2, '0', STR_PAD_LEFT) }}</td>
                        <td>
                          @if(@$value->type == Constants::CMS_TYPE_SLIDE_SHOW )
                            <img src="{{ asset(config("global.slide_show_image_path").@$value->thumbnail) }}" width="70px"/>
                          @elseif(@$value->type == Constants::CMS_TYPE_BRAND_CAROUSEL)
                            <img src="{{ asset(config("global.carousel_image_path").@$value->thumbnail) }}" width="70px"/>
                          @endif
                        </td>
                        <td>{{ @$value->slug }}</td>
                        <td>
                          <span class="badge badge-success">
                            {{ @Constants::CMS_TYPE[$value->type]}}
                          </span>
                        </td>
                        <td>
                          <span class="badge badge-info">
                            @if(@$value->type == Constants::CMS_TYPE_WIDGET)
                              {{ @Constants::BLOG_TYPE_WIDGET[$value->blog] }}
                            @elseif(@$value->type == Constants::CMS_TYPE_PAGE)
                              {{ @Constants::BLOG_TYPE_PAGE[$value->blog] }}
                            @elseif(@$value->type == Constants::CMS_TYPE_SLIDE_SHOW)
                              {{ __("Slide Show") }}
                            @elseif(@$value->type == Constants::CMS_TYPE_BRAND_CAROUSEL)
                              {{ __("Brand Carousel") }}
                            @endif
                          </span>
                        </td>
                        <td>{{ date("d-M-Y", strtotime($value->created_at)) }}</td>
                        <td>{{ date("d-M-Y", strtotime($value->updated_at)) }}</td>
                        <td class="text-left">
                          @if(isAdmin() || Auth::user()->can('cms.edit'))
                            <a href="{{ route('administrator.cms-edit', $value->id) }}" title="{{ __('Edit') }}" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-edit"></i></a>
                          @endif
                          @if(isAdmin() || Auth::user()->can('cms.delete'))
                            <a href="#" title="{{ trans("Delete") }}" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-remove" data-cms_id="{{ $value->id }}"><i class="la la-trash text-danger"></i></a>
                            <form method="post" action="{{ route("administrator.cms-destroy", $value->id) }}" id="{{ $value->id }}"><input type="hidden" name="_token" value="{{ csrf_token() }}"></form>
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  @endif
                </tbody>
              </table>
            </div>
            <div class="row">
              <div class="col-12 text-right">
                {{ $cms->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section("script")
  <script type="text/javascript">
    $( document ).ready(function() {
      $('.kt-menu__item__cms').addClass('kt-menu__item--active');

      $(".btn-remove").click(function (e) {
        e.preventDefault();

        e.preventDefault();
        var cms_id = $(this).data("cms_id");

        Swal.fire({
          title: `{{ __("are-you-sure") }}`,
          text: `{{ __('delete-confirm') }}`,
          type: 'info',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: `{{ __("Yes") }}`,
          cancelButtonText: `{{ __("Cancel") }}`
        }).then((result) => {
          if (result.value) {
            $("#"+cms_id).submit();
          }
        });
      })
    });
  </script>
@endsection