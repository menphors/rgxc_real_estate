<?php

namespace App\Http\Controllers\Front;

use App\Model\Contract\Contract;
use App\Model\Property\Property;
use App\Model\PropertyLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use LaravelLocalization;

class PropertyController extends Controller
{

    public function __construct()
    {
        date_default_timezone_set("Asia/Bangkok");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function detail($token)
    {
      $link = PropertyLink::where(['token' => $token])
        ->where("valid_from", "<=", date("Y-m-d h:i"))
        ->where("valid_to", ">=", date("Y-m-d h:i"))
        ->first();

      if(is_null($link)) {
        return "<pre>Token Expired</pre>";
      }

      $link->url = route("property-detail", $link->token);
      $link->data = json_decode($link->data);

      // set language;
      LaravelLocalization::setLocale($link->data->language);
      // App::setLocale(!empty(@$link->data->language) ? $link->data->language : "en");

      $property = Property::where("id", $link->property_id)->with([
          "province_id",
          "district_id",
          "commune_id",
          "village_id",
          "owner",
          "owner.owner_id:id,name",
          "collector",
          "collector.staff_id:id,user_id,name,email,phone1,phone2",
          "collector.staff_id.user:id,name",
          "property_type_id",
          "contracts",
          "attachments"
      ])->first();

      if(is_null($property)) {
        return "<pre>Not Found!</pre>";
      }
      $property = json_decode($property);
      $property->data = json_decode($property->data);
      if($link->data->gallery == 1) {
        $property->attachments = collect($property->attachments)->sortBy('type')->toArray();
      }
      else {
        $attachments = collect($property->attachments)->groupBy('type')->toArray();
        $property->attachments = isset($attachments[1]) ? $attachments[1] : [];
      }

      $other_service = isset($property->data->other_service) ? collect($property->data->other_service)->map(function($item) {
        return config('data.admin.services.orther_service')[\LaravelLocalization::getCurrentLocale()][$item] ?? NULL;
      }) : collect([]);
      $security = isset($property->data->security) ? collect($property->data->security)->map(function($item) {
        return config('data.admin.services.security')[\LaravelLocalization::getCurrentLocale()][$item] ?? NULL;
      }) : collect([]);
      $special = isset($property->data->special) ? collect($property->data->special)->map(function($item) {
        return config('data.admin.services.specials')[\LaravelLocalization::getCurrentLocale()][$item] ?? NULL;
      }) : collect([]);
      $property->data->amentities = $other_service->merge($security)->merge($special);

      $contract = Contract::where(['property_id' => $link->property_id])->get();

      return view("backend.property.detail", compact("property", "link", "contract"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
