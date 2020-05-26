<?php

namespace App\Http\Controllers\Admin;

use App\Model\District\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\District\DistrictRepository;
use App\Model\Province\ProvinceRepository;
class DistrictController extends Controller
{

    private $districtRepo;

    protected $provinceRepo;

    public function __construct(DistrictRepository $districtRepo, ProvinceRepository $provinceRepo)
    {
        $this->districtRepo = $districtRepo;
        $this->provinceRepo = $provinceRepo;
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
        $districts = $this->districtRepo->lists()
            ->orderBy("title", "ASC")
            ->with("province");


        $search_province = $request->get("province");
        if(!empty($search_province)){
            $districts->where("province_id", $search_province);
        }

        $districts = $districts->paginate(\Constants::LIMIT);

        return view("backend.district.index", compact("districts", "provinces"));
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
        $action = route("administrator.district-store");
        return  view("backend.district.form", compact("action", "provinces"));
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
            'code' => 'required|unique:districts,code',
            "province_id" => "required|exists:provinces,id",
            'title_en' => 'required'
        ]);

        $data['en'] = ['title' => $request->title_en];
        $data['cn'] = ['title' => $request->title_cn];
        $data['kh'] = ['title' => $request->title_kh];
        $data["code"] = $request->code;
        $data["province_id"] = $request->province_id;
        $save = District::create($data);
        if($save){
            return redirect(route("administrator.district-list")."?province=". $data["province_id"])->with('success', 'Save successful!');
        }

        return redirect()->back()->withErrors(__("Error: unable save province"))->withInput($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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

        $data = District::find($id);
        if(is_null($data)){
            return redirect()->back();
        }

        $action = route("administrator.district-update", $id);

        return  view("backend.district.form", compact("action", "data", "provinces"));
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
            'code' => 'required|unique:districts,code,'.$id,
            "province_id" => "required|exists:provinces,id",
            'title_en' => 'required'
        ]);

        $data['en'] = ['title' => $request->title_en];
        $data['cn'] = ['title' => $request->title_cn];
        $data['kh'] = ['title' => $request->title_kh];
        $data["code"] = $request->code;
        $data["province_id"] = $request->province_id;
        $district = District::find($id);
        $save = $district->update($data);
        if($save){
            return redirect(route("administrator.district-list")."?province=". $data["province_id"])->with('success', 'Save successful!');
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
      if(!\Auth::user()->can('location.delete')) {
        return view('backend.partial.no-permission', ['title' => 'No-permission']);
      }

        //
    }
}
