<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CustomerRequest;
use App\Model\Customer\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class CustomerController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if(!\Auth::user()->can('customer.view')) {
      return view('backend.partial.no-permission', ['title' => 'No-permission']);
    }

    $search_txt = $request->get("search");
    $customers = Customer::orderBy("id", "desc");

    if(!empty($search_txt)){
      $customers->where(function ($query) use($search_txt) {
        $query->orWhere("name", "like", "%". $search_txt. "%");
        $query->orWhere("phone", "like", "%". $search_txt. "%");
        $query->orWhere("email", "like", "%". $search_txt. "%");
        $query->orWhere("address", "like", "%". $search_txt. "%");
      });
    }
    $customers = $customers->paginate(\Constants::LIMIT);
    return view("backend.customer.index", compact("customers"));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    if(!\Auth::user()->can('customer.add')) {
      return view('backend.partial.no-permission', ['title' => 'No-permission']);
    }

    return view("backend.customer.form");
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  CustomerRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(CustomerRequest $request)
  {
    if(!\Auth::user()->can('customer.add') || !Auth::user()->can('customer.edit')) {
      return view('backend.partial.no-permission', ['title' => 'No-permission']);
    }

    $hidden_id = (int) $request->get("customer_id");
    if($hidden_id > 0) {
      $customer = Customer::find($hidden_id);
    }

    $data["name"] = $request->get("name");
    $data["phone"] = $request->get("phone");
    $data["phone2"] = $request->get("phone2");
    $data["email"] = $request->get("email");
    $data["id_card"] = $request->get("id_card");
    $data["gender"] = $request->get("gender");
    $data["linkedin"] = $request->get("linkedin");
    $data["fb"] = $request->get("fb");
    $data["address"] = $request->get("address");
    $data["status"] = $request->get("status", 1);
    $data["language"] = $request->get("language", 0);
    $data["wechat"] = $request->get("wechat", "");
    $data["telegram"] = $request->get("telegram", "");
    $data['created_by'] = auth()->user()->id;

    if($request->hasFile("thumbnail")) {
      $img = $request->file("thumbnail");
      $extension = $img->getClientOriginalExtension();
      $has = md5(date('Y-m-d H:i:s') . rand(1, 100));
      $file_name = !empty(@$customer->thumbnail)? @$customer->thumbnail : sha1($has) . "." . $extension;

      $path = base_path() . '/public' . config("global.customer_image_path");
      $thumbnail_path = base_path() . '/public' . config("global.customer_image_path"). "thumbnail/";

      if (!is_dir($path)) {
        File::makeDirectory($path, 0777, true, true);
      }

      if (!is_dir($thumbnail_path)) {
        File::makeDirectory($thumbnail_path, 0777, true, true);
      }

      $img = Image::make($img->getRealPath());
      if($img->resize(config('global.customer_thumbnail_size')["height"], null, function ($constraint) {
        $constraint->aspectRatio();
      })->save($thumbnail_path.$file_name)) {
        $data["thumbnail"] = $file_name;
      }

      if($img->save($path.$file_name)) {
        $data["picture"] = $file_name;
      }
    }
    // dd($data);

    if(!is_null(@$customer)) {
      $save = Customer::where("id", $hidden_id)->update($data);
    } 
    else {
      $save = Customer::create($data);
    }

    if(!$save) {
      return redirect()->back()->with("error", __("error-message"))->withInput($request->all());
    }

    return redirect(route("administrator.customer-listing"))->with("success", __("success-message"));
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
    if(!\Auth::user()->can('customer.edit')) {
      return view('backend.partial.no-permission', ['title' => 'No-permission']);
    }

    $customer = Customer::find($id);

    if(is_null($customer)){
      return redirect()->back()->with("error", __("Not Found"));
    }

    return view('backend.customer.form', compact("customer"));
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
    if(!\Auth::user()->can('customer.edit')) {
      return view('backend.partial.no-permission', ['title' => 'No-permission']);
    }
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
    if(!\Auth::user()->can('customer.delete')) {
      return view('backend.partial.no-permission', ['title' => 'No-permission']);
    }

    $customer = Customer::find($id);
    if(is_null($customer)){
      return view("backend.error.404");
    }

    if(!empty(@$customer->thumbnail)){
      File::delete( public_path() . config("global.office_image_path").'thumbnail/'.$customer->thumbnail);
    }

    if(!empty(@$customer->picture)){
      File::delete( public_path() . config("global.office_image_path").$customer->picture);
    }
    $delete = Customer::destroy($id);

    if($delete){
      return redirect()->back()->with("success", __("success-message"));
    }

    return redirect()->back()->with("error", __("error-message"));
  }
}