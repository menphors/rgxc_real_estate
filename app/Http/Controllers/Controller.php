<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Intervention\Image\Facades\Image;
use App\Model\Config;
use App\Model\Property\Property;
use View;
class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function __construct()
  {
    date_default_timezone_set("Asia/Bangkok");
    $config = Config::first();
    if(!is_null($config)) {
      // $config = json_decode($config);
      $config->data = json_decode($config->data);
    }

    $totalProperties = Property::where('status', \Constants::PROPERTY_STATUS["published"])->where('state', 1)->count();
    View::share('total_properties', number_format($totalProperties, 0, '', ','));
    View::share( 'config', $config );
  }

  public function water_mark($image_path, $position ='top-center', $x = 10, $y = 50)
  {
    $img = Image::make(public_path($image_path));

    $watermark = isset($config->data->watermark) && $config->data->watermark!='' ? public_path('images/site/').$config->data->watermark : public_path('images/water_mark.png');

    /* insert watermark at bottom-right corner with 10px offset */
    $img->insert($watermark, $position, $x, $y);

    $img->save(public_path($image_path));
  }
}