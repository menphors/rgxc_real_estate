<?php

namespace App\Http\Controllers\Admin;

use App\Model\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if(!\Auth::user()->can('tag.view'))
      return view('backend.partial.no-permission', ['title' => 'No-permission']);

    $tags = Tag::whereNotNull("id")->latest();

    $search = $request->get("search");
    if(!empty($search)) {
      $tags->where(function ($query) use($search) {
        $query->whereHas("translations", function ($query) use($search) {
          $query->where("title", "like", "%". $search ."%");
        });
      });
    }

    $tags = $tags->paginate(\Constants::LIMIT);
    return view("backend.tag.index", compact("tags"));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    if(!\Auth::user()->can('tag.add')) {
      return view('backend.partial.no-permission', ['title' => 'No-permission']);
    }

    $action = route("administrator.tag-store");
    return view("backend.tag.form", compact("action"));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    if(!\Auth::user()->can('tag.add'))
      return view('backend.partial.no-permission', ['title' => 'No-permission']);

    $request->validate([
      'title_en' => 'required'
    ]);

    $data['en'] = ['title' => $request->title_en ?? $request->title_en];
    $data['cn'] = ['title' => !empty($request->title_cn) ? $request->title_cn : $request->title_en];
    $data['kh'] = ['title' => !empty($request->title_kh) ? $request->title_kh : $request->title_en];
    $save = Tag::create($data);

    if($save) {
      return redirect(route("administrator.tag-listing"))->with("success", __("success-message"));
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
    if(!\Auth::user()->can('tag.edit'))
      return view('backend.partial.no-permission', ['title' => 'No-permission']);

    $tag = Tag::find($id);
    $action = route("administrator.tag-update", $id);
    return view("backend.tag.form", compact("tag", "action"));
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
    if(!\Auth::user()->can('tag.edit'))
      return view('backend.partial.no-permission', ['title' => 'No-permission']);

    $request->validate([
      'title_en' => 'required'
    ]);

    $data['en'] = ['title' => $request->title_en ?? $request->title_en];
    $data['cn'] = ['title' => !empty($request->title_cn) ? $request->title_cn : $request->title_en];
    $data['kh'] = ['title' => !empty($request->title_kh) ? $request->title_kh : $request->title_en];

    $update = Tag::where("id", $id)->first();
    $update = $update->update($data);

    if($update){
      return redirect(route("administrator.tag-listing"))->with("success", __("success-message"));
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
    if(!\Auth::user()->can('tag.delete'))
      return view('backend.partial.no-permission', ['title' => 'No-permission']);

    $delete = Tag::where("id", $id)->first();

    if($delete->delete()) {
      return redirect(route("administrator.tag-listing"))->with("success", __("success-message"));
    }

    return redirect()->back()->with("error", __("error-message"));
  }

  public function search(Request $request)
  {
    $tags = Tag::whereNotNull("id")->latest();

    $search = $request->get("search");
    if(!empty($search)) {
      $tags->where(function ($query) use($search) {
        $query->whereHas("translations", function ($query) use($search) {
          $query->where("title", "like", "%". $search ."%");
        });
      });
    }

    $tags = $tags->limit(20)->get()->map(function($item) {
      return [
        'id' => $item->id,
        'text' => $item->title,
      ];
    });

    return response()->json($tags, 200, [
      'Content-type' => 'application/json; charset=utf-8'
    ], JSON_UNESCAPED_UNICODE);
  }
}