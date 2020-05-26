<?php namespace App\Services\Mailers;

use Illuminate\Support\ServiceProvider;

class MailerServiceProvider extends ServiceProvider {

	protected $defer = false;
	protected $mails = [
		'Site',
	];

	public function register() {
		foreach ($this->mails as $mail) {
			$this->app->bind('mailer.'.strtolower($mail), function ($app) use ($mail) {
					$class = "\App\Services\Mailers\\".$mail."Mailer";
					return new $class($app->make('mailer'));
				});
		}
	}
}