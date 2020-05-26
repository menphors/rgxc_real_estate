<?php

namespace App\Http\Controllers\Admin;

use App\Model\Attachment\Attachment;
use App\Model\Commission\Commission;
use App\Model\Commune\Commune;
use App\Model\Contract\Contract;
use App\Model\District\District;
use App\Model\Office\Office;
use App\Model\Owner;
use App\Model\Project;
use App\Model\Property\Property;
use App\Model\Property\PropertyTranslation;
use App\Model\PropertyHasOwner;
use App\Model\PropertyHasStaff;
use App\Model\PropertyLink;
use App\Model\PropertyOffice;
use App\Model\PropertyType;
use App\Model\PropertyTag;
use App\Model\Staff\Staff;
use App\Model\User\User;
use App\Model\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\Facades\Image;
use PropertyRepository;
use ProvinceRepository;
use DistrictRepository;
use CommuneRepository;
use VillageRepository;
use OfficeRepository;
use StaffRepository;
use UserRepository;
use DB;

class PropertyController extends Controller
{
  protected $propertyRepo;

  protected $provinceRepo;

  protected $districtRepo;

  protected $communeRepo;

  protected $villageRepo;

  protected $propertyTypeRepo;

  protected $officeRepo;

  protected $user;

  protected $staff;

  function __construct(VillageRepository $villageRepo, CommuneRepository $communeRepo, OfficeRepository $officeRepo, DistrictRepository $districtRepo, ProvinceRepository $provinceRepo, PropertyRepository $propertyRepo, StaffRepository $staff, UserRepository $user) {
    $this->propertyRepo = $propertyRepo;
    $this->provinceRepo = $provinceRepo;
    $this->districtRepo = $districtRepo;
    $this->communeRepo = $communeRepo;
    $this->officeRepo = $officeRepo;
    $this->villageRepo = $villageRepo;
    $this->staff = $staff;
    $this->user = $user;

    date_default_timezone_set("Asia/Bangkok");
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if(!\Auth::user()->can('property.view')) {
      return view('backend.partial.no-permission', ['title' => 'No-permission']);
    }

    $limit = $request->get('limit', 10);
    $properties = [];
    $districts = [];
    $communes = [];

    $staffs = Staff::whereIn('type', [3,1,4])->get();

    if(!\Auth::user()->hasRole('administrator') && \Auth::user()->isOffice()) {
      $staffObj = \Auth::user()->staff;
      /*
      * Get properties in office
      */
      if (!empty($staffObj->office)) {
        if($staffObj->office->properties()->count()) {
          $properties = $staffObj->office->properties();//->orderBy("id", "desc")->paginate($limit);
        }

        /*
        * Get properties in staff
        */
      } 
      elseif (!empty($staffObj->properties) && count($staffObj->properties) > 0) {
        $properties = $staffObj->properties();//->orderBy("id", "desc")->paginate($limit);
      }
    }

    /*
    * Get all properties
    */
    if(\Auth::user()->isAdministrator()) {
      $properties = $this->propertyRepo->model();//->orderBy("id", "desc")->paginate($limit);
    }

    /*
    * Get properties for user role type cellector [Statue pending]
    */
    if (!\Auth::user()->hasRole('administrator') && \Auth::user()->isCollector()) {
      $properties = $properties->where('status', 0);//->orderBy("id", "desc")->paginate($limit);
    }

    $search_txt = $request->q;
    if(!empty($search_txt)) {
      $properties = $properties->where(function ($query) use($search_txt) {
        return $query->orWhere("code", "LIKE", "%{$search_txt}%");
      });
    }

    // dd($request->all());
    if($request->province != null) {
      $properties = $properties->where('province_id', $request->province);
      $districts = $this->districtRepo->lists()->where('province_id', $request->province)->pluck('title', 'id')->toArray();
    }
    if($request->district != null) {
      $properties = $properties->where('district_id', $request->district);

      $communes = $this->communeRepo->lists()->where('district_id', $request->district)->pluck('title', 'id')->toArray();
    }
    if($request->commune != null) {
      $properties = $properties->where('commune_id', $request->commune);
    }
    if($request->type != null) {
      $properties = $properties->where('listing_type', $request->type);
    }
    if($request->property_type != null) {
      $properties = $properties->where('property_type_id', $request->property_type);
    }
    if($request->status != null) {
      $properties = $properties->where('status', $request->status);
    }
    $properties = $properties->orderBy("id", "desc")->paginate($limit);

    $agents = Staff::where("type", \Constants::ROLE_KEY_AGENT)
    ->with("user", "property_link")
    ->orderBy("id", "DESC")
    ->get();
    $agents = json_decode($agents);
    $provinces = $this->provinceRepo->lists()->pluck('title', 'id')->toArray();
    $property_types = PropertyType::get();

    $status = [ "Pending", "Submitted", "Reviewed", "Published", "Solved", "Deposit", "Unpublished" ];
    $colors = [ "#fd397a", "#17a2b8", "#5867dd", "#0abb87", "#545b62", "#fd397a", "#5867dd" ];
    $propertiesCount = Property::groupBy('status')->get(['status', DB::raw("COUNT(id) AS total")])->map(function($property) use($status, $colors) {
      return [
        'label' => __($status[$property->status]),
        'value' => $property->total,
        'color' => $colors[$property->status]
      ];
    });

    $total_properties = [
      'data' => $propertiesCount,
      'total' => $propertiesCount->sum('value'),
    ];

    $requestQuery = collect($request)->map(function($items) {
      $items = ($items==null) ? '' : $items;
      return $items;
    })->all();

    return view('backend.property.index', compact('properties', "agents", "property_types", "provinces", "districts", "communes", "total_properties", "requestQuery", "staffs"));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    if(!\Auth::user()->can('property.create')) {
      return view('backend.partial.no-permission', ['title' => 'No-permission']);
    }

    $provinces = $this->provinceRepo->lists()->pluck('title', 'id')->toArray();
    $property_types = PropertyType::orderBy("id", "desc")->get();
    //$owners = Owner::orderBy("id", "desc")->get();
    $owners = [];
    $front_refer_to = $this->getFrontReferTo();
    $action = route("administrator.property-store");
    $collectors  = Staff::where(function($query) {
      $query->orWhereIn('type', [2,4]);
      $query->orWhereHas("user", function ($query) {
        $query->whereHas("user_has_role", function ($query) {
          $query->whereHas("role", function ($query) {
            $query->where("role_type", \Constants::ROLE_TYPE_COLLECTOR);
          });
        });
      });
    })->with("user")->orderBy("id", "DESC")->get();

    $projects = Project::orderBy("id", "DESC")->get();

    return view('backend.property.form', compact('provinces', 'front_refer_to', 'property_types', "owners", "action", "collectors", "projects"));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    if(!\Auth::user()->can('property.create'))
      return view('backend.partial.no-permission', ['title' => 'No-permission']);

    $request->validate([
      'title_en' => 'required',
      'code' => 'required|max:255|unique:properties,code',
      'cost' => 'required',
      'price' => 'required',
      'owner_contact' => 'required',
      'property_type' => 'required'
    ]);

    $propertyData = $this->requestData($request);

    $item = $this->propertyRepo->create($propertyData);
    if($item) {
      $collectors = $request->get("collector");
      if(!empty($collectors)) {
        foreach ($collectors as $collector) {
          PropertyHasStaff::create([
            "property_id" => $item->id,
            "staff_id"    => $collector,
            "type"        => 1
          ]);
        }
      }

      $tags = $request->tags;
      if(!empty($tags)) {
        foreach($tags as $tag) {
          PropertyTag::create([
            'property_id' => $item->id,
            'tag_id' => $tag,
            'type' => 1
          ]);
        }
      }

      return redirect(route("administrator.property-view", $item->id)."?action=gallery")->with('successful', 'Save Successfully, please add image gallery.');
    }

    return redirect()->back()->with("error", __("error-message"))->withInput($request->all());
  }

