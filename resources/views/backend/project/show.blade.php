@extends('backend.app')
@section("title")
    {{ __('Project') }}
@endsection
@section("style")
    <style type="text/css">
        #map {
            height: 100%;
        }
        /* Optional: Makes the sample page fill the window. */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__body kt-portlet__body--fit">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <table class="table table-hover">
                                        <tr>
                                            <td colspan="3" class="text-center">
                                                <img id="preview-profile-image" src="{{ asset(config("global.project_path"). @$project->thumbnail) }}" onerror="this.src='{{ url('none.png') }}'" style="width: 50%!important;float: left!important;">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __("Title") }}</td>
                                            <td>:</td>
                                            <td>{{ @$project->title }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __("Address") }}</td>
                                            <td>:</td>
                                            <td>{{ @$project->address }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __("Description") }}</td>
                                            <td>:</td>
                                            <td>{{ @$project->description }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __("Created At") }}</td>
                                            <td>:</td>
                                            <td><i>{{ date("d-M-Y h:i A", strtotime($project->created_at)) }}</i></td>
                                        </tr>
                                        <tr>
                                            <td>{{ __("Updated At") }}</td>
                                            <td>:</td>
                                            <td><i>{{ date("d-M-Y h:i A", strtotime($project->updated_at)) }}</i></td>
                                        </tr>
                                    </table>


                                </div>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-12">
                                            <div id="map" style="height: 500px;"></div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="lat" id="lat" value="{{ @$project->latitude }}"/>
                                    <input type="hidden" name="lon" id="lon" value="{{ @$project->longitude }}"/>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <h6>{{ __("PROPERTY LIST") }}</h6>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>{!!"#" !!}</th>
                                                <th>{!! __("Code") !!}</th>
                                                <th>{{ __('Property Title') }}</th>
                                                <th>{{ __('Cost') }}</th>
                                                <th>{{ __('Price') }}</th>
                                                <th>{{ __('Created At') }}</th>
                                                <th>{{ __('Status') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty(@$project->properties))
                                                @foreach($project->properties as $key => $property)
                                                    <tr>
                                                        <td>{{ str_pad($key + 1, 2, '0', STR_PAD_LEFT) }}</td>
                                                        <td>
                                                            <a href="{{ route("administrator.property-view", $property->id) }}">
                                                                {{ $property->code ?? '' }}
                                                            </a>
                                                        </td>
                                                        <td>{{ $property->title ?? '' }}</td>
                                                        <td>{{"$ ". number_format($property->cost ?? 0, 2) }}</td>
                                                        <td>{{"$ ". number_format($property->price ?? 0, 2) }}</td>
                                                        <td>{{ Date('d-m-Y', strtotime($property->created_at)) }}</td>
                                                        <td>
                                                            <?php
                                                            if(@$property->status == Constants::PROPERTY_STATUS["padding"]){ //padding
                                                                echo "<span class='badge badge-danger'>". __("Padding")."</span>";
                                                            }elseif(@$property->status == Constants::PROPERTY_STATUS["submitted"]){
                                                                echo "<span class='badge badge-info'>". __("Submitted")."</span>";
                                                            }elseif(@$property->status == Constants::PROPERTY_STATUS["reviewed"]){
                                                                echo "<span class='badge badge-primary'>". __("Reviewed")."</span>";
                                                            }elseif(@$property->status == Constants::PROPERTY_STATUS["published"]){
                                                                echo "<span class='badge badge-success'>". __("Published")."</span>";
                                                            }elseif(@$property->status == Constants::PROPERTY_STATUS["solved"]){
                                                                echo "<span class='badge badge-dark'>". __("Solved")."</span>";
                                                            }elseif(@$property->status == Constants::PROPERTY_STATUS["deposit"]){
                                                                echo "<span class='badge badge-secondary'>". __("Deposit")."</span>";
                                                            }

                                                            ?>
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


                            <div class="row kt-margin-t-20">
                                <div class="col-12 text-right">
                                    <a href="{{ route("administrator.project-listing") }}" class="btn btn-danger">
                                        <i class="la la-long-arrow-left"></i> {{ __("Back") }}
                                    </a>
                                    <a href="{{ route("administrator.project-edit", $project->id) }}" class="btn btn-info">
                                        <i class="fa fa-pencil-alt"></i> {{ __("Edit") }}
                                    </a>
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
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env("GOOGLE_MAPS_KEY") }}&libraries=places&callback=initMap" async defer></script>
    <script type="text/javascript">
        $(function () {
            $('.kt-menu__item__project').addClass(' kt-menu__item--active');

        });

        var initMap = function () {
            var myLatLng = {lat: 11.5564, lng: 104.9282};
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position){
                    myLatLng = {lat: position.coords.latitude, lng: position.coords.longitude};
                });
            }

            var map = new google.maps.Map(document.getElementById('map'), {
                center: myLatLng,
                zoom: 13
            });

            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: 'RXGC',
                draggable: true
            });

            google.maps.event.addListener(marker, 'dragend', function(marker) {
                var latLng = marker.latLng;
                $('#lat').val(latLng.lat());
                $('#lon').val(latLng.lng());
            });
        };
        </script>
    @endsection