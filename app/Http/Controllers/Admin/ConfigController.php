<?php

namespace App\Http\Controllers\Admin;

use App\Model\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class ConfigController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $config = Config::first();
    if(!is_null($config)) {
      // $config = json_decode($config);
      $config->data = json_decode($config->data);
      $config->data->site_logo = isset($config->data->site_logo) ? $config->data->site_logo : '';
      $config->data->fav = isset($config->data->fav) ? $config->data->fav : '';
      $config->data->logo = isset($config->data->logo) ? $config->data->logo : '';
      $config->data->watermark = isset($config->data->watermark) ? $config->data->watermark : '';
    }

    return view("backend.config.index", compact("config"));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $data = $request->except(['_token']);
    $config = Config::first();
    $config->data = json_decode($config->data);

    if($request->hasFile('site_logo')) {
      $profileImageName = time().'.'.request()->site_logo->getClientOriginalExtension();

      $path = public_path(config("global.config_path"));
      if (!is_dir($path)) {
        File::makeDirectory($path, 0777, true, true);
      }

      request()->site_logo->move(public_path(config("global.config_path")), $profileImageName);
      $data['site_logo'] = $profileImageName;
    }
    else {
      $data['site_logo'] = isset($config->data->site_logo) ? $config->data->site_logo : '';
    }
    if($request->hasFile("fav")) {
      $profileImageName = 'favicon'.'.'.request()->fav->getClientOriginalExtension();

      $path = public_path(config("global.config_path"));
      if (!is_dir($path)) {
        File::makeDirectory($path, 0777, true, true);
      }

      request()->fav->move(public_path(config("global.config_path")), $profileImageName);
      $data['fav'] = $profileImageName;
    }
    else {
      $data['fav'] = isset($config->data->fav) ? $config->data->fav : '';
    }
    if($request->hasFile("logo")) {
      $profileImageName = 'logo'.'.'.request()->logo->getClientOriginalExtension();

      $path = public_path(config("global.config_path"));
      if (!is_dir($path)) {
        File::makeDirectory($path, 0777, true, true);
      }

      request()->logo->move(public_path(config("global.config_path")), $profileImageName);
      $data['logo'] = $profileImageName;
    }
    else {
      $data['logo'] = isset($config->data->logo) ? $config->data->logo : '';
    }
    if($request->hasFile("watermark")) {
      $profileImageName = 'water_mark'.'.'.request()->watermark->getClientOriginalExtension();

      $path = public_path(config("global.config_path"));
      if (!is_dir($path)) {
        File::makeDirectory($path, 0777, true, true);
      }

      request()->watermark->move(public_path(config("global.config_path")), $profileImageName);
      $data['watermark'] = $profileImageName;
    }
    else {
      $data['watermark'] = isset($config->data->watermark) ? $config->data->watermark : '';
    }

    $save = Config::updateOrCreate(["id" => (int)@$config->id], [
      "data" => json_encode($data)
    ]);

    if($save) {
      return redirect()->back()->with("success",  __("success-message"));
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
        //
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
        //
    }
}
