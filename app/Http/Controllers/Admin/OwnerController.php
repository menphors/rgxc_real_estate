<?php

namespace App\Http\Controllers\Admin;

use App\Model\Commune\Commune;
use App\Model\District\District;
use App\Model\Owner;
use App\Model\Province\Province;
use App\Model\Village\Village;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!\Auth::user()->can('owner.view'))
            return view('backend.partial.no-permission', ['title' => 'No-permission']);

        $owners = Owner::orderBy("id", "DESC")->with([
            "province_id",
            "district_id",
            "commune_id",
            "village_id"
        ]);
        $search = $request->get("search");

        if(!empty($search)){
            $owners->where(function ($query) use($search){
               $query->orWhere("name", "like", "%".$search."%");
               $query->orWhere("phone", "like", "%".$search."%");
            });
        }
        $owners = $owners->paginate(\Constants::LIMIT);

        return view("backend.owner.index", compact("owners"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!\Auth::user()->can('owner.add'))
            return view('backend.partial.no-permission', ['title' => 'No-permission']);

        $provinces = Province::all();
        $action = route("administrator.property-owner-store");
        return view("backend.owner.form", compact("provinces", "action"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!\Auth::user()->can('owner.add'))
            return view('backend.partial.no-permission', ['title' => 'No-permission']);

        $request->validate([
            'name' => 'required',
            'phone' => 'required'
        ]);

        $data["province_id"] = $request->province;
        $data["district_id"] = $request->district;
        $data["commune_id"] = $request->commune;
        $data["village_id"] = $request->village;
        $data["name"] = $request->name;
        $data["phone"] = $request->phone;
        $data["phone2"] = $request->phone2;
        $data["phone3"] = $request->phone3;
        $data["email"] = $request->email;
        $data["address"] = $request->address;
        $data["remark"] = $request->remark;

        if($request->hasFile("thumbnail")){
            $img = $request->file("thumbnail");
            $extension = $img->getClientOriginalExtension();
            $has = md5(date('Y-m-d H:i:s') . rand(1, 100));
            $file_name = !empty($data["thumbnail"])? $data["thumbnail"] : sha1($has) . "." . $extension;

            $path = base_path() . '/public' . config("global.owner_image_path");

            if (!is_dir($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            $img = Image::make($img->getRealPath());
            if($img->resize(config('global.owner_thumbnail_size')["height"], null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path.$file_name)){
                $data["thumbnail"] = $file_name;
            }
        }

        try{
            $save = Owner::create($data);

            if(!$save){
                return redirect()->back()->with("error", __("error-message"))->withInput($request->all());
            }

            return redirect(route("administrator.property-owner-listing"))->with("success", __("success-message"));
        }catch (\Exception $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->with("error", __("error-message"))->withInput($request->all());
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!\Auth::user()->can('owner.edit'))
            return view('backend.partial.no-permission', ['title' => 'No-permission']);

        $owner = Owner::find($id);

        if(is_null($owner)){
            return redirect()->back()->with("error", __("error-message"));
        }

        $owner = json_decode($owner);

        $provinces = Province::all();

        $districts = District::where(["province_id" => @$owner->province_id])->get();
        $communes = Commune::where(["district_id" => @$owner->district_id])->get();

        $villages = Village::where(["commune_id" => @$owner->commune_id])->get();

        $action = route("administrator.property-owner-update", $id);
        return view("backend.owner.form", compact("provinces", "owner", "districts", "communes", "villages", "action"));
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
        if(!\Auth::user()->can('owner.edit'))
            return view('backend.partial.no-permission', ['title' => 'No-permission']);

        $request->validate([
            'name' => 'required',
            'phone' => 'required'
        ]);

        $owner = Owner::find($id);

        if(is_null($owner)){
            return redirect()->back()->with("error", __("error-message"));
        }

        $data["province_id"] = $request->province;
        $data["district_id"] = $request->district;
        $data["commune_id"] = $request->commune;
        $data["village_id"] = $request->village;
        $data["name"] = $request->name;
        $data["phone"] = $request->phone;
        $data["phone2"] = $request->phone2;
        $data["phone3"] = $request->phone3;
        $data["email"] = $request->email;
        $data["address"] = $request->address;
        $data["remark"] = $request->remark;
        $data["thumbnail"] = $request->get("thumbnail", "");
        if($request->hasFile("thumbnail")){
            $img = $request->file("thumbnail");
            $extension = $img->getClientOriginalExtension();
            $has = md5(date('Y-m-d H:i:s') . rand(1, 100));
            $file_name = !empty($data["thumbnail"])? $data["thumbnail"] : sha1($has) . "." . $extension;

            $path = base_path() . '/public' . config("global.owner_image_path");

            if (!is_dir($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            $img = Image::make($img->getRealPath());
            if($img->resize(config('global.owner_thumbnail_size')["height"], null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path.$file_name)){
                $data["thumbnail"] = $file_name;
            }
        }

        try{
            $save = Owner::where("id", $id)->update($data);

            if(!$save){
                return redirect()->back()->with("error", __("error-message"))->withInput($request->all());
            }

            return redirect(route("administrator.property-owner-listing"))->with("success", __("success-message"));
        }catch (\Exception $exception){
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
        if(!\Auth::user()->can('owner.delete'))
            return view('backend.partial.no-permission', ['title' => 'No-permission']);

        $owner = Owner::find($id);
        if(is_null($owner)){
            return view("backend.error.404");
        }

        if(!empty(@$owner->thumbnail)){
            File::delete( public_path() . config("global.owner_image_path").$owner->thumbnail);
        }


        $delete = Owner::destroy($id);

        if($delete){
            return redirect()->back()->with("success", __("success-message"));
        }

        return redirect()->back()->with("error", __("error-message"));
    }
}
