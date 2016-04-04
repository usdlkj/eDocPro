<?php
class Select_value_model extends CI_Model 
{
	public function __construct()
	{
		$this->load->database();
	}
	
	public function create($value)
	{
		$value['value_code'] = strtolower($value['value_code']);
		$this->db->insert('cdm_select_value', $value);
	}
	
	public function read()
	{
		$query = $this->db->get('cdm_select_value');
		return $query->result_array();
	}
	
	public function get_by_project_id($project_id)
	{
		$query = $this->db->get_where('cdm_select_value', array('project_id' => $project_id));
		return $query->result_array();
	}
	
	public function get_by_field_id($field_id)
	{
		$query = $this->db->get_where('cdm_select_value', array('field_id' => $field_id));
		return $query->result_array();
	}
	
	public function get_by_value_id($value_id)
	{
		$query = $this->db->get_where('cdm_select_value', array('id' => $value_id));
		return $query->row_array();
	}
	
	public function update($value)
	{
		$value['value_code'] = strtolower($value['value_code']);
		$this->db->where('id', $value['id']);
		$this->db->update('cdm_select_value', $value);
	}
	
	public function delete($value_id)
	{
		$this->db->where('id', $value_id);
		$this->db->delete('cdm_select_value');
	}
}