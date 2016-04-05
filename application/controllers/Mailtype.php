<?php
class Mailtype extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mail_type_model');
		$this->load->model('user_model');
		$this->load->model('project_user_model');
		$this->load->model('project_model');
		$this->load->helper('url_helper');
		$this->load->library('cdmhelper');
		$this->load->library('hashids');
	}

	public function view($id_hash, $message = NULL)
	{
		log_message('info', 'Viewing mail type records.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// set data variable for views
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$data = $this->set_data($user, $message);
		$temp = $this->hashids->decode($id_hash);
		$project_id = $temp[0];
		
		$data['mail_types'] 	= $this->mail_type_model->get_mail_types($project_id);
		$data['title'] 			= 'View Mail Types';
		$data['id_hash']		= $id_hash;
		
		// load views
		$this->load->view('templates/header', $data);
		$this->load->view('mailtype/view', $data);
		$this->load->view('templates/footer');
	}
	
	public function create($id_hash)
	{
		log_message('info', 'Creating mail type.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// set data variable for views
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$data = $this->set_data($user);
		$temp = $this->hashids->decode($id_hash);
		$project_id = $temp[0];
		
		$data['title'] 			= 'Create Mail Type';
		$data['id_hash']		= $id_hash;
		
		// load form and form validation
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$config = array(
			array(
				'field' => 'mail_code', 
				'label' => 'Mail Code', 
				'rules' => 'required|max_length[8]|alpha_numeric'
			),
			array(
				'field' => 'mail_type', 
				'label' => 'Mail Type', 
				'rules' => 'required'
			)
		);
		$this->form_validation->set_rules($config);
		
		// if validation passes
		if ($this->form_validation->run())
		{
			$mail['project_id']		= $project_id;
			$mail['mail_code'] 		= $this->input->post('mail_code');
			$mail['mail_type'] 		= $this->input->post('mail_type');
			$mail['is_transmittal'] = null != $this->input->post('transmittal') ? 1 : 0;
			$mail['user']			= $user['login'];
			$this->mail_type_model->create($mail);
			
			$this->view($id_hash);
		}
		else
		{
			// load create views
			$this->load->view('templates/header', $data);
			$this->load->view('mailtype/create', $data);
			$this->load->view('templates/footer');
		}
	}
	
	public function edit($id_hash)
	{
		log_message('info', 'Editing mail type.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// set data variable for views
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$data = $this->set_data($user);
		$temp = $this->hashids->decode($id_hash);
		$type_id = $temp[0];
		$mail_type = $this->mail_type_model->get_type_by_id($type_id);
		
		$data['title'] 			= 'Edit Mail Type';
		$data['id_hash']		= $id_hash;
		$data['id_hash2']		= $this->hashids->encode($mail_type['project_id']);
		$data['mail_type']		= $mail_type;
		
		// load form and form validation
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$config = array(
			array(
				'field' => 'mail_code', 
				'label' => 'Mail Code', 
				'rules' => 'required|max_length[8]|alpha_numeric'
			),
			array(
				'field' => 'mail_type', 
				'label' => 'Mail Type', 
				'rules' => 'required'
			)
		);
		$this->form_validation->set_rules($config);
		
		// if validation passes
		if ($this->form_validation->run())
		{
			$mail_type['mail_code'] 		= $this->input->post('mail_code');
			$mail_type['mail_type']			= $this->input->post('mail_type');
			$mail_type['is_transmittal'] 	= null != $this->input->post('transmittal') ? 1 : 0;
			$mail_type['user']				= $user['login'];
			
			$this->mail_type_model->update($mail_type);
			
			$this->view($this->hashids->encode($mail_type['project_id']), $this->cdmhelper->set_success_msg('Mail Type detail changed.'));
		}
		else
		{
			// load create views
			$this->load->view('templates/header', $data);
			$this->load->view('mailtype/edit', $data);
			$this->load->view('templates/footer');
		}
	}
	
	public function delete($id_hash)
	{
		log_message('info', 'Creating mail type.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// set data variable for views
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		
		$temp = $this->hashids->decode($id_hash);
		$type_id = $temp[0];
		$mail = array('id' => $type_id, 'user' => $user['login']);
		
		$this->mail_type_model->hide($mail);
		
		$this->view($id_hash, $this->cdmhelper->set_success_msg('Mail Type deleted.'));
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