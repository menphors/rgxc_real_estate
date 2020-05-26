<div class="tab-pane" id="kt_portlet_base_3_tab_content" role="tabpanel">
    <div class="kt-portlet1">
        <div class="kt-form">
            <div class="kt-portlet__body no-padding">
                
                <div class="kt-portlet">
                    <div class="kt-form">
                        <div class="kt-portlet__body">
                            <div class="row">
                                <div class="col-sm-12">
                                    {{Form::myText('code', $item->code??'', __('Code'), ['placeholder' => __('Enter code'), 'required'], $errors, true)}}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    {{Form::myText('cost', $item->cost ?? '', __('Cost'), ['placeholder' => __('0.00'), 'required'], $errors, true)}}
                                </div>
                                <div class="col-sm-6">
                                    {{Form::myText('price', $item->price ?? '', __('Price'), ['placeholder' => __('0.00'), 'required'], $errors, true)}}
                                </div>
                            </div>
                        
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>