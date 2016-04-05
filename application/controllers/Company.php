<?php
class Company extends CI_Controller {

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
		log_message('info', 'Viewing company records.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// set data variable for views
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$data = $this->set_data($user, $message);
		
		$data['companies'] 	= $this->company_model->read();
		$data['title'] 		= 'View Companies';
		
		// load views
		$this->load->view('templates/header', $data);
		$this->load->view('company/view', $data);
		$this->load->view('templates/footer');
	}
	
	public function create($message = NULL)
	{
		log_message('info', 'Creating company record.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// load form and form validation
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$config = array(
			array(
				'field' => 'cname', 
				'label' => 'Company Name', 
				'rules' => 'required'
			),
			array(
				'field' => 'tname', 
				'label' => 'Trading Name', 
				'rules' => 'required'
			),
			array(
				'field' => 'ccode', 
				'label' => 'Company Code', 
				'rules' => 'required|alpha_numeric'
			)
		);
		$this->form_validation->set_rules($config);
		
		// set data variable for views
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$data = $this->set_data($user, $message);
		
		$data['title'] 		= 'Create Company';
		
		// if validation passes
		if ($this->form_validation->run())
		{
			// insert new user record
			$company = array(
				'cname' => $this->input->post('cname'),
				'tname' => $this->input->post('tname'),
				'ccode' => $this->input->post('ccode'),
				'user' 	=> $user['login']
			);
			
			$this->company_model->create($company);
			
			$this->view($this->cdmhelper->set_success_msg('Company added.'));
		}
		else
		{
			$this->load->view('templates/header', $data);
			$this->load->view('company/create', $data);
			$this->load->view('templates/footer');
		}
	}
	
	public function edit($id_hash, $message = NULL)
	{
		log_message('info', 'Editing company record.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// load form and form validation
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$config = array(
			array(
				'field' => 'cname', 
				'label' => 'Company Name', 
				'rules' => 'required'
			),
			array(
				'field' => 'tname', 
				'label' => 'Trading Name', 
				'rules' => 'required'
			),
			array(
				'field' => 'ccode', 
				'label' => 'Company Code', 
				'rules' => 'required|alpha_numeric'
			)
		);
		$this->form_validation->set_rules($config);
		
		// decode company id
		$temp = $this->hashids->decode($id_hash);
		$id = $temp[0];
		
		// set data variable for views
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$data = $this->set_data($user, $message);
		
		$data['title'] 		= 'Edit Company';
		$data['id_hash'] 	= $id_hash;
		$data['company'] 	= $this->company_model->get_company_by_id($id);
		
		if ($id == 20000001) {
			$this->view($this->cdmhelper->set_error_msg('Owner Company cannot be edited.'));
		}
		else
		{
			// if validation passes
			if ($this->form_validation->run())
			{
				// edit company record
				$company = array(
					'id' 	=> $id,
					'cname' => $this->input->post('cname'),
					'tname' => $this->input->post('tname'),
					'ccode' => $this->input->post('ccode'),
					'user' 	=> $user['login']
				);
				$this->company_model->update($company);
				
				$this->view($this->cdmhelper->set_success_msg('Company detail changed.'));
			}
			else
			{
				$this->load->view('templates/header', $data);
				$this->load->view('company/edit', $id, $data);
				$this->load->view('templates/footer');
			}
		}
	}
	
	public function delete($id_hash)
	{
		log_message('info', 'Deleting user record.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// decode company id
		$temp = $this->hashids->decode($id_hash);
		$id = $temp[0];
		
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		
		if ($id == 20000001) {
			$this->view($this->cdmhelper->set_error_msg('Owner Company cannot be deleted.'));
		}
		else
		{
			$company = array(
				'id' 	=> $id,
				'user' 	=> $user['login']
			);
			$this->company_model->hide($company);
			
			$this->view($this->cdmhelper->set_success_msg('Company deleted.'));
		}
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