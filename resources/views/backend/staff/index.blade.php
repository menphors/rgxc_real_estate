@extends('backend.app')

@section("title")
    {{ __('Staff Management') }}   
@endsection

@section("breadcrumb")
    <li class="breadcrumb-item"><a href="{{ url('/administrator') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Staff Management') }}</li>
@endsection

@section('content')
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="row">
            <div class="col-md-6">
              {{ Form::open(['url' => route('administrator.staff.index'), 'method' => 'GET', 'id' => 'form-search']) }}
              {{ Form::text('search', request("search") ?? '', ['class' => 'form-control', 'placeholder' => __('Enter Keyword')]) }}
              {{ Form::close() }}
            </div>
            <div class="col-md-6">
              <button type="button" class="btn btn-info w-100-px" onclick="btnSearch()">
                <i class="fa fa-filter"></i>
                {{ __('Search') }}
              </button>
              <a href="{{ route('administrator.staff.index') }}" class="btn btn-danger">
                <i class="fa fa-search-minus"></i>
                {{ __('Clear') }}
              </a>
              @if(isAdmin() || Auth::user()->can('staff.add'))
              <a href="{{ route('administrator.staff.create') }}" class="btn btn-info float-right">
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
                  <tr>
                    <th>#</th>
                    <th></th>
                    <th>{{ __("Name") }}</th>
                    <th>{{ __("Email") }}</th>
                    <th>{{ __('Phone') }}</th>
                    <th> {{ __("Staff Type") }}</th>
                    <th>{{ __("Created Date") }}</th>
                    <th class="text-right">{{ __("Action") }}</th>
                  </tr>
                </thead>
                <tbody>
                  @if($items->count())
                    @foreach($items as $key => $item)
                      <tr>
                        <td>{{ str_pad($key + 1, 2, '0', STR_PAD_LEFT) }}</td>
                        <td>
                          <img src="{{ url('photos/account/'.$item->thumbnail) }}" width="50px" onerror="this.src='{{ url("images/default.png") }}'">
                        </td>
                        <td>{{ $item->name ?? '' }}</td>
                        <td>{{ $item->email ?? '' }}</td>
                        <td>{{ $item->phone1 ?? '' }}</td>
                        <td>
                          @if(!empty($item->type))
                            <span class="badge badge-info">{{ staff_type($item->type) }}</span>
                          @endif
                        </td>
                        <td>{{ Date('d-m-Y', strtotime($item->created_at)) }}</td>
                        <td class="text-right">
                          @if(isAdmin() || Auth::user()->can('staff.edit'))
                          <a href="{{ route('administrator.staff.edit', $item->id) }}">
                            <i class="fa fa-edit" aria-hidden="true"></i>
                          </a>
                          @endif
                          @if(isAdmin() || Auth::user()->can('staff.delete'))
                          <a data-url="{!! url('/administrator/staff') !!}" data-id="{!! $item->id !!}" class="text-danger delete-item" href="javascript:void(0);" onclick="deleteItem(this)">
                            <i class="fa fa-trash"></i>
                          </a>
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  @else
                    <tr>
                      <td class="text-center" colspan="6">{{ __('No data available.') }}</td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div>
          </div>
          {!! $items->render() !!}
        </div>
      </div>
    </div>
  </section>
@endsection

@section('script')
  <script type="text/javascript">
    $( document ).ready(function() {
      $('.kt-menu__item__setting').addClass(' kt-menu__item--open');
      $('.kt-menu__item__staff').addClass(' kt-menu__item--active');
    });
  </script>
@stop
