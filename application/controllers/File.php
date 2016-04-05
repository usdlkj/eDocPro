<?php
class File extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('file_model');
		$this->load->model('project_user_model');
		$this->load->helper('url_helper');
		$this->load->library('cdmhelper');
		$this->load->library('hashids');
	}

	public function view($message = NULL)
	{
		log_message('info', 'Viewing file records.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// set data variable for views
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$data = $this->set_data($user, $message);
		
		$data['file'] = $this->file_model->read();
		$data['title'] = 'View Files';
		
		// load views
		$this->load->view('templates/header', $data);
		$this->load->view('file/view', $data);
		$this->load->view('templates/footer');
	}
	
	public function create($message = NULL)
	{
		log_message('info', 'Creating file record.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// load form and form validation
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('file_to_upload', 'File', 'required');
		
		// set data variable for views
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$data = $this->set_data($user, $message);
		
		$data['title'] = 'Upload File';
		
		// load views
		$this->load->view('templates/header', $data);
		$this->load->view('file/create');
		$this->load->view('templates/footer');
	}
	
	function do_upload()
	{
		log_message('info', 'Uploading file.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		$config['upload_path'] = './public/upload';
		$config['allowed_types'] = '*';

		$this->load->library('upload', $config);

		if ($this->upload->do_upload('userfile'))
		{
			$data = array('upload_data' => $this->upload->data());
			
			// get file hash
			$tmp_file = $data['upload_data']['full_path'];
			$filehash = md5_file($tmp_file);
			$target_file = './public/filestore/' . $filehash . "." . $data['upload_data']['file_ext'];
			rename ($tmp_file, $target_file);
			
			// insert new file record
			$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
			$newfile = array(
				'file_hash' => $filehash,
				'file_name' => $data['upload_data']['file_name'],
				'file_loc' 	=> $target_file,
				'file_size' => $data['upload_data']['file_size'],
				'file_ext' 	=> $data['upload_data']['file_ext'],
				'user' 		=> $user['login']
			);
			$this->file_model->create($newfile);
			
			$this->view($this->cdmhelper->set_success_msg('File uploaded.'));
		}
		else
		{
			$this->load->view('templates/header', $data);
			$this->load->view('file/create', $data);
			$this->load->view('templates/footer');
		}
	}
	public function download($id_hash)
	{
		log_message('info', 'Downloading file.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
	
		// get file info
		$temp = $this->hashids->decode($id_hash);
		$file_id = $temp[0];
		$file = $this->file_model->get_file_by_id($file_id);
		
		$this->load->helper('download');
		$data = file_get_contents($file['file_loc']); // Read the file's contents
		force_download($file['file_name'], $data);
	}
	
	public function delete($id_hash)
	{
		log_message('info', 'Deleting file record.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		$temp = $this->hashids->decode($id_hash);
		$file_id = $temp[0];
	
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$file = array(
			'id' 	=> $file_id,
			'user' 	=> $user['login']
		);
		
		$this->file_model->hide($file);
		
		$this->view($this->cdmhelper->set_success_msg('File deleted.'));
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