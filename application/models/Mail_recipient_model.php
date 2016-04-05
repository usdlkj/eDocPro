<?php
class Mail_recipient_model extends CI_Model 
{
	public function __construct()
	{
		$this->load->database();
	}
	
	public function create($recipient)
	{
		// check if record exists
		$data = array(
			'mail_id'	=> $recipient['mail_id'],
			'user_id'	=> $recipient['user_id'],
			'user_type'	=> $recipient['user_type']
		);
		$query = $this->db->get_where('cdm_mail_recipient', $data);
		$result = $query->result_array();
		
		// insert only if record does not exist
		if (count($result) == 0) {
			$this->db->insert('cdm_mail_recipient', $recipient);
		}
	}
	
	public function read()
	{
		$query = $this->db->get('cdm_mail_recipient');
		return $query->result_array();
	}
	
	public function get_recipients($mail_id)
	{
		$this->db->select('mail_id, user_id, login, first_name, user_type');
		$this->db->from('cdm_mail_recipient');
		$this->db->join('cdm_user', 'cdm_mail_recipient.user_id = cdm_user.id');
		$this->db->where('mail_id', $mail_id);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_by_mail_id($mail_id)
	{
		$query = $this->db->get_where('cdm_mail_recipient', array('mail_id' => $mail_id));
		return $query->result_array();
	}
	
	public function delete($recipient)
	{
		$this->db->where($recipient['user_id']);
		$this->db->where($recipient['mail_id']);
		$this->db->delete('cdm_mail_recipient');
	}
}