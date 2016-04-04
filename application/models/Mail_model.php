<?php
class Mail_model extends CI_Model 
{
	public function __construct()
	{
		$this->load->database();
	}
	
	public function create($mail)
	{
		// get next id
		$query = $this->db->get_where('cdm_latest_number', array('table_name' => 'cdm_mail'));
		$result = $query->row_array();
		$id = intval($result['next_number']);
		
		if (!$mail['thread_starter_id']) {
			$mail['thread_starter_id'] = $id;
		}
		
		// set data to be entered into the table
		$data = array(
			'id'				=> $id,
			'thread_starter_id'	=> $mail['thread_starter_id'],
			'previous_mail_id'	=> $mail['previous_mail_id'],
			'mail_type_id'		=> $mail['mail_type_id'],
			'project_id'		=> $mail['project_id'],
			'sender_id'			=> $mail['sender_id'],
			'mail_code'			=> $mail['mail_code'],
			'mail_status'		=> 1,
			'subject'			=> $mail['subject'],
			'message'			=> $mail['message'],
			'created_by' 		=> $mail['user'],
			'modified_by' 		=> $mail['user']
		);
		$this->db->insert('cdm_mail', $data);
		
		// update latest number table
		$this->db->where('table_name', 'cdm_mail');
		$this->db->update('cdm_latest_number', array('next_number' => $id + 1));
		
		return $id;
	}
	
	public function read()
	{
		$query = $this->db->get('cdm_mail');
		return $query->result_array();
	}
	
	public function get_inbox_mails($company_id)
	{
		$this->db->select('mail_id');
		$this->db->from('cdm_mail_recipient');
		$this->db->join('cdm_user', 'cdm_mail_recipient.user_id = cdm_user.id');
		$this->db->group_by('mail_id');
		$this->db->group_by('company_id');
		$this->db->having('company_id', $company_id);
		$query = $this->db->get();
		$temps = $query->result_array();
		$mail_ids = array();
		foreach ($temps as $temp) {
			array_push($mail_ids, $temp['mail_id']);
		}
		
		$ret = array();
		if (count($mail_ids) > 0)
		{
			$this->db->where_in('id', $mail_ids);
			$query = $this->db->get('cdmv_mail');
			$ret = $query->result_array();
		}
		
		return $ret;
	}
	
	public function get_sent_mails($company_id)
	{
		$query = $this->db->get_where('cdmv_mail', array('sen_com_id' => $company_id));
		return $query->result_array();
	}
	
	public function get_by_mail_id($mail_id)
	{
		$query = $this->db->get_where('cdmv_mail', array('id' => $mail_id));
		return $query->row_array();
	}
	
	public function update($mail)
	{
		$data = array(
			'previous_mail_id'	=> $mail['previous_mail_id'],
			'mail_type_id'		=> $mail['mail_type_id'],
			'sender_id'			=> $mail['sender_id'],
			'mail_code'			=> $mail['mail_code'],
			'mail_status'		=> 1,
			'subject'			=> $mail['subject'],
			'message'			=> $mail['message'],
			'modified_by' 		=> $mail['user']
		);
		
		$this->db->where('id', $mail['id']);
		$this->db->update('cdm_mail', $data);
	}
	
	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('cdm_mail');
	}
}