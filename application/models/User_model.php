<?php
class User_model extends CI_Model 
{
	public function __construct()
	{
		$this->load->database();
	}
	
	public function create($user)
	{
		// get next id
		$query = $this->db->get_where('cdm_latest_number', array('table_name' => 'cdm_user'));
		$result = $query->row_array();
		$id = intval($result['next_number']);
		
		// set data to be entered into the table
		$data = array(
			'id'			=> $id,
			'company_id' 	=> $user['company_id'],
			'login' 		=> strtolower($user['login']),
			'password' 		=> $user['password'],
			'first_name' 	=> $user['fname'],
			'created_by' 	=> $user['user'],
			'modified_by' 	=> $user['user']
		);
		$this->db->insert('cdm_user', $data);
		
		// update latest number table
		$this->db->where('table_name', 'cdm_user');
		$this->db->update('cdm_latest_number', array('next_number' => $id + 1));
		
		return $id;
	}
	
	public function read()
	{
		$query = $this->db->get('cdmv_user');
		return $query->result_array();
	}
	
	public function get_active_users()
	{
		$query = $this->db->get_where('cdmv_user', array('active' => 1));
		return $query->result_array();
	}
	
	public function get_user_by_login($login)
	{
		$query = $this->db->get_where('cdmv_user', array('login' => $login));
		return $query->row_array();
	}
	
	public function get_user_by_id($id)
	{
		$query = $this->db->get_where('cdmv_user', array('id' => $id));
		return $query->row_array();
	}
	
	public function update($user)
	{
		$data = array(
			'company_id' 	=> $user['company_id'],
			'login' 		=> strtolower($user['login']),
			'first_name' 	=> $user['first_name'],
			'active' 		=> 1,
			'modified'		=> date('Y-m-d H:i:s'),
			'modified_by' 	=> $user['user']
		);
		
		$this->db->where('id', $user['id']);
		$this->db->update('cdm_user', $data);
	}
	
	public function set_password($user)
	{
		$data = array(
			'password' => $user['password']
		);
		
		$this->db->where('id', $user['id']);
		$this->db->update('cdm_user', $data);
	}
	
	public function delete($user)
	{
		$this->db->where('id', $user['id']);
		$this->db->delete('cdm_user');
	}
	
	public function hide($user)
	{
		$data = array(
			'active' 		=> 0,
			'modified' 		=> date('Y-m-d H:i:s'),
			'modified_by' 	=> $user['user']
		);
		
		$this->db->where('id', $user['id']);
		$this->db->update('cdm_user', $data);
	}
	
	public function set_current_project($user)
	{
		$data = array(
			'current_project_id' => $user['current_project_id']
		);
		
		$this->db->where('id', $user['id']);
		return $this->db->update('cdm_user', $data);
	}
}