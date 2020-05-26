<?php
use Illuminate\Support\Facades\Storage;
use App\Model\Property\Property;

if (! function_exists('default_image')) {
    function default_image($file_name = 'default_product.png') {
        return "/admin/filemanager/photos/shares/" . $file_name;
    }
}
if (! function_exists('getPropertyGallery')) {
    function getPropertyGallery() {
        $properties = Property::with([
            'attachments'
        ])
        ->where('status', \Constants::PROPERTY_STATUS["published"])
        ->limit(12)->get();
        
        return $properties;
    }
}

if (! function_exists('furniture')) {
    function furniture($index = "") {
       $data = array(
           1 => __("None"),
           2 => __("Full"),
           3 => __("Some")
       );

       if(!empty($index)){
           return @$data[$index];
       }

       return $data;
    }
}

if (! function_exists('gender')) {
    function gender($index = "") {
        $data = array(
            1 => __("Male"),
            2 => __("Female")
        );

        if(!empty($index)){
            return @$data[$index];
        }

        return $data;
    }
}


if (! function_exists('staff_type')) {
    function staff_type($index = "") {
        $data = array(
            2 => __("Collector"),
            3 => __("Office"),
            4 => __("Seller"),
            5 => __("Agent")
        );

        if(!empty($index)){
            return @$data[$index];
        }

        return $data;
    }
}

if (!function_exists('isAdmin')) {
  /**
   * Check if the login has role as admin.
   * FOR TEMPORARY USE.
   */
  function isAdmin()
  {
    $role = App\Model\Role\Role::where('id', env('ADMIN_ROLE'))->first();
    return auth()->check() && auth()->user()->hasRole($role->name);
  }
}