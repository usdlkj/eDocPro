<?php
class Document_access_model extends CI_Model 
{
	public function __construct()
	{
		$this->load->database();
	}
	
	public function create($access)
	{
		// check if record exists
		$data = array(
			'document_id' 	=> $access['document_id'], 
			'company_id' 	=> $access['company_id']
		);
		$query = $this->db->get_where('cdm_document_access', $data);
		$records = $query->result_array();
		
		// insert only if record does not exist
		if (count($records) == 0) {
			$this->db->insert('cdm_document_access', $access);
		}
	}
	
	public function read()
	{
		$query = $this->db->get('cdm_document_access');
		return $query->result_array();
	}
	
	public function delete($access)
	{
		$this->db->where($access['document_id']);
		$this->db->where($access['company_id']);
		$this->db->delete('cdm_document_access');
	}
}