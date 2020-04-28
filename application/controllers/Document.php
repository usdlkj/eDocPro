<?php
class Document extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('document_model');
		$this->load->model('document_field_model');
		$this->load->model('document_access_model');
		$this->load->model('project_model');
		$this->load->model('project_user_model');
		$this->load->model('project_field_model');
		$this->load->model('select_value_model');
		$this->load->model('file_model');
		$this->load->helper('url_helper');
		$this->load->library('cdmhelper');
		$this->load->library('hashids');
	}

	public function view($id_hash, $message = NULL)
	{
		log_message('info', 'Viewing latest version documents.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// get the project id from the hash
		$temp = $this->hashids->decode($id_hash);
		$project_id = $temp[0];
		$project = $this->project_model->get_project_by_id($project_id);
		if ($project['deleted_by']) {
			$project_id = 0;
		}
		
		// set current project id
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$user['current_project_id'] = $project_id;
		$this->user_model->set_current_project($user);
		
		// set data variable for views
		$data = $this->set_data($user, $message);
		
		if ($project_id == 0) {
			$data['message'] = $this->cdmhelper->set_error_msg('There is no project selected.');
		}
		
		$data['title'] 		= 'Viewing Documents';
		$data['id_hash'] 	= $this->hashids->encode($project_id);
		$data['id_hash2']	= $this->hashids->encode($project_id, $user['company_id']);
		$data['fields'] 	= $this->project_field_model->get_visible_fields_by_project_id($project_id);
		$data['selections']	= $this->select_value_model->get_by_project_id($project_id);
		
		// load views
		$this->load->view('templates/header', $data);
		$this->load->view('document/view', $data);
		$this->load->view('templates/footer');	
	}
	
	public function create($id_hash, $message = NULL)
	{
		log_message('info', 'Creating document record.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// decode project id
		$temp = $this->hashids->decode($id_hash);
		$project_id = $temp[0];
		$fields = $this->project_field_model->get_visible_fields_by_project_id($project_id);
		
		// load form validation
		$this->load_validations($fields);
		
		// set upload config
		$config['upload_path'] = './public/upload';
		$config['allowed_types'] = '*';
		$this->load->library('upload', $config);
		
		// set data variable for views
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$data = $this->set_data($user, $message);
		
		$data['title'] 		= 'Upload Document';
		$data['fields'] 	= $fields;
		$data['id_hash']	= $id_hash;
		$data['selections']	= $this->select_value_model->get_by_project_id($user['current_project_id']);
		
		// if submit event and passes validation, create document
		if ($this->form_validation->run()) 
		{
			$this->create_document($project_id, $fields, $user);
			$this->view($id_hash, $this->cdmhelper->set_success_msg('Document uploaded.'));
		}
		// else load 'create' view
		else
		{
			$this->load->view('templates/header', $data);
			$this->load->view('document/create', $data);
			$this->load->view('templates/footer');
		}
	}
	
	public function supersede($id_hash, $message = NULL)
	{
		log_message('info', 'Creating document record.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// decode document id
		$temp = $this->hashids->decode($id_hash);
		$document_id = $temp[0];
		$document = $this->document_model->get_document_by_id($document_id);
		$project_id = $document['project_id'];
		$fields = $this->project_field_model->get_visible_fields_by_project_id($project_id);
		
		// load form validation
		$this->load_validations($fields);
		
		// set upload config
		$config['upload_path'] = './public/upload';
		$config['allowed_types'] = '*';
		$this->load->library('upload', $config);
		
		// set data variable for views
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$data = $this->set_data($user, $message);
		$data = $this->set_document_data($data, $document_id, $user['current_project_id']);
		
		$data['title'] 		= 'Supersede Document';
		$data['id_hash']	= $id_hash;
		$data['selections']	= $this->select_value_model->get_by_project_id($user['current_project_id']);
		
		// if submit event and passes validation, create document
		if ($this->form_validation->run())
		{
			$this->create_document($project_id, $fields, $user);
			$this->view($this->hashids->encode($project_id), $this->cdmhelper->set_success_msg('Document superseded.'));
		}
		// else load 'supersede' view
		else
		{
			$this->load->view('templates/header', $data);
			$this->load->view('document/supersede', $data);
			$this->load->view('templates/footer');
		}
	}
	
	public function detail($id_hash)
	{
		log_message('info', 'Viewing document record.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// decode project id
		$temp = $this->hashids->decode($id_hash);
		$document_id = $temp[0];
		
		// set data variable for views
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$data = $this->set_data($user);
		$data = $this->set_document_data($data, $document_id, $user['current_project_id']);
		
		$data['title'] 		= 'Document Detail';
		$data['selections']	= $this->select_value_model->get_by_project_id($user['current_project_id']);
		$data['id_hash']	= $id_hash;
		
		// load create view
		$this->load->view('templates/header', $data);
		$this->load->view('document/detail', $data);
		$this->load->view('templates/footer');
	}
	
	// This function call from AJAX
	public function ajax_latest_docs($id_hash) 
	{
		// get the project id from the hash
		$temp = $this->hashids->decode($id_hash);
		$project_id = $temp[0];
		$company_id = $temp[1];
		
		$documents = $this->document_model->get_documents_by_com_id($project_id, $company_id, false);
		$data = array();
		
		foreach ($documents as $document)
		{
			$fields = $this->project_field_model->get_visible_fields_by_project_id($project_id);
			$new_row = array();
			
			if ($document['file_id'] == null) {
				$new_row[] = '<button type="button" class="btn btn-xs"><span class="cil-chevron-circle-down-alt btn-icon"></span></button>&nbsp;<a href="'.site_url(array('document','detail',$this->hashids->encode($document['id']))).'" data-toggle="tooltip" title="Document Detail"><button type="button" class="btn btn-primary btn-xs"><span class="cil-file btn-icon"></span></button></a>';
			}
			else {
				$new_row[] = '<a href="'.site_url(array('file','download',$this->hashids->encode($document['file_id']))).'" data-toggle="tooltip" title="Download File"><button type="button" class="btn btn-success btn-xs"><span class="cil-chevron-circle-down-alt btn-icon"></span></button></a>&nbsp;<a href="'.site_url(array('document','detail',$this->hashids->encode($document['id']))).'" data-toggle="tooltip" title="Document Detail"><button type="button" class="btn btn-primary btn-xs"><span class="cil-file btn-icon"></span></button></a>';
			}
			
			foreach ($fields as $field) 
			{
				$value = $this->document_field_model->get_field_value($document['id'], $field['field_code']);
				if (count($value) > 0)
				{
					log_message('debug','controller.document.ajax_latest_docs.$value[0][\'field_value\']'.$value[0]['field_value']);
					if ($field['field_type'] == 5)
					{
						$select = $this->select_value_model->get_by_value_id($value[0]['field_value']);
						$new_row[] = $select['value_text'];
					}
					elseif ($field['field_type'] == 6)
					{
						$select_ids = explode(',', $value[0]['field_value']);
						$select_values = array();
						foreach ($select_ids as $select_id)
						{
							$select_value = $this->select_value_model->get_by_value_id($select_id);
							$select_values[] = $select_value['value_text'];
						}
						$new_row[] = implode(', ', $select_values);
					}
					else
					{
						$new_row[] = $value[0]['field_value'];
					}
				}
			}
			
			$data[] = $new_row;
		}
		
		
		$json_data = array(
			"draw"            => 1,
			"recordsTotal"    => count($data),
			"recordsFiltered" => count($data),
			"data"            => $data
		);

		// Either you can print value or you can send value to database
		echo json_encode($json_data);
	}
	
	// This function call from AJAX
	public function ajax_all_docs($id_hash) 
	{
		// get the project id from the hash
		$temp = $this->hashids->decode($id_hash);
		$project_id = $temp[0];
		$company_id = $temp[1];
		
		$documents = $this->document_model->get_documents_by_com_id($project_id, $company_id, true);
		$data = array();
		
		foreach ($documents as $document)
		{
			$fields = $this->project_field_model->get_visible_fields_by_project_id($project_id);
			$new_row = array();
			
			if ($document['file_id'] == null) {
				$new_row[] = '<button type="button" class="btn btn-xs"><span class="cil-download btn-icon"></span></button>&nbsp;<a href="'.site_url(array('document','detail',$this->hashids->encode($document['id']))).'" data-toggle="tooltip" title="Document Detail"><button type="button" class="btn btn-primary btn-xs"><span class="cil-file btn-icon"></span></button></a>';
			}
			else {
				$new_row[] = '<a href="'.site_url(array('file','download',$this->hashids->encode($document['file_id']))).'" data-toggle="tooltip" title="File"><button type="button" class="btn btn-success btn-xs"><span class="cil-chevron-circle-down-alt btn-icon"></span></button></a>&nbsp;<a href="'.site_url(array('document','detail',$this->hashids->encode($document['id']))).'" data-toggle="tooltip" title="Document Detail"><button type="button" class="btn btn-primary btn-xs"><span class="cil-file btn-icon"></span></button></a>';
			}
			
			foreach ($fields as $field) 
			{
				$value = $this->document_field_model->get_field_value($document['id'], $field['field_code']);
				if (count($value) > 0)
				{
					if ($field['field_type'] == 5)
					{
						$select = $this->select_value_model->get_by_value_id($value[0]['field_value']);
						if ($document['is_latest']) {
							$new_row[] = '<strong>'.$select['value_text'].'</strong>';
						}
						else {
							$new_row[] = $select['value_text'];
						}
					}
					elseif ($field['field_type'] == 6)
					{
						$select_ids = explode(',', $value[0]['field_value']);
						$select_values = array();
						foreach ($select_ids as $select_id)
						{
							$select_value = $this->select_value_model->get_by_value_id($select_id);
							$select_values[] = $select_value['value_text'];
						}
						
						if ($document['is_latest']) {
							$new_row[] = '<strong>'.implode(', ', $select_values).'</strong>';
						}
						else {
							$new_row[] = implode(', ', $select_values);
						}
					}
					else
					{
						if ($document['is_latest']) {
							$new_row[] = '<strong>'.$value[0]['field_value'].'</strong>';
						}
						else {
							$new_row[] = $value[0]['field_value'];
						}
					}
				}
			}
			
			$data[] = $new_row;
		}
		
		
		$json_data = array(
			"draw"            => 1,
			"recordsTotal"    => count($data),
			"recordsFiltered" => count($data),
			"data"            => $data
		);

		// Either you can print value or you can send value to database
		echo json_encode($json_data);
	}
	
	// function: custom selection for select validation callback
	function selected($field)
	{	
		if ($field == '0')
		{	
			$this->form_validation->set_message('selected', 'The %s field is required.');
			return FALSE;
		}
		return TRUE;
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
	
	// function: set document data for supersede and detail pages
	function set_document_data($data, $document_id, $project_id)
	{
		// set file info in var data
		$document = $this->document_model->get_document_by_id($document_id);
		$data['file_id'] = $document['file_id'];
		if ($document['file_id'] > 0)
		{
			$file = $this->file_model->get_file_by_id($document['file_id']);
			$data['file_name'] = $file['file_name'];
		}
		
		// get all fields for the project
		$fields = $this->project_field_model->get_visible_fields_by_project_id($project_id);
		
		// get all document meta data
		$values = $this->document_field_model->get_field_values($document_id);
		
		// for each field match it with the document meta data
		$count = count($fields);
		for ($i = 0; $i < $count; $i++)
		{
			foreach ($values as $value)
			{
				if ($fields[$i]['field_code'] == $value['field_code'])
				{
					if ($fields[$i]['field_type'] == 6) {
						$fields[$i]['field_value'] = explode(',',$value['field_value']);
					}
					else {
						$fields[$i]['field_value'] = $value['field_value'];
					}
					break;
				}
			}
		}
		
		// set fields info into var data
		$data['fields']	= $fields;
		
		return $data;
	}
	
	// function: load validations for use in create and supersede pages
	function load_validations($fields)
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	
		// for each field, set the required rule as per info in fields table
		foreach ($fields as $field)
		{
			if ($field['mandatory'])
			{
				if ($field['field_type'] == 5 || $field['field_type'] == 6) {
					$this->form_validation->set_rules($field['field_code'], $field['field_text'], 'callback_selected');
				}
				else {
					$this->form_validation->set_rules($field['field_code'], $field['field_text'], 'required');
				}
			}
		}
	}
	
	// function: create documents for use in create and supersede pages
	function create_document($project_id, $fields, $user)
	{
		$this->project_model->trans_start();
			
		// upload file
		$file_id = null;
		if ($this->upload->do_upload('userfile'))
		{
			$file_data = $this->upload->data();
			
			// get file hash
			$temp_file = $file_data['full_path'];
			log_message('debug','controller.document.create_document.$temp_file: '.$temp_file);
			$file_hash = md5_file($temp_file);
			$target_file = './public/filestore/'.$file_hash.".".$file_data['file_ext'];
			if (file_exists($target_file)) {
				unlink($temp_file);
			}
			else {
				rename($temp_file, $target_file);
			}
			
			// insert new file record
			$file = array(
				'file_hash' => $file_hash,
				'file_name' => $file_data['file_name'],
				'file_loc' 	=> $target_file,
				'file_size' => $file_data['file_size'],
				'file_ext' 	=> $file_data['file_ext'],
				'user' 		=> $user['login']
			);
			
			$file_id = $this->file_model->create($file);
		}	
		
		// insert new document record
		$document = array(
			'doc_code'		=> $this->input->post('doccode'),
			'project_id' 	=> $project_id,
			'file_id'		=> $file_id,
			'user' 			=> $user['login']
		);
		$doc_id = $this->document_model->create($document);
		
		// insert document fields record
		foreach ($fields as $field)
		{
			$doc_field['document_id'] 	= $doc_id;
			$doc_field['field_code']	= $field['field_code'];
			if ($field['field_type'] == 6)
			{
				if ($this->input->post($field['field_code'])) 
				{
					$doc_field['field_value'] = implode(',',$this->input->post($field['field_code']));
					$this->document_field_model->create($doc_field);
				}
			}
			else 
			{
				$doc_field['field_value'] = $this->input->post($field['field_code']);
				$this->document_field_model->create($doc_field);
			}
		}
		
		// create document access permission
		$access = array(
			'document_id' 	=> $doc_id,
			'company_id' 	=> $user['company_id']
		);
		$this->document_access_model->create($access);
		
		$this->project_model->trans_complete();
	}
}