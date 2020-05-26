@extends('backend.app')

@section("title")
    {{ __('Customer') }}
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
                  {{ Form::open(['url' => route('administrator.customer-listing'), 'method' => 'GET', 'id' => 'form-search']) }}
                  {{ Form::text('search', request("search") ?? '', ['class' => 'form-control', 'placeholder' => __('Enter Keyword')]) }}
                  {{ Form::close() }}
                </div>
                <div class="col-md-6">
                  <button type="button" class="btn btn-info w-100-px" onclick="btnSearch()">
                    <i class="fa fa-filter"></i>
                    {{ __('Search') }}
                  </button>
                  <a href="{{ route('administrator.customer-listing') }}" class="btn btn-danger">
                    <i class="fa fa-search-minus"></i>
                    {{ __('Clear') }}
                  </a>
                  @if(isAdmin() || Auth::user()->can('customer.add'))
                  <a href="{{ route('administrator.customer-add') }}" class="btn btn-info float-right">
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
                        <th>{{ __('Card ID') }}</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Phone') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Action') }}</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if($customers->count())
                        @foreach($customers as $key => $customer)
                          <tr>
                            <td>{{ str_pad($key + 1, 2, '0', STR_PAD_LEFT) }}</td>
                            <td>
                              <img src="{{ asset(config("global.customer_image_path")."thumbnail/".$customer->thumbnail) }}" height="30px" class="img img-rounded">
                            </td>
                            <td>{{ $customer->id_card }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->email }}</td>
                            <td data-field="Actions" data-autohide-disabled="false" class="kt-datatable__cell">
                              <span style="overflow: visible; position: relative; width: 110px;">
                                @if(isAdmin() || Auth::user()->can('customer.edit'))
                                <a href="{{ route("administrator.customer-edit", $customer->id) }}" title="{{ trans("Edit") }}" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                  <i class="la la-edit"></i>
                                </a>
                                @endif
                                @if(isAdmin() || Auth::user()->can('customer.delete'))
                                <a href="#" title="{{ trans("Delete") }}" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-remove" data-customer_id="{{ $customer->id }}">
                                  <i class="la la-trash text-danger"></i>
                                </a>
                                <form method="post" action="{{ route("administrator.customer-destroy", $customer->id) }}" id="{{ $customer->id }}">
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
                    {{ $customers->links() }}
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
      $('.kt-menu__item__customer').addClass(' kt-menu__item--active');

      $(".btn-remove").click(function (e) {
        e.preventDefault();
        var customer_id = $(this).data("customer_id");

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
            $("#"+customer_id).submit();
          }
        });
      })
    })
  </script>
@endsection