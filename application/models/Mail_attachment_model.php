<?php
class Mail_attachment_model extends CI_Model 
{
	public function __construct()
	{
		$this->load->database();
	}
	
	public function create($attachment)
	{
		// check if record exists
		$data = array(
			'mail_id'		=> $attachment['mail_id'],
			'attachment_id'	=> $attachment['attachment_id']
		);
		$query = $this->db->get_where('cdm_mail_attachment', $data);
		$result = $query->result_array();
		
		// insert only if record does not exist
		if (count($result) == 0) {
			$this->db->insert('cdm_mail_attachment', $attachment);
		}
	}
	
	public function read()
	{
		$query = $this->db->get('cdm_mail_attachment');
		return $query->result_array();
	}
	
	public function get_attachments($mail_id)
	{
		$this->db->select('mail_id, attachment_id, doc_code');
		$this->db->from('cdm_mail_attachment');
		$this->db->join('cdm_document', 'cdm_mail_attachment.attachment_id = cdm_document.id');
		$this->db->where('cdm_mail_attachment.mail_id', $mail_id);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function delete($attachment)
	{
		$this->db->where('mail_id', $attachment['mail_id']);
		$this->db->where('attachment_id', $attachment['attachment_id']);
		$this->db->delete();
	}
}