  private function requestData($request) 
  {
    $data['property_type_id']   = $request->property_type ?? null;
    $data['province_id']        = $request->province ?? null;
    $data['project_id']         = $request->get("project");
    $data['district_id']        = $request->district ?? null;
    $data['commune_id']         = $request->commune ?? null;
    $data['village_id']         = $request->village ?? null;
    $data['code']               = $request->code ?? null;
    $data['listing_type']       = $request->listing_type ?? null;
    $data['cost']               = $request->cost ?? '6756';
    $data['price']              = $request->price ?? null;
    $data['property_size']      = is_float($request->property_size) || is_numeric($request->property_size) ? $request->property_size : 0;
    $data['floor_number']       = $request->floor_number ?? null;
    $data['bed_room']           = $request->bed_room ?? null;
    $data['bath_room']          = $request->bath_room ?? null;
    $data['has_parking']        = $request->has_parking ?? null;
    $data['front_refer_to']     = $request->front_refer_to ?? null;
    $data['latitude']           = $request->latitude ?? null;
    $data['longitude']          = $request->longitude ?? null;
    $data['display_on_maps']    = $request->display_on_maps ? true : false;
    $data['year_of_renovation'] = $request->year_of_renovation ?? null;
    $data['year_of_construction'] = $request->year_of_construction ?? null;
    $data['built_up_surface']   = $request->built_up_surface ?? null;
    $data['habitable_surface']  = $request->habitable_surface ?? null;
    $data['ground_surface']     = $request->ground_surface ?? null;
    $data['has_swimming_pool']  = $request->has_swimming_pool ? true : false;
    $data['has_elevator']       = $request->has_elevator ? true : false;
    $data['address']            = $request->address ?? null;
    $data['has_basement']       = $request->has_basement ? true : false;
    $data['is_home']            = $request->is_home ? 1 : 0;

    $other_services = $request->get('other_service', []);
    $service = [];
    if(!empty($other_services)) {
      $service['special'] = [];
      if(isset($other_services['special'])) {
        $service['special'] = $other_services['special'];
      }

      $service['other_service'] = [];
      if(isset($other_services['other_service'])) {
        $service['other_service'] = $other_services['other_service'];
      }

      $service['security'] = [];
      if(isset($other_services['security'])) {
        $service['security'] = $other_services['security'];
      }
    }
    $property_data = [];
    if(!empty($service)) {
      $property_data = $service;
    }
    if($request->hasFile('map_attachment')) {
      $img = $request->file("map_attachment");
      $extension = $img->getClientOriginalExtension();
      $has = md5(date('Y-m-d H:i:s') . rand(1, 100));
      $file_name = sha1($has) . "." . $extension;

      $path = base_path() . '/public' . config("global.property_image_path");
      if (!is_dir($path)) {
        File::makeDirectory($path, 0777, true, true);
      }

      $img = Image::make($img->getRealPath());
      if($img->save($path.$file_name)){
        $property_data["map_attachment"] = $file_name;
      }
    }

    $property_data["owner_contact"] = $request->get("owner_contact");
    $property_data["floor_level"] = $request->get("floor_level");
    $property_data["share_maps_link"] = $request->get("share_maps_link");
    $property_data["street"] = $request->get("street");
    $property_data["house_no"] = $request->get("house_no");
    $property_data["land_mark"] = $request->get("land_mark");
    $property_data["total_build_surface"] = $request->get("total_build_surface");
    $property_data["price_sqm"] = $request->get("price_sqm");
    $property_data["total_price"] = $request->get("total_price");
    $data['data'] = json_encode($property_data);

    if($request->hasFile('thumbnail')) {
      $featureImage = time().'.'.request()->thumbnail->getClientOriginalExtension();
      request()->thumbnail->move(public_path('images/property/'), $featureImage);
      $data['thumbnail'] = $featureImage;
      $this->water_mark(config("global.property_image_path").$featureImage);
    }

    $data['is_published']       = $request->is_published ?? null;//NULL, TRUE, FALSE
    $data['created_by']         = \Auth::user()->id;
    $data['updated_by']         = $request->updated_by ?? null;
    $data['user_id']            = \Auth::user()->id;
    $data['type_id']            = $request->type_id ?? null;
    $data['en'] = ['title' => $request->title_en, 'remark' => $request->remark_en];
    $data['cn'] = ['title' => $request->title_cn ?? $request->title_en, 'remark' => $request->remark_cn];
    $data['kh'] = ['title' => $request->title_kh ?? $request->title_en, 'remark' => $request->remark_kh];

    return $data;
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(Request $request, $id)
  {
    if(!\Auth::user()->can('property.view'))
      return view('backend.partial.no-permission', ['title' => 'No-permission']);

    $export = $request->get('export', '');
    // $property = $this->propertyRepo->find($id);

    $property = null;

    /*
    * Get all properties current office
    */
    if(!\Auth::user()->hasRole('administrator') && \Auth::user()->isOffice()) {
      $staffObj = \Auth::user()->staff;
      /*
      * Get properties in office
      */
      if (!empty($staffObj->office)) {
        if($staffObj->office->properties()->count()) {
          $property = $staffObj->office->properties()->where('property_id', $id)->first();
        }

        /*
        * Get properties in staff
        */
      } 
      elseif (!empty($staffObj->properties) && count($staffObj->properties) > 0) {
        $property = $staffObj->properties()->where('property_id', $id)->first();
      }
    }

    if(\Auth::user()->isAdministrator()) {
      $property = $this->propertyRepo->find($id);
    }

    if (!\Auth::user()->hasRole('administrator') && \Auth::user()->isCollector()) {
      $property = $this->propertyRepo->model()->where('id', $id)
      ->where('status', 0)
      ->first();
    }

    if(is_null($property)) {
      return redirect(url('administrator/property'))->with("error", __("error-message"));
    }
    if($export == 'contract-owner') {
      if(!\Auth::user()->can('contract_property'))
        return view('backend.partial.no-permission', ['title' => 'No-permission']);

      return view("backend.property.include.contract.owner_company", compact('property'));
    } 
    elseif($export == 'contract-customer') {
      if(!\Auth::user()->can('contract_property'))
        return view('backend.partial.no-permission', ['title' => 'No-permission']);
      return view("backend.property.include.contract.customer_company", compact('property'));
    }

    $property = Property::where("id", $id)->with([
      "province_id",
      "district_id",
      "commune_id",
      "village_id",
      "owner",
      "owner.owner_id:id,name",
      "collector",
      "collector.staff_id:id,user_id",
      "collector.staff_id.user:id,name",
      "property_type_id"
    ])->with(["property_has_staff" => function($query) {
      $query->where("type", 3)->with("staff_id", "staff_id.user");
    }])->first();

    if(is_null($property)){
      return redirect()->back()->with("error", __("error-message"));
    }
    $attachments = Attachment::where([
      "object_id" => $id,
      "key" => "properties",
      "type" => session('gallery_type', 1)
    ])->get();

    $property = json_decode($property);
    $commissions = [];
    $staffs = [];
    $owners = [];
    $property_has_owner = [];
    $contract_list =[];
    $contract = null;
    switch (\request("action")) {
      case "commission":
      $commissions = Commission::where(["property_id" => $id])->orderBy("type", "ASC")->get();
      break;

      case "assign-staff":
      $staffs = PropertyHasStaff::whereHas("staff_id")
      ->with(["staff_id",
        "staff_id.user:id,name,email,phone",
        "staff_id.user.user_has_role:role_id,model_id",
        "staff_id.user.user_has_role:role_id,model_id",
        "staff_id.user.user_has_role.role:id,role_type",
      ])
      ->where("type", 2)
      ->get();

      case "contract":
      $owners = Owner::orderBy("id", "desc")->get();
      $property_has_owner = PropertyHasOwner::where("property_id", $id)->pluck('owner_id')->toArray();
      $contract_list = Contract::where(["property_id" => $id])->orderBy("id", "desc")->get();
      if(!empty($request->get("contract-id"))){
        $contract = Contract::where(["id" => $request->get("contract-id")])->first();
      }
      break;
    }

    $sales = Staff::where(["type" => \Constants::ROLE_KEY_SALE])->with("user")->orderBy("id", "DESC")->get();
    return view("backend.property.show", compact("property", "sales", "attachments", "commissions", "staffs", "owners", "property_has_owner", "contract_list", "contract"));
  }

  public function removeImage($property_id, $attachment_id)
  {
    $attachment = Attachment::where(['id' => $attachment_id, "object_id" => $property_id, "key" => "properties"])->first();

    if(is_null($attachment)){
      return redirect()->back()->with("error", __("error-message"));
    }

    if(!empty(@$attachment->name)){
      File::delete( public_path() . config("global.property_image_path").$property_id. '/'. $attachment->name);
    }
    $attachment->delete();
    return redirect()->back()->with("success", __("success-message"));
  }

  public function upload(Request $request, $id)
  {
    if(!$request->hasFile("image")){
      return redirect()->back()->with("error", __("error-message"))->withInput(Input::all());
    }

    $files = $request->file("image");
    if(!empty($files)){
      foreach ($files as $img){
        $extension = $img->getClientOriginalExtension();
        $has = md5(date('Y-m-d H:i:s') . rand(1, 100));
        $file_name = sha1($has) . "." . $extension;

        $path = base_path() . '/public' . config("global.property_image_path").$id."/";

        if (!is_dir($path)) {
          File::makeDirectory($path, 0777, true, true);
        }
        $file_size = $img->getSize();
        $img = Image::make($img->getRealPath());

        if($img->save($path.$file_name)){
          Attachment::create([
            "object_id" => $id,
            "key" => "properties",
            "name" => $file_name,
            "size" => $file_size,
            "type" => session("gallery_type", 1)
          ]);

          $this->water_mark(config("global.property_image_path").$id.'/'.$file_name, "center");
        }
      }
      return redirect(route("administrator.property-view", $id)."?action=gallery");
    }

    return redirect()->back()->with("error", __("error-message"))->withInput($request->all());
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    if(!\Auth::user()->can('property.update'))
      return view('backend.partial.no-permission', ['title' => 'No-permission']);

    $front_refer_to = $this->getFrontReferTo();
    $item = null;

    /*
    * Get all properties current office
    */
    if(!\Auth::user()->hasRole('administrator') && \Auth::user()->isOffice()) {
      $staffObj = \Auth::user()->staff;
      /*
      * Get properties in office
      */
      if (!empty($staffObj->office)) {
        if($staffObj->office->properties()->count()) {
          $item = $staffObj->office->properties()->where('property_id', $id)->first();
        }

        /*
        * Get properties in staff
        */
      } 
      elseif (!empty($staffObj->properties) && count($staffObj->properties) > 0) {
        $item = $staffObj->properties()->where('property_id', $id)->first();
      }
    }

    if(\Auth::user()->isAdministrator()) {
      $item = $this->propertyRepo->find($id);
    }

    if (!\Auth::user()->hasRole('administrator') && \Auth::user()->isCollector()) {
      $item = $this->propertyRepo->model()->where('id', $id)
      ->where('status', 0)
      ->first();
    }

    if(empty($item)) {
      return redirect('administrator/property')->with(['error' , 'Property not found!']);
    }

    $item = Property::with(["owner", "collector", "property_tag"])->find($id);
    $provinces = $this->provinceRepo->lists()->pluck('title', 'id')->toArray();
    $districts = $this->districtRepo->lists()
    ->where(["province_id" => $item->province_id])
    ->pluck('title', 'id')
    ->toArray();
    $communes = $this->communeRepo->lists()
    ->where(["district_id" => $item->district_id])
    ->pluck('title', 'id')
    ->toArray();

    $villages = $this->communeRepo->lists()
    ->where(["commune_id" => $item->commune_id])
    ->pluck('title', 'id')
    ->toArray();
    if(!empty(@$item->owner)){
      $item->owners = $item->owner->pluck('owner_id')->toArray();
    }

    if(!empty(@$item->owner)) {
      $item->collector = $item->collector->pluck('staff_id')->toArray();
    }

    if(!empty(@$item->tag)) {
      $item->tag = $item->tag->map(function($tag) {
        return [
          'id' => $tag->tag_id,
          'text' => $tag->tag->title
        ];
      })->toArray();
      // $item->tag = $item->tag->pluck('tag_id')->toArray();
    }

    $action = route("administrator.property-update", $id);
    $property_types = PropertyType::orderBy("id", "desc")->get();
    $owners = Owner::orderBy("id", "desc")->get();

    $collectors = Staff::where(function($query){
      $query->orWhereIn('type', [2,4]);
      $query->orWhereHas("user", function ($query) {
        $query->whereHas("user_has_role", function ($query) {
          $query->whereHas("role", function ($query) {
            $query->where("role_type", \Constants::ROLE_TYPE_COLLECTOR);
          });
        });
      });
    })->with("user")->orderBy("id", "DESC")->get();

    $projects = Project::orderBy("id", "DESC")->get();

    return view('backend.property.form', compact('item', 'front_refer_to', "provinces", "districts", "communes", "villages", "property_types", "owners", "action", "collectors", "projects"));
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
    if(!\Auth::user()->can('property.update'))
      return view('backend.partial.no-permission', ['title' => 'No-permission']);

    $request->validate([
      'title_en' => 'required',
      'code' => 'required|max:255',
      'cost' => 'required',
      'price' => 'required',
      'owner_contact' => 'required',
      'property_type' => 'required'
    ]);

    $item = $this->propertyRepo->find($id);

    if($item) {
      $propertyData = $this->requestData($request);
      $updateSuccess = $item->update($propertyData);
      if($updateSuccess) {
        $collectors = $request->get("collector");
        if(!empty($collectors)) {
          PropertyHasStaff::where("property_id", $id)->delete();
          foreach ($collectors as $collector) {
            PropertyHasStaff::create([
              "property_id" => $item->id,
              "staff_id" => $collector,
              "type" => 1
            ]);
          }
        }

        $tags = $request->get('tags');
        PropertyTag::where('property_id', $id)->delete();
        if(!empty($tags)) {
          foreach($tags as $tag) {
            PropertyTag::create([
              'property_id' => $item->id,
              'tag_id' => $tag,
              'type' => 1
            ]);
          }
        }

        return redirect('/administrator/property')->with('successful', __('Save Successfully.'));
      }
    }
    return redirect('/administrator/property')->with('error', __('Save Fails.'));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    if(!\Auth::user()->can('property.delete'))
      return view('backend.partial.no-permission', ['title' => 'No-permission']);

    $item = $this->propertyRepo->find($id);
    if(!$item) {
      return \Response::json([
        'success'   => false,
      ], 500);
    }

    // Commission::where(["property_id" => $item->id])->delete();
    // PropertyTranslation::where(["property_id" => $item->id])->delete();
    // PropertyHasStaff::where(["property_id" => $item->id])->delete();
    if($item->delete()) {
      return \Response::json([
        'success'   => true,
      ], 200);
    }
    return \Response::json([
      'success'   => false,
    ], 500);
  }

  public function getDistrictProvince($id) 
  {
    $items = $this->districtRepo->lists()->where('province_id', $id)->pluck('title', 'id')->toArray();
    $data = [];
    foreach ($items as $key => $value) {
      $data[] = ['id' => $key, 'text' => $value];
    }
    return response()->json(['success' => true, 'message' => __('success'), 'districts' => $data], 200);
  }

  public function getCommuneDistrict($id) 
  {
    $items = Commune::where('district_id', $id)->get();

    $data = [];
    foreach ($items as $key => $value) {
      $data[] = ['id' => $value->id, 'text' => $value->title];
    }
    return response()->json(['success' => true, 'message' => __('success'), 'communes' => $data], 200);
  }

  public function getVillageCommune($id) 
  {
    $items = $this->villageRepo->lists()->where('commune_id', $id)->pluck('title', 'id')->toArray();
    $data = [];
    foreach ($items as $key => $value) {
      $data[] = ['id' => $key, 'text' => $value];
    }
    return response()->json(['success' => true, 'message' => __('success'), 'villages' => $data], 200);
  }

  public function sendPropertyToOffice($property_id)
  {
    $head_office = Office::where(["is_main" => 1])->first();
    $property = Property::find($property_id);
    if(is_null($head_office) || is_null($property)){
      return redirect()->back()->with("error", __("error-message"));
    }

    $add_property_office = PropertyOffice::create([
      "property_id" => $property_id,
      "office_id" => $head_office->id,
    ]);

    if($add_property_office){
      $property->status = 1;
      if($property->save()){
        return redirect()->back()->with("success", __("success-message"));
      }
    }

    return redirect()->back()->with("error", __("error-message"));
  }

  public function completedReview($property_id)
  {
    $property = Property::find($property_id);
    if(is_null($property)){
      return redirect()->back()->with("error", __("error-message"));
    }

    $property->status = 2;
    if($property->save()){
      return redirect(route("administrator.property-listing"))->with("success", __("success-message"));
    }

    return redirect()->back()->with("error", __("error-message"));
  }

  public function publishedProperty(Request $request,$property_id)
  {
    $property = Property::find($property_id);
    if(is_null($property)) {
      return redirect()->back()->with("error", __("error-message"));
    }

    if(empty($request->get('all')) && $request->get('all') == 0) {
      $staffs = $request->get("staff");
      if(!empty($staffs)) {
        foreach ($staffs as $staff) {
          PropertyHasStaff::create([
            "property_id" => $property_id,
            "staff_id"    => $staff,
            "type"        => 3 // only staff that assign when published property
          ]);
        }
      }
    }
    else {
      $staff = Staff::where('is_default', 1)->first()->id;
      // PropertyHasStaff::create([
      //   "property_id" => $property_id,
      //   "staff_id"    => $staff,
      //   "type"        => 3 // only staff that assign when published property
      // ]);
    }

    $property->status = 3;
    $property->state = 1;
    if($property->save()){
      return redirect()->back()->with("success", __("success-message"));
    }

    return redirect()->back()->with("error", __("error-message"));
  }

  public function solvedProperty($property_id)
  {
    $property = Property::find($property_id);
    if(is_null($property)){
      return redirect()->back()->with("error", __("error-message"));
    }

    $property->status = 4;
    // $property->state = 0;
    if($property->save()){
      return redirect()->back()->with("success", __("success-message"));
    }

    return redirect()->back()->with("error", __("error-message"));
  }

  private function getFrontReferTo() {
    return config('data.admin.front_refer_to')[\LaravelLocalization::getCurrentLocale()];
  }

  public function setupCommission(Request $request)
  {
    // if(!\Auth::user()->can('property.commission'))
    //   return view('backend.partial.no-permission', ['title' => 'No-permission']);

    $check_exists = Commission::where([
      "property_id" => $request->property_id,
      "type" => $request->commission_type,
      "to" => $request->get("commission_to", "")
    ])->first();

    if(!is_null($check_exists)){
      return redirect()->back()->withErrors( __("commission_already_exists"))->withInput($request->all());
    }


    $save = Commission::create([
      "property_id" => $request->property_id,
      "type" => $request->commission_type,
      "to" => $request->get("commission_to", ""),
      "commission" => $request->commission_type == \Constants::COMMISSION_OWNER_COMPANY? $request->owner_amount : $request->amount,
    ]);

    if($save){
      return redirect()->back()->with("success", __("success-message"));
    }

    return redirect()->back()->withErrors( __("error-message"));
  }

  public function deleteCommission($id)
  {
    // if(!\Auth::user()->can('property.commission'))
    //   return view('backend.partial.no-permission', ['title' => 'No-permission']);

    $delete = Commission::where(["id" => $id])->destroy();

    if($delete){
      return redirect()->back()->with("success", __("success-message"));
    }

    return redirect()->back()->withErrors( __("error-message"));
  }

  public function updateCommission(Request $request, $id)
  {
    // if(!\Auth::user()->can('property.commission'))
    //   return view('backend.partial.no-permission', ['title' => 'No-permission']);

    $save = Commission::where("id", $id)
    ->update([
      "commission" => $request->hidden_type == \Constants::COMMISSION_OWNER_COMPANY? $request->owner_amount : $request->amount,
    ]);

    if($save){
      return redirect()->back()->with("success", __("success-message"));
    }

    return redirect()->back()->withErrors( __("error-message"))->withInput($request->all());
  }

  public function getStaffByRoleType($type)
  {
    $html = "";
    $data  = Staff::whereHas("user", function ($query) use($type){
      $query->whereHas("user_has_role", function ($query) use($type){
        $query->whereHas("role", function ($query) use($type){
          $query->where("role_type", $type);
        });
      });
    })->doesntHave("property_has_staff")->with("user")->orderBy("id", "DESC")->get();

    if($data->count()){
      foreach ($data as $value){
        $html .="<option value='". $value->id ."'>". @$value->user->name ."</option>";
      }
    }

    return $html;
  }

  public function addStaffToProperty(Request $request, $property_id)
  {
    $request->validate([
      'property_id' => 'required',
      'staff' => 'required'
    ]);

    $staffs = $request->get("staff");

    if(!empty($staffs)){
      foreach ($staffs as $staff){
        PropertyHasStaff::create([
          "property_id" => $property_id,
          "staff_id" => $staff,
          "type" => 2
        ]);
      }
    }

    return redirect()->back()->with("success", __("success-message"));
  }

  public function removeStaff($staff_id, $property_id)
  {
    $remove = PropertyHasStaff::where([
      "property_id" => $property_id,
      "staff_id" => $staff_id,
      "type" => 2,
    ])->delete();

    if($remove){
      return redirect()->back()->with("success", __("success-message"));
    }

    return redirect()->back()->withErrors( __("error-message"));
  }

  public function generateClientUrl(Request $request, $property_id)
  {
    $agent_id = $request->get("agent");
    $link = PropertyLink::where('property_id', $property_id)
    ->where("agent_id", $agent_id)
    ->where("valid_from", "<=", date("Y-m-d h:i"))
    ->where("valid_to", ">=", date("Y-m-d h:i"))
    ->first();

    if(!is_null($link)) {
      PropertyLink::where(["id" => $link->id])->update([
        "data" => json_encode($request->get("data", []))
      ]);
      $token = $link->token;
    }
    else {
      $token = $this->getToken(20);
      PropertyLink::create([
        "agent_id" => $agent_id,
        "property_id" => $property_id,
        "token" => $token,
        "valid_from" => date("Y-m-d h:i"),
        "valid_to" => date("Y-m-d h:i", strtotime("+1 week")),
        "created_by" => auth()->id(),
        "data" => json_encode($request->get("data", []))
      ]);
    }

    return redirect(route("property-detail", $token));
  }

  public function generatePDF(Request $request, $property_id)
  {
    $agent_id = $request->get("agent");
    $link = PropertyLink::where(['property_id' => $property_id])
    ->where("agent_id", $agent_id)
    ->where("valid_from", "<=", date("Y-m-d h:i"))
    ->where("valid_to", ">=", date("Y-m-d h:i"))
    ->first();

    if(!is_null($link)) {
      PropertyLink::where(["id" => $link->id])->update([
        "data" => json_encode($request->get("data", []))
      ]);
      return Redirect::away(route("property-detail", [$link->token, 1]));
    }

    $token = $this->getToken(20);
    $save = PropertyLink::create([
      "agent_id" => $agent_id,
      "property_id" => $property_id,
      "token" => $token,
      "valid_from" => date("Y-m-d h:i"),
      "valid_to" => date("Y-m-d h:i", strtotime("+1 week")),
      "created_by" => auth()->id(),
      "data" => json_encode($request->get("data", []))
    ]);

    if($save) {
      return redirect(route("property-detail", [$token, 1]));
    }
    return redirect()->back()->withErrors( __("error-message"));
  }

  function getToken($length)
  {
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
      $token .= $codeAlphabet[random_int(0, $max-1)];
    }

    return $token;
  }

