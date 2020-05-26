<?php

namespace App\Http\Controllers\Admin;

use App\Model\Village\Village;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Province\ProvinceRepository;
use App\Model\District\DistrictRepository;
use App\Model\Commune\CommuneRepository;
use App\Model\Village\VillageRepository;

class VillageController extends Controller
{

    private $provinceRepo;

    private $districtRepo;

    private $communeRepo;

    private $villageRepo;

    public function __construct(ProvinceRepository $provinceRepo, DistrictRepository $districtRepo, CommuneRepository $communeRepo, VillageRepository $villageRepo)
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
        $provinces = $this->provinceRepo->lists()->orderBy("t.title", "ASC")->get();
        $districts = [];
        $communes = [];
        $villages = $this->villageRepo->lists()
            ->orderBy("title", "ASC");


        $province_id = $request->get("province");
        $district_id = $request->get("district");
        $commune_id = $request->get("commune");
        if(!empty($province_id)){
            $districts = $this->districtRepo->lists()->where(["province_id" => $province_id])->get();
        }

        if(!empty($district_id)){
            $communes = $this->communeRepo->lists()->where(["district_id" => $district_id])->get();
        }

        if(!empty($commune_id)){
            $villages->where("commune_id", $commune_id);
        }

        $villages = $villages->paginate(\Constants::LIMIT);

        return view("backend.village.index", compact("villages", "provinces", "districts", "communes"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provinces = $this->provinceRepo->lists()->orderBy("t.title", "ASC")->get();
        $action = route("administrator.village-store");
        return  view("backend.village.form", compact("action", "provinces"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:villages,code',
            "province_id" => "required|exists:provinces,id",
            "district_id" => "required|exists:districts,id",
            "commune_id" => "required|exists:communes,id",
            'title_en' => 'required'
        ]);

        $data['en'] = ['title' => $request->title_en];
        $data['cn'] = ['title' => $request->title_cn];
        $data['kh'] = ['title' => $request->title_kh];
        $data["code"] = $request->code;
        $data["province_id"] = $request->province_id;
        $data["district_id"] = $request->district_id;
        $data["commune_id"] = $request->commune_id;
        $save = Village::create($data);
        if($save){
            return redirect(route("administrator.village-list")."?province=". $data["province_id"]."&district=".$data["district_id"]."&commune=". $data["commune_id"])->with('success', 'Save successful!');
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
        $provinces = $this->provinceRepo->lists()->orderBy("t.title", "ASC")->get();

        $data = Village::with(["commune", "commune.district", "commune.district.province"])->find($id);
        if(is_null($data)){
            return redirect()->back();
        }

        $action = route("administrator.village-update", $id);

        return  view("backend.village.form", compact("action", "data", "provinces"));
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
        $request->validate([
            'code' => 'required|unique:villages,code,'. $id,
            "province_id" => "required|exists:provinces,id",
            "district_id" => "required|exists:districts,id",
            "commune_id" => "required|exists:communes,id",
            'title_en' => 'required'
        ]);

        $data['en'] = ['title' => $request->title_en];
        $data['cn'] = ['title' => $request->title_cn];
        $data['kh'] = ['title' => $request->title_kh];
        $data["code"] = $request->code;
        $data["province_id"] = $request->province_id;
        $data["district_id"] = $request->district_id;
        $data["commune_id"] = $request->commune_id;
        $village = Village::find($id);
        $save = $village->update($data);
        if($save){
            return redirect(route("administrator.village-list")."?province=". $data["province_id"]."&district=".$data["district_id"]."&commune=". $data["commune_id"])->with('success', 'Save successful!');
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
    }
}
