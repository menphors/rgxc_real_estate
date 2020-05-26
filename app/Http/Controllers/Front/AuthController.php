<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator, Auth;
use App\Services\Mailers\SiteMailer;
use App\Model\User\UserRepository;

class AuthController extends Controller
{
  protected $user;

  protected $email;

	public function __construct (UserRepository $user, SiteMailer $mail) 
  {
		$this->user = $user;
		$this->mail = $mail;
	}

	public function showLoginForm() 
  {
    if(\Auth::check()) {
      if(\Auth::user()->isAdmin()) {
        return redirect(url('administrator/dashboard'));
      }
      else {
        return redirect('/');
      }
    }
		return view('auth.login');
	}    

	public function login(Request $request) 
  {
		$data = $request->all();
		$remember = $request->get('remember', 0);

		$validate = Validator::make($data , [
  		'email' 	=> 'email|required',
  		'password'  => 'required'
  	], []);

		if($validate->fails()) {
			return redirect('/administrator')->withErrors($validate)->withInput();
		}
		if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']], $remember)) {
      if(Auth::user()->isAdmin()) {
        return redirect('administrator/dashboard');
      } 
      else {
        return redirect('/');
      }
		}

		return redirect('/administrator')->with('error','The credentials are incorrect!')->withInput();
	}

	public function logout()
  {
    Auth::logout();
    return redirect('/');
  }
		
  public function email() {
  	return view('admin.auth.email');
  }

  public function sendEmail(Request $request)
  {
    $data = $request->all();
    $validate = Validator::make($data , [
			'email' 	=> 'email|required'
		]);
		if($validate->fails()) {
			return redirect()->back()->withErrors($validate)->withInput();
		}

	  $user = $this->user->model()->where('email',$request->email)->first();
    if($user) {
      $confirmation_code = str_random(30);
      $user->confirmation_code = $confirmation_code;
      $user->save();
      $data = [
        'username' => $user->name,
        'code'     => $user->confirmation_code,
        'email'    => $user->email,
        'urlView'  => url('get-reset-password/'.$user->confirmation_code)
      ];
      $data['title'] = 'Welcome to codexcambodia.com';
      
      $this->mail->resetPassword($data);
      return redirect('email-password-success');
    }
    return \Redirect::back()->withInput()->with('error', 'Email does not exist!');
  }

  public function forgetPasswordSuccess()
  {
    return view('admin.auth.email-sucess');
  }

  public function formResetPassword($code = null)
  {
  	if(!$code) return view('errors.404');
    $result = $this->user->model()->where('confirmation_code',$code)->first();
    if($result) {
      $data['user'] = $result;
      return view('admin.auth.reset-password',$data);
    } 
    return view('errors.404');
  }

  public function postResetPassword(Request $request) 
  {
    $validate = Validator::make($request->all(), [
			'code'                   => 'required',
			'password'               => 'required|confirmed|min:6',
			'password_confirmation'  => 'required|min:6'
		]);
  	if($validate->fails()) {
  		return redirect()->back()->withErrors($validate)->withInput();
  	}
  	$user = $this->user->updateNewPassword($request);
    if($user) return redirect('reset-password-success');
    return view('errors.404');
  }

  public function resetSuccess() 
  {
  	return view('admin.auth.reset-password-success');
  }
}
