<div class="tab-pane" id="kt_portlet_base_2_tab_content" role="tabpanel">
    <div class="kt-portlet1">
        <div class="kt-form">
            <div class="kt-portlet__body no-padding">

                <div class="kt-portlet">
                    <div class="kt-form">
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="habitable_surface">{!!  __('Property Size') !!}</label>
                                        <input type="text" class="form-control" name="habitable_surface" value="{{ old("habitable_surface", @$item->habitable_surface) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="property-size">{!! __('Size Sqm'). " ". "m<sup>2</sup>" !!}</label>
                                    <input type="number" value="{{ old("property_size", @$item->property_size) }}" placeholder="0.00" name="property_size" class="form-control"/>
                                </div>
                                <div class="col-sm-4 no_land">
                                    {{Form::myNumber('floor_number', old("floor_number", @$item->floor_number) ?? '', __('Floor number'), ['placeholder' => "0"], $errors, false)}}
                                </div>
                                <div class="col-sm-4 no_land">
                                    {{Form::myNumber('bed_room', old("bed_room", @$item->bed_room) ?? '', __('Bed room'), ['placeholder' => "0"], $errors, false)}}
                                </div>
                                <div class="col-sm-4 no_land">
                                    {{Form::myNumber('bath_room', old("bath_room", @$item->bath_room) ?? '', __('Bath room'), ['placeholder' => "0"], $errors, false)}}
                                </div>

                                <div class="col-sm-4 no_land">
                                    {!! Form::label('front_refer_to', __('Front refer to')) !!}
                                    {{Form::select('front_refer_to', $front_refer_to ?? [], old("front_refer_to", @$item->front_refer_to) ?? '', ['class' => 'form-control'])}}
                                    @if ($errors->has('front_refer_to'))
                                        <p class="text-danger">
                                            {{ $errors->first('front_refer_to') }}
                                        </p>
                                    @endif
                                </div>
                                <div class="col-sm-2 no_land">
                                    {{Form::myNumber('year_of_renovation', old("year_of_renovation", @$item->year_of_renovation) ?? '', __('Year of renovation'), ['placeholder' => __(''), "min" => "1"], $errors, false)}}
                                </div>
                                <div class="col-sm-2 no_land">
                                    {{Form::myNumber('year_of_construction', old("year_of_construction", @$item->year_of_construction) ?? '', __('Year of construction'), ['placeholder' => __(''), "min" => "1"], $errors, false)}}
                                </div>
                            </div>
                            <div class="row no_land">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="built_up_surface">{!!  __('Built up surface'). " (m<sup>2</sup>)" !!}</label>
                                        <input type="number" class="form-control" name="built_up_surface" value="{{ old("built_up_surface", @$item->built_up_surface) }}">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="ground_surface">{!!  __('Ground surface'). " (m<sup>2</sup>)" !!}</label>
                                        <input type="number" class="form-control" name="ground_surface" value="{{ old("ground_surface", @$item->ground_surface) }}">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="floor-level">{{ __("Floor Level") }}</label>
                                        <select name="floor_level" class="form-control">
                                            <option value="">{{ __("Please Select") }}</option>
                                            @for($i=1; $i<=50; $i++)
                                                <option value="{{ $i }}" {{ @$property_data["floor_level"] == $i? "selected" : "" }}>{{ $i }}</option>
                                            @endfor
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <label for="total-build-surface">{!!  __("Total Build Surface") !!}</label>
                                    <input type="number" value="{{ old("total_build_surface", @$property_data["total_build_surface"]) }}" name="total_build_surface" class="form-control">
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                <div class="kt-portlet__body">

                    <div class="kt-portlet__foot" style="padding-bottom: 0px;padding-right: 0px;">
                        <div class="kt-form__actions float-right">
                            <a href="javascript:;" class="btn btn-danger btn-attribute-click-back">
                                <i class="la la-long-arrow-left">&nbsp;</i>{{ __("Back") }}
                            </a>
                            <a href="javascript:;" class="btn btn-success btn-attribute-click">
                                <i class="la la-long-arrow-right">&nbsp;</i>{{ __("Next") }}
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
