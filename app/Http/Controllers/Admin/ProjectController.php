<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProjectRequest;
use App\Model\Project;
use App\Model\Property\Property;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class ProjectController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $projects = Project::orderBy("id", "DESC");

    $search = $request->get("search");

    if(!empty($search)) {
      $projects->where(function ($query) use($search){
        $query->orWhere("title", "like", "%". $search. "%");
        $query->orWhere("description", "like", "%". $search. "%");
      });
    }

    $projects = $projects->paginate(\Constants::LIMIT);

    return view("backend.project.index", compact("projects"));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $action = route("administrator.project-store");
    return view("backend.project.form", compact("action"));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(ProjectRequest $request)
  {
    $data["title"] = $request->get("title");
    $data["address"] = $request->get("address");
    $data["description"] = $request->get("description");
    $data["latitude"] = $request->get("lat");
    $data["longitude"] = $request->get("lon");

    if($request->hasFile("thumbnail")) {
      $img = $request->file("thumbnail");
      $extension = $img->getClientOriginalExtension();
      $has = md5(date('Y-m-d H:i:s') . rand(1, 100));
      $file_name = sha1($has) . "." . $extension;

      $path = base_path() . '/public' . config("global.project_path");

      if (!is_dir($path)) {
        File::makeDirectory($path, 0777, true, true);
      }

      $img = Image::make($img->getRealPath());

      if($img->save($path.$file_name)) {
        $data["thumbnail"] = $file_name;
      }
    }

    $save = Project::create($data);
    if($save) {
      return redirect(route("administrator.project-listing"))->with("success", __("success-message"));
    }

    return redirect()->back()->with("error", __("error-message"))->withInput($request->all());
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $project = Project::with("properties")->find($id);

    if(is_null($project)) {
      return redirect()->back()->with("error", __("Project not found!"));
    }
    return view("backend.project.show", compact("action", "project"));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $action = route("administrator.project-update", $id);
    $project = Project::find($id);

    if(is_null($project)) {
      return redirect()->back()->with("error", __("Project not found!"));
    }
    return view("backend.project.form", compact("action", "project"));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(ProjectRequest $request, $id)
  {
    $project = Project::find($id);
    if(is_null($project)) {
      return redirect()->back()->with("error", __("Project not found!"))->withInput($request->all());
    }
    $data["title"] = $request->get("title");
    $data["address"] = $request->get("address");
    $data["description"] = $request->get("description");
    $data["latitude"] = $request->get("lat");
    $data["longitude"] = $request->get("lon");

    if($request->hasFile("thumbnail")) {
      $img = $request->file("thumbnail");
      $extension = $img->getClientOriginalExtension();
      $has = md5(date('Y-m-d H:i:s') . rand(1, 100));
      $file_name = !empty($project->thumbnail) ? $project->thumbnail : sha1($has) . "." . $extension;

      $path = base_path() . '/public' . config("global.project_path");

      if (!is_dir($path)) {
        File::makeDirectory($path, 0777, true, true);
      }

      $img = Image::make($img->getRealPath());

      if($img->save($path.$file_name)){
        $data["thumbnail"] = $file_name;
      }
    }

    $save = Project::where("id", $id)->update($data);
    if($save) {
      return redirect(route("administrator.project-listing"))->with("success", __("success-message"));
    }

    return redirect()->back()->with("error", __("error-message"))->withInput($request->all());
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $check_project_property = Property::where(['project_id' => $id])->get();

    if($check_project_property->count() > 0){
      return redirect()->back()->with("error", __("Can not delete this project because this project link with some property"));
    }

    $project = Project::find($id);
    if(is_null($project)) {
      return view("backend.error.404");
    }

    if(!empty(@$project->thumbnail)){
      File::delete( public_path() . config("global.office_image_path").$project->thumbnail);
    }

    $delete = Project::destroy($id);

    if($delete) {
      return redirect()->back()->with("success", __("success-message"));
    }

    return redirect()->back()->with("error", __("error-message"));
  }
}