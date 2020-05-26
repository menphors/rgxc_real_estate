<?php namespace App\Services\Mailers;

use Illuminate\Contracts\Mail\Mailer as LaravelMailer;

class SiteMailer extends Mailer {

	public function __construct(LaravelMailer $mailer) {
		$this->mailer = $mailer;
	}

	public function testMail($email) {
		$this->send($email, 'test cron', 'test', $data = ['name' => 'Sophy SEM']);
	}

	public function contactMail($sender, $subject, $view ,$data) {
		$this->send($sender , $subject, $view, $data);
	} 

	public function quotationMail($f_email,$f_name, $t_email, $t_name, $subject, $view ,$data) {
		$this->codeClansSend($f_email,$f_name, $t_email, $t_name, $subject, $view ,$data);
	} 

	public function resetPassword($data = []) {
		// $this->send($sender, $subject , $view , $data);
		$this->send($data['email'],$data['title'],'admin.auth.mail.email-reset',$data);
	}

}