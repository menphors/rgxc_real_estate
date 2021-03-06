@extends('backend.app')

@section("title")
    {{ __('Commune') }}
@endsection

@section('content')
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="row">
            <div class="col-lg-10">
              {{ Form::open(['url' => route('administrator.commune-list'), 'method' => 'GET', 'id' => 'form-search']) }}
                <div class="row">
                  <div class="col-6">
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
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <select name="district" class="form-control"  onchange="this.form.submit()">
                        <option value="">{{ __("Select District") }}</option>
                        @if(!empty(@$districts))
                          @foreach($districts as $district)
                            <option value="{{ $district->id }}" {{ request("district")== $district->id? "selected" : "" }}>{{ $district->title }}</option>
                          @endforeach
                        @endif
                      </select>
                    </div>
                  </div>
                </div>
              {{ Form::close() }}
            </div>
            <div class="col-2 pull-right text-right">
              @if(isAdmin() || Auth::user()->can('location.add'))
              <a href="{{ route('administrator.commune-add') }}" class="btn btn-info float-right">
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
                  @if($communes->count())
                    <?php $i = 0; ?>
                    @foreach ($communes as $commune)
                      <?php $i++; ?>
                      <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $commune->code }}</td>
                        <td>{{ $commune->title }}</td>
                        <td>
                          @if(isAdmin() || Auth::user()->can('location.edit'))
                          <span style="overflow: visible; position: relative; width: 110px;">
                            <a href="{{ route("administrator.commune-edit", $commune->id) }}" title="{{ trans("Edit") }}" class="btn btn-sm btn-clean btn-icon btn-icon-md">
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
                {{ $communes->links() }}
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
      $('.kt-menu__item__commune').addClass(' kt-menu__item--active');
      //$("#form-search").submit();
    })
  </script>
@endsection