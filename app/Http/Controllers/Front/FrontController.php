<?php

namespace App\Http\Controllers\Front;

use Mail;
use App\Model\Cms;
use App\Model\Property\Property;
use App\Model\PropertyType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Province\Province;
use App\Model\District\District;
use App\Model\Staff\Staff;
use App\Model\User\User;
use App\Model\Config;
use App\Model\Project;

use Illuminate\Support\Facades\Validator;

class FrontController extends Controller
{
  public function index()
  {
    $provinces = Province::get();
    $projects = Project::get();
    $properties = Property::with([
      "province_id",
      "district_id",
      "commune_id",
      "village_id"
    ])
    ->where('status', \Constants::PROPERTY_STATUS["published"])
    ->where("state", '=', 1)
    ->where("is_home", '=', 1)
    ->orderBy("id", "DESC")
    ->paginate(6);
    $property_types = PropertyType::all();

    $is_filter = [
      'province_id' => '',
      'district_id' => '',
      'listing_type' => '',
      'property_type' => '',
      'bedroom' => '',
      'bathroom' => '',
      'price_from' => '',
      'price_to' => '',
      'search' => '',
      'project' => '',
      'option' => '',
    ];

    $agents = Staff::where("type", \Constants::ROLE_KEY_SALE)->orderBy("id", "DESC")->limit(10)->get();

    // get slide show
    $slide = Cms::where(["type" => \Constants::CMS_TYPE_SLIDE_SHOW])->orderBy("id", "desc")->get();
    $home_page_widget = Cms::where(["type" => \Constants::CMS_TYPE_WIDGET, "blog" => 1])
    ->orderBy("id", "desc")
    ->first();

    //get carousel
    $carousel = Cms::where(["type" => \Constants::CMS_TYPE_BRAND_CAROUSEL])->orderBy("id", "desc")->get();
    return view('front.home', compact(
      'properties',
      'provinces',
      "property_types",
      "projects",
      'is_filter',
      'agents',
      "slide",
      "carousel",
      "home_page_widget"
    ));
  }

