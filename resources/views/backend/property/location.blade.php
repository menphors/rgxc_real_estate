<div class="tab-pane" id="kt_portlet_base_4_tab_content" role="tabpanel">
  <div class="kt-portlet1">
    <div class="kt-form">
      <div class="kt-portlet__body no-padding">
        <div class="kt-portlet">
          <div class="kt-form">
            <div class="kt-portlet__body">
              <div class="row">
                <div class="col-3">
                  <div class="form-group">
                    <label for="province">{{__("Province")}}</label>
                    <select name="province" class="form-control province_id @error('province') is-invalid @enderror" style="width:100%;">
                      <option value="">{{ __("Please Select") }}</option>
                      @if(!is_null($provinces))
                      @foreach($provinces as $key => $province)
                      <option value="{{ $key }}" {{ old("province", @$item->province_id) == $key? "selected" : "" }}>{{ $province }}</option>
                      @endforeach
                      @endif
                    </select>
                    @if ($errors->has('province'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('province') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label for="district">{{__("District")}}</label><br/>
                    <select name="district" class="form-control district_id @error('district') is-invalid @enderror" style="width:100%;">
                      <option value="">{{ __("Please Select") }}</option>
                      @if(!empty(@$districts))
                      @foreach(@$districts as $key => $district)
                      <option value="{{ $key }}" {{ old("district", @$item->district_id) == $key? "selected" : "" }}>{{ $district }}</option>
                      @endforeach
                      @endif
                    </select>
                    @if ($errors->has('district'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('district') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label for="commune">{{__("Commune")}}</label><br/>
                    <select name="commune" class="form-control commune_id @error('commune') is-invalid @enderror" style="width:100%;">
                      <option value="">{{ __("Please Select") }}</option>
                      @if(!empty(@$communes))
                      @foreach(@$communes as $key => $commune)
                      <option value="{{ $key }}" {{ old("commune", @$item->commune_id) == $key? "selected" : "" }}>{{ $commune }}</option>
                      @endforeach
                      @endif
                    </select>
                    @if ($errors->has('commune'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('commune') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-group">
                    <label for="village">{{__("Village")}}</label><br/>
                    <select name="village" class="form-control village_id @error('village') is-invalid @enderror" style="width:100%;">
                      <option value="">{{ __("Please Select") }}</option>
                      @if(!empty(@$villages))
                      @foreach(@$villages as $key => $village)
                      <option value="{{ $key }}" {{ old("village", @$item->village_id) == $key? "selected" : "" }}>{{ $village }}</option>
                      @endforeach
                      @endif
                    </select>
                    @if ($errors->has('village'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('village') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-3 form-group">
                  <label for="street">{{ __("Street") }}</label>
                  <input type="text" name="street" value="{{ old("street", @$property_data["street"]) }}" class="form-control">
                </div>
                <div class="col-3 form-group">
                  <label for="house_no">{{ __("House No") }}</label>
                  <input type="text" name="house_no" value="{{ old("house_no", @$property_data["house_no"]) }}" class="form-control">
                </div>
                <div class="col-3 form-group">
                  <label for="land_mark">{{ __("Land mark") }}</label>
                  <input type="text" name="land_mark" value="{{ old("land_mark", @$property_data["land_mark"]) }}" class="form-control">
                </div>

                <div class="col-md-6 form-group">
                  <label for="tag">{{ __('Tag') }}</label>
                  <select name="tags[]" id="tags" class="form-control" multiple style="width:100%;">
                    <option value=""></option>
                    @if(!empty($item->property_tag))
                      @foreach($item->property_tag as $tag)
                        <option selected value="{{ $tag->tag->id }}">{{ $tag->tag->title }}</option>
                      @endforeach
                    @endif
                  </select>
                </div>
              </div>

              <br/>
              <div class="row">
                <div class="col-12">
                  <label for="map_attachment">{{ __("Attachment Maps") }}</label><br/>
                  <input type="file" name="map_attachment" id="map_attachment" class="btn btn-primary"/><br/>
                  @if(!empty($property_data["map_attachment"]))
                  <img src="{{ asset(config("global.property_image_path"). @$property_data["map_attachment"])  }}" height="250px"/>
                  @endif
                </div>
              </div>
              <br/>
              <div class="row">
                <div class="col-12">
                  <label for="share-maps-link">{{ __("Share Maps Link") }}</label><br/>
                  <input type="text" name="share_maps_link" id="share-maps-link" value="{{ old("share_maps_link", @$property_data["share_maps_link"]) }}" class="form-control"/>
                </div>
              </div>
              <br/>
              <div class="row">
                <div class="col-sm-3">
                  <div class="form-group">
                    <div class="kt-checkbox-list">
                      <label class="kt-checkbox kt-checkbox--success">
                        @if(isset($item) || old("display_on_maps"))
                        <input type="checkbox" class="display_on_maps" name="display_on_maps" id="display_on_maps" @if(old("display_on_maps", @$item->display_on_maps)) checked="checked" @endif>
                        @else
                        <input type="checkbox" name="display_on_maps" id="display_on_maps"> 
                        @endif
                        <label for="display_on_maps">{{ __('Display on maps') }}</label>
                        <span></span>
                      </label>
                    </div>
                  </div>
                  <div class="clearfix">&nbsp;</div>
                </div>
              </div>
              <div class="row">

                <div class="col-sm-12 is-map {{ !old("display_on_maps", @$item->display_on_maps)? "d-none" : "" }}">
                  <div class="row">
                    <div class="col-6">
                      <label>{{ __("Latitude") }}</label>
                      <input type="text" name="latitude" class="form-control input-sm lat-span" value="{{  old("latitude", !empty(@$item->latitude)? @$item->latitude: "11.579524") }}">
                    </div>
                    <div class="col-6">
                      <label>{{ __("Longitude") }}</label>
                      <input type="text" name="longitude" class="form-control input-sm lon-span" value="{{  old("longitude", !empty(@$item->longitude)? @$item->longitude: "104.8199751") }}">
                    </div>
                  </div>
                  <br/>
                  <!-- StartWorking Map -->
                  <div id="map" style="height: 500px;"></div>
                  <ul id="geoData" class="d-none">
                    <li>Latitude: <span id="lat-span"></span></li>
                    <li>Longitude: <span id="lon-span"></span></li>
                  </ul>
                  <!-- End Working Map -->
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="kt-portlet__body">

          <div class="kt-portlet__foot" style="padding-bottom: 0px;padding-right: 0px;">
            <div class="kt-form__actions float-right">
              <a href="javascript:;" class="btn btn-danger btn-location-click-back">
                <i class="la la-long-arrow-left">&nbsp;</i>{{ __("Back") }}
              </a>
              <a href="javascript:;" class="btn btn-success btn-location-click">
                <i class="la la-long-arrow-right">&nbsp;</i>{{ __("Next") }}
              </a>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>
</div>