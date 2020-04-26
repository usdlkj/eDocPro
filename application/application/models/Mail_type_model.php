<?php
class Mail_type_model extends CI_Model 
{
	public function __construct()
	{
		$this->load->database();
	}
	
	public function create($type)
	{
		$data = array(
			'project_id'		=> $type['project_id'],
			'mail_type'			=> $type['mail_type'],
			'mail_code'			=> strtolower($type['mail_code']),
			'is_transmittal'	=> $type['is_transmittal'],
			'created_by' 		=> $type['user']
		);
		
		$this->db->insert('cdm_mail_type', $data);
	}
	
	public function read()
	{
		$query = $this->db->get('cdm_mail_type');
		return $query->result_array();
	}
	
	public function get_type_by_id($type_id)
	{
		$query = $this->db->get_where('cdm_mail_type', array('id' => $type_id));
		return $query->row_array();
	}
	
	public function get_mail_types($project_id)
	{
		$query = $this->db->get_where('cdm_mail_type', 'project_id = '.$project_id.' AND deleted_by IS NULL');
		return $query->result_array();
	}
	
	public function update($type)
	{
		$data = array(
			'mail_type'			=> $type['mail_type'],
			'mail_code'			=> strtolower($type['mail_code']),
			'is_transmittal'	=> $type['is_transmittal'],
			'updated_at'		=> date('Y-m-d H:i:s'),
			'updated_by' 		=> $type['user']
		);
		
		$this->db->where('id', $type['id']);
		$this->db->update('cdm_mail_type', $data);
	}
	
	public function increment_number($type)
	{
		$new_number = intval($type['last_number']) + 1;
		$this->db->where('id', $type['id']);
		$this->db->update('cdm_mail_type', array('last_number' => $new_number));
		return $new_number;
	}
	
	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('cdm_mail_type');
	}
	
	public function hide($type)
	{
		$data = array(
			'deleted_at' 	=> date('Y-m-d H:i:s'),
			'deleted_by' 	=> $type['user']
		);
		
		$this->db->where('id', $type['id']);
		$this->db->update('cdm_mail_type', $data);
	}
}