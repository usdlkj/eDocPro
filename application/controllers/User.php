<?php
class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('company_model');
		$this->load->model('project_user_model');
		$this->load->helper('url_helper');
		$this->load->library('cdmhelper');
		$this->load->library('hashids');
	}

	public function view($message = NULL)
	{
		log_message('info', 'Viewing user records.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// set data variable for views
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$data = $this->set_data($user, $message);
		
		$data['title'] = 'View Users';
		$data['users'] = $this->user_model->read();
		
		// load views
		$this->load->view('templates/header', $data);
		$this->load->view('user/view', $data);
		$this->load->view('templates/footer');
	}
	
	public function create($message = NULL)
	{
		log_message('info', 'Creating user.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// load form and form validation
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$config = array(
			array(
				'field' => 'login', 
				'label' => 'Username', 
				'rules' => 'required|min_length[4]|max_length[8]|alpha_numeric'
			),
			array(
				'field' => 'password', 
				'label' => 'Password', 
				'rules' => 'required|matches[cfpassword]|min_length[8]|max_length[16]|alpha_dash'
			),
			array(
				'field' => 'cfpassword', 
				'label' => 'Password Confirmation', 
				'rules' => 'required'
			),   
			array(
				'field' => 'first_name', 
				'label' => 'First Name', 
				'rules' => 'required'
			),
			array(
				'field' => 'company',
				'label' => 'Company',
				'rules' => 'required'
			)
		);
		$this->form_validation->set_rules($config);
		
		// set data variable for views
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$data = $this->set_data($user, $message);
		
		$data['title'] 		= 'Create User';
		$data['company'] 	= $this->company_model->get_active_companies();
		
		// if validation passes
		if ($this->form_validation->run())
		{
			$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
			
			// insert new user record
			$new_user = array(
				'login' 		=> $this->input->post('login'),
				'password' 		=> password_hash($this->input->post('password'), PASSWORD_DEFAULT),
				'first_name' 	=> $this->input->post('first_name'),
				'last_name'		=> $this->input->post('last_name'),
				'company_id' 	=> $this->input->post('company'),
				'user' 			=> $user['login']
			);
			$this->user_model->create($new_user);
			
			$this->view($this->cdmhelper->set_success_msg('User created.'));
		}
		else
		{
			$this->load->view('templates/header', $data);
			$this->load->view('user/create', $data);
			$this->load->view('templates/footer');
		}
	}
	
	public function edit($id_hash, $message = NULL)
	{
		log_message('info', 'Editing user record.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// load form and form validation
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$config = array(
			array(
				'field' => 'login', 
				'label' => 'Username', 
				'rules' => 'required|min_length[4]|max_length[8]|alpha_numeric'
			), 
			array(
				'field' => 'first_name', 
				'label' => 'First Name', 
				'rules' => 'required'
			),
			array(
				'field' => 'company',
				'label' => 'Company',
				'rules' => 'required'
			)
		);
		$this->form_validation->set_rules($config);
		
		// decode user id
		$temp = $this->hashids->decode($id_hash);
		$id = $temp[0];
		
		// set data variable for views
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$data = $this->set_data($user, $message);
		
		$data['user'] 		= $this->user_model->get_user_by_id($id);
		$data['title'] 		= 'Edit User';
		$data['company'] 	= $this->company_model->get_active_companies();
		$data['id_hash']	= $id_hash;
		
		if ($id == 10000001) {
			$this->view($this->cdmhelper->set_error_msg('User Admin cannot be edited.'));
		}
		else
		{
			// if validation does not pass
			if ($this->form_validation->run())
			{
				// edit user record
				$user = array(
					'id' 			=> $id,
					'company_id' 	=> $this->input->post('company'),
					'login' 		=> $this->input->post('login'),
					'password'		=> $user['password'],
					'first_name' 	=> $this->input->post('first_name'),
					'last_name'		=> $this->input->post('last_name'),
					'user' 			=> $user['login']
				);
				$this->user_model->update($user);
				
				$this->view($this->cdmhelper->set_success_msg('User detail changed.'));
			}
			else
			{
				$this->load->view('templates/header', $data);
				$this->load->view('user/edit', $id_hash, $data);
				$this->load->view('templates/footer');
			}
		}
	}
	
	public function password($id_hash, $message = NULL)
	{
		log_message('info', 'Changing user password.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// load form and form validation
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$config = array(
			array(
				'field' => 'password', 
				'label' => 'Password', 
				'rules' => 'required|matches[cfpassword]|min_length[8]|max_length[16]|alpha_dash'
			),
			array(
				'field' => 'cfpassword', 
				'label' => 'Password Confirmation', 
				'rules' => 'required'
			)
		);
		$this->form_validation->set_rules($config);
		
		// decode user id
		$temp = $this->hashids->decode($id_hash);
		$id = $temp[0];
		
		// set data variable for views
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$data = $this->set_data($user, $message);
		
		$data['user'] 		= $this->user_model->get_user_by_id($id);
		$data['title'] 		= 'Set Password';
		$data['company'] 	= $this->company_model->get_active_companies();
		$data['id_hash']	= $id_hash;
		
		// if validation does not pass
		if ($this->form_validation->run())
		{
			// edit password
			$user = array(
				'id' 			=> $id,
				'password'		=> password_hash($this->input->post('password'), PASSWORD_DEFAULT)
			);
			$this->user_model->set_password($user);
			
			$this->view($this->cdmhelper->set_success_msg('Password changed.'));
		}
		else
		{
			$this->load->view('templates/header', $data);
			$this->load->view('user/password', $id_hash, $data);
			$this->load->view('templates/footer');
		}
	}
	
	public function delete($id_hash)
	{
		log_message('info', 'Deleting user record.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// decode user id
		$temp = $this->hashids->decode($id_hash);
		$id = $temp[0];

		$current_user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		
		if ($id == 10000001) {
			$this->view($this->cdmhelper->set_error_msg('User Admin cannot be deleted.'));
		}
		else
		{
			$user = array(
				'id' 	=> $id,
				'user' 	=> $current_user['login']
			);
			$this->user_model->hide($user);
			
			$this->view($this->cdmhelper->set_success_msg('User deleted.'));
		}
	}
	
	public function login()
	{
		// load form and form validation
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		// set validation
		$config = array(
			array(
				'field' => 'login', 
				'label' => 'Username', 
				'rules' => 'required|min_length[4]|max_length[8]|alpha_numeric'
			),
			array(
				'field' => 'password', 
				'label' => 'Password', 
				'rules' => 'required|min_length[8]|max_length[16]|alpha_dash'
			)
        );
		$this->form_validation->set_rules($config);
		
		// if validation passes
		if ($this->form_validation->run())
		{		
			// get login and password
			$login 		= $this->input->post('login');
			$password 	= $this->input->post('password');
			log_message('info', 'User ' . $login . ' is logging in.');
			
			// get user based on login
			$user = $this->user_model->get_user_by_login($login);
			if (empty($user)) 
			{
				$message = 'User does not exist.';
				log_message('error', $message);
				$data['message'] = $this->cdmhelper->set_error_msg($message);
				$this->load->view('user/login', $data);
			}
			else
			{
				// if login and password is confirmed
				if (password_verify($password, $user['password']))
				{
					// save user info into session
					session_start();
					$_SESSION['user_id'] = $user['id'];
					
					// load the document view page
					$project_id = $user['current_project_id'];
					if ($project_id == null) {
						$project_id = 0;
					}
					$project_id = $this->hashids->encode($project_id);
					redirect('/document/view/'.$project_id, 'refresh');
				}
				else 
				{
					$message = 'User authentication failed.';
					log_message('error', $message);
					$data['message'] = $this->cdmhelper->set_error_msg($message);
					$this->load->view('user/login', $data);
				}
			}
		}
		else {
			$this->load->view('user/login');
		}
	}
	
	public function logout()
	{
		session_start();
		session_unset();
		session_destroy();
		$this->login();
	}
	
	// function: set general data for top navigation and project list
	function set_data($user, $message = NULL)
	{
		$data['project_id'] = $user['current_project_id'] == 0 ? 0 : $this->hashids->encode($user['current_project_id']);
		$data['is_admin']	= $user['id'] == 10000001 ? 1 : 0;
		$data['projects'] 	= $this->project_user_model->get_active_projects_by_user_id($user['id']);
		$data['name'] 		= $user['first_name'];
		if ($message != null) {
			$data['message'] = $message;
		}
		
		return $data;
	}
}