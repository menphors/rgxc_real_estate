<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OfficeRequest;
use App\Model\Commune\Commune;
use App\Model\District\District;
use App\Model\Office\Office;
use App\Model\Province\Province;
use App\Model\Village\Village;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use ProvinceRepository;
use DistrictRepository;
use CommuneRepository;
use VillageRepository;

class OfficeController extends Controller
{
    protected $provinceRepo;

    protected $districtRepo;

    protected $communeRepo;

    protected $villageRepo;

    public function __construct(VillageRepository $villageRepo, CommuneRepository $communeRepo, DistrictRepository $districtRepo, ProvinceRepository $provinceRepo)
    {
        $this->provinceRepo = $provinceRepo;
        $this->districtRepo = $districtRepo;
        $this->communeRepo = $communeRepo;
        $this->villageRepo = $villageRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!\Auth::user()->can('office.view'))
            return view('backend.partial.no-permission', ['title' => 'No-permission']);

        $search_txt = $request->get("search");
        $offices = Office::orderBy("is_main", "desc");

        if(!empty($search_txt)){
            $offices->where(function ($query) use($search_txt){
                $query->orWhere("name", "like", "%". $search_txt. "%");
                $query->orWhere("phone", "like", "%". $search_txt. "%");
                $query->orWhere("email", "like", "%". $search_txt. "%");
                $query->orWhere("address", "like", "%". $search_txt. "%");
            });
        }
        $offices = $offices->paginate(\Constants::LIMIT);
        return view("backend.office.index", compact("offices"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!\Auth::user()->can('office.add'))
            return view('backend.partial.no-permission', ['title' => 'No-permission']);

        $provinces = $this->provinceRepo->lists()->pluck('title', 'id')->toArray();
        $main_office = Office::where(["is_main" => 1])->first();
        return view("backend.office.add", compact("provinces", "main_office"));
    }

