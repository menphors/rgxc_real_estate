<div class="tab-pane" id="kt_portlet_base_service_tab_content" role="tabpanel">
    <div class="kt-portlet1">
        <div class="kt-form">
            <div class="kt-portlet__body no-padding">
                
                <div class="kt-portlet">
                    <div class="kt-form">
                        <div class="kt-portlet__body">
                            
                            <div class="rows">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <!-- Start Other Service -->
                                        <div class="kt-checkbox-list">
                                            <label class="m-b-15-px cursor-pointer">
                                                <label class=" cursor-pointer">
                                                    <label class="kt-checkbox" style="margin-left: -30px;">
                                                        <b><u>{{ __('General') }}</u></b>
                                                    </label>
                                                </label>
                                            </label>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <div class="kt-checkbox-list">
                                                            <label class="kt-checkbox kt-checkbox--success">
                                                                @if(isset($item) || old("has_swimming_pool"))
                                                                    <input type="checkbox" name="has_swimming_pool" value="1" @if(old("has_swimming_pool", @$item->has_swimming_pool)) checked @endif> {{ __('Has swimming pool') }}
                                                                @else
                                                                    <input type="checkbox" name="has_swimming_pool" value="1"> {{ __('Has swimming pool') }}
                                                                @endif
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <div class="kt-checkbox-list">
                                                            <label class="kt-checkbox kt-checkbox--success">
                                                                @if(isset($item) || old("has_elevator"))
                                                                    <input type="checkbox" name="has_elevator" value="1" @if(old("has_elevator", @$item->has_elevator)) checked @endif> {{ __('Has elevator') }}
                                                                @else
                                                                    <input type="checkbox" name="has_elevator" value="1"> {{ __('Has elevator') }}
                                                                @endif
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <div class="kt-checkbox-list">
                                                            <label class="kt-checkbox kt-checkbox--success">
                                                                @if(isset($item) || old("has_basement"))
                                                                    <input type="checkbox" name="has_basement" value="1" @if(old("has_basement", @$item->has_basement)) checked @endif> {{ __('Has basement') }}
                                                                @else
                                                                    <input type="checkbox" name="has_basement" value="1"> {{ __('Has basement') }}
                                                                @endif
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <div class="kt-checkbox-list">
                                                            <label class="kt-checkbox kt-checkbox--success">
                                                                @if(isset($item))
                                                                    <input type="checkbox" name="has_parking" value="1" @if(old("has_parking", @$item->has_parking)) checked @endif> {{ __('Has parking') }}
                                                                @else
                                                                    <input type="checkbox" name="has_parking" value="1"> {{ __('Has Parking') }}
                                                                @endif
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Start Other Service -->
                                        <div class="kt-checkbox-list">
                                            <label class="m-b-15-px cursor-pointer">
                                                <label class=" cursor-pointer">
                                                    <label class="kt-checkbox" style="margin-left: -30px;">
                                                        <b><u>{{ __('Other Service') }}</u></b>
                                                    </label>
                                                </label>
                                            </label>
                                            <div class="row">
                                                @if(isset($item))
                                                    @php
                                                        $dataOrtherServiceToArray = json_decode($item->data, true);

                                                        $data= $dataOrtherServiceToArray['other_service'] ?? [];
                                                    @endphp
                                                    @foreach(config('data.admin.services.orther_service')[\LaravelLocalization::getCurrentLocale()] as $key => $other_service)
                                                        @php $checked = "";  @endphp
                                                        @if((isset($data[$key]) && $data[$key] == $key) || old("other_service.other_service.$key"))
                                                            @php $checked = "checked";@endphp
                                                        @endif
                                                        <div class="col-md-3">
                                                            <label class="kt-checkbox kt-checkbox--success">
                                                                <input type="checkbox" name="other_service[other_service][{{$key}}]" id="other_service{{ $other_service }}" value="{{ $key }}" {{ $checked }}>
                                                                <label for="other_service{{ $other_service }}">{{ $other_service }}</label>
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    @foreach(config('data.admin.services.orther_service')[\LaravelLocalization::getCurrentLocale()] as $key => $other_service)
                                                        @php
                                                            $checked = "";
                                                            if(old("other_service.other_service.$key")){
                                                                $checked = "checked";
                                                            }
                                                        @endphp
                                                        <div class="col-md-3">
                                                            <label class="kt-checkbox kt-checkbox--success">
                                                                <input type="checkbox" name="other_service[other_service][{{$key}}]" id="other_service{{ $other_service }}" value="{{ $key }}" {{ $checked }}>
                                                                <label for="other_service{{ $other_service }}">{{ $other_service }}</label>
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                        <!-- End Other Service -->

                                        <!-- Start Special -->
                                        <div class="kt-checkbox-list">
                                            <label class="m-b-15-px cursor-pointer">
                                                <label class=" cursor-pointer">
                                                    <label class="kt-checkbox" style="margin-left: -30px;">
                                                        <b><u>{{ __('Special') }}</u></b>
                                                    </label>
                                                </label>
                                            </label>
                                            <div class="row">
                                                @if(isset($item))
                                                    @php
                                                        $dataSpecialToArray = json_decode($item->data, true);
                                                    @endphp
                                                    @foreach(config('data.admin.services.specials')[\LaravelLocalization::getCurrentLocale()] as $key => $special)
                                                        @php $checked = ""; @endphp
                                                        @if((isset($dataSpecialToArray['special'][$key]) && $dataSpecialToArray['special'][$key] == $key) || old("other_service.special.$key"))
                                                            @php $checked = "checked"; @endphp
                                                        @endif
                                                        <div class="col-md-3">
                                                            <label class="kt-checkbox kt-checkbox--success">
                                                                <input type="checkbox" name="other_service[special][{{$key}}]" id="specials{{ $special }}" value="{{ $key }}" {{ $checked }}>
                                                                <label for="specials{{ $special }}">{{ $special }}</label>
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    @foreach(config('data.admin.services.specials')[\LaravelLocalization::getCurrentLocale()] as $key => $special)
                                                        @php
                                                            $checked = "";
                                                            if(old("other_service.special.$key")){
                                                                $checked = "checked";
                                                            }
                                                        @endphp
                                                        <div class="col-md-3">
                                                            <label class="kt-checkbox kt-checkbox--success">
                                                                <input type="checkbox" name="other_service[special][{{$key}}]" id="specials{{ $special }}" value="{{ $key }}" {{ $checked }}>
                                                                <label for="specials{{ $special }}">{{ $special }}</label>
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                        <!-- End Special -->

                                        <!-- Start Security -->
                                        <div class="kt-checkbox-list">
                                            <label class="m-b-15-px cursor-pointer">
                                                <label class=" cursor-pointer">
                                                    <label class="kt-checkbox" style="margin-left: -30px;">
                                                        <b><u>{{ __('Security') }}</u></b>
                                                    </label>
                                                </label>
                                            </label>
                                            <div class="row">
                                                @if(isset($item))
                                                    @php
                                                        $dataSpecialToArray = json_decode($item->data, true);
                                                    @endphp
                                                    @foreach(config('data.admin.services.security')[\LaravelLocalization::getCurrentLocale()] as $key => $security)
                                                        @php $checked = ""; @endphp
                                                        @if((isset($dataSpecialToArray['security'][$key]) && $dataSpecialToArray['security'][$key] == $key) || old("other_service.security.$key"))
                                                            @php $checked = "checked"; @endphp
                                                        @endif
                                                        <div class="col-md-3">
                                                            <label class="kt-checkbox kt-checkbox--success">
                                                                <input type="checkbox" name="other_service[security][{{$key}}]" id="security{{ $security }}" value="{{ $key }}" {{ $checked }}>
                                                                <label for="security{{ $security }}">{{ $security }}</label>
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    @foreach(config('data.admin.services.security')[\LaravelLocalization::getCurrentLocale()] as $key => $security)
                                                        @php
                                                            $checked = "";
                                                            if(old("other_service.security.$key")){
                                                                $checked = "checked";
                                                            }
                                                        @endphp
                                                        <div class="col-md-3">
                                                            <label class="kt-checkbox kt-checkbox--success">
                                                                <input type="checkbox" name="other_service[security][{{$key}}]" id="security{{ $security }}" value="{{ $key }}" {{ $checked }}>
                                                                <label for="security{{ $security }}">{{ $security }}</label>
                                                                <span></span>
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                        <!-- End Security -->
                                    </div>
                                    <div class="clearfix">&nbsp;</div>
                                </div>
                            </div>
                        
                        </div>

                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions float-right">
                                <a href="javascript:;" class="btn btn-danger btn-other-service-click-back">
                                    <i class="la la-long-arrow-left">&nbsp;</i>{{ __("Back") }}
                                </a>
                                {{ Form::submitSave(__('Submit'), ['type' => 'submit']) }}
                            </div>
                        </div>
                        
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>