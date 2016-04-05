<?php
class Project extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('project_model');
		$this->load->model('project_user_model');
		$this->load->model('project_field_model');
		$this->load->model('user_model');
		$this->load->helper('url_helper');
		$this->load->library('cdmhelper');
		$this->load->library('hashids');
	}

	public function view($message = NULL)
	{
		log_message('info', 'Viewing project records.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// set data variable for views
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$data = $this->set_data($user, $message);
		
		$data['projects_list'] 	= $this->project_model->read();
		$data['title'] 			= 'View Projects';
		
		// load views
		$this->load->view('templates/header', $data);
		$this->load->view('project/view', $data);
		$this->load->view('templates/footer');
	}
	
	public function create($message = NULL)
	{
		log_message('info', 'Creating project record.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// load form and form validation
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$config = array(
			array(
				'field' => 'pname', 
				'label' => 'Project Name', 
				'rules' => 'required'
			),
			array(
				'field' => 'pcode', 
				'label' => 'Project Code', 
				'rules' => 'required|max_length[8]|alpha_numeric'
			)
		);
		$this->form_validation->set_rules($config);
		
		// set data variable for views
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$data = $this->set_data($user, $message);
		
		$data['title'] 		= 'Create Project';
		
		// if validation passes
		if ($this->form_validation->run())
		{
			$this->project_model->trans_start();
			
			// create new project record
			$project = array(
				'pname' 		=> $this->input->post('pname'),
				'pcode' 		=> $this->input->post('pcode'),
				'desc' 			=> $this->input->post('desc'),
				'company_id' 	=> $user['company_id'],
				'user' 			=> $user['login']
			);
			$project_id = $this->project_model->create($project);
			
			// create project-user association
			$project_user = array(
				'project_id' 	=> $project_id,
				'user_id' 		=> $user['id']
			);
			$this->project_user_model->create($project_user);
			
			// create document code fields
			$this->create_field($project_id, 'doccode', 2, 'Document Code', 1, 1);
			$this->create_field($project_id, 'doctitle', 2, 'Document Title', 1, 2);
			$this->create_field($project_id, 'revision', 1, 'Revision', 1, 3);
			$this->create_field($project_id, 'doctype', 5, 'Document Type', 1, 4);
			$this->create_field($project_id, 'docstatus', 5, 'Document Status', 1, 5);
			$this->create_field($project_id, 'discipline', 6, 'Discipline', 0, 6);
			$this->create_field($project_id, 'revdate', 4, 'Revision Date', 0, 7);
			
			// set current user's current project
			$user['current_project_id'] = $project_id;
			$this->user_model->set_current_project($user);
			
			$this->project_model->trans_complete();
			
			$this->view($this->cdmhelper->set_success_msg('Project created.'));
		}
		else
		{
			$this->load->view('templates/header', $data);
			$this->load->view('project/create', $data);
			$this->load->view('templates/footer');
		}
	}
	
	public function edit($id_hash, $message = NULL)
	{
		log_message('info', 'Editing project record.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// load form and form validation
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$config = array(
			array(
				'field' => 'pname', 
				'label' => 'Project Name', 
				'rules' => 'required'
			),
			array(
				'field' => 'pcode', 
				'label' => 'Project Code', 
				'rules' => 'required|max_length[8]|alpha_numeric'
			)
		);
		$this->form_validation->set_rules($config);
		
		// decode project id
		$temp = $this->hashids->decode($id_hash);
		$project_id = $temp[0];
		
		// set data variable for views
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$data = $this->set_data($user, $message);
		
		$data['id_hash'] 	= $id_hash;
		$data['project'] 	= $this->project_model->get_project_by_id($project_id);
		$data['title'] 		= 'Edit Project';
		
		// if validation passes
		if ($this->form_validation->run())
		{
			$this->project_model->trans_start();
			
			// edit project record
			$project = array(
				'id' 			=> $project_id,
				'pname' 		=> $this->input->post('pname'),
				'pcode' 		=> $this->input->post('pcode'),
				'desc' 			=> $this->input->post('desc'),
				'owner_com_id' 	=> $data['project']['owner_com_id'],
				'user' 			=> $user['login']
			);
			$this->project_model->update($project);
			
			// set current project id to 0
			$user['current_project_id'] = $project_id;
			$this->user_model->set_current_project($user);
			
			$this->project_model->trans_complete();
			
			$this->view($this->cdmhelper->set_success_msg('Project detail changed.'));
		}
		else
		{
			$this->load->view('templates/header', $data);
			$this->load->view('project/edit', $id_hash, $data);
			$this->load->view('templates/footer');
		}
	}
	
	public function delete($id_hash)
	{
		log_message('info', 'Deleting project record.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// decode project id
		$temp = $this->hashids->decode($id_hash);
		$id = $temp[0];
		
		$this->project_model->trans_start();
		
		// hides project
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$project = array(
			'id' 	=> $id,
			'user' 	=> $user['login']
		);
		
		$this->project_model->hide($project);
		
		// set current project id to 0
		$user['current_project_id'] = 0;
		$this->user_model->set_current_project($user);
		
		$this->project_model->trans_complete();
		
		$this->view($this->cdmhelper->set_success_msg('Project deleted.'));
	}
	
	// function: create new project field
	function create_field($project_id, $field_code, $field_type, $field_text, $mandatory, $sequence)
	{
		// create document code field
		$doc_field = array(
			'project_id' 	=> $project_id,
			'field_code'	=> $field_code,
			'field_type'	=> $field_type,
			'field_text'	=> $field_text,
			'visible'		=> 1,
			'mandatory'		=> $mandatory,
			'sequence'		=> $sequence
		);
		$this->project_field_model->create($doc_field);
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