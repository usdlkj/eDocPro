<?php
class Project_user_model extends CI_Model 
{
	public function __construct()
	{
		$this->load->database();
	}
	
	public function create($project_user)
	{
		$this->db->insert('cdm_project_user', $project_user);
	}
	
	public function read()
	{
		$query = $this->db->get('cdm_project_user');
		return $query->result_array();
	}
	
	public function get_active_projects_by_user_id($user_id)
	{
		$query = $this->db->get_where('cdmv_project_user', 'user_id = '.$user_id.' AND deleted_by IS NULL');
		return $query->result_array();
	}
	
	public function get_project_users($project_id)
	{
		$query = $this->db->get_where('cdmv_project_user', array('project_id' => $project_id));
		return $query->result_array();
	}
	
	public function get_users_not_in_project($project_id)
	{
		$query = $this->db->query('SELECT * FROM cdm_user WHERE id NOT IN (SELECT user_id FROM cdm_project_user WHERE project_id = "'.$project_id.'")');
		return $query->result_array();
	}
	
	public function delete($project_user)
	{
		$this->db->where('project_id', $project_user['project_id']);
		$this->db->where('user_id', $project_user['user_id']);
		$this->db->delete('cdm_project_user');
	}
}