  public function uploadOwnerContract(Request $request, $property_id)
  {
    $contract_id = $request->get("contract_id", "");
    $data = [];
    if(!empty($contract_id)){
      $contract = Contract::find($contract_id);
      if(!is_null($contract)){
        $data = json_decode($contract->data, true);
      }
    }

    if($request->hasFile("contract")){
      $file = $request->file("contract");
      $file_name = $file->getClientOriginalName();
      $file_name = str_replace(" ", "_", $file_name);
      if(!empty(@$data["owner_contract"])){
        $file_name = @$data["owner_contract"];
      }
      // $has = md5(date('Y-m-d H:i:s') . rand(1, 100));
      // $file_name = sha1($has) . "." . $extension;

      $path = base_path() . '/public' . config("global.owner_contract_path");
      if (!is_dir($path)) {
        File::makeDirectory($path, 0777, true, true);
      }
      if($file->move($path, $file_name)){
        $data["owner_contract"] = $file_name;
      }
    }

    $data["year_of_contract"]   = $request->get("year_of_contract") ?? 0;
    $data['month_of_contract']  = $request->get('month_of_contract') ?? 0;
    $data["furniture"]          = $request->get("furniture");
    $data["deposit"]            = $request->get("deposit") ?? 0;
    $data["title"]              = $request->get("title");
    $data["commission"]         = $request->get("commission") ?? 0;
    $data["commission_type"]    = $request->get("commission_type") ?? 0;
    $data["deposit_type"]       = $request->get("deposit_type") ?? 0;
    
    Contract::updateOrCreate(["id" => $contract_id], [
      "property_id" => $property_id,
      "user_id" => auth()->id(),
      "staff_id" => auth()->id(),
      "create_on" => date("Y-m-d h:i:s"),
      "data" => json_encode($data)
    ]);

    return redirect(route("administrator.property-view", $property_id). "?action=contract")->with("success", __("success-message"));
  }

