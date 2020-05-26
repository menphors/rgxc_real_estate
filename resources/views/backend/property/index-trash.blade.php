@extends('backend.app')

@section("title")
  {{ __('Property Management') }}   
@endsection

@section("breadcrumb")
  <li class="breadcrumb-item"><a href="{{ url('/administrator') }}">{{ __('Home') }}</a></li>
  <li class="breadcrumb-item active">{{ __('Property Management') }}</li>
@endsection

@section("style")
  <link rel="stylesheet" href="{{asset('backend/plugins/easyAutocomplete/easy-autocomplete.min.css')}}">
@endsection

@section('content')
<div class="kt-subheader kt-grid__item" id="kt_subheader">
  <div class="kt-container  kt-container--fluid ">
    <div class="kt-subheader__main">
      <h3 class="kt-subheader__title">{{ __("Trash Properties") }}</h3>

      <span class="kt-subheader__separator kt-subheader__separator--v"></span>
      <div class="kt-subheader__breadcrumbs">
        <span class="kt-subheader__breadcrumbs-separator"></span>
        <a href="#" class="kt-subheader__breadcrumbs-link information" title="">
         {{ $properties->total() }}
       </a>
     </div>
   </div>
 </div>
</div>

<section class="content mt-5">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body table-responsive p-0">
            @include("backend.partial.message")
            <br/>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th class="text-center">{!! __("N<sup><u>o</u></sup>") !!}</th>
                  <th>{!! __("Code") !!}</th>
                  <th>{{ __('Property Title') }}</th>
                  <th class="text-right">{{ __('Cost') }}</th>
                  <th class="text-right">{{ __('Price') }}</th>
                  <th>{{ __('Deleted At') }}</th>
                  <th class="text-center">{{ __('Status') }}</th>
                  <th class="text-right">{{ __('Action') }}</th>
                </tr>
              </thead>
              <tbody>
                @if(!empty($properties))
                  @foreach($properties as $key => $property)
                  <tr>
                    <td class="text-center">{{ str_pad($key + 1, 2, '0', STR_PAD_LEFT) }}</td>
                    <td><a href="#">{{ $property->code ?? '' }}</a></td>
                    <td>{{  @$property->code. '-' .$property->title ?? '' }}</td>
                    <td class="text-right">{{"$ ". number_format($property->cost ?? 0, 2) }}</td>
                    <td class="text-right">{{"$ ". number_format($property->price ?? 0, 2) }}</td>
                    <td>{{ Date('d-m-Y', strtotime($property->deleted_at)) }}</td>
                    <td class="text-center">
                      <?php
                        if(@$property->status == Constants::PROPERTY_STATUS["padding"]) { //padding
                          echo "<span class='badge badge-danger'>". __("Pending")."</span>";
                        } 
                        elseif(@$property->status == Constants::PROPERTY_STATUS["submitted"]) {
                          echo "<span class='badge badge-info'>". __("Submitted")."</span>";
                        } 
                        elseif(@$property->status == Constants::PROPERTY_STATUS["reviewed"]) {
                          echo "<span class='badge badge-primary'>". __("Reviewed")."</span>";
                        } 
                        elseif(@$property->status == Constants::PROPERTY_STATUS["published"]) {
                          echo "<span class='badge badge-success'>". __("Published")."</span>";
                        } 
                        elseif(@$property->status == Constants::PROPERTY_STATUS["solved"]) {
                          echo "<span class='badge badge-dark'>". __("Solved")."</span>";
                        } 
                        elseif(@$property->status == Constants::PROPERTY_STATUS["deposit"]) {
                          echo "<span class='badge badge-secondary'>". __("Deposit")."</span>";
                        }
                        elseif(@$property->status == Constants::PROPERTY_STATUS["unpublished"]) {
                          echo "<span class='badge badge-secondary'>". __("Unpublished")."</span>";
                        }
                      ?>
                    </td>
                    <td class="text-right">
                      <a href="{{ url('administrator/property/restore-trash/'.$property->id) }}" title="{{ __('Restore') }}" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                        <i class="fa fa-redo" aria-hidden="true"></i>
                      </a>

                      <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md btn-remove" data-url="{!! url('administrator/property/force-delete') !!}" data-id="{!! $property->id !!}" onclick="deleteItem(this)" title="{{ __('Permanent Delete') }}">
                        <i class="la la-trash text-danger"></i>
                      </a>
                    </td>
                  </tr>
                  @endforeach
                @else
                  <tr>
                    <td class="text-center" colspan="8">{{ __('No data available.') }}</td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>

        {!! Form::pagination($properties) !!}
        {{-- {{ $properties->appends($requestQuery)->links() }} --}}
      </div>
    </div>
  </div>
</section>
@endsection

@section('script')
  <script src="{{ asset('backend/plugins/easyAutocomplete/jquery.easy-autocomplete.js') }}"></script>
  <script type="text/javascript">
    var _token = $('#csrf-token').val();

    $( document ).ready(function() {
      $('.kt-menu__item__property_block').addClass(' kt-menu__item--open');
      $('.kt-menu__item__property').addClass(' kt-menu__item--active');
    });
  </script>
@stop