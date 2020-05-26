@extends('backend.app')

@section("title")
    {{ __('Role Management') }}
@endsection

@section("breadcrumb")
    <li class="breadcrumb-item"><a href="{{ url('/administrator') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Role Management') }}</li>
@endsection

@section('content')
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="row">
            <div class="col-md-6">
              {{ Form::open(['url' => route('administrator.role.index'), 'method' => 'GET', 'id' => 'form-search']) }}
              {{ Form::text('search', $search ?? '', ['class' => 'form-control', 'placeholder' => __('Enter Keyword')]) }}
              {{ Form::close() }}
            </div>
            <div class="col-md-6">
              <button type="button" class="btn btn-info w-100-px" onclick="btnSearch()"> {{ __('Search') }}</button>
              <a href="{{ route('administrator.role.index') }}" class="btn btn-default w-100-px"> {{ __('Clear') }}</a>
              @if(isAdmin() || Auth::user()->can('role.add'))
              <a href="{{ route('administrator.role.create') }}" class="btn btn-info float-right"> {{ __('Create New') }}</a>
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
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Group Role') }}</th>
                    <th>{{ __('Created At') }}</th>
                    <th class="text-right">{{ __('Action') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @if($roles->count())
                    @foreach($roles as $key => $role)
                      <tr>
                        <td>{{ str_pad($key + 1, 2, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $role->title }}</td>
                        <td> {{ $role->role_type ? config('data.admin.role_types')[$role->role_type] : '' }} </td>
                        <td>{{ Date('d-m-Y', strtotime($role->created_at)) }}</td>
                        <td class="text-right">
                          {{-- @if($role->name != 'administrator') --}}
                            @if(isAdmin() || Auth::user()->can('role.edit'))
                            <a href="{{ route('administrator.role.edit', $role->id) }}">
                              <i class="fa fa-edit" aria-hidden="true"></i>
                            </a>
                            @endif
                            @if(isAdmin() || Auth::user()->can('role.delete'))
                            <a data-url="{!! url('/administrator/role') !!}" data-id="{!! $role->id !!}" class="text-danger delete-item" href="javascript:void(0);" onclick="deleteItem(this)">
                              <i class="fa fa-trash"></i>
                            </a>
                            @endif
                          {{-- @endif --}}
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
          {!! $roles->render() !!}
        </div>
      </div>
    </div>
  </section>
@endsection

@section('script')
  <script type="text/javascript">
    $( document ).ready(function() {
      $('.kt-menu__item__setting').addClass(' kt-menu__item--open');
      $('.kt-menu__item__role').addClass(' kt-menu__item--active');
    });
  </script>
@stop
