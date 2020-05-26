<?php

namespace App\Http\Controllers\Admin;

use App\Model\Province\Province;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use ProvinceRepository;

class ProvinceController extends Controller
{
    protected $provinceRepo;

    public function __construct(ProvinceRepository $provinceRepo)
    {
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

        $provinces = $this->provinceRepo->lists();

        $search = $request->get("search");
        if(!empty($search)){
            $provinces->where(function ($query) use($search){
               $query->orWhere('code', "like", "%$search%");
               $query->orWhere('title', "like", "%$search%");
            });
        }

        $provinces = $provinces->orderBy("t.title", "ASC")->get();

        return view("backend.province.index", compact("provinces"));
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

        $action = route("administrator.province-store");
        return  view("backend.province.form", compact("action"));
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
            'code' => 'required|unique:provinces,code',
            'title_en' => 'required'
        ]);

        $data['en'] = ['title' => $request->title_en];
        $data['cn'] = ['title' => $request->title_cn];
        $data['kh'] = ['title' => $request->title_kh];
        $data["code"] = $request->code;
        $save = Province::create($data);
        if($save){
            return redirect(route("administrator.province-list"))->with('success', 'Save successful!');
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
      if(!\Auth::user()->can('location.edit')) {
        return view('backend.partial.no-permission', ['title' => 'No-permission']);
      }

        $data = Province::find($id);
        if(is_null($data)){
            return redirect()->back();
        }

        $action = route("administrator.province-update", $id);

        return  view("backend.province.form", compact("action", "data"));
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
            'code' => 'required|unique:provinces,code,'.$id,
            'title_en' => 'required'
        ]);

        $data['en'] = ['title' => $request->title_en];
        $data['cn'] = ['title' => $request->title_cn];
        $data['kh'] = ['title' => $request->title_kh];
        $data["code"] = $request->code;
        $province = Province::where(["id" => $id])->first();
        $save = $province->update($data);
        if($save){
            return redirect(route("administrator.province-list"))->with('success', 'Save successful!');
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
