<?php
class Company_model extends CI_Model 
{
	public function __construct()
	{
		$this->load->database();
	}
	
	public function create($company)
	{
		// get next id
		$query = $this->db->get_where('cdm_latest_number', array('table_name' => 'cdm_company'));
		$result = $query->row_array();
		$id = intval($result['next_number']);
		
		// set data to be entered into the table
		$data = array(
			'id'			=> $id,
			'company_name' 	=> $company['cname'],
			'trading_name' 	=> $company['tname'],
			'company_code' 	=> strtolower($company['ccode']),
			'created_by' 	=> $company['user']
		);
		$this->db->insert('cdm_company', $data);
		
		// update latest number table
		$this->db->where('table_name', 'cdm_company');
		$this->db->update('cdm_latest_number', array('next_number' => $id + 1));
		
		return $id;
	}
	
	public function read()
	{
		$query = $this->db->get('cdm_company');
		return $query->result_array();
	}
	
	public function get_active_companies()
	{
		$query = $this->db->get_where('cdm_company', 'deleted_by IS NULL');
		return $query->result_array();
	}
	
	public function get_company_by_code($company_code)
	{
		$query = $this->db->get_where('cdm_company', array('company_code' => $company_code));
		return $query->row_array();
	}
	
	public function get_company_by_id($id)
	{
		$query = $this->db->get_where('cdm_company', array('id' => $id));
		return $query->row_array();
	}
	
	public function update($company)
	{	
		$data = array(
			'company_name' 	=> $company['cname'],
			'trading_name' 	=> $company['tname'],
			'company_code' 	=> strtolower($company['ccode']),
			'updated_by' 	=> $company['user'],
			'updated_at'	=> date('Y-m-d H:i:s')
		);
		
		$this->db->where('id', $company['id']);
		$this->db->update('cdm_company', $data);
	}
	
	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('cdm_company');
	}
	
	public function hide($company)
	{
		$data = array(
			'deleted_by' 	=> $company['user'],
			'deleted_at'	=> date('Y-m-d H:i:s')
		);
		
		$this->db->where('id', $company['id']);
		$this->db->update('cdm_company', $data);
	}
}