@extends('backend.app')

@section("title")
    {{ __('Office') }}
@endsection

@section('content')
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="row">
            <div class="col-md-6">
              {{ Form::open(['url' => route('administrator.office-listing'), 'method' => 'GET', 'id' => 'form-search']) }}
              {{ Form::text('search', request("search") ?? '', ['class' => 'form-control', 'placeholder' => __('Enter Keyword')]) }}
              {{ Form::close() }}
            </div>
            <div class="col-md-6">
              <button type="button" class="btn btn-info w-100-px" onclick="btnSearch()">
                <i class="fa fa-filter"></i>
                {{ __('Search') }}
              </button>
              <a href="{{ route('administrator.office-listing') }}" class="btn btn-danger">
                <i class="fa fa-search-minus"></i>
                {{ __('Clear') }}
              </a>
              @if(isAdmin() || Auth::user()->can('office.add'))
              <a href="{{ route('administrator.office-add') }}" class="btn btn-info float-right">
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
                    <th>N<sup><u>o</u></sup></th>
                    <td></td>
                    <th>{{ __('Head Office') }}</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Phone') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Address') }}</th>
                    <th class="text-right">{{ __('Action') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @if($offices->count())
                    <?php $i = 0;?>
                    @foreach($offices as $office)
                      <?php $i++;?>
                      <tr>
                        <td class="kt-padding-t-15">{{ $i }}</td>
                        <td>
                          <img src="{{ asset(config("global.office_image_path")."thumbnail/".$office->thumbnail) }}" height="30px" class="img img-rounded">
                        </td>
                        <td class="kt-padding-t-15">{!!  $office->is_main == 1 ? "<span class='badge badge-primary'>". __("Yes"). "</span>" : "<span class='badge badge-danger'>". __("No") . "</span>"  !!}</td>
                        <td class="kt-padding-t-15">{{ $office->name }}</td>
                        <td class="kt-padding-t-15">{{ $office->phone }}</td>
                        <td class="kt-padding-t-15">{{ $office->email }}</td>
                        <td class="kt-padding-t-15">{{ $office->address }}</td>
                        <td data-field="Actions" data-autohide-disabled="false" class="kt-datatable__cell">
                          <span style="overflow: visible; position: relative; width: 110px;">
                            @if(isAdmin() || Auth::user()->can('office.edit'))
                            <a href="{{ route("administrator.office-edit", $office->id) }}" title="{{ trans("Edit") }}" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                              <i class="la la-edit"></i>
                            </a>
                            @endif
                            @if(isAdmin() || Auth::user()->can('office.delete'))
                            <a href="#" title="{{ trans("Delete") }}" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-remove" data-office_id="{{ $office->id }}">
                              <i class="la la-trash text-danger"></i>
                            </a>
                            <form method="post" action="{{ route("administrator.office-destroy", $office->id) }}" id="{{ $office->id }}">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </form>
                            @endif
                          </span>
                        </td>
                      </tr>
                    @endforeach
                  @endif
                </tbody>
              </table>
            </div>
            <div class="row">
              <div class="col-12 text-right">
                {{ $offices->links() }}
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
    $(function () {
      $('.kt-menu__item__office').addClass(' kt-menu__item--active');

      $(".btn-remove").click(function (e) {
        e.preventDefault();
        var office_id = $(this).data("office_id");

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
            $("#"+office_id).submit();
          }
        });
      })
    })
  </script>
@endsection