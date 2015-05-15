<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Illuminate\Http\Request;
//use Illuminate\Http\Auth\User;
//use Illuminate\Contracts\Auth\User;
use App\User;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'getLogout']);
	}

	/**
	 * Handle a registration request for the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postRegister(Request $request)
	{
		$validator = $this->registrar->validator($request->all());
	
		if ($validator->fails())
		{
			$this->throwValidationException(
					$request, $validator
			);
		}

		$activation_code = str_random(60) . $request->input('email');
		$user = new User;
		$user->name = $request->input('name');
		$user->email = $request->input('email');
		$user->password = bcrypt($request->input('password'));
		$user->activation_code = $activation_code;
		
		if ($user->save()) {
			
			$data = array(
				'name' => $user->name,
				'code' => $activation_code,
			);
			
			\Mail::queue('emails.activateAccount', $data, function($message) use ($user) {
				$message->subject('Please activate your account.');
				$message->to($user->email);
			});
			
			return view('auth.activateAccount')
				->with('email', $request->input('email'));
		
		} else {
			
			\Session::flash('message', 'Your account could not be create please try again');
			return redirect()->back()->withInput();
			
		}
		
	}
	
	public function activateAccount($code, User $user)
	{
	
		if($user->accountIsActive($code)) {
			\Session::flash('message', 'Success, your account has been activated.');
			return redirect('home');
		}
	
		\Session::flash('message', 'Your account could not be activated; please try again.');
		return redirect('home');
	
	}
	
}