  /**
   * Store a newly created resource in storage.
   *
   * @param  OfficeRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(OfficeRequest $request)
  {
    if(!\Auth::user()->can('office.add'))
      return view('backend.partial.no-permission', ['title' => 'No-permission']);

    $data["is_main"] = $request->get("is_main", 0);
    $data["province_id"] = $request->province;
    $data["district_id"] = $request->district;
    $data["commune_id"] = $request->commune;
    $data["village_id"] = $request->village;
    $data["name"] = $request->get("name", "");
    $data["address"] = $request->get("address", "");
    $data["description"] = $request->get("description", "");
    $data["latitude"] = $request->lat;
    $data["longitude"] = $request->lon;
    $data["phone"] = $request->get("phone", "");
    $data["email"] = $request->get("email", "");
    $data["thumbnail"] = "";
    $data["picture"] = "";

    if($request->hasFile("thumbnail")) {
      $img = $request->file("thumbnail");
      $extension = $img->getClientOriginalExtension();
      $has = md5(date('Y-m-d H:i:s') . rand(1, 100));
      $file_name = sha1($has) . "." . $extension;

      $path = base_path() . '/public' . config("global.office_image_path");
      $thumbnail_path = base_path() . '/public' . config("global.office_image_path"). "thumbnail/";

      if (!is_dir($path)) {
        File::makeDirectory($path, 0777, true, true);
      }

      if (!is_dir($thumbnail_path)) {
        File::makeDirectory($thumbnail_path, 0777, true, true);
      }

      $img = Image::make($img->getRealPath());
      if($img->resize(config('global.office_thumbnail_size')["height"], null, function ($constraint) {
        $constraint->aspectRatio();
      })->save($thumbnail_path.$file_name)){
        $data["thumbnail"] = $file_name;
      }

      if($img->save($path.$file_name)){
        $data["picture"] = $file_name;
      }
    }

    try {
      $save = Office::create($data);

      if(!$save) {
        return redirect()->back()->with("error", __("error-message"))->withInput($request->all());
      }

      return redirect(route("administrator.office-listing"))->with("success", __("success-message"));
    } catch (\Exception $exception) {
      Log::error($exception->getMessage());
      return redirect()->back()->with("error", __("error-message"))->withInput($request->all());
    }
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
        if(!\Auth::user()->can('office.edit'))
            return view('backend.partial.no-permission', ['title' => 'No-permission']);

        $office = Office::find($id);

        if(is_null($office)){
            return view("backend.error.404");
        }

        $provinces = $this->provinceRepo->lists()->pluck('title', 'id')->toArray();
        $districts = $this->districtRepo->lists()
            ->where(["province_id" => $office->province_id])
            ->pluck('title', 'id')
            ->toArray();
        $communes = $this->communeRepo->lists()
            ->where(["district_id" => $office->district_id])
            ->pluck('title', 'id')
            ->toArray();

        $villages = $this->communeRepo->lists()
            ->where(["commune_id" => $office->commune_id])
            ->pluck('title', 'id')
            ->toArray();
        return view("backend.office.edit", compact("office", "provinces", "districts", "communes", "villages"));
    }

  /**
   * Update the specified resource in storage.
   *
   * @param  OfficeRequest  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(OfficeRequest $request, $id)
  {
    if(!\Auth::user()->can('office.edit'))
      return view('backend.partial.no-permission', ['title' => 'No-permission']);

    $data["is_main"] = $request->get("is_main", 0);
    $data["province_id"] = $request->province;
    $data["district_id"] = $request->district;
    $data["commune_id"] = $request->commune;
    $data["village_id"] = $request->village;
    $data["name"] = $request->get("name", "");
    $data["address"] = $request->get("address", "");
    $data["description"] = $request->get("description", "");
    $data["latitude"] = $request->lat;
    $data["longitude"] = $request->lon;
    $data["phone"] = $request->get("phone", "");
    $data["email"] = $request->get("email", "");
    // $data["thumbnail"] = $request->get("thumbnail");
    // $data["picture"] = $request->get("thumbnail");

    if($request->hasFile("thumbnail")) {
      $img = $request->file("thumbnail");
      $extension = $img->getClientOriginalExtension();
      $has = md5(date('Y-m-d H:i:s') . rand(1, 100));
      $file_name = !empty($data["thumbnail"]) ? $data["thumbnail"] : sha1($has) . "." . $extension;

      $path = base_path() . '/public' . config("global.office_image_path");
      $thumbnail_path = base_path() . '/public' . config("global.office_image_path"). "thumbnail/";

      if (!is_dir($path)) {
        File::makeDirectory($path, 0777, true, true);
      }

      if (!is_dir($thumbnail_path)) {
        File::makeDirectory($thumbnail_path, 0777, true, true);
      }

      $img = Image::make($img->getRealPath());
      if($img->resize(config('global.office_thumbnail_size')["height"], null, function ($constraint) {
        $constraint->aspectRatio();
      })->save($thumbnail_path.$file_name)) {
        $data["thumbnail"] = $file_name;
      }

      if($img->save($path.$file_name)) {
        $data["picture"] = $file_name;
      }
    }

    try {
      $save = Office::where("id", $id)->update($data);

      if(!$save) {
        return redirect()->back()->with("error", __("error-message"))->withInput($request->all());
      }

      return redirect(route("administrator.office-listing"))->with("success", __("success-message"));
    } 
    catch (\Exception $exception) {
      Log::error($exception->getMessage());
      return redirect()->back()->with("error", __("error-message"))->withInput($request->all());
    }
  }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!\Auth::user()->can('office.delete'))
            return view('backend.partial.no-permission', ['title' => 'No-permission']);

        $office = Office::find($id);
        if(is_null($office)){
            return view("backend.error.404");
        }

        if(!empty(@$office->thumbnail)){
            File::delete( public_path() . config("global.office_image_path").'thumbnail/'.$office->thumbnail);
        }

        if(!empty(@$office->picture)){
            File::delete( public_path() . config("global.office_image_path").$office->picture);
        }
        $delete = Office::destroy($id);

        if($delete){
            return redirect()->back()->with("success", __("success-message"));
        }

        return redirect()->back()->with("error", __("error-message"));
    }
}