  public function removeContract($id, $property_id)
  {
    $contract = Contract::find($id);

    if(is_null($contract)){
      return redirect()->back()->withErrors( __("error-message"));
    }

    $delete = $contract->delete();

    if($delete){
      return redirect(route("administrator.property-view", $property_id). "?action=contract")->with("success", __("success-message"));
    }

    return redirect()->back()->withErrors( __("error-message"));
  }

  public function changeState($property_id, $state = 0)
  {
    $property = Property::find($property_id);

    if(is_null($property)){
      return \redirect()->back()->withErrors(__('Could not found property!'));
    }

    $property->state = $state;
    $property->status = ($state==1) ? 3 : 6;

    if($property->save()) {
      return redirect()->back()->with("success", __("success-message"));
    }

    return redirect()->back()->withErrors( __("error-message"));
  }

  public function createCollector(Request $request)
  {
    $check = User::where(["email" => $request->email])->first();
    if(!is_null($check)){
      return response()->json([
        "status" => false,
        "message" => "Error: email already exists!"
      ]);
    }


    $data['name'] = is_null($request->name)? "" : $request->name;
    $data['phone1'] = is_null($request->phone1)? "" : $request->phone1;
    $data['phone2'] = is_null($request->phone2)? "" : $request->phone2;
    $data['email'] = is_null($request->email)? "" : $request->email;
    $data['id_card'] = '';
    $data['address'] = $request->get("address");
    $data['office_id'] = is_null($request->office_id)? 0 : $request->office_id;
    $data["type"] = 1;

    $save = Staff::create($data);

    if($save) {
      $html = "<option selected value='".$save->id."'>".$request->name."</option>";
      return response()->json([
        "status" => true,
        "data" => $html
      ]);

    }

    return response()->json([
      "status" => false,
      "message" => "Error: error!"
    ]);
  }

