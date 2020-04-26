<?php
class Mail extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mail_model');
		$this->load->model('mail_type_model');
		$this->load->model('mail_recipient_model');
		$this->load->model('mail_attachment_model');
		$this->load->model('user_model');
		$this->load->model('company_model');
		$this->load->model('document_model');
		$this->load->model('document_field_model');
		$this->load->model('document_access_model');
		$this->load->model('project_model');
		$this->load->model('project_field_model');
		$this->load->model('project_user_model');
		$this->load->model('select_value_model');
		$this->load->helper('url_helper');
		$this->load->library('cdmhelper');
		$this->load->library('hashids');
	}

	public function view($id_hash, $message = NULL)
	{
		log_message('info', 'Viewing mail records.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// set data variable for views
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$data = $this->set_data($user, $message);
		
		$data['title'] 		= 'Read Mails';
		$data['id_hash']	= $id_hash;
		$data['mails']		= $this->mail_model->read();
		
		// load views
		$this->load->view('templates/header', $data);
		$this->load->view('mail/view', $data);
		$this->load->view('templates/footer');
	}
	
	public function inbox($id_hash, $message = NULL)
	{
		log_message('info', 'Viewing inbox mails.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// set data variable for views
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$data = $this->set_data($user, $message);
		
		// set mail data
		$data['title'] = 'Mail Inbox';
		$mails = $this->mail_model->get_inbox_mails($user['company_id']);
		$this->set_mail_data($data, $id_hash, $mails);
	}
	
	public function sent($id_hash, $message = NULL)
	{
		log_message('info', 'Viewing sent mails.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// set data variable for views
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$data = $this->set_data($user, $message);
		
		// set mail data
		$data['title'] 		= 'Sent Mail';
		$mails = $this->mail_model->get_sent_mails($user['company_id']);
		$this->set_mail_data($data, $id_hash, $mails);
	}
	
	public function create($id_hash)
	{
		log_message('info', 'Sending mail.');
		
		$temp = $this->hashids->decode($id_hash);
		
		$temp = $this->hashids->decode($id_hash);
		$project_id = $temp[0];
		
		// set data variable for views
		session_start();
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$data = $this->set_data($user);
		$data['title'] 		= 'Send Mail';
		$data['id_hash']	= $id_hash;
		$data['id_hash2'] 	= $this->hashids->encode($project_id, $user['company_id']);
		
		// call the create mail function
		$this->create_mail($user, $project_id, null, null, 1,  $data, $id_hash);
	}
	
	public function reply($id_hash)
	{
		log_message('info', 'Replying mail.');
		
		$temp = $this->hashids->decode($id_hash);
		$project_id = $temp[0];
		$mail_id = $temp[1];
		$mail = $this->mail_model->get_by_mail_id($mail_id);
		
		// set data variable for views
		session_start();
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$data = $this->set_data($user);
		$data['title'] 		= 'Reply Mail';
		$data['subject']	= 'Re: '.$mail['subject'];
		$data['sender_id']	= $mail['sender_id'];
		$data['body']	= $mail['message'];
		$data['id_hash']	= $id_hash;
		
		// call the create mail function
		$this->create_mail($user, $project_id, $mail['thread_starter_id'], $mail_id, 2, $data, $id_hash);
	}
	
	public function forward($id_hash)
	{
		log_message('info', 'Forwarding mail.');
		
		$temp = $this->hashids->decode($id_hash);
		$project_id = $temp[0];
		$mail_id = $temp[1];
		$mail = $this->mail_model->get_by_mail_id($mail_id);
		
		// set data variable for views
		session_start();
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$data = $this->set_data($user);
		$data['title'] 		= 'Forward Mail';
		$data['subject']	= 'Fw: '.$mail['subject'];
		$data['body']	= $mail['message'];
		$data['id_hash']	= $id_hash;
		
		// call the create mail function
		$this->create_mail($user, $project_id, $mail['thread_starter_id'], $mail_id, 3, $data, $id_hash);
	}
	
	public function detail($id_hash)
	{
		log_message('info', 'Viewing mail detail.');
		
		// check if login is valid
		$this->cdmhelper->check_login();
		
		// set data variable for views
		$user = $this->user_model->get_user_by_id($_SESSION['user_id']);
		$data = $this->set_data($user);
		$temp = $this->hashids->decode($id_hash);
		$project_id = $temp[0];
		$mail_id = $temp[1];
		$mail = $this->mail_model->get_by_mail_id($mail_id);
		
		$data['title'] 			= 'Read Mail';
		$data['id_hash']		= $this->hashids->encode($project_id);
		$data['id_hash2']		= $id_hash;
		$data['recipients']		= $this->mail_recipient_model->get_recipients($mail_id);
		$data['attachments']	= $this->mail_attachment_model->get_attachments($mail_id);
		$data['mail']			= $mail;
		
		$mails = $this->mail_model->get_inbox_mails($user['company_id']);
		$count_mails = count($mails);
		for ($i = 0; $i < $count_mails; $i++)
		{
			$temps = $this->mail_recipient_model->get_recipients($mails[$i]['id']);
			$recipients = array();
			foreach ($temps as $temp) {
				array_push($recipients, $temp['first_name']);
			}
			$mails[$i]['recipients'] = implode(', ', $recipients);
			$modified = new DateTime($mails[$i]['modified']);
			$mails[$i]['modified2'] = $modified->format('d/m/Y H:i:s');
		}
		
		$data['mails']			= $mails;
		
		// load form
		$this->load->helper('form');
		
		// load create views
		$this->load->view('templates/header', $data);
		$this->load->view('mail/detail', $data);
		$this->load->view('templates/footer');
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
	
	// function: set recipients
	function set_recipients($input, $user_type, $mail_id)
	{
		$recipients = $this->input->post($input);
		
		if (count($recipients) == 0) return;
		
		foreach ($recipients as $recipient)
		{
			$new_recipient = array(
				'mail_id' 	=> $mail_id,
				'user_id' 	=> $recipient,
				'user_type' => $user_type
			);
			
			$this->mail_recipient_model->create($new_recipient);
			
			// set document access for transmittals
			$attachments = $this->input->post('attachments');
			$user = $this->user_model->get_user_by_id($recipient);
			$att_count = count($attachments) - 1;
			for ($i = 0; $i < $att_count; $i++)
			{
				$attachment = $attachments[$i];
				
				// create document access
				$doc_access = array(
					'company_id'	=> $user['company_id'],
					'document_id'	=> $attachment
				);
				$this->document_access_model->create($doc_access);
				
				// create mail attachment records
				$mail_attach = array(
					'mail_id'		=> $mail_id,
					'attachment_id'	=> $attachment
				);
				$this->mail_attachment_model->create($mail_attach);
			}
		}
	}
	
	// function: set mail data
	function set_mail_data($data, $id_hash, $mails)
	{
		$data['id_hash'] = $id_hash;
		$count_mails = count($mails);
		
		for ($i = 0; $i < $count_mails; $i++)
		{
			$temps = $this->mail_recipient_model->get_recipients($mails[$i]['id']);
			$recipients = array();
			foreach ($temps as $temp) {
				array_push($recipients, $temp['first_name']);
			}
			$mails[$i]['recipients'] = implode(', ', $recipients);
			$modified = new DateTime($mails[$i]['modified']);
			$mails[$i]['modified2'] = $modified->format('d/m/Y H:i:s');
		}
		$data['mails']		= $mails;
		
		// load views
		$this->load->view('templates/header', $data);
		$this->load->view('mail/view', $data);
		$this->load->view('templates/footer');
	}
	
	// function: create mail based on user, project id, thread starter id, previous mail id, create type, data array, id hash
	function create_mail($user, $project_id, $starter_id, $previous_id, $create_type, $data, $id_hash)
	{
		// check if login is valid
		$this->cdmhelper->check_login();
		
		$data['recipients']	= $this->project_user_model->get_project_users($project_id);
		$data['selections']	= $this->select_value_model->get_by_project_id($project_id);
		$data['mail_types']	= $this->mail_type_model->get_mail_types($project_id);
		
		// load form and form validation
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$config = array(
			array(
				'field' => 'subject', 
				'label' => 'Mail Subject', 
				'rules' => 'required'
			)
		);
		$this->form_validation->set_rules($config);
		
		$documents = $this->document_model->get_documents_by_com_id($project_id, $user['company_id'], $create_type > 1);
		$data['all_version'] = $create_type > 1;
		$doc_count = count($documents);
		for ($i = 0; $i < $doc_count; $i++)
		{
			$values = $this->document_field_model->get_field_values($documents[$i]['id']);
			foreach ($values as $value) {
				$documents[$i][$value['field_code']] = $value['field_value'];
			}
		}
		
		$data['documents'] 	= $documents;
		$data['fields'] 	= $this->project_field_model->get_by_project_id($project_id);
		
		// if validation passes
		if ($this->form_validation->run())
		{
			$this->project_model->trans_start();
			
			// get mail type code
			$mail_type_id = $this->input->post('mail_type');
			$mail_type = $this->mail_type_model->get_type_by_id($mail_type_id);
			
			// get company code
			$company = $this->company_model->get_company_by_id($user['company_id']);
			
			// update mail type code's last number
			$new_number = $this->mail_type_model->increment_number($mail_type);
			
			// set mail code
			$mail_code = strtoupper($company['company_code'].'-'.$mail_type['mail_code'].'-'.str_pad($new_number, 6, '0', STR_PAD_LEFT));
			
			
			// create mail
			$mail = array(
				'thread_starter_id'	=> $starter_id, 
				'previous_mail_id'	=> $previous_id,
				'mail_type_id'		=> $this->input->post('mail_type'),
				'project_id'		=> $project_id,
				'sender_id'			=> $user['id'],
				'mail_code'			=> $mail_code,
				'subject'			=> $this->input->post('subject'),
				'message'			=> $this->input->post('message'),
				'user' 				=> $user['login']
			);
			
			$mail_id = $this->mail_model->create($mail);
			
			// set mail recipients to
			$this->set_recipients('recipient_to', 1, $mail_id);
			
			// set mail recipients cc
			$this->set_recipients('recipient_cc', 2, $mail_id);
			
			// set mail recipients bcc
			$this->set_recipients('recipient_bcc', 3, $mail_id);
			
			$this->sent($id_hash, $this->cdmhelper->set_success_msg('Mail sent.'));
			
			$this->project_model->trans_complete();
		}
		else
		{
			// load create views
			$this->load->view('templates/header', $data);
			$this->load->view('mail/create', $data);
			$this->load->view('templates/footer');
		}
	}
}