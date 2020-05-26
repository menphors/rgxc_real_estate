@extends('backend.app')

@section("title")
    {{ __('Province') }}
@endsection

@section('content')
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="row">
            <div class="col-md-6">
              {{ Form::open(['url' => route('administrator.province-list'), 'method' => 'GET', 'id' => 'form-search']) }}
              {{ Form::text('search', request("search") ?? '', ['class' => 'form-control', 'placeholder' => __('Enter Keyword')]) }}
              {{ Form::close() }}
            </div>
            <div class="col-md-6">
              <button type="button" class="btn btn-info w-100-px" onclick="btnSearch()">
                <i class="fa fa-filter"></i>
                {{ __('Search') }}
              </button>
              <a href="{{ route('administrator.province-list') }}" class="btn btn-danger">
                <i class="fa fa-search-minus"></i>
                {{ __('Clear') }}
              </a>
              @if(isAdmin() || Auth::user()->can('location.add'))
              <a href="{{ route('administrator.province-add') }}" class="btn btn-info float-right">
                <i class="fa fa-plus"></i>
                {{ __('Create New') }}
              </a>
              @endif
            </div>
            <div class="clearfix">&nbsp;</div>
          </div>
          <div class="card">
            <div class="card-body table-responsive p-0">
              <table class="table table-hover">
                <thead>
                  <th>#</th>
                  <th>{{ __("Code") }}</th>
                  <th>{{ __("Title") }}</th>
                  <th width="60"></th>
                </thead>
                <tbody>
                  @if($provinces->count())
                    <?php $i = 0; ?>
                    @foreach ($provinces as $province)
                      <?php $i++; ?>
                      <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $province->code }}</td>
                        <td>{{ $province->title }}</td>
                        <td>
                          <span style="overflow: visible; position: relative; width: 110px;">
                            @if(isAdmin() || Auth::user()->can('location.edit'))
                            <a href="{{ route("administrator.province-edit", $province->id) }}" title="{{ trans("Edit") }}" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                              <i class="la la-edit"></i>
                            </a>
                            @endif
                          </span>
                        </td>
                      </tr>
                    @endforeach
                  @endif
                </tbody>
              </table>
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
      $('.kt-menu__item__setting').addClass(' kt-menu__item--open');
      $('.kt-menu__item__location').addClass(' kt-menu__item--open');
      $('.kt-menu__item__province').addClass(' kt-menu__item--active');
    })
  </script>
@endsection