  public function changeGalleryType(Request $request)
  {
    session(["gallery_type" => $request->gallery_type]);
    return \redirect()->back();
  }

  public function suggestion(Request $request)
  {
    $propertyCode = $request->get('query');
    $output = [];

    $property = Property::where('code', "LIKE", "%{$propertyCode}%")->limit(20)->get()->map(function($item) {
      $item->suggestion = $item->code . ' - ' . $item->title;

      return $item;
    });
    // dd($property);

    return response()->json($property, 200, [
      'Content-Type' => 'application/json; charset=utf-8'
    ], JSON_UNESCAPED_UNICODE);
  }

  public function viewTrash(Request $request)
  {
    if(!\Auth::user()->can('property.view')) {
      return view('backend.partial.no-permission', ['title' => 'No-permission']);
    }

    $limit = $request->get('limit', 10);
    $properties = [];

    if(!\Auth::user()->hasRole('administrator') && \Auth::user()->isOffice()) {
      $staffObj = \Auth::user()->staff;
      /*
      * Get properties in office
      */
      if (!empty($staffObj->office)) {
        if($staffObj->office->properties()->count()) {
          $properties = $staffObj->office->properties();//->orderBy("id", "desc")->paginate($limit);
        }

        /*
        * Get properties in staff
        */
      } 
      elseif (!empty($staffObj->properties) && count($staffObj->properties) > 0) {
        $properties = $staffObj->properties();//->orderBy("id", "desc")->paginate($limit);
      }
    }

    /*
    * Get all properties
    */
    if(\Auth::user()->isAdministrator()) {
      $properties = $this->propertyRepo->model();//->orderBy("id", "desc")->paginate($limit);
    }

    /*
    * Get properties for user role type cellector [Statue pending]
    */
    if (!\Auth::user()->hasRole('administrator') && \Auth::user()->isCollector()) {
      $properties = $properties->where('status', 0);//->orderBy("id", "desc")->paginate($limit);
    }

    $properties = $properties->onlyTrashed()->orderBy("id", "desc")->paginate($limit);

    // dd($properties);
    return view('backend.property.index-trash', compact('properties'));
  }

  public function restoreTrash($id)
  {
    if(!\Auth::user()->can('property.delete'))
      return view('backend.partial.no-permission', ['title' => 'No-permission']);

    $item = Property::withTrashed()->where('id', $id)->restore();
    return redirect('administrator/property/view-trash');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function deleteTrash($id)
  {
    if(!\Auth::user()->can('property.delete'))
      return view('backend.partial.no-permission', ['title' => 'No-permission']);

    $item = Property::withTrashed()->where('id', $id)->first();

    Commission::where(["property_id" => $item->id])->delete();
    PropertyTranslation::where(["property_id" => $item->id])->delete();
    PropertyHasStaff::where(["property_id" => $item->id])->delete();
    if($item->forceDelete()) {
      return \Response::json([
        'success'       => true,
        'redirect_url'  => url('administrator/property/view-trash'),
      ], 200);
    }
    return \Response::json([
      'success'   => false,
    ], 500);
  }
}