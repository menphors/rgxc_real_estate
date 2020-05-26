<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider {
	public function register()
	{
		config([
			'laravellocalization.supportedLocales' => [
				'es'          => ['name' => 'Spanish', 'script' => 'Latn', 'native' => 'español', 'regional' => 'es_ES'],
				'en'  =>  ['name' => 'English', 'script' => 'Latn', 'native' => 'English'],
			],

			'laravellocalization.useAcceptLanguageHeader' => true,

			'laravellocalization.hideDefaultLocaleInURL' => true
		]);
	}

}