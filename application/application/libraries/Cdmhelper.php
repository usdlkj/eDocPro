<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Cdmhelper {

    public function check_login()
    {
		log_message('info', 'Checking session.');
		
		// start session if not yet started
		if (session_status() == PHP_SESSION_NONE) 
		{
			log_message('info', 'Session not started. Starting session.');
			session_start();
		}
		
		// if user's login does not exist, e.g. user is not logged in, return to login screen.
		if ($_SESSION['user_id'] === NULL) 
		{
			log_message('info', 'User is not logged in.');
			$CI =& get_instance();
			$CI->login();
		}
    }
	
	public function set_error_msg($error)
	{
		// log error message
		log_message('error', $error);
		
		// return error message for display
		return '<div class="alert alert-danger" role="alert">'.$error.'</div>';
	}
	
	public function set_success_msg($success)
	{
		/// log info message
		log_message('info', $success);
		
		// return success message for display
		return '<div class="alert alert-success" role="alert">'.$success.'</div>';
	}
}

/* End of file Cdmhelper.php */