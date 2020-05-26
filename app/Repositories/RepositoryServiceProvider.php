<?php 
namespace App\Repositories;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider 
{
	
	protected $providers = [
		'Setting',
		'User',
		'Role',
		'Permission',
		'Staff',
		'Customer',
		'Property',
		'Contract',
		'PaymentTransaction',
		'Commission',
		'Visit',
		'Attachment',
		'District',
		'Commune',
		'Village',
		'Office',
		'Province',
		'Owner'
	];

	public function register() 
	{
		$loader = AliasLoader::getInstance();

		foreach ($this->providers as $provider) {
			$this->app->bind("App\\Model\\$provider\\" .$provider."Repository", function () use ($provider) {
				$model = app("App\\Model\\{$provider}\\{$provider}");
				return app("App\\Model\\{$provider}\\Db{$provider}Repository", [$model]);
			});

			$this->app->booting(function () use ($provider, $loader) {
				$loader->alias($provider, "App\\Model\\{$provider}\\{$provider}");
				$loader->alias($provider."Repository", "App\\Model\\{$provider}\\{$provider}Repository");
			});
		}

		$this->app->bind('AppSetting', "App\\Services\\Setting\\AppSetting");
		$loader->alias('AppSetting', "App\\Services\\Setting\\AppSettingFacade");
	}
}
