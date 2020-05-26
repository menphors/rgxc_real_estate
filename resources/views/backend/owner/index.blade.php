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
              {{ Form::open(['url' => route('administrator.property-owner-listing'), 'method' => 'GET', 'id' => 'form-search']) }}
              {{ Form::text('search', request("search") ?? '', ['class' => 'form-control', 'placeholder' => __('Enter Keyword')]) }}
              {{ Form::close() }}
            </div>
            <div class="col-md-6">
              <button type="button" class="btn btn-info w-100-px" onclick="btnSearch()">
                <i class="fa fa-filter"></i>
                {{ __('Search') }}
              </button>
              <a href="{{ route('administrator.property-owner-listing') }}" class="btn btn-danger">
                <i class="fa fa-search-minus"></i>
                {{ __('Clear') }}
              </a>
              @if(isAdmin() || Auth::user()->can('owner.add'))
              <a href="{{ route('administrator.property-owner-add') }}" class="btn btn-info float-right">
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
                    <th></th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Phone') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __("Province") }}</th>
                    <th>{{ __("District") }}</th>
                    <th>{{ __("Commune") }}</th>
                    <th>{{ __("Village") }}</th>
                    <th class="text-right">{{ __('Action') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @if($owners->count())
                    @foreach($owners as $key => $owner)
                      <?php
                        $owner = json_decode($owner);
                      ?>
                      <tr>
                        <td>{{ str_pad($key + 1, 2, '0', STR_PAD_LEFT) }}</td>
                        <td>
                          <img src="{{ asset(config("global.owner_image_path").$owner->thumbnail) }}" height="30px" class="img img-rounded">
                        </td>
                        <td>{{ @$owner->name }}</td>
                        <td>{{ @$owner->phone }}</td>
                        <td>{{ @$owner->email }}</td>
                        <td>{{ @$owner->province_id->title }}</td>
                        <td>{{ @$owner->district_id->title }}</td>
                        <td>{{ @$owner->commune_id->title }}</td>
                        <td>{{ @$owner->village_id->title }}</td>
                        <td data-field="Actions" data-autohide-disabled="false" class="kt-datatable__cell">
                          <span style="overflow: visible; position: relative; width: 110px;">
                            @if(isAdmin() || Auth::user()->can('owner.edit'))
                            <a href="{{ route("administrator.property-owner-edit", $owner->id) }}" title="{{ trans("Edit") }}" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                              <i class="la la-edit"></i>
                            </a>
                            @endif
                            @if(isAdmin() || Auth::user()->can('owner.delete'))
                            <a href="#" title="{{ trans("Delete") }}" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-remove" data-owner_id="{{ $owner->id }}">
                              <i class="la la-trash text-danger"></i>
                            </a>
                            <form method="post" action="{{ route("administrator.property-owner-destroy", $owner->id) }}" id="{{ $owner->id }}">
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
                {{ $owners->links() }}
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
      $('.kt-menu__item__property_block').addClass('kt-menu__item--open');
      $('.kt-menu__item__property_owner').addClass(' kt-menu__item--active');

      $(".btn-remove").click(function (e) {
        e.preventDefault();
        var owner_id = $(this).data("owner_id");

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
            $("#"+owner_id).submit();
          }
        });
      })
    })
  </script>
@endsection