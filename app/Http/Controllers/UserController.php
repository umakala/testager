<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Http\Controllers\Handlers\EmailHandler;

class UserController extends Controller {


	public function index()
	{
		if(isset($_GET['info']))
			return view('welcome', ['list' => $news, 'info' => $_GET['info'] ]);
		if(isset($_GET['message']))
			return view('welcome', ['message' => $_GET['message'] ]);
		else
			return view('welcome');
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function login(Request $request)
	{
		$validator = \Validator::make($request->all(), array(
			'email' => 'required',
			'password' => 'required'            
			));
		if ($validator->fails())
		{
			foreach ($validator->errors()->toArray() as $key => $value) {
				$error[]=$value[0];
			} 
		}
		else{
			$password =  $request->password;
			//$hash_password = hash('sha256', $request->password);
       		$result = \App\User::select('name', 'id', 'autorun_location', 'open_project')->where(['email' =>  $request->email, 'password' =>   $password])->get()->toArray();
			
			//print_r($result);

			if(isset($result[0]))
			{
				/*if($result[0]['verification'] != NULL)
					$error[] = "Email is not verified. Please verify email.";
				else*/

				$project_name = \App\TestProject::select('tp_name')->find($result[0]['open_project']);
				
				session(['id' => $result[0]['id'], 'name'=>$result[0]['name'], 'email' => $request->email , 'open_project' => $result[0]['open_project'] , 'autorun_location' =>  $result[0]['autorun_location'] , 'project_name' => $project_name->tp_name]);
				return redirect()->route('profile');			
			}
			else
				$error[] = "Incorrect email or password!";
		}
		return redirect()->route('home', ['message' => $error])->withInput();
	}

	 /**
     *  Logout 
     */
	 public function signout(Request $request)
	 {
	 	$request->session()->flush();
	 	return redirect()->route('home');
	 }

	  /**
     *  Profile page
     */
	  public function profile()
	  {
	  	$user = \App\User::find(session()->get('id'));
	  	$view['projects']= \App\TestProject::all();	  	

	  	if(isset($user->open_project) && $user->open_project != "")
			$view['open_project'] =  $user->open_project;		

		return view('profile', $view);
	  }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		if(isset($_GET['message']))
			return view('register', ['message' => $_GET['message'] ]);
		else
			return view('register');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$validator = \Validator::make($request->all(), array(
			'name' => 'required',
			'email' => 'required|Email|unique:users'           
			));
		if ($validator->fails())
		{
			foreach ($validator->errors()->toArray() as $key => $value) {
				$error[]=$value[0];
			} 
		}
		else{

			try{
			$content['email'] 					= $request->email;
			$content['name']                   	= $request->name;
			$content['verification']		    = hash('sha256', $this->genrateRandomInt());
        	
        	// Send verification mail
			$full_link = url('user/verify_email?email=' . $content["email"] . '&verification_code=' . $content['verification']);

       		// $link      = $this->getShortURL($full_link);
			$message = "Hi " .  $content['name'] . ", <br/><br/>Almost there! <br/>Please click on the link below  or copy/paste the link into your browser to verify your email and complete signup.<br/><br/>" . $full_link . "<br/><br/>Warmly<br/>Team Newstand";
			$subject    = '[Newstand] Welcome On-board!';

			$email_obj = new EmailHandler();

			if($email_obj ->sendEmail($content['email'], $message, $subject) == 0)
			{
				$error= "Could not connect internet. Kindly check your connection.";
			}else{
				$create_user = \App\User::create($content);
				return redirect()->route('home', ['info' => "Please check your email to complete signup process."] );
			}
		}
			catch(Exception $e){
				 $error= "Could not connect internet. Kindly check your connection.";
			}
		}		
		return redirect()->route('user.register', ['message' => $error])->withInput();
	}

	/**
	 * Verify email of the clicked link.
	 * 
	 */

	public function verify_email()
		{
			$request                 = \Request::instance();
			$validator = \Validator::make($request->all(), array(
				'verification_code' => 'required',
				'email' => 'required|Email'           
				));
			if ($validator->fails())
			{
				foreach ($validator->errors()->toArray() as $key => $value) {
					$error[]=$value[0];
				} 
				return view('reset', ['info' => 'Verification failed. Please try again.', 'status' => 'failed']);
			}else{
				$email                   = $request->input('email');
				$email_verification_code = $request->input('verification_code');
				$update_cnt['verification'] = NULL;
				try
				{
					$update_user = \App\User::where('email', $email)->where('verification', $email_verification_code)->update($update_cnt);
					if ($update_user)
						return view('reset', ['info' => 'Email verified. Please set a new password.',  'status' => 'success', 'email' => $email]);
					else
						return view('reset', ['info' => 'Verification failed. Please try again.', 'status' => 'failed']);
				}
				catch (Exception $e)
				{
					return view('reset', ['info' => 'There was an error.Please try again.',  'status' => 'failed']);
				}
			}
		}

	    /**
	     *  Set new password
	     */
	    public function reset_password(Request $request)
	    {	

	    	$validator = \Validator::make($request->all(), array(
				'email' => 'required|Email',
				'password' => 'required'          
				));
			if ($validator->fails())
			{
				foreach ($validator->errors()->toArray() as $key => $value) {
					$error[]=$value[0];
				} 
				return view('reset', ['info' => 'Please enter a valid password.',  'status' => 'validation_failed', 'email' => $request->email]);			
			}else{

	    	$content ['email'] =  $request->email;
			$content ['password'] =  $request->password;
 
	    	$update_cnt['password']      = hash('sha256', $content['password']);
	    	try
	    	{	    		
	    		
	    		$update_user = \App\User::where('email', $content['email'])->update($update_cnt);
	    		if ($update_user == 'false')
	    		{
	    			$error  = 'Error updating new password, please try later!';
	    			return view('reset', ['info' => $error,  'status' => 'failed']);
	    		}
	    		else
	    		{
	    			$result = \App\User::select('id', 'name', 'email')->where('email', $content['email'])->get()->toArray();
	    			session(['id' => $result[0]['id'], 'name'=>$result[0]['name'], 'email' => $request->email ]);
					return redirect()->route('profile'); 
	    		}
	    	}
	    	catch (Exception $e)
	    	{
	    		echo $error  = 'Error updating new password, please try later!';
	    		return view('reset', ['info' => $error,  'status' => 'failed']);
	    	}
	    }
	}

}
