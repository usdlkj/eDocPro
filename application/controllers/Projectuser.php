<?php
class Projectuser extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('project_user_model');
		$this->load->helper('url_helper');
		$this->load->library('cdmhelper');
		$this->load->library('hashids');
	}

	public function view($id_hash, $message = NULL)
	{
		log_message('info', 'Viewing project user list.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// set data variable for views
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$data = $this->set_data($user, $message);
		$temp = $this->hashids->decode($id_hash);
		$project_id = $temp[0];
		
		$data['title'] 		= 'View Project Users';
		$data['id_hash']	= $id_hash;
		$data['users']		= $this->project_user_model->get_project_users($project_id);
		$data['prj_id'] 	= $project_id;
		
		// load views
		$this->load->view('templates/header', $data);
		$this->load->view('projectuser/view', $data);
		$this->load->view('templates/footer');
	}
	
	public function create($id_hash)
	{
		log_message('info', 'Adding project user.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// set data variable for views
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$data = $this->set_data($user);
		$temp = $this->hashids->decode($id_hash);
		$project_id = $temp[0];
		
		$data['title'] 		= 'Add User';
		$data['id_hash']	= $id_hash;
		$data['users']		= $this->project_user_model->get_users_not_in_project($project_id);
		
		if (count($data['users']) == 0) {
			$this->view($id_hash, $this->cdmhelper->set_error_msg('All user added.'));
		}
		else
		{
			// load form and form validation
			$this->load->helper('form');
			$this->load->library('form_validation');
			
			$config = array(
				array(
					'field' => 'user', 
					'label' => 'User', 
					'rules' => 'required'
				)
			);
			$this->form_validation->set_rules($config);
			
			// if validation passes
			if ($this->form_validation->run())
			{
				// create project user record
				$project_user = array(
					'project_id' 	=> $project_id,
					'user_id'		=> $this->input->post('user')
				);
				$this->project_user_model->create($project_user);
				
				$this->view($this->hashids->encode($project_id), $this->cdmhelper->set_success_msg('User added.'));
			}
			else
			{
				// load create views
				$this->load->view('templates/header', $data);
				$this->load->view('projectuser/create', $data);
				$this->load->view('templates/footer');
			}
		}
	}
	
	public function delete($id_hash)
	{
		log_message('info', 'Removing project user.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// convert id hash
		$temp = $this->hashids->decode($id_hash);
		
		$this->project_user_model->delete(array('project_id' => $temp[0], 'user_id' => $temp[1]));
		
		$this->view($this->hashids->encode($temp[0]), $this->cdmhelper->set_success_msg('User removed.'));
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