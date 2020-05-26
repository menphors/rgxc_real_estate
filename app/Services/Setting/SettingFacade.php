<?php 

namespace App\Services\Setting;  

use Illuminate\Support\Facades\Facade;  

class AppSettingFacade extends Facade
{
	protected static function getFacadeAccessor() { return 'AppSetting'; }
}