<div class="tab-pane" id="kt_portlet_base_image_tab_content" role="tabpanel">
    <div class="kt-portlet1">
        <div class="kt-form">
            <div class="kt-portlet__body no-padding">
                
                <div class="kt-portlet">
                    <div class="kt-form">
                        <div class="kt-portlet__body">
                            
                            <div class="col-sm-3">
                                <div class="card card-default">
                                    <div class="card-header">
                                        <h3 class="card-title font-size-1-rem">
                                            <a href="javascript:;" class="w-100 btn btn-default btn-sm pull-right btn-add btn-add-profile-image"><small>+ {{ __('add feature image') }}</small></a>
                                        </h3>
                                    </div>
                                    <div class="card-body btn-add-profile-image cursor-pointer">
                                        <input type='file' id="input-profile-image" class="d-none click-input-profile-image" name="thumbnail" />
                                        <img id="preview-profile-image" src="{{ !empty(@$item->thumbnail)? asset(config("global.property_image_path"). @$item->thumbnail) : "" }}"  onerror="this.src='{{ url("none.png") }}';" width="100%">
                                    </div>
                                </div>
                            </div>
                        
                        </div>

                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions float-right">
                                <a href="javascript:;" class="btn btn-danger btn-image-click-back">
                                    <i class="la la-long-arrow-left">&nbsp;</i>{{ __("Back") }}
                                </a>
                                <a href="javascript:;" class="btn btn-success btn-image-click">
                                    <i class="la la-long-arrow-right">&nbsp;</i>{{ __("Next") }}
                                </a>
                            </div>
                        </div>
                        
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>