<?php
class Document_field_model extends CI_Model 
{
	public function __construct()
	{
		$this->load->database();
	}
	
	public function create($value)
	{
		$this->db->insert('cdm_document_field', $value);
	}
	
	public function read()
	{
		return $this->db->get('cdm_document_field');
	}
	
	public function get_field_values($document_id)
	{
		$query = $this->db->get_where('cdm_document_field', array('document_id'	=> $document_id));
		return $query->result_array();
	}
	
	public function get_field_value($document_id, $field_code)
	{
		$data = array(
			'document_id'	=> $document_id,
			'field_code'	=> $field_code
		);
		$query = $this->db->get_where('cdm_document_field', $data);
		return $query->result_array();
	}
	
	public function update($value)
	{
		$this->db->where('document_id', $value['document_id']);
		$this->db->where('field_code', $value['field_code']);
		$data['field_value'] = $value['field_value'];
		$this->db->update('cdm_document_field', $data);
	}
	
	public function delete($user)
	{
		$this->db->where('document_id', $value['document_id']);
		$this->db->where('field_code', $value['field_code']);
		$this->db->delete('cdm_document_field');
	}
}