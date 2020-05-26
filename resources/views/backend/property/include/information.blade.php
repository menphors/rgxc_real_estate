<?php
if(isset($property)){
    $property_data = json_decode($property->data, true);
}
?>
<section class="content">
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__body kt-portlet__body--fit">
            <div class="card">
                <div class="card-body">
                  <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                      <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
                        {{ __("Information") }}
                      </a>
                      <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">
                        {{ __("Attribute") }}
                      </a>
                      <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">
                        {{ __("Location") }}
                      </a>
                      <a class="nav-item nav-link" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-controls="nav-about" aria-selected="false">
                        {{ __("Image") }}
                      </a>
                      <a class="nav-item nav-link" id="nav-about-tab" data-toggle="tab" href="#nav-detail" role="tab" aria-controls="nav-about" aria-selected="false">
                        {{ __("Detail") }}
                      </a>
                    </div>
                  </nav>
                    <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                          <table class="table table-hover">
                            @if(count(@$property->property_has_staff))
                              <tr>
                                <td width="250px">{{ __("Website Staff Contact") }}</td>
                                <td>:</td>
                                <td>
                                  @if(count(@$property->property_has_staff))
                                    @foreach(@$property->property_has_staff as $property_has_staff)
                                      <span class="badge badge-primary">{{ @$property_has_staff->staff_id->user->name }}</span>
                                    @endforeach
                                  @endif
                                </td>
                              </tr>
                            @endif
                            <tr>
                              <td width="250px">{{ __('Status') }}</td>
                              <td width="20px">:</td>
                              <td>
                                @if($property->status ==  Constants::PROPERTY_STATUS["padding"])
                                  <span class="badge badge-danger">{{ __("Padding") }}</span>
                                @elseif($property->status == Constants::PROPERTY_STATUS["submitted"])
                                  <span class="badge badge-info">{{ __("Submitted") }}</span>
                                @elseif($property->status == Constants::PROPERTY_STATUS["reviewed"])
                                  <span class="badge badge-primary">{{ __("Reviewed") }}</span>
                                @elseif($property->status == Constants::PROPERTY_STATUS["published"])
                                  <span class="badge badge-success">{{ __("Published") }}</span>
                                @else
                                  <span class="badge badge-dark">{{ __("Solved") }}</span>
                                @endif
                              </td>
                            </tr>

                            <tr>
                              <td width="250px">{{ __('Owner') }}</td>
                              <td width="20px">:</td>
                              <td>
                                <?php
                                $owners = [];
                                if(!empty(@$property_data["owner_contact"])){
                                  $owners = explode(",", @$property_data["owner_contact"]);
                                }
                                ?>
                                @if(!empty(@$owners))
                                  @foreach(@$owners as $owner)
                                    <span class="badge badge-success">{{ @$owner }}</span>
                                  @endforeach
                                @endif
                              </td>
                            </tr>
                            <tr>
                              <td width="250px">{{ __('Collector') }}</td>
                              <td width="20px">:</td>
                              <td>
                                @if(!empty(@$property->collector))
                                  @foreach(@$property->collector as $collector)
                                    <span class="badge badge-success">{{ @$collector->staff_id->username }}</span>
                                  @endforeach
                                @endif
                              </td>
                            </tr>
                            <tr>
                              <td width="250px">{{ __('Property Type') }}</td>
                              <td width="20px">:</td>
                              <td>{{ @$property->property_type_id->title }}</td>
                            </tr>
                            <tr>
                              <td width="250px">{{ __('Listing Type') }}</td>
                              <td width="20px">:</td>
                              <td style="text-transform: capitalize">{{ $property->listing_type }}</td>
                            </tr>
                            <tr>
                              <td width="250px">{{ __('Cost') }}</td>
                              <td width="20px">:</td>
                              <td>{{ "$ ". number_format($property->cost, 2) }}</td>
                            </tr>
                            <tr>
                              <td width="250px">{{ __('Price') }}</td>
                              <td width="20px">:</td>
                              <td>{{ "$ ". number_format($property->price, 2) }}</td>
                            </tr>
                            <tr>
                              <td width="250px">{{ __('Remark') }}</td>
                              <td width="20px">:</td>
                              <td>{!! $property->remark  !!}</td>
                            </tr>
                            <tr>
                              <td width="250px">{{ __('Title') }}</td>
                              <td width="20px">:</td>
                              <td>{{ $property->title }}</td>
                            </tr>
                          </table>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                          <table class="table table-hover">
                            <tr>
                              <td width="250px">{!!  __('Size') ." (m<sup>2</sup>)"!!}</td>
                              <td width="20px">:</td>
                              <td>{{ number_format($property->property_size, 2) }}</td>
                            </tr>
                            <tr>
                              <td width="250px">{{ __('Floor number') }}</td>
                              <td width="20px">:</td>
                              <td>{{ $property->floor_number }}</td>
                            </tr>
                            <tr>
                              <td width="250px">{{ __('Bed room') }}</td>
                              <td width="20px">:</td>
                              <td>{{ $property->bed_room }}</td>
                            </tr>
                            <tr>
                              <td width="250px">{{ __('Bath room') }}</td>
                              <td width="20px">:</td>
                              <td>{{ $property->bath_room }}</td>
                            </tr>
                            <tr>
                              <td width="250px">{{ __('Front refer to') }}</td>
                              <td width="20px">:</td>
                              <td>{!! @config('data.admin.front_refer_to')[\LaravelLocalization::getCurrentLocale()][@$property->front_refer_to]  !!}</td>
                            </tr>
                            <tr>
                              <td width="250px">{{ __('Year of renovation') }}</td>
                              <td width="20px">:</td>
                              <td>{!! $property->year_of_renovation !!}</td>
                            </tr>
                            <tr>
                              <td width="250px">{{ __('Year of construction') }}</td>
                              <td width="20px">:</td>
                              <td>{!! $property->year_of_construction  !!}</td>
                            </tr>
                            <tr>
                              <td width="250px">{!!  __('Built up surface'). " (m<sup>2</sup>)" !!}</td>
                              <td width="20px">:</td>
                              <td>{!! number_format($property->built_up_surface, 2)  !!}</td>
                            </tr>
                            <tr>
                              <td width="250px">{!!  __('Habitable surface') !!}</td>
                              <td width="20px">:</td>
                              <td>{!! $property->habitable_surface  !!}</td>
                            </tr>
                            <tr>
                              <td width="250px">{!!  __('Ground surface'). " (m<sup>2</sup>)" !!}</td>
                              <td width="20px">:</td>
                              <td>{!! number_format($property->ground_surface, 2)  !!}</td>
                            </tr>
                          </table>
                        </div>
                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                          <table class="table table-hover">
                            <tr>
                              <td width="250px">{{ __('Province') }}</td>
                              <td width="20px">:</td>
                              <td>{{ @$property->province_id->title }}</td>
                            </tr>
                            <tr>
                              <td width="250px">{{ __('District') }}</td>
                              <td width="20px">:</td>
                              <td>{{ @$property->district_id->title }}</td>
                            </tr>
                            <tr>
                              <td width="250px">{{ __('Commune') }}</td>
                              <td width="20px">:</td>
                              <td>{{ @$property->commune_id->title }}</td>
                            </tr>
                            <tr>
                              <td width="250px">{{ __('Village') }}</td>
                              <td width="20px">:</td>
                              <td>{{ @$property->village_id->title }}</td>
                            </tr>
                            <tr>
                              <td width="250px">{{ __('Description') }}</td>
                              <td width="20px">:</td>
                              <td>{{ @$property_data["location_description"] }}</td>
                            </tr>
                            <tr>
                              <td width="250px" colspan="3">{{ __('Attachment Location') }}</td>
                            </tr>
                            <tr>
                              <td colspan="3">
                                @if(!empty($property_data["map_attachment"]))
                                <img src="{{ asset(config("global.property_image_path"). @$property_data["map_attachment"])  }}" height="250px"/>
                                @endif
                              </td>
                            </tr>
                          </table>

                          <div id="map" style="height: 500px;"></div>
                        </div>

                        <div class="tab-pane fade" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                          @if(!empty(@$property->thumbnail))
                            <img src="{{ asset(config("global.property_image_path"). @$property->thumbnail) }}"  width="100%" class="img img-responsive">
                          @else
                            {{ __("No image display!") }}
                          @endif
                        </div>
                        <div class="tab-pane fade" id="nav-detail" role="tabpanel" aria-labelledby="nav-about-tab">
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
                                            @if(isset($property))
                                            <input type="checkbox" disabled name="has_swimming_pool" value="1" @if( @$property->has_swimming_pool) checked @endif> {{ __('Has swimming pool') }}
                                            @else
                                            <input type="checkbox" disabled name="has_swimming_pool" value="1"> {{ __('Has swimming pool') }}
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
                                            @if(isset($property) || old("has_elevator"))
                                            <input type="checkbox" disabled name="has_elevator" value="1" @if(old("has_elevator", @$property->has_elevator)) checked @endif> {{ __('Has elevator') }}
                                            @else
                                            <input type="checkbox" disabled name="has_elevator" value="1"> {{ __('Has elevator') }}
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
                                            @if(isset($property) || old("has_basement"))
                                            <input type="checkbox" disabled name="has_basement" value="1" @if(old("has_basement", @$property->has_basement)) checked @endif> {{ __('Has basement') }}
                                            @else
                                            <input type="checkbox" disabled name="has_basement" value="1"> {{ __('Has basement') }}
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
                                            @if(isset($property))
                                            <input type="checkbox" disabled name="has_parking" value="1" @if(old("has_parking", @$property->has_parking)) checked @endif> {{ __('Has parking') }}
                                            @else
                                            <input type="checkbox" disabled name="has_parking" value="1"> {{ __('Has parking') }}
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
                                    @if(isset($property))
                                      @php
                                        $dataOrtherServiceToArray = json_decode($property->data, true);
                                        $data = $dataOrtherServiceToArray['other_service'] ?? [];
                                      @endphp

                                      @foreach(config('data.admin.services.orther_service')[\LaravelLocalization::getCurrentLocale()] as $key => $other_service)
                                        @php $checked = "";  @endphp
                                        @if((isset($data[$key]) && $data[$key] == $key) || old("other_service.other_service.$key"))
                                          @php $checked = "checked";@endphp
                                        @endif
                                        <div class="col-md-3">
                                          <label class="kt-checkbox kt-checkbox--success">
                                            <input type="checkbox" disabled name="other_service[other_service][{{$key}}]" id="other_service{{ $other_service }}" value="{{ $key }}" {{ $checked }}>
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
                                            <input type="checkbox" disabled name="other_service[other_service][{{$key}}]" id="other_service{{ $other_service }}" value="{{ $key }}" {{ $checked }}>
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
                                    @if(isset($property))
                                    @php
                                    $dataSpecialToArray = json_decode($property->data, true);
                                    @endphp
                                    @foreach(config('data.admin.services.specials')[\LaravelLocalization::getCurrentLocale()] as $key => $special)
                                    @php $checked = ""; @endphp
                                    @if((isset($dataSpecialToArray['special'][$key]) && $dataSpecialToArray['special'][$key] == $key) || old("other_service.special.$key"))
                                    @php $checked = "checked"; @endphp
                                    @endif
                                    <div class="col-md-3">
                                      <label class="kt-checkbox kt-checkbox--success">
                                        <input type="checkbox" disabled name="other_service[special][{{$key}}]" id="specials{{ $special }}" value="{{ $key }}" {{ $checked }}>
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
                                        <input type="checkbox" disabled name="other_service[special][{{$key}}]" id="specials{{ $special }}" value="{{ $key }}" {{ $checked }}>
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
                                    @if(isset($property))
                                    @php
                                    $dataSpecialToArray = json_decode($property->data, true);
                                    @endphp
                                    @foreach(config('data.admin.services.security')[\LaravelLocalization::getCurrentLocale()] as $key => $security)
                                    @php $checked = ""; @endphp
                                    @if((isset($dataSpecialToArray['security'][$key]) && $dataSpecialToArray['security'][$key] == $key) || old("other_service.security.$key"))
                                    @php $checked = "checked"; @endphp
                                    @endif
                                    <div class="col-md-3">
                                      <label class="kt-checkbox kt-checkbox--success">
                                        <input type="checkbox" disabled name="other_service[security][{{$key}}]" id="security{{ $security }}" value="{{ $key }}" {{ $checked }}>
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
                                        <input type="checkbox" disabled name="other_service[security][{{$key}}]" id="security{{ $security }}" value="{{ $key }}" {{ $checked }}>
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
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>