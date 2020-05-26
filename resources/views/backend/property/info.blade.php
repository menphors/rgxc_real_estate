<div class="tab-pane active" id="kt_portlet_base_1_tab_content" role="tabpanel">
  <div class="kt-portlet no-margin-bottom">
    <div class="kt-form">
      <div class="kt-portlet__body no-padding">
        <div class="kt-form">
          <div class="kt-portlet__body">
            <div class="row">
              <div class="col-12">
                <input type="hidden" name="is_home" value="0"/>
                <label class="kt-checkbox kt-checkbox--success" style="padding-top: 2px">
                  <input type="checkbox" name="is_home" value="1" {{ @$item->is_home == 1? "checked" : "" }}> {{ __("Feature") }}
                  <span></span>
                </label>
              </div>
            </div>

            <div class="row">
              <div class="col-6">
                <div class="row">
                  <div class="col-10">
                    <div class="form-group">
                      <label for="collector">{{ __("Collector") }} <span class="text-danger">*</span> </label>
                      <select name="collector[]" class="form-control select2-multiple" multiple id="collector" data-live-search="true">
                        @if($collectors->count())
                          @foreach($collectors as $collector)
                            <option value="{{ $collector->id }}" {{ !empty(old("collector[]", @$item->collector)) ? (in_array($collector->id, old("collector[]", @$item->collector)) ? "selected" : ""): "" }}>{{  !empty(@$collector->name)? @$collector->name : @$collector->user->name }}</option>
                          @endforeach
                        @endif
                      </select>
                    </div>
                  </div>
                  <div class="col-2" style="padding-top: 28px">
                    <a href="#" class="add-collection btn btn-info btn-sm" data-toggle="modal" data-target="#kt_modal_1_2">
                      <i class="fa fa-plus"></i>
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="project">{{ __("Project") }} </label>
                  <select name="project" class="form-control" id="project" data-live-search="true">
                    <option value="">{{ __("Please Select") }}</option>
                    @if($projects->count())
                    @foreach($projects as $project)
                    <option value="{{ $project->id }}" {{ old("project", @$item->project_id) ==  $project->id ? "selected" : "" }}>{{ @$project->title }}</option>
                    @endforeach
                    @endif
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-6">
                {{--un use --}}
                <div class="form-group" style="display: none;">
                  <label for="owner">{{ __("Owner") }} <span class="text-danger">*</span> </label>
                  <select name="owner_id[]" class="form-control select2-multiple" multiple id="owner" data-live-search="true">
                    @if(@count($owners) > 0)
                    @foreach(@$owners as $owner)
                    <option value="{{ $owner->id }}" {{ !empty(old("owner_id", @$item->owners))? (in_array($owner->id, old("owner_id", @$item->owners))  ? "selected" : "") : ""}}>{{ $owner->name }}</option>
                    @endforeach
                    @endif
                  </select>
                </div>
                <div class="form-group">
                  <label for="owner">{{ __("Owner") }} <span class="text-danger">*</span></label><br/>
                  <input type="text" required name="owner_contact" class="form-control" value="{{ old("owner_contact", @$property_data["owner_contact"]) }}" data-role="tagsinput"/>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="property-type">{{ __("Property Type") }} <span class="text-danger">*</span></label>
                  <select name="property_type" class="form-control" id="property-type">
                    <option value="">{{ __("Please Select") }}</option>
                    @if($property_types->count())
                    @foreach($property_types as $property_type)
                    <option value="{{ $property_type->id }}" {{ old("property_type", @$item->property_type_id) == $property_type->id ? "selected" : "" }}>{{ $property_type->title }}</option>
                    @endforeach
                    @endif
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6">
                {{Form::myText('code', old("code", @$item->code)??'', __('Code'), ['placeholder' => __('Enter code')], $errors, true)}}
              </div>
              <div class="col-sm-6">
                {!! Form::label('listing_type', __('Listing Type')) !!}
                {{ Form::select('listing_type', ['sale' => __('Sale'), 'rent' => __('Rent')], old("listing_type", @$item->listing_type)  ?? '', ['class' => 'form-control'])}}
                @if ($errors->has('listing_type')) <p class="text-danger">{{ $errors->first('listing_type') }}</p> @endif
                <div class="clearfix">&nbsp;</div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="cost">{{ __('Cost') }} <span class="pricing-type">($)</span> </label>
                  <input type="number" value="{{ old("cost", @$item->cost) }}"  step="any"  class="form-control" name="cost" id="cost" placeholder="0.00">
                </div>
              </div>
              <div class="col-sm-3 price">
                <div class="form-group">
                  <label for="price">{{ __('Price') }} <span class="pricing-type">($)</span> </label>
                  <input type="number" value="{{ old("price", @$item->price) }}"  step="any"  class="form-control" name="price" id="price" placeholder="0.00">
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="price-sqm">{{ __('Price') }} ($)/ (Sqm) </label>
                  <input type="number" value="{{ old("price_sqm", @$property_data["price_sqm"]) }}"  step="any" class="form-control" name="price_sqm" id="price_sqm" placeholder="0.00">
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="total-price">{{ __('Total Price') }} ($) </label>
                  <input type="number" value="{{ old("total_price", @$property_data["total_price"]) }}" step="any" class="form-control" name="total_price" id="total_price" placeholder="0.00">
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Start Language -->
        <div class="kt-portlet kt-portlet--tabs no-margin-bottom">
          <div class="kt-portlet__head">
            <div class="kt-portlet__head-toolbar">
              <ul class="nav nav-tabs nav-tabs-line nav-tabs-line-success" role="tablist">

                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <li class="nav-item">

                  <a class="nav-link {{ $localeCode == app()->getLocale() ? 'active' : '' }}" data-toggle="tab" href="#kt_portlet_base_{{$localeCode}}_tab_content" role="tab" aria-selected="true">
                    <img width="20" src="{{ asset("backend/media/flags/".$localeCode.".png") }}" alt="" />&nbsp;{!!$properties['name']!!}
                  </a>
                </li>
                @endforeach

              </ul>
            </div>
          </div>
          <div class="kt-portlet__body no-padding">
            <div class="tab-content">
              @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
              <div class="tab-pane {{ $localeCode == app()->getLocale() ? 'active' : '' }}" id="kt_portlet_base_{{$localeCode}}_tab_content" role="tabpanel">
                {{ Form::hidden('lang', $localeCode) }}

                <div class="kt-portlet">
                  <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                      <h3 class="kt-portlet__head-title">
                        ({{$localeCode}})
                      </h3>
                    </div>
                  </div>
                  <div class="kt-form">
                    <div class="kt-portlet__body" style="padding-bottom: 0px;">
                      <div class="row">
                        <div class="col-sm-12">
                          {{Form::myText('title_'.$localeCode, old('title_'.$localeCode, (@$item? @$item->translate($localeCode)->title: ""))??'', __('Title'), ['placeholder' => __('Enter Property Title') ], $errors, true)}}
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-sm-12">
                          {{ Form::label('remark', __('Remark')) }}
                          {{Form::textarea('remark_'.$localeCode, old('remark_'.$localeCode, (@$item? @$item->translate($localeCode)->remark: "")) ?? '', ['class' => 'form-control summernote', 'rows' => 3], $errors, false)}}
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
        <!-- End Language -->

        <div class="kt-portlet__body">
          <div class="kt-portlet__foot" style="padding-bottom: 0px;padding-right: 0px;">
            <div class="kt-form__actions float-right">
              <a href="javascript:;" class="btn btn-success btn-info-click">
                <i class="la la-long-arrow-right">&nbsp;</i>{{ __("Next") }}
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="kt_modal_1_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{ __("Collector") }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="text-danger error-message"></div>
        <div class="form-group">
          <label for="name">{{__("Name")}} </label>
          <input type="text" name="name" value="{{ old("name") }}" class="form-control">
        </div>
        <div class="form-group">
          <label for="email">{{__("Email")}}</label>
          <input type="text" name="email" value="{{ old("email") }}" class="form-control">
        </div>
        <div class="form-group">
          <label for="phone">{{__("Phone1")}}</label>
          <input type="text" name="phone" value="{{ old("phone") }}" class="form-control">
        </div>
        <div class="form-group">
          <label for="phone2">{{__("Phone2")}}</label>
          <input type="text" name="phone2" value="{{ old("phone2") }}" class="form-control">
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__("Cancel")}}</button>
        <button type="button" class="btn btn-primary btn-save-collector">{{__("Save")}}</button>
      </div>
    </div>
  </div>
</div>