<?php

namespace App\Http\Controllers\Admin;

use App\Model\PropertyType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PropertyTypeController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if(!\Auth::user()->can('type.view'))
      return view('backend.partial.no-permission', ['title' => 'No-permission']);

    $property_types = PropertyType::whereNotNull("id");

    $search = $request->get("search");
    if(!empty($search)){
      $property_types->where(function ($query) use($search){
        $query->whereHas("translations", function ($query) use($search) {
          $query->where("title", "like", "%". $search ."%");
        });
      });
    }

    $property_types = $property_types->paginate(\Constants::LIMIT);
    return view("backend.property-type.index", compact("property_types"));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    if(!\Auth::user()->can('type.add')) {
      return view('backend.partial.no-permission', ['title' => 'No-permission']);
    }

    $action = route("administrator.property-type-store");
    return view("backend.property-type.form", compact("action"));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    if(!\Auth::user()->can('type.add'))
      return view('backend.partial.no-permission', ['title' => 'No-permission']);

    $request->validate([
      'title_en' => 'required'
    ]);

    $data['en'] = ['title' => $request->title_en??$request->title_en];
    $data['cn'] = ['title' => !empty($request->title_cn) ? $request->title_cn : $request->title_en];
    $data['kh'] = ['title' => !empty($request->title_kh) ? $request->title_kh : $request->title_en];
    $save = PropertyType::create($data);

    if($save){
      return redirect(route("administrator.property-type-listing"))->with("success", __("success-message"));
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
    if(!\Auth::user()->can('type.edit'))
      return view('backend.partial.no-permission', ['title' => 'No-permission']);

    $property_type = PropertyType::find($id);
    $action = route("administrator.property-type-update", $id);
    return view("backend.property-type.form", compact("property_type", "action"));
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
    if(!\Auth::user()->can('type.edit'))
      return view('backend.partial.no-permission', ['title' => 'No-permission']);

    $request->validate([
      'title_en' => 'required'
    ]);

    $data['en'] = ['title' => $request->title_en??$request->title_en];
    $data['cn'] = ['title' => !empty($request->title_cn) ? $request->title_cn : $request->title_en];
    $data['kh'] = ['title' => !empty($request->title_kh) ? $request->title_kh : $request->title_en];

    $update = PropertyType::where("id", $id)->first();
    $update = $update->update($data);

    if($update){
      return redirect(route("administrator.property-type-listing"))->with("success", __("success-message"));
    }

    return redirect()->back()->with("error", __("error-message"));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    if(!\Auth::user()->can('type.delete'))
      return view('backend.partial.no-permission', ['title' => 'No-permission']);

    $delete = PropertyType::where("id", $id)->first();

    if($delete->delete()){
      return redirect(route("administrator.property-type-listing"))->with("success", __("success-message"));
    }

    return redirect()->back()->with("error", __("error-message"));
  }
}