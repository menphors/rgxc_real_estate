<?php

namespace App\Http\Controllers\Admin;

use App\Model\Cms;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class CMSController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $filter = \request("filter");
    $cms = Cms::orderBy("id", "DESC");//->get();
    if($filter > 0){
      $cms->where("type", $filter);
    }

    $cms = $cms->paginate(\Constants::LIMIT);
    return view("backend.cms.index", compact("cms"));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view("backend.cms.form");
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $hidden_id = $request->get("hidden_id");
    $cms = Cms::find($hidden_id);
    $data['slug'] = $request->link ? $request->link : str_slug($request->title_en);
    $data['type'] = $request->get("cms_type");
    $data['blog'] = $request->get("blog_type");
    $data['en'] = [
      'title' => $request->title_en??$request->title_en,
      "content" =>  $request->description_en??$request->description_en
    ];
    $data['cn'] = [
      'title' => !empty($request->title_cn) ? $request->title_cn : $request->title_en,
      "content" =>  !empty($request->description_cn)? $request->description_cn : $request->description_en
    ];
    $data['kh'] = [
      'title' => !empty($request->title_kh) ? $request->title_kh : $request->title_en,
      "content" => !empty($request->description_kh)? $request->description_kh : $request->description_en
    ];

    if(($request->get("cms_type") == \Constants::CMS_TYPE_SLIDE_SHOW || $request->get("cms_type") == \Constants::CMS_TYPE_BRAND_CAROUSEL ) && $request->hasFile("image")) {
      $file = $request->file("image");
      $extension = $file->getClientOriginalExtension();
      $has = md5(date('Y-m-d H:i:s') . rand(1, 100));
      $file_name = !empty(@$cms->thumbnail)? @$cms->thumbnail : sha1($has) . "." . $extension;

      if($request->get("cms_type") == \Constants::CMS_TYPE_BRAND_CAROUSEL){
        $path = base_path() . '/public' . config("global.carousel_image_path");
      }else{
        $path = base_path() . '/public' . config("global.slide_show_image_path");
      }

      if (!is_dir($path)) {
        File::makeDirectory($path, 0777, true, true);
      }
      $img = Image::make($file->getRealPath());
      if($img->save($path.$file_name)) {
        $data["picture"] = $file_name;
        $data["thumbnail"] = $file_name;
      }
    }

    // check if cms already exists
    if($request->get("cms_type") != \Constants::CMS_TYPE_SLIDE_SHOW && $request->get("cms_type") != \Constants::CMS_TYPE_BRAND_CAROUSEL) {
      $check_cms = Cms::where([
        "type" => $request->get("cms_type"),
        "blog" => $request->get("blog_type")
      ]);

      if($hidden_id > 0){
        $check_cms->where("id", "!=", $hidden_id);
      }
      $check_cms = $check_cms->first();

      if(!is_null($check_cms)){
        return redirect()->back()->with("error", __("cms-already-exist"))->withInput($request->all());
      }
    }

    if($hidden_id > 0) {
      $save = Cms::where("id", $hidden_id)->first();
      $save = $save->update($data);
    } 
    else {
      $where["type"] =  $request->get("cms_type");
      $where['blog'] = $request->get("blog_type");
      if($where["type"] != \Constants::CMS_TYPE_SLIDE_SHOW && $where["type"] != \Constants::CMS_TYPE_BRAND_CAROUSEL) {
      // not slide show
        $save = Cms::updateOrCreate($where, $data);
      }
      else {
        $save = Cms::create($data);
      }
    }

    if($save) {
      return redirect(route("administrator.cms-index"))->with("success", __("success-message"));
    }

    return redirect()->back()->with("error", __("error-message"));
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
    $cms = Cms::find($id);
    if(is_null($cms)){
      return redirect()->back()->withErrors(__("Not Found!"));
    }
    return view("backend.cms.form", compact("cms"));
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
    $cms = Cms::find($id);

    if(is_null($cms)) {
      return redirect()->back()->withErrors(__("Not Found!"));
    }

    if($cms->type == \Constants::CMS_TYPE_SLIDE_SHOW && !empty(@$cms->thumbnail)) {
      File::delete( public_path() . config("global.slide_show_image_path").$cms->thumbnail);
    }

    if($cms->type == \Constants::CMS_TYPE_BRAND_CAROUSEL && !empty(@$cms->thumbnail)) {
      File::delete( public_path() . config("global.carousel_image_path").$cms->thumbnail);
    }

    if($cms->delete()) {
      return redirect()->back()->with("success", __("success-message"));
    }

    return redirect()->back()->withErrors(__("error-message"));
  }
}