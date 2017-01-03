<?php namespace App\Http\Controllers\Handlers;

class EmailHandler {

	/**
	 * Send email using PHP Mailer .
	 *
	 * @return int
	 */

	public function sendEmail($email, $msg, $subject )
	{    
		try{    
			\Mail::queue('text_mail', array(
				'msg' => $msg
				), function($message) use ($email, $subject)
			{
				$message->to($email, '')->subject($subject);
			});
		}catch(Exception $e)
		{
			return 0;
		}
		return 1;
	}

}