  public function properties(Request $request)
  {
    $price_from = $request->get("min_price") ?? 0;
    $price_to = $request->get("max_price") ?? 0;
    $province_id = !empty($request->input('province')) ? $request->input('province') : '';
    $district_id = !empty($request->input('district')) ? $request->input('district') : '';
    $listing_type = !empty($request->input('listing_type')) ? $request->input('listing_type') : '';
    $property_type = !empty($request->input('property_type')) ? $request->input('property_type') : '';
    $bedroom = !empty($request->input('bedroom')) ? $request->input('bedroom') : '';
    $bathroom = !empty($request->input('bathroom')) ? $request->input('bathroom') : '';
    $propery_key = !empty($request->input('property_key')) ? $request->input('property_key') : '';
    $search = $request->get('search');
    $project = $request->get('project');
    $option = $request->get('option');

    $is_filter = [
      'province_id' => $province_id,
      'district_id' => $district_id,
      'listing_type' => $listing_type,
      'property_type' => $property_type,
      'bedroom' => $bedroom,
      'bathroom' => $bathroom,
      'price_from' => $price_from,
      'price_to' => $price_to,
      'search' => $search,
      'project' => $project,
      'option' => $option
    ];

    $provinces = Province::get();
    $districts = District::where('province_id', $province_id)->get();
    $projects = Project::get();
    $limit = $request->get('limit', 15);
    $properties = Property::with(["province_id", "district_id", "commune_id", "village_id", "property_tag"])
    ->where('status', \Constants::PROPERTY_STATUS["published"])
    ->where("state", '=', 1);

    if(!empty($province_id)) {
      $properties->where('province_id', $province_id);
    }
    if(!empty($district_id)) {
      $properties->where('district_id', $district_id);
    }
    if(!empty($listing_type)){
      $properties->where('listing_type', $listing_type);
    }
    if(!empty($property_type)){
      $properties->where('property_type_id', $property_type);
    }
    if(!empty($bedroom)){
      if($bedroom != 'greater') {
        $properties->where('bed_room', $bedroom);
      }
      else {
        $properties->where('bed_room', '>=', 10);
      }
    }
    if(!empty($bathroom)){
      if($bathroom != 'greater') {
        $properties->where('bath_room', $bathroom);
      }
      else {
        $properties->where('bath_room', '>=', 10);
      }
    }
    if(!empty($project)) {
      $properties->where('project_id', $project);
    }
    if(!empty($price_from)) {
      $properties->where('price', '>=', $price_from);
      // $properties->whereBetween('price', [$price_from, $price_to]);
    }
    if(!empty($price_to)) {
      $properties->where('price', '<=', $price_to);
    }
    if(!empty($search)) {
      if($option == 'all') {
        $properties->where('code', 'LIKE', "%{$search}%");
        $properties->orWhereHas('property_tag.tag', function($query) use($search) {
          $query->whereHas('translations', function($tag_translation) use($search) {
            $search = collect(explode(',', $search));
            if($search->count() > 0) {
              foreach($search as $key => $element) {
                $tag_translation->where('title', 'LIKE', "%{$element}%");
                if($key > 0) {
                  $tag_translation->orWhere('title', 'LIKE', "%{$element}%");
                }
              }
            }
          });
        });
      }
      elseif($option == 'keyword') {
        $properties->whereHas('property_tag.tag', function($query) use($search) {
          $query->whereHas('translations', function($tag_translation) use($search) {
            $search = collect(explode(',', $search));
            if($search->count() > 0) {
              foreach($search as $key => $element) {
                $tag_translation->where('title', 'LIKE', "%{$element}%");
                if($key > 0) {
                  $tag_translation->orWhere('title', 'LIKE', "%{$element}%");
                }
              }
            }
          });
        });
      }
      elseif($option == 'code') {
        $properties->where('code', 'LIKE', "%{$search}%");
      }
    }

    if(empty($bathroom)
      && empty($price_from)
      && empty($price_to)
      && empty($bedroom)
      && empty($property_type)
      && empty($listing_type)
      && empty($district_id)
      && empty($property_id)
      && empty($search)) {
      $properties->where("is_home", '=', 1);
    }
    $properties = $properties->orderBy("id", "desc")
    ->paginate($limit);
    $property_types = PropertyType::all();

    //get carousel
    $carousel = Cms::where(["type" => \Constants::CMS_TYPE_BRAND_CAROUSEL])->orderBy("id", "desc")->get();

    // request from URL
    $requestQuery = collect($request)->map(function($items) {
      $items = ($items==null) ? '' : $items;
      return $items;
    })->all();

    return view('front.properties', compact(
      'properties',
      'provinces',
      'districts',
      "property_types",
      "projects",
      'is_filter',
      'carousel',
      'requestQuery'
    ));
  }


  public function agents(Request $request)
  {
    $limit = $request->get('limit', 12);
    // $agents = Staff::whereHas("user", function ($query) {
    //   $query->whereHas("user_has_role", function ($query) {
    //     $query->whereHas("role", function ($query) {
    //       $query->where("role_type", \Constants::ROLE_TYPE_SALE);
    //     });
    //   });
    // })->orderBy("id", "DESC")->paginate($limit);
    $agents = Staff::where("type", \Constants::ROLE_KEY_SALE)->orderBy("id", "DESC")->paginate($limit);

    //get carousel
    $carousel = Cms::where(["type" => \Constants::CMS_TYPE_BRAND_CAROUSEL])->orderBy("id", "desc")->get();

    return view('front.agents', compact('agents', "carousel"));
  }

  public function service()
  {
    $cms = Cms::where([
      "type" => \Constants::CMS_TYPE_PAGE,
      "blog" => \Constants::CMS_PAGE_BLOG_SERVICE
    ])->orderBy("id", "desc")->first();

    //get carousel
    $carousel = Cms::where(["type" => \Constants::CMS_TYPE_BRAND_CAROUSEL])->orderBy("id", "desc")->get();

    return view('front.service', compact("cms", "carousel"));
  }

  public function companyProfile()
  {
    $cms = Cms::where([
      "type" => \Constants::CMS_TYPE_PAGE,
      "blog" => \Constants::CMS_PAGE_BLOG_COMPANY_PROFILE
    ])->orderBy("id", "desc")->first();

    //get carousel
    $carousel = Cms::where(["type" => \Constants::CMS_TYPE_BRAND_CAROUSEL])->orderBy("id", "desc")->get();
    return view("front.company-profile", compact("cms", "carousel"));
  }

  public function contact()
  {
    //get carousel
    $carousel = Cms::where(["type" => \Constants::CMS_TYPE_BRAND_CAROUSEL])->orderBy("id", "desc")->get();
    return view('front.contact', compact("carousel"));
  }

