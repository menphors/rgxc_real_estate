<?php

namespace App\Http\Controllers\Admin;

use App\Model\Commune\Commune;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Province\ProvinceRepository;
use App\Model\District\DistrictRepository;
use App\Model\Commune\CommuneRepository;
class CommuneController extends Controller
{
    private $provinceRepo;

    private $districtRepo;

    private $communeRepo;

    public function __construct(ProvinceRepository $provinceRepo, DistrictRepository $districtRepo, CommuneRepository $communeRepo)
    {
        $this->provinceRepo = $provinceRepo;
        $this->districtRepo = $districtRepo;
        $this->communeRepo = $communeRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      if(!\Auth::user()->can('location.view')) {
        return view('backend.partial.no-permission', ['title' => 'No-permission']);
      }

        $provinces = $this->provinceRepo->lists()->orderBy("t.title", "ASC")->get();
        $districts = [];
        $communes = $this->communeRepo->lists()
            ->orderBy("title", "ASC")
            ->with(["district"]);


        $search_province = $request->get("province");
        $district_id = $request->get("district");
        if(!empty($search_province)){
            $districts = $this->districtRepo->lists()->where(["province_id" => $search_province])->get();
        }

        if(!empty($district_id)){
            $communes->where("district_id", $district_id);
        }

        $communes = $communes->paginate(\Constants::LIMIT);

        return view("backend.commune.index", compact("communes", "provinces", "districts"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      if(!\Auth::user()->can('location.add')) {
        return view('backend.partial.no-permission', ['title' => 'No-permission']);
      }

        $provinces = $this->provinceRepo->lists()->orderBy("t.title", "ASC")->get();
        $action = route("administrator.commune-store");
        return  view("backend.commune.form", compact("action", "provinces"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if(!\Auth::user()->can('location.add')) {
        return view('backend.partial.no-permission', ['title' => 'No-permission']);
      }

        $request->validate([
            'code' => 'required|unique:communes,code',
            "province_id" => "required|exists:provinces,id",
            "district_id" => "required|exists:districts,id",
            'title_en' => 'required'
        ]);

        $data['en'] = ['title' => $request->title_en];
        $data['cn'] = ['title' => $request->title_cn];
        $data['kh'] = ['title' => $request->title_kh];
        $data["code"] = $request->code;
        $data["province_id"] = $request->province_id;
        $data["district_id"] = $request->district_id;
        $save = Commune::create($data);
        if($save){
            return redirect(route("administrator.commune-list")."?province=". $data["province_id"]."&district=".$data["district_id"])->with('success', 'Save successful!');
        }

        return redirect()->back()->withErrors(__("Error: unable save province"))->withInput($request->all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      if(!\Auth::user()->can('location.edit')) {
        return view('backend.partial.no-permission', ['title' => 'No-permission']);
      }

        $provinces = $this->provinceRepo->lists()->orderBy("t.title", "ASC")->get();

        $data = Commune::with("district", "district.province")->find($id);
        if(is_null($data)){
            return redirect()->back();
        }

        $action = route("administrator.commune-update", $id);

        return  view("backend.commune.form", compact("action", "data", "provinces"));
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
      if(!\Auth::user()->can('location.edit')) {
        return view('backend.partial.no-permission', ['title' => 'No-permission']);
      }

        $request->validate([
            'code' => 'required|unique:communes,code,'. $id,
            "province_id" => "required|exists:provinces,id",
            "district_id" => "required|exists:districts,id",
            'title_en' => 'required'
        ]);

        $data['en'] = ['title' => $request->title_en];
        $data['cn'] = ['title' => $request->title_cn];
        $data['kh'] = ['title' => $request->title_kh];
        $data["code"] = $request->code;
        $data["province_id"] = $request->province_id;
        $data["district_id"] = $request->district_id;
        $commune = Commune::find($id);
        $save = $commune->update($data);
        if($save){
            return redirect(route("administrator.commune-list")."?province=". $data["province_id"]."&district=".$data["district_id"])->with('success', 'Save successful!');
        }

        return redirect()->back()->withErrors(__("Error: unable save province"))->withInput($request->all());

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
      if(!\Auth::user()->can('location.delete')) {
        return view('backend.partial.no-permission', ['title' => 'No-permission']);
      }
    }
}