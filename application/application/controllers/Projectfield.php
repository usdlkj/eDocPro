<?php
class Projectfield extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('project_model');
		$this->load->model('project_field_model');
		$this->load->model('project_user_model');
		$this->load->model('user_model');
		$this->load->helper('url_helper');
		$this->load->library('cdmhelper');
		$this->load->library('hashids');
	}

	public function view($id_hash, $message = NULL)
	{
		log_message('info', 'Viewing project fields.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// decode project id
		$temp = $this->hashids->decode($id_hash);
		$project_id = $temp[0];
		
		// set data variable for views
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$data = $this->set_data($user, $message);
		
		$data['title'] 		= 'View Projects Fields';
		$data['fields'] 	= $this->project_field_model->get_by_project_id($project_id);
		$data['id_hash']	= $id_hash;
		
		// load views
		$this->load->view('templates/header', $data);
		$this->load->view('projectfield/view', $data);
		$this->load->view('templates/footer');
	}
	
	public function create($id_hash, $message = NULL)
	{
		log_message('info', 'Creating project field.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// decode project id
		$temp = $this->hashids->decode($id_hash);
		$project_id = $temp[0];
		
		// load form and form validation
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$config = array(
			array(
				'field' => 'field_code', 
				'label' => 'Field Code', 
				'rules' => 'required|alpha_dash'
			),
			array(
				'field' => 'field_type', 
				'label' => 'Field Type', 
				'rules' => 'required'
			),
			array(
				'field' => 'field_text', 
				'label' => 'Display Text', 
				'rules' => 'required'
			)
		);
		$this->form_validation->set_rules($config);
		
		// set data variable for views
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$data = $this->set_data($user, $message);
		
		$data['title'] 		= 'Create Field';
		$data['id_hash']	= $id_hash;
		$fields = $this->project_field_model->get_by_project_id($project_id);
		$data['fields']		= count($fields) + 1;
		
		// if validation passes
		if ($this->form_validation->run())
		{
			$new_field = array(
				'project_id' 	=> $project_id,
				'field_code' 	=> strtolower($this->input->post('field_code')),
				'field_type' 	=> $this->input->post('field_type'),
				'field_text' 	=> $this->input->post('field_text'),
				'visible'		=> $this->input->post('visible') == NULL ? 0 : 1,
				'mandatory' 	=> $this->input->post('mandatory') == NULL ? 0 : 1,
				'sequence'		=> $this->input->post('sequence')
			);
			
			$this->project_model->trans_start();
			$this->project_field_model->create($new_field);
			$this->project_model->trans_complete();
			
			$success = 'Field added.';
			$this->view($id_hash, $this->cdmhelper->set_success_msg($success));
		}
		
		// load create view
		if (!isset($success))
		{
			$this->load->view('templates/header', $data);
			$this->load->view('projectfield/create', $data);
			$this->load->view('templates/footer');
		}
	}
	
	public function edit($id_hash, $message = NULL)
	{
		log_message('info', 'Editing project field.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// decode field id
		$temp = $this->hashids->decode($id_hash);
		$field_id = $temp[0];
		
		// load form and form validation
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$config = array(
			array(
				'field' => 'field_text', 
				'label' => 'Display Text', 
				'rules' => 'required'
			)
		);
		$this->form_validation->set_rules($config);
		
		// set data variable for views
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$data = $this->set_data($user, $message);
			
		$data['id_hash'] 	= $id_hash;
		$data['title'] 		= 'Edit Field';
		$field = $this->project_field_model->get_by_id($field_id);
		$data['field'] = $field;
		$fields = $this->project_field_model->get_by_project_id($field['project_id']);
		$data['fields']		= count($fields);
		
		// if validation passes
		if ($this->form_validation->run())
		{
			$field = $this->project_field_model->get_by_id($field['id']);
			$field['field_text'] 	= $this->input->post('field_text');
			$field['visible'] 		= $this->input->post('visible') == NULL ? 0 : 1;
			$field['mandatory'] 	= $this->input->post('mandatory') == NULL ? 0 : 1;
			$field['sequence']		= $this->input->post('sequence');
			
			$this->project_model->trans_start();
			$fields2 = $this->project_field_model->update_sequence($field);
			$this->project_model->trans_complete();
			
			$success = 'Field changed.';
			$this->view($this->hashids->encode($field['project_id']), $this->cdmhelper->set_success_msg($success));
		}
		else
		{
			$this->load->view('templates/header', $data);
			$this->load->view('projectfield/edit', $id_hash, $data);
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
		$field_id = $temp[0];
		
		$field = $this->project_field_model->get_by_id($field_id);
		if ($field['field_code'] == 'doccode')
		{
			$this->view($this->hashids->encode($field['project_id']), $this->cdmhelper->set_error_msg('Field Document Code cannot be deleted.'));
		}
		else
		{
			$this->project_model->trans_start();
			$this->project_field_model->delete($field);
			$this->project_model->trans_complete();
			$this->view($this->hashids->encode($field['project_id']), $this->cdmhelper->set_success_msg('Field deleted.'));
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