  public function sendContact(Request $request) 
  {
    $this->validate($request, [
      'name' => 'required',
      'email' => 'required|email',
      'subject'=> 'required',
      'message'=> 'required'
    ]);
    $config = Config::pluck('data')->first();
    if(!is_null($config)){
      $config = json_decode($config);
    }
    $data = array(
      'name' => $request->name,
      'email' => $request->email,
      'subject' => $request->subject,
      'bodyMessage' => $request->message,
      'to' => $config->email
    );
    Mail::send(['html'=>'front.contactmail'], $data, function($message) use ($data){
      $message->to($data['to'], 'Rxgcrealestate')->subject($data['subject']);
      $message->from($data['email'], $data['name']);
    });

    return redirect()->route('contact')->with('success', 'Your email sent success!! We will contact you back shortly.');
  }

  public function property_detail($id)
  {
    $property = Property::with([
      "province_id",
      "district_id",
      "commune_id",
      "village_id",
      'property_type_id',
      'attachments',
      'property_tag.tag'
    ])
    ->where('status', \Constants::PROPERTY_STATUS["published"])
    ->where("state", '=', 1)
    ->where('id', $id)
    ->first();

    if(is_null($property)){
      return view("front.errors.404");
    }
    $property = json_decode($property);
    $property->data = json_decode($property->data);

    $property_types = PropertyType::with('properties')->get();
    $relate_properties = Property::where('property_type_id', (int) @$property->property_type_id->id)
    ->with(["province_id"])
    ->where('id', '!=', $property->id)
    ->where('status', \Constants::PROPERTY_STATUS["published"])
    ->orderBy('id', 'desc')
    ->limit(5)
    ->get();

    //get carousel
    $carousel = Cms::where(["type" => \Constants::CMS_TYPE_BRAND_CAROUSEL])->orderBy("id", "desc")->get();
    $sidebar = Cms::where([
      "type" => \Constants::CMS_TYPE_BRAND_SIDE_BAR,
      "blog" => \Constants::BLOG_TYPE_SIDEBAR_PROPERTY_DETAIL
    ])->orderBy("id", "desc")->first();

    // filter general images
    $attachments = collect($property->attachments)->groupBy('type')->toArray();
    if(isset($attachments[1])) {
      $property->attachments = $attachments[1];
    }
    else {
      $property->attachments = [];
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
    // dd($property->data->amentities);
    return view('front.property_detail', compact('property', 'property_types', 'relate_properties', 'carousel', "sidebar"));
  }

  public function agent_detail($id) 
  {
    $agent = Staff::where('id', $id)->first();
    $other_agents =  Staff::whereHas("user", function ($query) {
      $query->whereHas("user_has_role", function ($query) {
        $query->whereHas("role", function ($query) {
          $query->where("role_type", \Constants::ROLE_TYPE_SALE);
        });
      });
    })->where('staffs.id', '!=', $id)->orderBy("id", "DESC")->limit(4)->get();
          //get carousel
    $carousel = Cms::where(["type" => \Constants::CMS_TYPE_BRAND_CAROUSEL])->orderBy("id", "desc")->get();

    return view('front.agent_detail', compact('agent', 'other_agents', 'carousel'));
  }

  public function blogDetail($slug)
  {
    $cms = CMS::where('slug', $slug)->orWhere('id', $slug)->first();
    // dd($cms);

    return view('front.blog_detail', [
      'row' => $cms
    ]);
  }

  public function inquiry(Request $request)
  {
    $status = 0;
    $message = '';
    $validate = Validator::make($request->all(), [
      'name' => 'required',
      'email' => 'required',
      'message' => 'required'
    ]);

    if($validate->fails()) {
      $message = $validate->errors();
    }
    else {
      try {
        $inquiry = new \App\Model\Inquiry;
        $inquiry->name    = $request->name;
        $inquiry->type    = '';
        $inquiry->value   = $request->email;
        $inquiry->remark  = $request->message;
        $inquiry->save();
        $status = 1;
        $message = __("The inquiry has submited. We will reply you soon.");
      } 
      catch(\Exception $exception) {
        Log::error($exception->getMessage());
        $message = __("error-message");
      }
    }

    return response()->json([
      'success' => $status,
      'message' => $message
    ], 200);
  }
}