<?php namespace App\Services\Mailers;

abstract class Mailer {

	protected $mailer;
	


	public function codeClansSend($f_email,$f_name,$t_email,$t_name, $subject, $view, $data = []) {
		$this->mailer->queue($view, $data, function ($message) use ($f_email,$f_name,$t_email,$t_name, $subject, $data) {
				$message->from($f_email,$f_name);
				$message->to($t_email,$t_name)->subject($subject);
				if (array_key_exists('attach', $data)) {
					$message->attach($data['attach'], array('as' => $data['attach_as'], 'mime' => 'application/pdf'));
				}

			});

	}


	public function send($email, $subject, $view, $data = []) {
		$this->mailer->queue($view, $data, function ($message) use ($email, $subject, $data) {
				$message->to($email)
					->subject($subject);
				if (array_key_exists('attach', $data)) {
					$message->attach($data['attach'], array('as' => $data['attach_as'], 'mime' => 'application/pdf'));
				}

			});

	}
	public function sendBcc($email, $subject, $view, $data = []) {
		$this->mailer->queue($view, $data, function ($message) use ($email, $subject, $data) {

				$message->to($email)
					->subject($subject);
				if (array_key_exists('attach', $data)) {
					$message->attach($data['attach'], array('as' => $data['attach_as'], 'mime' => 'application/pdf'));
				}
				$message->bcc("info@guiddies.com", "info");

			});

	}
	public function sendReplyTo($email, $replyTo, $nameReplyTo, $subject, $view, $data = []) {
		$this->mailer->queue($view, $data, function ($message) use ($email, $subject, $data, $replyTo, $nameReplyTo) {

				$message
				//->from(env('FROM_SUPPORT','support@guiddies.com'), env('FROM_SUPPORT_NAME','Guiddies.com'))
				->to($email)
					->subject($subject)
				->replyTo($replyTo, $nameReplyTo);
			});

	}

}