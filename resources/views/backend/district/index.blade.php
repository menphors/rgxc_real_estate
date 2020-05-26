@extends('backend.app')

@section("title")
    {{ __('District') }}
@endsection

@section('content')
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="row">
            <div class="col-lg-6">
              {{ Form::open(['url' => route('administrator.district-list'), 'method' => 'GET', 'id' => 'form-search']) }}
                <div class="form-group">
                  <select name="province" class="form-control"  onchange="this.form.submit()">
                    <option value="">{{ __("Select Province") }}</option>
                    @if($provinces->count())
                      @foreach($provinces as $province)
                        <option value="{{ $province->id }}" {{ request("province")== $province->id? "selected" : "" }}>{{ $province->title }}</option>
                      @endforeach
                    @endif
                  </select>
                </div>
              {{ Form::close() }}
            </div>
            <div class="col-4"></div>
            <div class="col-2 pull-right text-right">
              @if(isAdmin() || Auth::user()->can('location.add'))
                <a href="{{ route('administrator.district-add') }}" class="btn btn-info float-right">
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
                  @if(empty(request("province")))
                  <th>{{ __("Province") }}</th>
                  @endif
                  <th>{{ __("Code") }}</th>
                  <th>{{ __("Title") }}</th>
                  <th width="60"></th>
                </thead>
                <tbody>
                  @if($districts->count())
                    <?php $i = 0; ?>
                    @foreach ($districts as $district)
                      <?php $i++; ?>
                      <tr>
                        <td>{{ $i }}</td>
                        @if(empty(request("province")))
                        <td>{{ @$district->province->title }}</td>
                        @endif
                        <td>{{ $district->code }}</td>
                        <td>{{ $district->title }}</td>
                        <td>
                          @if(isAdmin() || Auth::user()->can('location.edit'))
                          <span style="overflow: visible; position: relative; width: 110px;">
                            <a href="{{ route("administrator.district-edit", $district->id) }}" title="{{ trans("Edit") }}" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                              <i class="la la-edit"></i>
                            </a>
                          </span>
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
                {{ $districts->links() }}
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
      $('.kt-menu__item__setting').addClass(' kt-menu__item--open');
      $('.kt-menu__item__location').addClass(' kt-menu__item--open');
      $('.kt-menu__item__district').addClass(' kt-menu__item--active');
    })
  </script>
@endsection