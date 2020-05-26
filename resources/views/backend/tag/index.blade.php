@extends('backend.app')

@section("title")
  {{ __('Listing') }}
@endsection

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        @include("backend.partial.message")
        <div class="row">
          <div class="col-md-6">
            {{ Form::open(['url' => route('administrator.tag-listing'), 'method' => 'GET', 'id' => 'form-search']) }}
            {{ Form::text('search', request("search"), ['class' => 'form-control', 'placeholder' => __('Enter Keyword')]) }}
            {{ Form::close() }}
          </div>
          <div class="col-md-6">
            <button type="button" class="btn btn-info w-100-px" onclick="btnSearch()">
              <i class="fa fa-filter"></i>
              {{ __('Search') }}
            </button>
            <a href="{{ route('administrator.tag-listing') }}" class="btn btn-danger">
              <i class="fa fa-search-minus"></i>
              {{ __('Clear') }}
            </a>
            @if(isAdmin() || Auth::user()->can('tag.add'))
            <a href="{{ route('administrator.tag-add') }}" class="btn btn-info float-right">
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
                  <th width="90px">#</th>
                  <th>{!! __("Title") !!}</th>
                  <th>{{ __("Created At") }}</th>
                  <th>{{ __("Updated At") }}</th>
                  <th width="120px" class="text-left">{{ __('Action') }}</th>
                </tr>
              </thead>
              <tbody>
                @if($tags->count())
                @foreach($tags as $key => $tag)
                <tr>
                  <td>{{ str_pad($key + 1, 2, '0', STR_PAD_LEFT) }}</td>
                  <td>{{ $tag->title }}</td>
                  <td>{{ date("d-M-Y", strtotime($tag->created_at)) }}</td>
                  <td>{{ date("d-M-Y", strtotime($tag->updated_at)) }}</td>
                  <td class="text-left">
                    @if(isAdmin() || Auth::user()->can('tag.edit'))
                    <a href="{{ route('administrator.tag-edit', $tag->id) }}" title="{{ __('Edit') }}" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                      <i class="la la-edit"></i>
                    </a>
                    @endif
                    @if(isAdmin() || Auth::user()->can('tag.delete'))
                    <a href="#" title="{{ trans("Delete") }}" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-remove" data-id="{{ $tag->id }}">
                      <i class="la la-trash text-danger"></i>
                    </a>
                    <form method="post" action="{{ route("administrator.tag-delete", $tag->id) }}" id="{{ $tag->id }}">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                    @endif
                  </td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td class="text-center" colspan="5">{{ __('No data available.') }}</td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>
        {!! Form::pagination($tags) !!}
      </div>
    </div>
  </div>
</section>
@endsection

@section("script")
  <script type="text/javascript">
    $(function () {
      $('.kt-menu__item__setting').addClass(' kt-menu__item--open');
      $('.kt-menu__item__tag').addClass(' kt-menu__item--active');

      $(".btn-remove").click(function (e) {
        e.preventDefault();
        var id = $(this).data("id");

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
            $("#"+id).submit();
          }

        });
      });
    });
  </script>
@endsection