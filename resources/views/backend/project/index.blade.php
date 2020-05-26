@extends('backend.app')

@section("title")
    {{ __('Project') }}
@endsection

@section("style")
@endsection

@section('content')
  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <div class="row">
                <div class="col-md-6">
                  {{ Form::open(['url' => route('administrator.project-listing'), 'method' => 'GET', 'id' => 'form-search']) }}
                  {{ Form::text('search', request("search") ?? '', ['class' => 'form-control', 'placeholder' => __('Enter Keyword')]) }}
                  {{ Form::close() }}
                </div>
                <div class="col-md-6">
                  <button type="button" class="btn btn-info w-100-px" onclick="btnSearch()">
                    <i class="fa fa-filter"></i>
                    {{ __('Search') }}
                  </button>
                  <a href="{{ route('administrator.project-listing') }}" class="btn btn-danger">
                    <i class="fa fa-search-minus"></i>
                    {{ __('Clear') }}
                  </a>
                  @if(isAdmin() || Auth::user()->can('project.add'))
                  <a href="{{ route('administrator.project-add') }}" class="btn btn-info float-right">
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
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('Created At') }}</th>
                        <th>{{ __('Updated At') }}</th>
                        <th>{{ __('Action') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if($projects->count())
                        @foreach($projects as $key => $project)
                          <tr>
                            <td>{{ str_pad($key + 1, 2, '0', STR_PAD_LEFT) }}</td>
                            <td>
                              <img src="{{ asset(config("global.project_path").$project->thumbnail) }}" onerror="this.src='{{ url('none.png') }}'" height="30px" class="img img-rounded">
                            </td>
                            <td>
                              <a href="{{ route('administrator.project-show', $project->id) }}">
                                {{ $project->title }}
                              </a>
                            </td>
                            <td><i>{{ date("d-M-Y h:i A", strtotime($project->created_at)) }}</i></td>
                            <td><i>{{ date("d-M-Y h:i A", strtotime($project->updated_at)) }}</i></td>
                            <td data-field="Actions" data-autohide-disabled="false" class="kt-datatable__cell">
                              <span style="overflow: visible; position: relative; width: 110px;">
                                @if(isAdmin() || Auth::user()->can('project.edit'))
                                <a href="{{ route("administrator.project-edit", $project->id) }}" title="{{ trans("Edit") }}" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                  <i class="la la-edit"></i>
                                </a>
                                @endif
                                @if(isAdmin() || Auth::user()->can('project.delete'))
                                <a href="#" title="{{ trans("Delete") }}" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-remove" data-project_id="{{ $project->id }}">
                                  <i class="la la-trash text-danger"></i>
                                </a>
                                <form method="post" action="{{ route("administrator.project-destroy", $project->id) }}" id="{{ $project->id }}">
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
                    {{ $projects->links() }}
                  </div>
                </div>
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
      $('.kt-menu__item__project').addClass(' kt-menu__item--active');

      $(".btn-remove").click(function (e) {
        e.preventDefault();
        var project_id = $(this).data("project_id");

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
            $("#"+project_id).submit();
          }
        });
      })
    })
  </script>
@endsection