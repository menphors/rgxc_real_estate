@extends('backend.app')
@section("title")
    {{ __('Village') }}
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-10">
                            {{ Form::open(['url' => route('administrator.village-list'), 'method' => 'GET', 'id' => 'form-search']) }}
                                <div class="row">
                                    <div class="col-4">
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
                                    <div class="col-4">
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
                                    <div class="col-4">
                                        <div class="form-group">
                                            <select name="commune" class="form-control"  onchange="this.form.submit()">
                                                <option value="">{{ __("Select Commune") }}</option>
                                                @if(!empty(@$communes))
                                                    @foreach($communes as $commune)
                                                        <option value="{{ $commune->id }}" {{ request("commune")== $commune->id? "selected" : "" }}>{{ $commune->title }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            {{ Form::close() }}
                        </div>
                        <div class="col-2 pull-right text-right">
                            <a href="{{ route('administrator.village-add') }}" class="btn btn-info float-right">
                                <i class="fa fa-plus"></i>
                                {{ __('Create New') }}
                            </a>

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
                                    @if($villages->count())
                                        <?php $i = 0; ?>
                                        @foreach ($villages as $village)
                                            <?php $i++; ?>
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td>{{ $village->code }}</td>
                                                <td>{{ $village->title }}</td>
                                                <td>
                                                    <span style="overflow: visible; position: relative; width: 110px;">
                                                        <a href="{{ route("administrator.village-edit", $village->id) }}" title="{{ trans("Edit") }}" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                                            <i class="la la-edit"></i>
                                                        </a>
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
                                {{ $villages->links() }}
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
            $('.kt-menu__item__village').addClass(' kt-menu__item--active');

            //$("#form-search").submit();
        })
    </script>
    @endsection