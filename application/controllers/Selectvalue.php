<?php
class Selectvalue extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('select_value_model');
		$this->load->model('user_model');
		$this->load->model('project_user_model');
		$this->load->model('project_field_model');
		$this->load->helper('url_helper');
		$this->load->library('cdmhelper');
		$this->load->library('hashids');
	}

	public function view($id_hash, $message = NULL)
	{
		log_message('info', 'Viewing project fields.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// decode field id
		$temp = $this->hashids->decode($id_hash);
		$field_id = $temp[0];
		$field = $this->project_field_model->get_by_id($field_id);
		
		// set data variable for views
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$data = $this->set_data($user, $message);
		
		$data['title'] 		= 'View Field Selections';
		$data['values'] 	= $this->select_value_model->get_by_field_id($field_id);
		$data['id_hash']	= $id_hash;
		$data['id_hash2']	= $this->hashids->encode($field['project_id']);
		
		// load views
		$this->load->view('templates/header', $data);
		$this->load->view('selectvalue/view', $data);
		$this->load->view('templates/footer');
	}
	
	public function create($id_hash, $message = NULL)
	{
		log_message('info', 'Creating project field.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// decode project id
		$temp = $this->hashids->decode($id_hash);
		$field_id = $temp[0];
		
		// load form and form validation
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$config = array(
			array(
				'field' => 'value_code', 
				'label' => 'Field Value Code', 
				'rules' => 'required|alpha_numeric'
			),
			array(
				'field' => 'value_text', 
				'label' => 'Field Value Text', 
				'rules' => 'required'
			)
		);
		$this->form_validation->set_rules($config);
		
		// set data variable for views
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$data = $this->set_data($user, $message);
		
		$data['title'] 		= 'Create Field Selection';
		$data['id_hash']	= $id_hash;
		
		// if validation passes
		if ($this->form_validation->run())
		{
			$value = array(
				'field_id' 		=> $field_id,
				'project_id'	=> $user['current_project_id'],
				'value_code' 	=> strtolower($this->input->post('value_code')),
				'value_text' 	=> $this->input->post('value_text')
			);
			$this->select_value_model->create($value);
			
			
			$success = 'Selection added.';
			$this->view($id_hash, $this->cdmhelper->set_success_msg($success));
		}
		
		// load create view
		if (!isset($success))
		{
			$this->load->view('templates/header', $data);
			$this->load->view('selectvalue/create', $data);
			$this->load->view('templates/footer');
		}
	}
	
	public function delete($id_hash)
	{
		log_message('info', 'Deleting project field.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// decode field id
		$temp = $this->hashids->decode($id_hash);
		$value_id = $temp[0];
		
		$value = $this->select_value_model->get_by_value_id($value_id);
		$this->select_value_model->delete($value_id);
		$this->view($this->hashids->encode($value['field_id']), $this->cdmhelper->set_success_msg('Selection deleted.'));
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